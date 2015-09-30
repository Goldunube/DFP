<?php

namespace GCSV\TechnicalBundle\Controller\Backend;

use GCSV\TechnicalBundle\Entity\StatusZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\UczestnikZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use GCSV\TechnicalBundle\Form\Filter\ListaWizytFilterType;
use GCSV\TechnicalBundle\Form\ZdarzenieTechniczneType;
use Ivory\GoogleMap\Services\Geocoding\Result\GeocoderResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Kontroler Zdarzen Technicznych
 * @package GCSV\TechnicalBundle\Controller\Backend
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
     *      name="zaplecze_zdarzenia_techniczne"
     * )
     * @Template()
     * @Method("GET")
     */
    public function indexAction(Request $request, $strona)
    {
        $form = $this->get('form.factory')->create(new ListaWizytFilterType());

        $form->submit($this->get('request')->query->get($form->getName()));
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego')
            ->createQueryBuilder('tzt')
            ->select('tzt,uzt,zt,os,rzt,odf,fi,rap,raz,sta')
            ->leftJoin('tzt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('tzt.status','sta')
            ->leftJoin('uzt.zdarzenieTechniczne','zt')
            ->leftJoin('uzt.osoba','os')
            ->leftJoin('zt.oddzialFirmy','odf')
            ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
            ->leftJoin('odf.klient','fi')
            ->leftJoin('zt.raportyTechniczne','rap')
            ->leftJoin('zt.raportyZuzyc','raz')
            ->orderBy('tzt.rozpoczecieWizyty','DESC');

        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

        $zdarzenia = $filterBuilder;

        $paginator = $this->get('knp_paginator');
        $paginacja = $paginator->paginate($zdarzenia, $strona, 25);


        return array(
            'terminy_zdarzen'   => $paginacja,
            'form'              =>  $form->createView(),
        );
    }

    /**
     * Tworzy nowe Zdarzenie Techniczne
     *
     * @Route(
     *      "/",
     *      name="zaplecze_zdarzenie_techniczne_create"
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
     * Tworzy nowe Zdarzenie Techniczne (wersja modal)
     *
     * @Route(
     *      "/modal/",
     *      name="zaplecze_zdarzenie_techniczne_create_modal",
     *      options={"expose"=true}
     * )
     * @Method("POST")
     * @Template("@GCSVTechnical/Backend/ZdarzenieTechniczne/newModal.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createModalAction(Request $request)
    {
        $terminZdarzenia = new TerminZdarzeniaTechnicznego();
        $uczestnikZdarzenia = new UczestnikZdarzeniaTechnicznego();
        $uczestnikZdarzenia->addTerminy($terminZdarzenia);
        $zdarzenie = new ZdarzenieTechniczne();
        $zdarzenie->addUczestnikZdarzeniaTechnicznego($uczestnikZdarzenia);
        $form = $this->createCreateModalForm($zdarzenie);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($zdarzenie);
        $em->flush();

        $response = new JsonResponse();
        $response->setData("Poprawnie utworzono Zdarzenie Techniczne.");

        return $response;
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
     * Tworzy formularz modalny nowego Zdarzenia Technicznego
     */
    private function createCreateModalForm(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $form = $this->createForm(new ZdarzenieTechniczneType(), $zdarzenieTechniczne, array(
                'action'        =>  $this->generateUrl('zaplecze_zdarzenie_techniczne_create_modal'),
                'method'        =>  'POST'
            )
        );

        $form->add('submit','submit',array('label'=>'Utwórz'));
        $form->add('status');
        $form->add('opis','textarea');
        $form->add('reset','reset',array(
                'label'     =>  'Resetuj'
            )
        );
        $form->remove('priorytet');

        return $form;
    }

    /**
     * Wyświetla formularz w celu dodania nowego Zdarzenia Technicznego
     *
     * @Route(
     *      "/nowe-zdarzenie",
     *      name="zaplecze_zdarzenie_techniczne_new"
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
     * Wyświetla formularz w postaci modalnej w celu dodania nowego Zdarzenia Technicznego
     *
     * @Route(
     *      "/nowe-zdarzenie-modal/{dataOd}_{dataDo}",
     *      requirements={"dataOd" = "^\d{4}-\d{2}-\d{2}$"},
     *      requirements={"dataDo" = "^\d{4}-\d{2}-\d{2}$"},
     *      name="zaplecze_zdarzenie_techniczne_new_modal",
     *      options={"expose"=true}
     * )
     * @Method("GET")
     * @Template()
     */
    public function newModalAction($dataOd,$dataDo)
    {
        $dataOd = new \DateTime($dataOd);
        $dataDo = new \DateTime($dataDo);
        $terminZdarzenia = new TerminZdarzeniaTechnicznego();
        $terminZdarzenia->setRozpoczecieWizyty($dataOd);
        $terminZdarzenia->setZakonczenieWizyty($dataDo);
        $uczestnikZdarzenia = new UczestnikZdarzeniaTechnicznego();
        $uczestnikZdarzenia->addTerminy($terminZdarzenia);
        $zdarzenie = new ZdarzenieTechniczne();
        $zdarzenie->addUczestnikZdarzeniaTechnicznego($uczestnikZdarzenia);
        $form = $this->createCreateModalForm($zdarzenie);

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
        );
    }

    /**
     * Wyświetla formularz w postaci modalnej w celu dodania nowego Zdarzenia Technicznego
     *
     * @Route(
     *      "/{id}/edycja-zdarzenie-modal",
     *      name="zaplecze_zdarzenie_techniczne_edit_modal",
     *      options={"expose"=true}
     * )
     * @Method("GET")
     * @Template()
     */
    public function editModalAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $zdarzenie = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->find($id);

        if (!$zdarzenie) {
            throw $this->createNotFoundException('Szukane zdarzenie techniczne nie istnieje.');
        }

        $form = $this->createEditModalForm($zdarzenie);
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

        return array(
            'zdarzenie' =>  $zdarzenie,
            'form'      =>  $form->createView(),
            'mapa'      =>  $mapa,
        );
    }

    /**
     * Tworzy formularz modalny edycji Zdarzenia Technicznego
     */
    private function createEditModalForm(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $form = $this->createForm(new ZdarzenieTechniczneType(), $zdarzenieTechniczne, array(
                'action'        =>  $this->generateUrl('zaplecze_zdarzenie_techniczne_update_modal', array('id' => $zdarzenieTechniczne->getId())),
                'method'        =>  'PUT'
            )
        );

        $form->add('submit','submit',array('label'=>'Aktualizuj'));
        $form->add('status');
        $form->add('opis','textarea');
        $form->add('reset','reset',array(
                'label'     =>  'Resetuj'
            )
        );
        $form->remove('priorytet');

        return $form;
    }

    /**
     * Aktualizuje informacje o Zdarzeniu Technicznym
     *
     * @Route(
     *      "/{id}",
     *      name="zaplecze_zdarzenie_techniczne_update_modal",
     *      options={"expose"=true}
     * )
     * @Method("PUT")
     * @Template("@GCSVTechnical/Backend/ZdarzenieTechniczne/editModal.html.twig")
     * @param Request $request
     * @param $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateModalAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $zdarzenieTechniczne = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->find($id);
        if (!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć szukanego zdarzenia technicznego');
        }

        $form = $this->createEditModalForm($zdarzenieTechniczne);
        $form->handleRequest($request);

        $em->persist($zdarzenieTechniczne);
        $em->flush();

        $response = new JsonResponse();
        $response->setData("Poprawnie utworzono Zdarzenie Techniczne.");

        return $response;
    }

    /**
     * (AJAX) Akceptuje zdarzenie
     *
     * @Route(
     *      "/termin/{id}/decyzja/{status}",
     *      name="ajax_decyzja_zdarzenie_techniczne",
     *      options={"expose"=true}
     * )
     * @Method("PUT")
     * @Security("has_role('ROLE_KDFP')")
     * @ParamConverter("status", class="GCSVTechnicalBundle:StatusZdarzeniaTechnicznego", options={"mapping": {"status" : "wartosc"}})
     */
    public function akceptujZdarzenieTechniczneAjaxAction(TerminZdarzeniaTechnicznego $terminZdarzeniaTechnicznego,StatusZdarzeniaTechnicznego $status)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$terminZdarzeniaTechnicznego)
        {
            throw $this->createNotFoundException('Nie można odnaleźć wskazanego terminu zdarzenia technicznego.');
        }

        $terminZdarzeniaTechnicznego->setStatus($status);
        $terminZdarzeniaTechnicznego->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->setStatus($status);
        $em->flush();

        $response = new JsonResponse();
        $response->setData("Akceptacja terminu zdarzenia techicznego zakończona sukcesem.");

        return $response;
    }

    /**
     * (AJAX) Całkowicie usuwa zdarzenie z bazy danych
     *
     * @Route(
     *      "/{id}",
     *      name="ajax_delete_zdarzenie_techniczne",
     *      options={"expose"=true}
     * )
     * @Method("DELETE")
     * @Security("has_role('ROLE_KDFP')")
     */
    public function deleteAjaxAction(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$zdarzenieTechniczne)
        {
            throw $this->createNotFoundException('Nie można odnaleźć wskazanego Zdarzenia Technicznego.');
        }

        $em->remove($zdarzenieTechniczne);
        $em->flush();

        $response = new JsonResponse();
        $response->setData("Poprawnie usunięto Zdarzenie Techniczne.");

        return $response;
    }

    /**
     * (AJAX) Przesuwa zadarzenie
     *
     * @Route(
     *      "/termin/{terminId}/{dataOd}_{dataDo}",
     *      requirements={"dataOd" = "^\d{4}-\d{2}-\d{2}$"},
     *      requirements={"dataDo" = "^\d{4}-\d{2}-\d{2}$"},
     *      name="ajax_resize_move_zdarzenie_techniczne",
     *      options={"expose"=true}
     * )
     * @Method("PUT")
     */
    public function resizeMoveAjaxAction($terminId,$dataOd,$dataDo)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var TerminZdarzeniaTechnicznego $termin
         */
        $termin = $em->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego')->find($terminId);

        if(!$termin)
        {
            throw $this->createNotFoundException('Nie można odnaleźć wskazanego terminu Zdarzenia Technicznego.');
        }

        $dataOd = new \DateTime($dataOd);
        $dataDo = new \DateTime($dataDo);

        $termin->setRozpoczecieWizyty($dataOd);
        $termin->setZakonczenieWizyty($dataDo);

        $em->flush();

        $response = new JsonResponse();
        $response->setData("Poprawnie usunięto Zdarzenie Techniczne.");

        return $response;
    }

    /**
     * (AJAX) Pobiera informacje o zdarzeniu
     * @Route(
     *      "/ajax/{id}/get-zdarzenie-ajax",
     *      name="zaplecze_zdarzenie_techniczne_get_data_ajax",
     *      options={"expose"=true}
     * )
     * @Method("GET")
     * @Security("has_role('ROLE_KDFP')")
     */
    public function getZdarzenieTechniczneDataAjaxAction(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $zdarzenieId = $zdarzenieTechniczne->getId();
        $oddzialFirmy = $zdarzenieTechniczne->getOddzialFirmy();
        $klient = '';
        if($oddzialFirmy)
        {
            $firma = $oddzialFirmy->getKlient()->getNazwaSkrocona();
            $miasto = $oddzialFirmy->getMiejscowosc();
            $klient = "$firma ($miasto)";
        }
        $opis = $zdarzenieTechniczne->getOpis();
        $status = $zdarzenieTechniczne->getStatus();
        $rodzajId = $zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getId();
        $technik = $zdarzenieTechniczne->getUczestnikZdarzeniaTechnicznego()->first();
        $technikId = $technik ? $technik->getOsoba()->getId() : null;
        $zlecajacyId = $zdarzenieTechniczne->getOsobaZlecajaca()->getId();
        $rozpoczecie = $technik->getTerminy()->first()->getRozpoczecieWizyty()->format('Y-m-d');
        $zakonczenie = $technik->getTerminy()->first()->getZakonczenieWizyty()->format('Y-m-d');
        $szerokoscGeo = $zdarzenieTechniczne->getSzerokoscGeo();
        $dlugoscGeo = $zdarzenieTechniczne->getDlugoscGeo();
        $response = new JsonResponse();
        $response->setData(array('idZdarzenia'=>$zdarzenieId,'opis'=>$opis,'status'=>$status,'rodzaj'=>$rodzajId,'technik'=>$technikId,'zlecajacy'=>$zlecajacyId,'rozpoczecie'=>$rozpoczecie,'zakonczenie'=>$zakonczenie,'szerokosc'=>$szerokoscGeo,'dlugosc'=>$dlugoscGeo,'klient'=>$klient));

        return $response;
    }
} 