<?php

namespace GCSV\TechnicalBundle\Controller\Frontend;


use DFP\EtapIBundle\Entity\Filia;
use GCSV\MagazynBundle\Entity\StanMagazynuWirtualny;
use GCSV\RaportBundle\Entity\Notatka;
use GCSV\RaportBundle\Entity\RaportTechniczny;
use GCSV\RaportBundle\Entity\RaportZuzycia;
use GCSV\RaportBundle\Entity\RaportZuzyciaProdukt;
use GCSV\RaportBundle\Form\NotatkaType;
use GCSV\RaportBundle\Form\RaportTechnicznyType;
use GCSV\RaportBundle\Form\RaportZuzyciaType;
use GCSV\TechnicalBundle\Form\ZdarzenieTechniczneHiddenDateTimeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\UczestnikZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use GCSV\TechnicalBundle\Entity\RodzajZdarzeniaTechnicznego;
use Ivory\GoogleMap\Services\Geocoding\Result\GeocoderResponse;
use Ivory\GoogleMap\Services\Geocoding\Result\GeocoderResult;
use Ivory\GoogleMap\Overlays\Marker;

/**
 * Kontroler Zdarzen Technicznych
 * @package GCSV\TechnicalBundle\Controller\Frontend
 * @Route("/zdarzenia-techniczne")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class ZdarzenieTechniczneController extends Controller
{
    /**
     * Lista wszystkich zdarzeń technicznych
     * @Route(
     *      "/{strona}",
     *      requirements={"strona" = "\d+"},
     *      defaults={"strona" = 1},
     *      name="zdarzenia_techniczne"
     * )
     * @Template()
     * @Method("GET")
     */
    public function indexAction($strona)
    {
        $em = $this->getDoctrine()->getManager();

        $zdarzenia = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->getListaZdarzenTechnicznychQuery();

        $paginator = $this->get('knp_paginator');
        $paginacja = $paginator->paginate($zdarzenia, $strona, 25);

        return array(
            'terminy_zdarzen' => $paginacja
        );
    }

    /**
     * Tworzy nowe Zdarzenie Techniczne
     *
     * @Route(
     *      "/",
     *      name="zdarzenie_techniczne_create"
     * )
     * @Method("POST")
     * @Template("@GCSVTechnical/Frontend/ZdarzenieTechniczne/new.html.twig")
     * @param Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     */
    public function createAction(Request $request)
    {
        $statusZdarzeniaTechnicznego = $this->getDoctrine()->getManager()->getRepository('GCSVTechnicalBundle:StatusZdarzeniaTechnicznego')->findOneByWartosc(0);
        $terminZdarzenia = new TerminZdarzeniaTechnicznego();
        $uczestnikZdarzenia = new UczestnikZdarzeniaTechnicznego();
        $uczestnikZdarzenia->addTerminy($terminZdarzenia);
        $zdarzenie = new ZdarzenieTechniczne();
        $zdarzenie->addUczestnikZdarzeniaTechnicznego($uczestnikZdarzenia);
        $zdarzenie->setStatus($statusZdarzeniaTechnicznego);
        $form = $this->createCreateForm($zdarzenie);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($zdarzenie);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',array('title'=>'Udało się!','body'=>'Nowe zdarzenie techniczne zostało pomyślne zapisane w kalendarzu Technicznym.'));

            return $this->redirect($this->generateUrl('strona_glowna'));

        }else{
            $this->get('session')->getFlashBag()->add('danger',array('title'=>'Błąd!','body'=>'Wystąpił błąd podczas próby dodania nowego zdarzenia technicznego. Sprawdź poprawność wypełnienia wszystkich wymaganych pól formularza.'));
        }

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
        );
    }

    /**
     * Tworzy formularz nowego Zdarzenia Technicznego
     */
    private function createCreateForm(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $form = $this->createForm(new ZdarzenieTechniczneHiddenDateTimeType(), $zdarzenieTechniczne, array(
                'action'        =>  $this->generateUrl('zdarzenie_techniczne_create'),
                'method'        =>  'POST'
            )
        );
        $form->add('oddzialFirmy','gcsv_firma_oddzial_autocomplete',array(
                'label'         =>  'Klient (oddział)',
                'required'      =>  true,
                'attr'          =>  array('autocomplete'=>'off'),
            )
        );
        $form->add('submit','submit',array(
                'label' =>  'Zamów wizytę',
                'attr'  =>  array('class'=>'btn btn-success col-sm-2')
            )
        );

        return $form;
    }

    /**
     * Wyświetla formularz w celu dodania nowego Zdarzenia Technicznego
     *
     * @Route(
     *      "/nowe-zdarzenie",
     *      name="zdarzenie_techniczne_new"
     * )
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $terminZdarzenia = new TerminZdarzeniaTechnicznego();
        $uczestnikZdarzenia = new UczestnikZdarzeniaTechnicznego();
        $uczestnikZdarzenia->addTerminy($terminZdarzenia);
        $zdarzenie = new ZdarzenieTechniczne();
        $zdarzenie->addUczestnikZdarzeniaTechnicznego($uczestnikZdarzenia);
        $zdarzenie->setOsobaZlecajaca($this->getUser());
        $form = $this->createCreateForm($zdarzenie);

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
        );
    }

    /**
     * Wyświetla zdarzenie techniczne
     *
     * @Route(
     *      "/zdarzenie-{id}",
     *      requirements={"id" = "\d+"},
     *      name="zdarzenie_techniczne_show",
     *      options={"expose"=true}
     * )
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var ZdarzenieTechniczne $zdarzenie
         */
        $zdarzenie = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->find($id);
        if(!$zdarzenie)
        {
            throw $this->createNotFoundException('Nie można odnaleźć zdarzenia.');
        }

//        $dokumentacja = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->getRaportyTechniczne($zdarzenie->getId());
//        $raportyZuzycia = $em->getRepository('GCSVRaportBundle:RaportZuzycia')->findBy(array('zdarzenieTechniczne'=>$zdarzenie));
//        $receptury = $em->getRepository('GCSVRecepturaBundle:Receptura')->findByZdarzenieTechniczne($id);
//        $notatki = $em->getRepository('GCSVRaportBundle:Notatka')->findBy(array('zdarzenieTechniczne'=>$zdarzenie));

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zdarzenia-techniczne?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('strona_glowna');
        }

        $finder = new Finder();
        $fileSystem = new Filesystem();
        if($fileSystem->exists('uploads/zalaczniki/'.$zdarzenie->getId().'/'))
        {
            $finder->files()->in('uploads/zalaczniki/'.$zdarzenie->getId().'/');
        }else{
            $finder = null;
        }

        $csrfProvider = $this->get('form.csrf_provider');

        return array(
            'zdarzenie'                 =>  $zdarzenie,
//            'dokumentacja'              =>  $dokumentacja,
//            'raporty_zuzycia'           =>  $raportyZuzycia,
//            'notatki'                   =>  $notatki,
            'back_link'                 =>  $referer,
//            'stopien_realizacji_class'  =>  $stopienRealizacjiClass,
//            'receptury'                 =>  $receptury,
//            'mapa'                      =>  $mapa,
            'adres'                     =>  isset($adres) ? $adres : '',
            'zalaczniki'                =>  $finder,
            'csrfProvider'              =>  isset($csrfProvider) ? $csrfProvider : null
        );
    }

    /**
     * Creates a new RaportTechniczny entity.
     *
     * @Route("/zdarzenie-{id}/raport-techniczny", name="zdarzenie_techniczne_raport_techniczny_create")
     * @Method("POST")
     * @Template("GCSVRaportBundle:Frontend/RaportTechniczny:new.html.twig")
     */
    public function createRaportTechnicznyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $zdarzenieTechniczne = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->find($id);
        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć zdarzenia technicznego.');
        }

        $raportTechniczny = new RaportTechniczny();
        $raportTechniczny->setZdarzenieTechniczne($zdarzenieTechniczne);
        $form = $this->createForm(new RaportTechnicznyType(), $raportTechniczny, array(
                'action'    =>  $this->generateUrl('zdarzenie_techniczne_raport_techniczny_create', array('id' => $id)),
                'method'    =>  'POST'
            )
        );
        $form->add('submit','submit',array(
                'label' =>  'Utwórz'
            )
        );
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($raportTechniczny);
            $em->flush();

            return $this->redirect($this->generateUrl('zdarzenie_techniczne_show', array('id' => $id)));
        }

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zdarzenia-techniczne?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('zdarzenia_techniczne');
        }

        return array(
            'zdarzenie' =>      $zdarzenieTechniczne,
            'raport'    =>      $raportTechniczny,
            'back_link' =>      $referer,
            'form'      =>      $form->createView(),
        );
    }

    /**
     * Dodaje raport techniczny do zdarzenia technicznego
     *
     * @Route(
     *      "/zdarzenie-{id}/raport-techniczny/nowy",
     *      requirements={"id" = "\d+"},
     *      name="zdarzenie_techniczne_raport_techniczny_new"
     * )
     * @Method({"GET","POST"})
     * @Template("GCSVRaportBundle:Frontend/RaportTechniczny:new.html.twig")
     * @param \GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne $zdarzenieTechniczne
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     */
    public function newRaportTechnicznyAction(ZdarzenieTechniczne $zdarzenieTechniczne, Request $request)
    {
        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć zdarzenia technicznego.');
        }

        $raportTechniczny = new RaportTechniczny();
        $raportTechniczny->setZdarzenieTechniczne($zdarzenieTechniczne);
        $raportTechniczny->setCel($zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getNazwa());
        $form = $this->createForm(new RaportTechnicznyType(), $raportTechniczny, array(
                'action'    =>  $this->generateUrl('zdarzenie_techniczne_raport_techniczny_new', array('id' => $zdarzenieTechniczne->getId())),
                'method'    =>  'POST'
            )
        );
        $form->add('submit','submit',array(
                'label' =>  'Zapisz'
            )
        );

        $idZdarzeniaTechnicznego = $zdarzenieTechniczne->getId();
        $_SESSION['imgmanager_upload_directory'] = "zdarzenia_techniczne/$idZdarzeniaTechnicznego/";

        $referer =  array("name"    =>  'zdarzenie_techniczne_show', "args" =>  array('id'=>$zdarzenieTechniczne->getId()));

        return array(
            'zdarzenie' =>  $zdarzenieTechniczne,
            'raport'    =>  $raportTechniczny,
            'back_link' =>  $referer,
            'form'      =>  $form->createView(),
        );
    }

    /**
     * Dodaje raport techniczny do zdarzenia technicznego
     *
     * @Route(
     *      "/zdarzenie-{idz}/raport-techniczny-{idrt}/edytuj",
     *      requirements={
     *          "idz" = "\d+",
     *          "idrt" = "\d+"
     *      },
     *      name="zdarzenie_techniczne_raport_techniczny_edit"
     * )
     * @Method({"GET","PUT"})
     * @Template("GCSVRaportBundle:Frontend/RaportTechniczny:new.html.twig")
     * @ParamConverter("zdarzenieTechniczne", class="GCSVTechnicalBundle:ZdarzenieTechniczne", options={"id" = "idz"})
     * @ParamConverter("raportTechniczny", class="GCSVRaportBundle:RaportTechniczny", options={"id" = "idrt"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne $zdarzenieTechniczne
     * @param \GCSV\RaportBundle\Entity\RaportTechniczny $raportTechniczny
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     */
    public function editRaportTechnicznyAction(Request $request,ZdarzenieTechniczne $zdarzenieTechniczne,RaportTechniczny $raportTechniczny)
    {
        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć zdarzenia technicznego.');
        }

        if(!$raportTechniczny)
        {
            throw $this->createNotFoundException('Nie można odnaleźć raportu technicznego.');
        }

        $raportTechniczny->setZdarzenieTechniczne($zdarzenieTechniczne);
        $form = $this->createForm(new RaportTechnicznyType(), $raportTechniczny, array(
                'action'    =>  $this->generateUrl('zdarzenie_techniczne_raport_techniczny_edit', array('idz' => $zdarzenieTechniczne->getid(), 'idrt' => $raportTechniczny->getId())),
                'method'    =>  'PUT'
            )
        );
        $form->add('submit','submit',array(
                'label' =>  'Aktualizuj'
            )
        );

        $idz = $zdarzenieTechniczne->getid();

        if($request->isMethod('PUT'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($raportTechniczny);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Poprawnie zedytowano raport techniczny!');

                return $this->redirect($this->generateUrl('zdarzenie_techniczne_show', array('id' => $idz)));
            }
        }

        $_SESSION['imgmanager_upload_directory'] = "zdarzenia_techniczne/$idz/";

        $referer =  array("name"    =>  'zdarzenie_techniczne_show', "args" =>  array('id'=>$idz));

        return array(
            'zdarzenie' =>  $zdarzenieTechniczne,
            'raport'    =>  $raportTechniczny,
            'back_link' =>  $referer,
            'form'      =>  $form->createView(),
        );
    }

    /**
     * @Route(
     *      "/zdarzenie-{idz}/raport-techniczny-{idrt}",
     *      requirements={
     *          "idz" = "\d+",
     *          "idrt" = "\d+"
     *      },
     *      name="zdarzenie_techniczne_raport_techniczny_show"
     * )
     * @Method("GET")
     * @Template("GCSVRaportBundle:Frontend/RaportTechniczny:show.html.twig")
     * @ParamConverter("zdarzenieTechniczne", class="GCSVTechnicalBundle:ZdarzenieTechniczne", options={"id" = "idz"})
     * @ParamConverter("raportTechniczny", class="GCSVRaportBundle:RaportTechniczny", options={"id" = "idrt"})
     */
    public function showRaportTechnicznyAction(ZdarzenieTechniczne $zdarzenieTechniczne,RaportTechniczny $raportTechniczny)
    {
        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć zdarzenia technicznego.');
        }

        if(!$raportTechniczny)
        {
            throw $this->createNotFoundException('Nie można odnaleźć raportu technicznego.');
        }

        return array(
            'raport'    =>  $raportTechniczny,
        );
    }

    /**
     * Zwraca wszystkie zapisane lokalizacje wskazanego Oddziału Firmy.
     *
     * @Route(
     *      "/{id}/get-lokalizacje-oddzalu",
     *      name="ajax_get_lokalizacje_oddzialu",
     *      options={"expose"=true}
     * )
     * @Method("GET")
     */
    public function getLokalizacjeOddzialu($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var Oddzial $oddzial
         */
        $oddzial = $em->getRepository('GCSVCustomerBundle:Oddzial')->find($id);

        if(!$oddzial)
        {
            throw $this->createNotFoundException('Szukany oddział nie został odnaleziony w bazie danych.');
        }

        /**
         * @var Adres $adres
         */
        $adresy = array();

        foreach ($oddzial->getAdresy() as $adres)
        {
            $id = $adres->getId();
            $lokalizacja = $adres->getMiasto().', '.$adres->getUlica();
            $placowka = implode(', ', $adres->getRodzajPlacowki()->toArray());
            $lat = $adres->getSzerokoscGeo();
            $lng = $adres->getDlugoscGeo();
            $adresy[$id] = array('lokalizacja'=>$lokalizacja,'placowka'=>$placowka, 'lat'=>$lat, 'lng'=>$lng);
        }

        $response = new JsonResponse();
        $response->setData($adresy);

        return $response;
    }

    /**
     * Przekierowanie do formularza dodawania nowej receptury własnej
     *
     * @Route(
     *      "/zdarzenie-{id}/nowa-receptura",
     *      name="zdarzenie_techniczne_nowa_receptura",
     * )
     * @Method("GET")
     */
    public function newRecepturaAction($id)
    {
        $response = $this->forward('GCSVRecepturaBundle:Frontend/Receptura:new', array(
                'zdarzenieId'       =>  $id,
                'backLink'          =>  array('name' => 'zdarzenie_techniczne_show', 'args' => array('id'=>$id)),
            )
        );
        return $response;
    }

    /**
     * Przekierowanie do formularza edycji receptury własnej
     *
     * @Route(
     *      "/zdarzenie-{zdarzenieId}/receptura-{recepturaId}/edytuj",
     *      name="zdarzenie_techniczne_edytuj_recepture"
     * )
     * @Method("GET")
     */
    public function editRecepturaAction($zdarzenieId,$recepturaId)
    {
        $response = $this->forward('GCSVRecepturaBundle:Frontend/Receptura:edit',array(
                'id'        =>  $recepturaId,
                'backLink'  =>  array("name"    =>  'zdarzenie_techniczne_show', "args" =>  array('id'=>$zdarzenieId))
            )
        );
        return $response;
    }

    /**
     * Przekierowanie podglądu receptury własnej
     *
     * @Route(
     *      "/zdarzenie-{zdarzenieId}/receptura-{recepturaId}",
     *      name="zdarzenie_techniczne_pokaz_recepture"
     * )
     * @Method("GET")
     */
    public function showRecepturaAction($zdarzenieId,$recepturaId)
    {
        $response = $this->forward('GCSVRecepturaBundle:Frontend/Receptura:show',array(
                'id'        =>  $recepturaId,
                'backLink'  =>  array("name"    =>  'zdarzenie_techniczne_show', "args" =>  array('id'=>$zdarzenieId))
            )
        );
        return $response;
    }

    /**
     * Formularz dodawania nowego raportu zużycia przypisanego do zdarzenia technicznego
     *
     * @Route(
     *      "/zdarzenie-{id}/raport-zuzycia/nowy",
     *      name="zdarzenie_techniczne_nowy_raport_zuzycia",
     * )
     * @Method({"GET","POST"})
     * @Template("GCSVRaportBundle:Frontend/RaportZuzycia:new.html.twig")
     */
    public function newRaportZuzyciaAction(Request $request, $id)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $zdarzenieTechniczne = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->find($id);
        $stanMagazynuWirtualnego = $em->getRepository('GCSVMagazynBundle:StanMagazynuWirtualny')->wyswietlMojStanMagazynowyWirtualnyQuery($user);

        $raportZuzycia = new RaportZuzycia();
        $raportZuzycia->setZdarzenieTechniczne($zdarzenieTechniczne);
        $raportZuzycia->setAutor($user);

        /**
         * @var StanMagazynuWirtualny $pozycja
         */
        foreach($stanMagazynuWirtualnego as $pozycja)
        {
            $raportZuzyciaProdukt = new RaportZuzyciaProdukt();
            $raportZuzyciaProdukt->setProdukt($pozycja->getProdukt());
            $raportZuzycia->addRaportZuzyciaProdukty($raportZuzyciaProdukt);
        }

        $form = $this->createForm(new RaportZuzyciaType(), $raportZuzycia, array(
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Zapisz raport','attr'=> array('class'=>'btn btn-success right')));

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $raportZuzyciaProdukty = $raportZuzycia->getRaportZuzyciaProdukty();
                /**
                 * @var RaportZuzyciaProdukt $raportZuzyciaProdukt
                 */
                foreach($raportZuzyciaProdukty as $raportZuzyciaProdukt)
                {
                    foreach($stanMagazynuWirtualnego as $pozycja)
                    {
                        if($pozycja->getProdukt() == $raportZuzyciaProdukt->getProdukt())
                        {
                            $aktuanlaIlosc = $pozycja->getIlosc() - $raportZuzyciaProdukt->getIloscZuzyta() - $raportZuzyciaProdukt->getIloscZostawiona();
                            $pozycja->setIlosc($aktuanlaIlosc);
                            $em->persist($pozycja);
                        }
                    }
                }
                $em->persist($raportZuzycia);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Raport zużycia dodany!');

                return $this->redirect($this->generateUrl('zdarzenie_techniczne_show', array('id' => $id)));
            }
        }

        return array(
            'entity'                    =>  $raportZuzycia,
            'form'                      =>  $form->createView(),
            'stan_magazynu_wirtualnego' =>  $stanMagazynuWirtualnego,
            'back_link'                 =>  array('name' => 'zdarzenie_techniczne_show', 'args' => array('id'=>$id)),
        );
    }

    /**
     * Formularz dodawania notatki wewnętrznej do zdarzenia technicznego
     *
     * @Route(
     *      "/zdarzenie-{id}/notatka/nowa",
     *      name="zdarzenie_techniczne_nowa_notatka",
     * )
     * @Method({"GET","POST"})
     * @Template("GCSVRaportBundle:Frontend/Notatka:new.html.twig")
     * @ParamConverter("zdarzenieTechniczne")
     */
    public function newNotatkaWewnetrzna(Request $request, ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Zdarzenie techniczne nie zostało odnalezione.');
        }

        $notatka = new Notatka();
        $notatka->setZdarzenieTechniczne($zdarzenieTechniczne);

        $form = $this->createForm(new NotatkaType(), $notatka, array(
                'method'    =>  'POST'
            )
        );

        $form->add('submit', 'submit', array('label' => 'Zapisz notatkę','attr'=> array('class'=>'btn btn-success right')));

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($notatka);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Dodano nową notatkę do zdarzenia technicznego.');

                return $this->redirect($this->generateUrl('zdarzenie_techniczne_show', array('id' => $zdarzenieTechniczne->getId())));
            }
        }

        $referer =  array("name"    =>  'zdarzenie_techniczne_show', "args" =>  array('id'=>$zdarzenieTechniczne->getId()));

        return array(
            'zdarzenie' =>  $zdarzenieTechniczne,
            'back_link' =>  $referer,
            'form'      =>  $form->createView(),
        );
    }

    /**
     * @Route(
     *      "/zdarzenie-{idz}/notatka-{idn}",
     *      requirements={
     *          "idz" = "\d+",
     *          "idrt" = "\d+"
     *      },
     *      name="zdarzenie_techniczne_notatka_show"
     * )
     * @Method("GET")
     * @Template("GCSVRaportBundle:Frontend/Notatka:show.html.twig")
     * @ParamConverter("zdarzenieTechniczne", class="GCSVTechnicalBundle:ZdarzenieTechniczne", options={"id" = "idz"})
     * @ParamConverter("notatka", class="GCSVRaportBundle:Notatka", options={"id" = "idn"})
     */
    public function showNotatkaAction(ZdarzenieTechniczne $zdarzenieTechniczne,Notatka $notatka)
    {
        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć zdarzenia technicznego.');
        }

        if(!$notatka)
        {
            throw $this->createNotFoundException('Nie można odnaleźć raportu technicznego.');
        }

        return array(
            'notatka'    =>  $notatka,
        );
    }
} 