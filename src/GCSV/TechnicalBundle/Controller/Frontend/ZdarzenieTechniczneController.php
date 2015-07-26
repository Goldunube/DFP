<?php

namespace GCSV\TechnicalBundle\Controller\Frontend;


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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use GCSV\CustomerBundle\Entity\Oddzial;
use GCSV\CustomerBundle\Entity\Adres;
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
        $terminZdarzenia = new TerminZdarzeniaTechnicznego();
        $uczestnikZdarzenia = new UczestnikZdarzeniaTechnicznego();
        $uczestnikZdarzenia->addTerminy($terminZdarzenia);
        $zdarzenie = new ZdarzenieTechniczne();
        $zdarzenie->addUczestnikZdarzeniaTechnicznego($uczestnikZdarzenia);
        $form = $this->createCreateForm($zdarzenie);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $polaDodatkowe = $this->get('request')->request->get('pola_dodatkowe');
            $dlugoscGeo = $form->get('dlugoscGeo')->getData();
            $szerokoscGeo = $form->get('szerokoscGeo')->getData();

            $html = null;
            if($polaDodatkowe)
            {
                foreach($polaDodatkowe as $idPytania => $pole)
                {
                    $dodatkowePytanie = $em->getRepository('GCSVTechnicalBundle:PytanieZdarzenieTechniczne')->find($idPytania);
                    $pytanie = $dodatkowePytanie->getPytanie();
                    $odpowiedz = $pole;
                    $html .= <<<HTML
<p><strong>$pytanie</strong>$odpowiedz</p>
HTML;

                };
            }

            //SPRAWDZENIE CZY POLA DŁUGOŚĆ I SZEROKOŚĆ GEOGRAFICZNA SĄ WYPEŁNIONE
            if(!$dlugoscGeo or !$szerokoscGeo)
            {
                $odzialFirmy = $form->get('oddzialFirmy')->getData();

                /**
                 * @var $lokalizacja Adres
                 */
                $lokalizacja = $odzialFirmy->getAdresy()->first();
                if(!$lokalizacja->getDlugoscGeo() || !$lokalizacja->getSzerokoscGeo())
                {
                    $kodPocztowy = substr_replace($lokalizacja->getKodPocztowy(),'-',2,0);
                    $adresString = $lokalizacja->getUlica().', '.$lokalizacja->getMiasto().', '.$kodPocztowy;
                    /**
                     * @var GeocoderResponse $response
                     */
                    $response = $this->get('ivory_google_map.geocoder')->geocode($adresString);
                    $status = $response->getStatus();
                    if($status == 'OK')
                    {
                        /**
                         * @var GeocoderResult $geocoderResult
                         */
                        $geocoderResults = $response->getResults();
                        $geocoderResult = $geocoderResults[0];
                        $lokalizacja->setSzerokoscGeo($geocoderResult->getGeometry()->getLocation()->getLatitude());
                        $lokalizacja->setDlugoscGeo($geocoderResult->getGeometry()->getLocation()->getLongitude());

                        $em->persist($lokalizacja);
                    }
                }
                $zdarzenie->setDlugoscGeo($lokalizacja->getDlugoscGeo());
                $zdarzenie->setSzerokoscGeo($lokalizacja->getSzerokoscGeo());
            }

            $em->persist($zdarzenie);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',array('title'=>'Udało się!','body'=>'Nowe zdarzenie techniczne zostało pomyślne zapisane w kalendarzu Technicznym.'));

            return $this->redirect($this->generateUrl('zdarzenie_techniczne_new'));

        }else{
            $this->get('session')->getFlashBag()->add('danger',array('title'=>'Błąd!','body'=>'Wystąpił błąd podczas próby dodania nowego zdarzenia technicznego. Sprawdź poprawność wypełnienia wszystkich wymaganych pól formularza.'));
        }

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zaplecze\/zdarzenia-techniczne?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('zdarzenia_techniczne');
        }

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
            'back_link' =>  $referer,
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

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zdarzenia-techniczne?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('zdarzenia_techniczne');
        }

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
            'back_link' =>  $referer,
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

        $dokumentacja = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->getRaportyTechniczne($zdarzenie->getId());
        $raportyZuzycia = $em->getRepository('GCSVRaportBundle:RaportZuzycia')->findBy(array('zdarzenieTechniczne'=>$zdarzenie));
        $receptury = $em->getRepository('GCSVRecepturaBundle:Receptura')->findByZdarzenieTechniczne($id);
        $notatki = $em->getRepository('GCSVRaportBundle:Notatka')->findBy(array('zdarzenieTechniczne'=>$zdarzenie));
        $stopienRealizacji = $zdarzenie->getStopienRealizacji();
        switch(true)
        {
            case ($stopienRealizacji > 30 and $stopienRealizacji <= 70):
                $stopienRealizacjiClass = 'warning';
                break;
            case ($stopienRealizacji > 70):
                $stopienRealizacjiClass = 'success';
                break;
            default:
                $stopienRealizacjiClass = 'danger';
        }

        $mapa = $this->get('ivory_google_map.map');
        $mapa->setAsync(false);
        $mapa->setAutoZoom(true);
        $mapa->setStylesheetOption('width', '100%');
        $mapa->setStylesheetOption('height', '500px');
        $marker = new Marker;
        if($zdarzenie->getDlugoscGeo() && $zdarzenie->getSzerokoscGeo())
        {
            $requestDirections = $this->container->get('ivory_google_map.directions_request');
            $curlHttpAdapter = $this->container->get('widop_http_adapter.curl');
            $directions = $this->container->get('ivory_google_map.directions');

            $orginSzerokoscGeo = floatval($zdarzenie->getUczestnikZdarzeniaTechnicznego()->first()->getOsoba()->getProfil()->getLat());
            $orginDlugoscGeo = floatval($zdarzenie->getUczestnikZdarzeniaTechnicznego()->first()->getOsoba()->getProfil()->getLng());
            $destSzerokoscGeo = floatval($zdarzenie->getSzerokoscGeo());
            $destDlugoscGeo = floatval($zdarzenie->getDlugoscGeo());
            $requestDirections->setOrigin($orginSzerokoscGeo,$orginDlugoscGeo,true);
            $requestDirections->setDestination($destSzerokoscGeo,$destDlugoscGeo,true);
            $requestDirections->setLanguage('pl');
            $requestDirections->setRegion('pl');
            $directions->setHttpAdapter($curlHttpAdapter);
            $responseDirections = $directions->route($requestDirections);
            $routes = $responseDirections->getRoutes();
//            $route->getOverviewPolyline();

            if($routes)
            {
                $encodedPolyline = $routes[0]->getOverviewPolyline();
                $encodedPolyline->setOption('strokeColor', '#00F');
                $encodedPolyline->setOption('geodesic', true);
                $mapa->addEncodedPolyline($encodedPolyline);
            }else{
                $marker->setPosition($zdarzenie->getSzerokoscGeo(),$zdarzenie->getDlugoscGeo());
                $marker->setAnimation('drop');
                $mapa->addMarker($marker);

                $geocoderRequest = $this->get('ivory_google_map.geocoder_request');
                $geocoderRequest->setCoordinate($zdarzenie->getSzerokoscGeo(),$zdarzenie->getDlugoscGeo());
                /**
                 * @var GeocoderResponse $response
                 */
                $response = $this->get('ivory_google_map.geocoder')->geocode($geocoderRequest);
                if($response->getStatus() == 'OK')
                {
                    /**
                     * @var GeocoderResult $geocoderResult
                     */
                    $geocoderResults = $response->getResults();
                    $geocoderResult = $geocoderResults[0];
                    $adres = $geocoderResult->getFormattedAddress();
                }
            }
        }else{
            $mapa->setAutoZoom(false);
            $mapa->setCenter(51.9189046,19.1343786,true);
            $mapa->setMapOption('zoom', 6);
        }

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zdarzenia-techniczne?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('zdarzenia_techniczne');
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
            'dokumentacja'              =>  $dokumentacja,
            'raporty_zuzycia'           =>  $raportyZuzycia,
            'notatki'                   =>  $notatki,
            'back_link'                 =>  $referer,
            'stopien_realizacji_class'  =>  $stopienRealizacjiClass,
            'receptury'                 =>  $receptury,
            'mapa'                      =>  $mapa,
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
            'zdarzenie' =>  $zdarzenieTechniczne,
            'raport'    => $raportTechniczny,
            'back_link' =>  $referer,
            'form'      => $form->createView(),
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
     * @Method("GET")
     * @Template("GCSVRaportBundle:Frontend/RaportTechniczny:new.html.twig")
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function newRaportTechnicznyAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $zdarzenieTechniczne = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->find($id);
        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć zdarzenia technicznego.');
        }

        $raportTechniczny = new RaportTechniczny();
        $raportTechniczny->setZdarzenieTechniczne($zdarzenieTechniczne);
        $raportTechniczny->setCel($zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getNazwa());
        $form = $this->createForm(new RaportTechnicznyType(), $raportTechniczny, array(
                'action'    =>  $this->generateUrl('zdarzenie_techniczne_raport_techniczny_create', array('id' => $id)),
                'method'    =>  'POST'
            )
        );
        $form->add('submit','submit',array(
                'label' =>  'Zapisz'
            )
        );

        $_SESSION['imgmanager_upload_directory'] = "zdarzenia_techniczne/$id/";

        $referer =  array("name"    =>  'zdarzenie_techniczne_show', "args" =>  array('id'=>$id));

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
     * @Route(
     *      "{id}/get-dodatkowe-pytania",
     *      name="ajax_get_dodatkowe_pola_zdarzenia",
     *      options={"expose"=true}
     * )
     * @Method("GET")
     */
    public function getDodatkowePytaniaHTML($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var RodzajZdarzeniaTechnicznego $rodzaj
         */
        $rodzaj = $em->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego')->find($id);

        if(!$rodzaj)
        {
            throw $this->createNotFoundException('Szukany rodzaj zdarzenia technicznego nie został odnaleziony.');
        }

        $dodatkowePolaFormularza = null;

        foreach($rodzaj->getRodzajePytan() as $wiersz)
        {
            $id = $wiersz->getPytanie()->getId();
            $label = $wiersz->getPytanie()->getPytanie();
            $pole = "<input id=\"pole_$id\" name=\"pola_dodatkowe[$id]\" type=\"text\" class=\"form-control\">";
            $dodatkowePolaFormularza .= <<<HTML
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pole_$id">$label</label>
                    <div class="form-control-static col-sm-9">
                        $pole
                    </div>
                </div>
HTML;
        }

        return new Response($dodatkowePolaFormularza);
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