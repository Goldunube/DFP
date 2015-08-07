<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use DFP\EtapIBundle\Entity\DoPobrania;
use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Form\AktualnosciPostType;
use DFP\EtapIBundle\Form\Filtry\ListaKlientowByDaneFilterType;
use DFP\EtapIBundle\Form\Filtry\ListaKlientowByPromienFilterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="strona_glowna")
     * @Template("@DFPEtapI/Frontend/index.html.twig")
     */
    public function indexAction()
    {
        $doPobraniaRepo = $this->getDoctrine()->getRepository('DFPEtapIBundle:DoPobrania');
        $allList = $doPobraniaRepo->findAllAktualnosciBySort();
        $editPermissions = false;
        $paginator = $this->get('knp_paginator');

        $usersGroups = array(
            'ROLE_TECHNIK'  =>  'Technik',
            'ROLE_HDFP'     =>  'Handlowc DFP',
            'ROLE_HWPS'     =>  'WPS',
            'ROLE_FDFP'     =>  'Freelancer',
            'ROLE_RLS'      =>  'RLS',
            'ROLE_RKS'      =>  'RKS',
        );

        if($this->get('security.authorization_checker')->isGranted('ROLE_KDFP') or $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $editPermissions = true;
            $csrfProvider = $this->get('form.csrf_provider');
        }

        $pagination = $paginator->paginate($allList, $this->get('request')->query->get('strona',1),10);

        return array(
            'wiadomosci'   =>  $pagination,
            'uprawnienia'   =>  $editPermissions,
            'csrf_provider' =>  isset($csrfProvider) ? $csrfProvider : null,
            'token'         =>  'DFPdel%d',
            'roles_table'   =>  $usersGroups
        );
    }

    /**
     * @Route("/aktualnosci/new",
     *      name="aktualnosci_new"
     * )
     * @Method({"GET","POST"})
     * @Template()
     * @Security("has_role('ROLE_KDFP') or has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $aktualnosciPost = new DoPobrania();
        $aktualnosciPost->setWiadomosciShow(1);

        $form = $this->createForm(new AktualnosciPostType(),$aktualnosciPost,array(
                'action'    =>  $this->generateUrl('aktualnosci_new'),
                'method'    =>  "POST",
            )
        );
        $form
            ->add('submit','submit',array(
                    'label' =>  'Dodaj',
                    'attr'  =>  array('class'   =>  'btn-primary pull-right col-md-1')
                )
            );

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($aktualnosciPost);
                $em->flush();

                return $this->redirect($this->generateUrl('strona_glowna'));
            }
        }

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/aktualnosci/edytuj/{slug}", name="aktualnosci_edit")
     * @Method({"GET","PUT"})
     * @Template()
     * @ParamConverter("doPobrania", class="DFPEtapIBundle:DoPobrania",options={"mapping" : { "slug" : "slug" } })
     * @Security("has_role('ROLE_KDFP') or has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, DoPobrania $doPobrania)
    {
        if(!$doPobrania)
        {
            throw $this->createNotFoundException('Nie odnaleziono wskazanej do edycji encji.');
        }

        $form = $this->createForm(new AktualnosciPostType(),$doPobrania,array(
                'action'    =>  $this->generateUrl('aktualnosci_edit',array('slug'=>$doPobrania->getSlug())),
                'method'    =>  'PUT'
            )
        );
        $form
            ->add('submit','submit',array(
                    'label' =>  'Aktualizuj',
                    'attr'  =>  array('class' => 'btn-primary pull-right col-md-1')
                )
            );

        if($request->isMethod('PUT'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($doPobrania);
                $em->flush();

                return $this->redirect($this->generateUrl('strona_glowna'));
            }
        }

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/aktualnosci/{id}/{token}",
     *      name="aktualnosci_usun",
     * )
     * @Method("DELETE")
     * @param $id
     * @param $token
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Security("has_role('ROLE_KDFP') or has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id, $token)
    {
        $validToken = sprintf('DFPdel%d',$id);
        if(!$this->get('form.csrf_provider')->isCsrfTokenValid($validToken,$token))
        {
            throw $this->createAccessDeniedException('Błędny token akcji usuwania.');
        }

        $em = $this->getDoctrine()->getManager();
        $doPobrania = $em->getRepository('DFPEtapIBundle:DoPobrania')->find($id);

        if(!$doPobrania)
        {
            throw $this->createNotFoundException('Załącznik, który próbujesz usunąć nie istnieje.');
        }

        $em->remove($doPobrania);
        $em->flush();

        return new JsonResponse(array(
            'status'    =>  'ok',
            'message'   =>  'Załącznik został usunięty.'
        ));
    }

    /**
     * @Route("/wyszukiwarka/klienci-wolni/", name="wyszukiwarka_jeden")
     * @Template()
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function getListaKlientowWyszukiwarkaPierwszaAction(Request $request)
    {
        $form = $this->get('form.factory')->create(new ListaKlientowByPromienFilterType(),null,array(
                'method'    =>  "GET",
                'action'    =>  $this->generateUrl('wyszukiwarka_jeden')
            )
        );

        $punktCentralny = array(52.2329379,21.0611941);
        $promien = 0;

        if($request->query->has($form->getName()))
        {
            $form->submit($request->query->get($form->getName()));

            $params = $request->query->get('lista_klientow_promien_filter');
            $punktCentralny = trim(str_replace(" ","+",$params['miejscowosc']));
            $geocodeResponse = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$punktCentralny));
            $results = $geocodeResponse->results;
            $punktCentralny = array($results[0]->geometry->location->lat, $results[0]->geometry->location->lng);
            $promien = $params['promien'] * 1000;
        };


        $kat = 45 * M_PI / 180;
        $jedenStopien = 111319.9;

        $maxLat = $punktCentralny[0] + ($promien / $jedenStopien) * sin($kat);
        $maxLng = $punktCentralny[1] + ($promien / ($jedenStopien*(cos($punktCentralny[0] * M_PI / 180)))) *  cos($kat);
        $minLat = $punktCentralny[0] - ($promien / $jedenStopien)* sin($kat);
        $minLng = $punktCentralny[1] - ($promien / ($jedenStopien*(cos($punktCentralny[0] * M_PI / 180)))) *  cos($kat);

        $filiaRepo = $this->getDoctrine()->getManager()->getRepository('DFPEtapIBundle:Filia');
        $filie = $filiaRepo->createQueryBuilder('f')
            ->select('f','k')
            ->leftJoin('f.klient','k')
            ->leftJoin('f.filieUzytkownicy','fu')
            ->where('f.lat BETWEEN :latMin AND :latMax')
            ->andWhere('f.lng BETWEEN :lngMin AND :lngMax')
            ->andWhere('fu.uzytkownik IS NULL')
            ->setParameters(array(
                    'latMin'    =>  $minLat,
                    'latMax'    =>  $maxLat,
                    'lngMin'    =>  $minLng,
                    'lngMax'    =>  $maxLng
                ))
            ->getQuery()->getResult();

        $filieOdleglosci = array();
        $filieLatLng = array();
        /**
         * @var Filia $filia
         */
        foreach ($filie as $filia) {
            $filieOdleglosci[$filia->getId()] = $this->getDistanceFromLatLonInKm($punktCentralny[0],$punktCentralny[1],$filia->getLat(),$filia->getLng());
            $filieLatLng[] = array('lat' => $filia->getLat(), 'lng' => $filia->getLng(), 'title' => '<strong>'.$filia->getKlient()->getNazwaSkrocona().'</strong><br>'.$filia->getUlica().', '.$filia->getMiejscowosc());
        }

        if(!$filie)
        {
            $this->addFlash(
                'notice',
                'Brak wyników wyszukiwania');
        };

        asort($filieOdleglosci);

        return array(
            'filie'         =>  $filie,
            'form'          =>  $form->createView(),
            'promien'       =>  $promien,
            'odleglosc'     =>  $filieOdleglosci,
            'filieLatLng'   =>  json_encode($filieLatLng)
        );
    }

    /**
     * @Route("/wyszukiwarka/klienci-zajeci", name="wyszukiwarka_dwa")
     * @Template()
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function getListaKlientowWyszukiwarkaDrugaAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');

        $form = $this->get('form.factory')->create(new ListaKlientowByDaneFilterType(),null,array(
                'method'    =>  "GET",
                'action'    =>  $this->generateUrl('wyszukiwarka_dwa')
            )
        );

        if($request->query->has($form->getName()))
        {
            $form->submit($request->query->get($form->getName()));
            $filterBuilder = $this->get('doctrine.orm.entity_manager')->getRepository('DFPEtapIBundle:Filia')->createQueryBuilder('f')
                ->select('f','k','fu','u')
                ->leftJoin('f.klient','k')
                ->leftJoin('f.filieUzytkownicy','fu')
                ->leftJoin('fu.uzytkownik','u');

            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
            $filie = $paginator->paginate($filterBuilder->getQuery(), $this->get('request')->query->get('strona',1),25);
        };

        if(!isset($filie) or !$filie)
        {
            $this->addFlash(
                'notice',
                'Brak wyników wyszukiwania');
        };

        return array(
            'form'  =>  $form->createView(),
            'filie' =>  isset($filie) ? $filie : null
        );
    }

    private function getDistanceFromLatLonInKm($lat1, $lon1, $lat2, $lon2)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r = 6372.797;
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return $km;
    }
}
