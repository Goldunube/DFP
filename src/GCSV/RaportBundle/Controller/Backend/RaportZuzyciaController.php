<?php

namespace GCSV\RaportBundle\Controller\Backend;


use GCSV\MagazynBundle\Entity\StanMagazynuWirtualny;
use GCSV\RaportBundle\Entity\RaportZuzycia;
use GCSV\RaportBundle\Entity\RaportZuzyciaProdukt;
use GCSV\RaportBundle\Form\Filter\ListaRaporyZuzycFilter;
use GCSV\RaportBundle\Form\RaportZuzyciaProduktType2;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use Ivory\GoogleMap\Services\Geocoding\Geocoder;
use Ivory\GoogleMap\Services\Geocoding\GeocoderProvider;
use Geocoder\HttpAdapter\CurlHttpAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RaportZuzyciaController
 * @package GCSV\RaportBundle\Controller\Backend
 * @Route("/zaplecze")
 */
class RaportZuzyciaController extends Controller
{

    /**
     * Wyświetla kompletną listę sporządzonych raportów zużyć
     *
     * @Route(
     *      "/raporty-zuzyc/{strona}",
     *      requirements={"strona" = "\d+"},
     *      defaults={"strona" = 1},
     *      name="zaplecze_raporty_zuzycia"
     * )
     * @Method("GET")
     */
    public function indexAction(Request $request, $strona)
    {
        $form = $this->get('form.factory')->create(new ListaRaporyZuzycFilter());

        if($request->query->has($form->getName()))
        {
            $params = serialize($this->get('request')->query->get($form->getName()));

            $cookie = new Cookie($form->getName(),$params,time()+3600);
            $form->submit($this->get('request')->query->get($form->getName()));
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('GCSVRaportBundle:RaportZuzycia')
                ->createQueryBuilder('rz')
                ->select('rz,a,zt,rzt,odf,f')
                ->leftJoin('rz.autor','a')
                ->leftJoin('rz.zdarzenieTechniczne','zt')
                ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
                ->leftJoin('zt.oddzialFirmy','odf')
                ->leftJoin('odf.firma','f')
                ->orderBy('rz.akceptacja','ASC')
                ->addOrderBy('rz.dataUtworzenia','DESC');

            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

            $raportyZuzyc = $filterBuilder;
        }else{
            if($request->cookies->get($form->getName()))
            {
                $params = unserialize($request->cookies->get($form->getName()));
                $form->submit($params);
                $filterBuilder = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('GCSVRaportBundle:RaportZuzycia')
                    ->createQueryBuilder('rz')
                    ->select('rz,a,zt,rzt,odf,f')
                    ->leftJoin('rz.autor','a')
                    ->leftJoin('rz.zdarzenieTechniczne','zt')
                    ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
                    ->leftJoin('zt.oddzialFirmy','odf')
                    ->leftJoin('odf.firma','f')
                    ->orderBy('rz.akceptacja','ASC')
                    ->addOrderBy('rz.dataUtworzenia','DESC');

                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

                $raportyZuzyc = $filterBuilder;
            }else{
                $raportyZuzyc = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('GCSVRaportBundle:RaportZuzycia')
                    ->createQueryBuilder('rz')
                    ->select('rz,a,zt,rzt,odf,f')
                    ->leftJoin('rz.autor','a')
                    ->leftJoin('rz.zdarzenieTechniczne','zt')
                    ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
                    ->leftJoin('zt.oddzialFirmy','odf')
                    ->leftJoin('odf.firma','f')
                    ->orderBy('rz.akceptacja','ASC')
                    ->addOrderBy('rz.dataUtworzenia','DESC');
            };
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($raportyZuzyc,$strona,50);

        $response = $this->render('GCSVRaportBundle:Backend/RaportZuzycia:index.html.twig', array(
                'form'                  =>  $form->createView(),
                'listaRaportowZuzyc'    =>  $pagination
            )
        );
        if(isset($cookie)) { $response->headers->setCookie($cookie); };

        $response->prepare($request);

        return $response;
    }


    /**
     * Wyświetla raport zużycia
     *
     * @Route(
     *      "/raport-zuzycia/{id}.{_format}",
     *      defaults={"_format":"html"},
     *      requirements={
     *          "id" : "\d+",
     *          "_format" : "html|pdf"
     *      },
     *      name="zaplecze_raport_zuzycia_show",
     * )
     * @Method("GET")
     * @Template()
     */
    public function showAction(RaportZuzycia $raportZuzycia)
    {
        if(!$raportZuzycia)
        {
            throw $this->createNotFoundException('Nie odnaleziono raportu zużycia.');
        }

        if($this->get('request')->getRequestFormat() == 'pdf')
        {
            $geocoder = new Geocoder();
            $geocoder->registerProviders(array(
                    new GeocoderProvider(new CurlHttpAdapter()),
                )
            );

            /**
             * @var ZdarzenieTechniczne $zdarzenieTechniczne
             */
            $zdarzenieTechniczne = $raportZuzycia->getZdarzenieTechniczne();
            $lat = $zdarzenieTechniczne->getSzerokoscGeo();
            $lng = $zdarzenieTechniczne->getDlugoscGeo();
            $responseGeocoder = $geocoder->reverse($lat,$lng);
            $results = $responseGeocoder->getResults();

            $html = $this->renderView('@GCSVRaport/Backend/RaportZuzycia/show.pdf.twig', array(
                    'raportZuzycia' =>  $raportZuzycia,
                    'adres' =>  $results[0]->getFormattedAddress()
                ),false
            );

            $pdf = $this->get('knp_snappy.pdf');
            $pdf->setOption('lowquality',false);
            $pdf->setOption('encoding','utf-8');
            $pdf->setOption('header-html',$this->generateUrl('raport_zuzycia_header',array(),true));
            $pdf->setOption('header-spacing',10);
            $pdf->setOption('footer-spacing',10);
            $pdf->setOption('margin-top',35);
            $pdf->setOption('margin-left',0);
            $pdf->setOption('margin-right',0);
            $pdf->setOption('margin-bottom',51);
            $pdf->setOption('footer-html',$this->generateUrl('raport_footer',array(),true));

            return new Response(
                $pdf->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'filename="Raport-Zuzycia-'.$raportZuzycia->getId().'.pdf"'
                )
            );
        }

        $csrfProvider = $this->get('form.csrf_provider');

        return array(
            'raportZuzycia' =>  $raportZuzycia,
            'csrfProvider'  =>  isset($csrfProvider) ? $csrfProvider : null
        );
    }

    /**
     * Edytuje niezakceptowany raport zużycia
     *
     * @Route(
     *      "/raport-zuzycia/{id}/edit",
     *      name="zaplecze_raport_zuzycia_edit"
     * )
     * @Method({"GET","PUT"})
     * @Template()
     * @Security("has_role('ROLE_KOORDYNATOR_DT')")
     */
    public function editAction(Request $request, RaportZuzycia $raportZuzycia)
    {
        //TODO: Dodać mechanizm zdejmowania / dodawania zedytowanych ilości materiałów na magazyn technika.

        if(!$raportZuzycia)
        {
            throw $this->createNotFoundException('Nie odnaleziono raportu zużycia, który chciałbyś edytować.');
        }
        $form = $this->createFormBuilder($raportZuzycia)
            ->setAction($this->generateUrl('zaplecze_raport_zuzycia_edit', array('id' => $raportZuzycia->getId())))
            ->setMethod('PUT')
            ->add('raportZuzyciaProdukty','collection',array(
                    'type'          =>  new RaportZuzyciaProduktType2(),
                    'by_reference'  =>  false,
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true
                )
            )
            ->add('uwagi')
            ->add('submit','submit',array(
                    'label' =>  'Aktualizauj',
                    'attr'  =>  array('class'   =>  'btn btn-success')
                )
            )
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($raportZuzycia);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',array('title'=>'Zaktualizowano raport zużycia!','body'=>sprintf("Raport zużycia o identyfikatorze %s został pomyślnie zaktualizowany.",$raportZuzycia->getId())));

            return $this->redirect($this->generateUrl('zaplecze_raport_zuzycia_show', array('id'=>$raportZuzycia->getId())));
        }

        return array(
            'form'      =>  $form->createView()
        );
    }

    /**
     * Usuwa raport zużycia wraz z produktami
     *
     * @Route(
     *      "/raport-zuzycia/{id}/{token}",
     *      name="zaplecze_raport_zuzycia_delete",
     *      requirements={"id" = "\d+"},
     * )
     * @Method("GET")
     * @Security("has_role('ROLE_KOORDYNATOR_DT')")
     */
    public function deleteAction(RaportZuzycia $raportZuzycia, $token)
    {
        if(!$raportZuzycia)
        {
            throw $this->createNotFoundException('Nie odnaleziono raportu zużycia, który chciałbyś usunąć.');
        }
        $id = $raportZuzycia->getId();
        $validToken = sprintf('delRaport%d',$id);
        if(!$this->get('form.csrf_provider')->isCsrfTokenValid($validToken, $token))
        {
            throw $this->createAccessDeniedException('Błędny token akcji.');
        };
        $em = $this->getDoctrine()->getManager();
        $autor = $raportZuzycia->getAutor();
        $stanMagazynuWirtualnego = $em->getRepository('GCSVMagazynBundle:StanMagazynuWirtualny')->wyswietlMojStanMagazynowyWirtualnyQuery($autor);
        $raportZuzyciaProdukty = $raportZuzycia->getRaportZuzyciaProdukty();
        /**
         * @var RaportZuzyciaProdukt $raportZuzyciaProdukt
         */
        foreach($raportZuzyciaProdukty as $raportZuzyciaProdukt)
        {
            /**
             * @var StanMagazynuWirtualny $pozycja
             */
            foreach($stanMagazynuWirtualnego as $pozycja)
            {
                if($pozycja->getProdukt() == $raportZuzyciaProdukt->getProdukt())
                {
                    /**
                     * @var $iloscPozostawiona int
                     * @var $iloscZuzyta int
                     * @var $iloscWMagazynie int
                     */
                    $iloscWMagazynie = $pozycja->getIlosc();
                    $iloscZuzyta = $raportZuzyciaProdukt->getIloscZuzyta();
                    $iloscPozostawiona = $raportZuzyciaProdukt->getIloscZostawiona();
                    $aktuanlaIlosc = $iloscWMagazynie + $iloscZuzyta + $iloscPozostawiona;
                    $pozycja->setIlosc($aktuanlaIlosc);
                    $em->persist($pozycja);
                }
            }
        }
        $em->remove($raportZuzycia);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success',array('title'=>'Usunięto raport zużycia!','body'=>sprintf("Raport zużycia o identyfikatorze %s został całkowicie usunięty z systemu.",$id)));

        return $this->redirect($this->generateUrl('zaplecze_raporty_zuzycia'));
    }

    /**
     * @Route(
     *      "/raport-zuzycia/{id}/modify",
     *      requirements={"\d+"},
     *      name="ajax_zaplecze_raport_zuzycia_modify",
     *      condition="request.headers.get('X-Requested-With') == 'XMLHttpRequest'",
     *      options={"expose"=true}
     * )
     * @Method("PUT")
     * @param \GCSV\RaportBundle\Entity\RaportZuzycia $raportZuzycia
     * @return array
     */
    public function changeStatus(RaportZuzycia $raportZuzycia)
    {
        $put_str = $this->get('request')->getContent();
        parse_str($put_str, $_PUT);

        $em = $this->getDoctrine()->getManager();
        $jsonResponse = new JsonResponse();

        switch($_PUT['akcja'])
        {
            case 'blokuj':
                break;
            case 'akceptuj':
                $raportZuzycia->setAkceptacja(true);
                $jsonResponse->setData(array('code'=>'ok','message'=>'Oznaczono jako zaakceptowany.'));
                break;
            case 'akceptuj-cofnij':
                $raportZuzycia->setAkceptacja(false);
                $jsonResponse->setData(array('code'=>'ok','message'=>'Oznaczono jako NIE zaakceptowany.'));
                break;
            case 'korekta':
                break;
            case 'drukuj':
                $raportZuzycia->setWydruk(true);
                $jsonResponse->setData(array('code'=>'ok','message'=>'Oznaczono jako wydrukowany.'));
                break;
            case 'drukuj-cofnij':
                $raportZuzycia->setWydruk(false);
                $jsonResponse->setData(array('code'=>'ok','message'=>'Oznaczono jako NIE wydrukowany.'));
                break;
        }

        $em->persist($raportZuzycia);
        $em->flush();

        return $jsonResponse;
    }
} 