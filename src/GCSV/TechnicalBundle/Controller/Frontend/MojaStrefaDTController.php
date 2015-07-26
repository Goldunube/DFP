<?php

namespace GCSV\TechnicalBundle\Controller\Frontend;


use Doctrine\Common\Collections\ArrayCollection;
use GCSV\TechnicalBundle\Entity\StatusZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Form\Filter\ListaWizytFilterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use GCSV\CustomerBundle\Entity\Oddzial;
use GCSV\CustomerBundle\Entity\Adres;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\UczestnikZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use GCSV\TechnicalBundle\Form\ZdarzenieTechniczneType;
use GCSV\TechnicalBundle\Entity\RodzajZdarzeniaTechnicznego;
use Ivory\GoogleMap\Services\Geocoding\Result\GeocoderResponse;

/**
 * Kontroler Zdarzen Technicznych
 * @package GCSV\TechnicalBundle\Controller\Frontend
 * @Route("/moja-strefa-dt")
 */
class MojaStrefaDTController extends Controller
{
    /**
     * Lista wszystkich zdarzeń technicznych
     * @Route(
     *      "/{strona}",
     *      requirements={"strona" = "\d+"},
     *      defaults={"strona" = 1},
     *      name="moje_wizyty_techniczne"
     * )
     * @Template()
     * @Method("GET")
     */
    public function mojeWizytyAction(Request $request, $strona)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $uid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')->create(new ListaWizytFilterType());

        $grupaTechnik = $em->getRepository('GCSVUserBundle:Grupa')->findOneByNazwa('Technik');

        if(!$this->get('request')->query->has($form->getName()))
        {
            $searchParam = $request->query->get('wizyty_filter');
            if($this->getUser()->getGrupy()->contains($grupaTechnik))
            {
                $searchParam['technik']  = $uid;
            }else{
                $searchParam['zlecajacy']  = $uid;
            }
            $request->query->set('wizyty_filter',$searchParam);
        }

        $form->submit($this->get('request')->query->get($form->getName()));
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego')
            ->createQueryBuilder('tzt')
            ->select('tzt,uzt,zt,os,rzt,odf,fi,rec,rap,raz')
            ->leftJoin('tzt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('uzt.zdarzenieTechniczne','zt')
            ->leftJoin('uzt.osoba','os')
            ->leftJoin('zt.oddzialFirmy','odf')
            ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
            ->leftJoin('odf.firma','fi')
            ->leftJoin('zt.receptury','rec')
            ->leftJoin('zt.raportyTechniczne','rap')
            ->leftJoin('zt.raportyZuzyc','raz')
            ->orderBy('tzt.rozpoczecieWizyty','DESC');

        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

        $searchQuery = $request->query->get('wizyty_filter');
        $zdarzenia = $filterBuilder;

        // PRZEFILTROWANIE ZDARZEŃ PO NAPISANYCH / NIENAPISANYCH RAPORTACH TECHNICZNYCH
        if(isset($searchQuery['raport_tech']))
        {
            if($searchQuery['raport_tech'] == 0 and ($searchQuery['raport_tech']) != null)
            {
                $resultArray = $filterBuilder->getQuery()->getResult();
                $zdarzenia = new ArrayCollection();
                /**
                 * @var TerminZdarzeniaTechnicznego $terminZdarzeniaTechnicznego
                 */
                foreach($resultArray as $terminZdarzeniaTechnicznego)
                {
                    $iloscRaportowTechnicznych = $terminZdarzeniaTechnicznego->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRaportyTechniczne()->count();
                    if($iloscRaportowTechnicznych == 0)
                    {
                        $zdarzenia->add($terminZdarzeniaTechnicznego);
                    }
                }
            }elseif($searchQuery['raport_tech'] == 1){
                $resultArray = $filterBuilder->getQuery()->getResult();
                $zdarzenia = new ArrayCollection();
                /**
                 * @var TerminZdarzeniaTechnicznego $terminZdarzeniaTechnicznego
                 */
                foreach($resultArray as $terminZdarzeniaTechnicznego)
                {
                    $iloscRaportowTechnicznych = $terminZdarzeniaTechnicznego->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRaportyTechniczne()->count();
                    if($iloscRaportowTechnicznych > 0)
                    {
                        $zdarzenia->add($terminZdarzeniaTechnicznego);
                    }
                }
            }
        }

        // PRZEFILTROWANIE ZDARZEŃ PO NAPISANYCH / NIENAPISANYCH RAPORTACH ZUŻYĆ
        if(isset($searchQuery['raport_zuz']))
        {
            if($searchQuery['raport_zuz'] == 0 and ($searchQuery['raport_zuz']) != null)
            {
                $resultArray = $filterBuilder->getQuery()->getResult();
                $zdarzenia = new ArrayCollection();
                /**
                 * @var TerminZdarzeniaTechnicznego $terminZdarzeniaTechnicznego
                 */
                foreach($resultArray as $terminZdarzeniaTechnicznego)
                {
                    $iloscRaportowZuzyc = $terminZdarzeniaTechnicznego->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRaportyZuzyc()->count();
                    if($iloscRaportowZuzyc == 0)
                    {
                        $zdarzenia->add($terminZdarzeniaTechnicznego);
                    }
                }
            }elseif($searchQuery['raport_zuz'] == 1){
                $resultArray = $filterBuilder->getQuery()->getResult();
                $zdarzenia = new ArrayCollection();
                /**
                 * @var TerminZdarzeniaTechnicznego $terminZdarzeniaTechnicznego
                 */
                foreach($resultArray as $terminZdarzeniaTechnicznego)
                {
                    $iloscRaportowZuzyc = $terminZdarzeniaTechnicznego->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRaportyZuzyc()->count();
                    if($iloscRaportowZuzyc > 0)
                    {
                        $zdarzenia->add($terminZdarzeniaTechnicznego);
                    }
                }
            }
        }

        $paginator = $this->get('knp_paginator');
        $paginacja = $paginator->paginate($zdarzenia, $strona, 25);

        /**
         * @var StatusZdarzeniaTechnicznego $status
         */
        $statusy = $em->getRepository('GCSVTechnicalBundle:StatusZdarzeniaTechnicznego')->findAll();
        $statusyArray = array();
        $statusyClassArray = array();
        foreach($statusy as $status)
        {
            $statusyArray[$status->getWartosc()] = $status->getNazwa();
            switch($status->getWartosc())
            {
                case -2:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case -1:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case 0:
                    $statusyClassArray[$status->getWartosc()] = 'warning';
                    break;
                case 1:
                    $statusyClassArray[$status->getWartosc()] = 'active';
                    break;
                case 2:
                    $statusyClassArray[$status->getWartosc()] = 'info';
                    break;
                case 3:
                    $statusyClassArray[$status->getWartosc()] = 'success';
                    break;
            }
        }

        return array(
            'terminy_zdarzen'   => $paginacja,
            'statusy'           => $statusyArray,
            'statusy_klasy'     => $statusyClassArray,
            'form'  =>  $form->createView(),
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
     * @Template("@GCSVTechnical/Backend/ZdarzenieTechniczne/new.html.twig")
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

        $mapa = $this->get('ivory_google_map.map');
        $event = $this->get('ivory_google_map.event');
        $event->setInstance($mapa->getJavascriptVariable());
        $event->setEventName('click');
        $mapId = $mapa->getJavascriptVariable();
        $handler = <<<javascript
            function(event)
            {
                if(marker !== undefined)
                {
                    marker.setPosition(event.latLng);

                }else{
                    placeMarker(event.latLng,$mapId);
                }
                codeLatLng(event.latLng,$mapId);
                $('#zdt_dlugoscGeo').val(event.latLng.lng());
                $('#zdt_szerokoscGeo').val(event.latLng.lat());
            }
javascript;
        $event->setHandle($handler);
        $mapa->getEventManager()->addEvent($event);

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
                        $wynik = $response->getResults();
                        $lokalizacja->setSzerokoscGeo($wynik[0]->getGeometry()->getLocation()->getLatitude());
                        $lokalizacja->setDlugoscGeo($wynik[0]->getGeometry()->getLocation()->getLongitude());

                        $em->persist($lokalizacja);
                    }
                }
                $zdarzenie->setDlugoscGeo($lokalizacja->getDlugoscGeo());
                $zdarzenie->setSzerokoscGeo($lokalizacja->getSzerokoscGeo());
            }

            //$zdarzenie->setOpis($html);
            $em->persist($zdarzenie);
            $em->flush();

            return $this->redirect($this->generateUrl('zaplecze_zdarzenie_techniczne_new'));

        }else{

        }

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zaplecze\/zdarzenia-techniczne?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('zaplecze_zdarzenia_techniczne');
        }

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
            'mapa'      =>  $mapa,
            'back_link' =>  $referer,
        );
    }

    /**
     * Tworzy formularz nowego Zdarzenia Technicznego
     */
    private function createCreateForm(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $form = $this->createForm(new ZdarzenieTechniczneType(), $zdarzenieTechniczne, array(
                'action'        =>  $this->generateUrl('zaplecze_zdarzenie_techniczne_create'),
                'method'        =>  'POST'
            )
        );

        $form->add('submit','submit',array('label'=>'Utwórz'));

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
        $form = $this->createCreateForm($zdarzenie);

        $mapa = $this->get('ivory_google_map.map');
        $mapa->setJavascriptVariable('mapa');
        $event = $this->get('ivory_google_map.event');
        $event->setInstance($mapa->getJavascriptVariable());
        $event->setEventName('click');
        $mapId = $mapa->getJavascriptVariable();
        $handler = <<<javascript
            function(event)
            {
                if(marker !== undefined)
                {
                    marker.setMap(null);
                }
                placeMarker(event.latLng,$mapId);
                codeLatLng(event.latLng,$mapId);
                $('#zdt_dlugoscGeo').val(event.latLng.lng());
                $('#zdt_szerokoscGeo').val(event.latLng.lat());
            }
javascript;
        $event->setHandle($handler);
        $mapa->getEventManager()->addEvent($event);

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zaplecze\/zdarzenia-techniczne?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('zaplecze_uzytkownicy');
        }

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
            'mapa'      =>  $mapa,
            'back_link' =>  $referer,
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
} 