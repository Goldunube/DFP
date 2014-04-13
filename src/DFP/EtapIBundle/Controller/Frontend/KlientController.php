<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Entity\Klient;
use DFP\EtapIBundle\Entity\ProcesAplikacji;
use DFP\EtapIBundle\Entity\ProcesPrzygotowaniaPowierzchni;
use DFP\EtapIBundle\Entity\ProcesUtwardzaniaPowloki;
use DFP\EtapIBundle\Entity\RodzajPowierzchni;
use DFP\EtapIBundle\Entity\Uzytkownik;
use DFP\EtapIBundle\Entity\FiliaUzytkownik;
use DFP\EtapIBundle\Entity\FiliaNotatka;
use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use DFP\EtapIBundle\Entity\FiliaProcesPrzygotowaniaPowierzchni;
use DFP\EtapIBundle\Entity\WymaganiaPowloki;
use DFP\EtapIBundle\Entity\WymaganiaProduktu;
use DFP\EtapIBundle\Form\FiliaNotatkaType;
use DFP\EtapIBundle\Form\FiliaType;
use DFP\EtapIBundle\Form\KlientType;
use DFP\EtapIBundle\Form\KartaKlientaPodstawowaType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend Klient Controller
 * @package DFP\EtapIBundle\Controller\Frontend
 *
 * @Route("/klient")
 */

class KlientController extends Controller
{
    /**
     * Lista wszystkich klientów.
     *
     * @Route("/", name="url_lista_klientow")
     * @Method("GET")
     * @Template()
     *
     */
    public function listaKlientowAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $queryProcess = $em->getRepository('DFPEtapIBundle:FiliaUzytkownik')->getZnajdzFilieUzytkownikaQuery($this->getUser());

        $pagination = $paginator->paginate($queryProcess,$this->get('request')->query->get('strona',1),11);

        return array(
            'filie_uzytkownika'  => $pagination,
        );
    }

    /**
     * TODO: Zmienić
     * Tworzy nową podstawową kartę klienta.
     *
     * @Route("/", name="url_utworz_karte_klienta_podstawowa")
     * @Method("POST")
     */
    public function utworzKartePodstawowaAction(Request $request)
    {
        $klient = new Klient();
        $klient->setDataZalozenia(new \DateTime('now'));
        $klient->setAktywny();

        $filia = new Filia();
        if($filia->getNazwaFilii() == null)
        {
            $filia->setNazwaFilii('Filia Główna');
        }
        $filia->setKlient($klient);
        $klient->getFilie()->add($filia);

        $filiaUzytkownik = new FiliaUzytkownik();
        $filiaUzytkownik->setUzytkownik($this->getUser());
        $filiaUzytkownik->setFilia($filia);
        $filiaUzytkownik->setPoczatekPrzypisania(new \DateTime('now'));
        $filiaUzytkownik->setKoniecPrzypisania(new \DateTime('+30 days'));
//        $filiaUzytkownik->setKoniecPrzypisania(new \DateTime('+7 days'));
        $filiaUzytkownik->setAkcept(true);
        $filia->getFilieUzytkownicy()->add($filiaUzytkownik);

        $form = $this->createForm(new KlientType(), $klient, array(
                'action' => $this->generateUrl('url_utworz_karte_klienta_podstawowa'),
                'method' => 'POST',
            )
        );
        $form->add('submit', 'submit', array('label'=> 'Utworz'));
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($klient);
            $klient->setKanalDystrybucji('DFP');
            $em->flush();

            return $this->redirect($this->generateUrl('url_lista_klientow'));
        };
        return array(
            'klient'    => $klient,
            'form'      => $form->createView(),
        );
    }

    /**
     *  Dodaje nową filię do klienta już istniejącego w bazie danych.
     *
     *  @Route("/filia", name="url_dodaj_filie_klienta")
     *  @Method("POST")
     */
    public function dodajFilieKlientaAction(Request $request)
    {
        $filia = new Filia();
//        $filia->setPotencjalny(true);

        $filiaUzytkownik = new FiliaUzytkownik();
        $filiaUzytkownik->setUzytkownik($this->getUser());
        $filiaUzytkownik->setFilia($filia);
        $filiaUzytkownik->setPoczatekPrzypisania(new \DateTime('now'));
        $filiaUzytkownik->setKoniecPrzypisania(new \DateTime('+30 days'));
//        $filiaUzytkownik->setKoniecPrzypisania(new \DateTime('+7 days'));
        $filiaUzytkownik->setAkcept(true);
        $filia->getFilieUzytkownicy()->add($filiaUzytkownik);

        $form = $this->createForm(new FiliaType(),$filia,array());
        $form
            ->add('nazwaFilii','text')
            ->add('klient','entity',array(
                    'class'     => 'DFPEtapIBundle:Klient',
                    'property'  => 'id'
                )
            );
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:Filia')->findOneByZip($filia->getKodPocztowy());
            if(!$entity)
            {
                $em->persist($filia);
                $em->flush();
            }else{
                //TODO: Dodać warunek sprawdzający przypisanie klienta do użytkownika
            }

        }else{
            //return $this->redirect($this->generateUrl('strona_glowna'));
        }

        return $this->redirect($this->generateUrl('url_lista_klientow'));
    }

    /**
     * TODO Przebudować akcje zakładania nowej podstawowej karty klienta
     *
     * Kontroler podstawowej karty klienta formularza wieloetapowego
     *
     * @Route("/nowy2", name="url_fm_podstawowa_karta_klienta")
     * @Template("@DFPEtapI/Frontend/Klient/fmKartaKlientaPodstawowaEtap1.html.twig")
     */
    public function wyswietlFmPodstawowaKarteKlientaEtap1Action(Request $request)
    {
        $klient = new Klient();
        $filia = new Filia();
        $klient->getFilie()->add($filia);

        $klient->setDataZalozenia(new \DateTime('now'));
        $form = $this->createForm(new KartaKlientaPodstawowaType(),$klient,array(
                'action'    => $this->generateUrl('url_fm_podstawowa_karta_klienta'),
            )
        );
        $form->add('submit', 'submit', array('label' => 'Dalej'));

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            /* @var $entity Klient */
            $entity = $em->getRepository('DFPEtapIBundle:Klient')->findOneByNIP($klient->getNip());
            if(!$entity)
            {
                $form = $this->createForm(new KartaKlientaPodstawowaType(),$klient,array(
                        'action'    =>  $this->generateUrl('url_utworz_karte_klienta_podstawowa'),
                        'method'    =>  'POST'
                    )
                );
                $form->add('nip','hidden');
                $form->add('submit', 'submit', array('label' => 'Dalej'));
                return $this->render('DFPEtapIBundle:Frontend/Klient:fmKartaKlientaPodstawowaEtap2.html.twig',array(
                    'klient'            => $klient,
                    'kartaPodstawowa'   => $form->createView(),
                ));
            }else{
                $filia = new Filia();
                $filia->setKlient($entity);
                $form2step = $this->createForm(new FiliaType(),$filia,array(
                        'action'    => $this->generateUrl('url_dodaj_filie_klienta'),
                        'method'    => 'POST',
                    )
                );
                $form2step
                    ->add('nazwaFilii','text')
                    ->add('klient','hidden',array(
                            'data'  =>  $entity->getId(),
                        )
                    )
                    ->add('powrot','submit',array('label'=>'Powrót'))
                    ->add('dodaj','submit',array('label'=>'Dodaj'));
                return $this->render('DFPEtapIBundle:Frontend/Klient:filieKlienta.html.twig',array(
                    'klient'            => $entity,
                    'drugiFormularz'    => $form2step->createView(),
                ));
            }
        }

        return array(
            'klient'                => $klient,
            'kartaPodstawowa'       => $form->createView(),
        );
    }

    /**
     * Znajduje i wyświetla Klienta
     *
     * @Route("/{id}", name="url_pokaz_karte_klienta")
     * @Method("GET")
     * @Template()
     */
    public function pokazKarteKlientaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $klient = $em->getRepository('DFPEtapIBundle:Klient')->find($id);

        if (!$klient) {
            throw $this->createNotFoundException('Nie znaleziono karty klienta.');
        }
        return array(
            'klient'                => $klient,
        );
    }

    /**
     * @param $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     * @Route("/filia/{id}", name="frontend_pokaz_filie_klienta")
     * @Template()
     * @Method("GET")
     */
    public function pokazKarteFiliiAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        if (!$filia) {
            throw $this->createNotFoundException('Nie znaleziono filii klienta.');
        }

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        return array(
            'filia' => $filia,
            'notatka_kategorie' => $kategorieNotatek
        );
    }

    /**
     * @param $id
     * @return array
     * @Route("/filia/{id}/notatka/", name="frontend_filia_notatka_new")
     * @Template()
     * @Method("GET")
     */
    public function nowaNotatkaFiliiAction($id)
    {
        //TODO dodać sprawdzenie, czy osoba zalogowana może dodawać notatki do tej filii.

        $em = $this->getDoctrine()->getManager();
        $notatka = new FiliaNotatka();

        /* @var $filia Filia*/
        $filia  = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        $form = $this->createForm(new FiliaNotatkaType(), $notatka, array(
                'action'    =>  $this->generateUrl('frontend_filia_notatka_stworz' ,array('id'=>$filia->getId())),
                'method'    =>  "POST",
        ));

        $form->add('submit','submit',array('label' => 'Dodaj'));

        return array(
            'form'      => $form->createView(),
        );

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/filia/{id}/notatka/", name="frontend_filia_notatka_stworz")
     * @Method("POST")
     */
    public function stworzNotatkaFiliiAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $filia Filia */
        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);
        $notatka = new FiliaNotatka();

        $form = $this->createForm(new FiliaNotatkaType(), $notatka, array(
                'action'    =>  $this->generateUrl('frontend_filia_notatka_stworz' ,array('id'=>$filia->getId())),
                'method'    =>  "POST",
        ));
        $form->add('submit','submit',array('label' => 'Dodaj'));

        $form->handleRequest($request);

        if($form->isValid())
        {
            $notatka->setStatus(true);
            $notatka->setDataSporzadzenia(new \DateTime('now'));
            $notatka->setKoniecEdycji(new \DateTime('+30 minutes'));
            $notatka->setFilia($filia);
            $notatka->setUzytkownik($this->getUser());

            $em->persist($notatka);
            $em->flush();

            return $this->redirect($this->generateUrl('frontend_pokaz_filie_klienta',array('id'=>$id)));
        }
    }

    /**
     * @param $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/filia/notatka/{id}/usun", name="frontend_filia_notatka_usun")
     */
    public function usunNotatkeFiliiAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        /* @var $notatka FiliaNotatka */
        $notatka = $em->getRepository('DFPEtapIBundle:FiliaNotatka')->find($id);

        /* @var $filia Filia */
        $filia = $notatka->getFilia();
        if(!$notatka)
        {
            throw $this->createNotFoundException('Notatka, którą chcesz usunąć, nie istnieje.');
        }

        $autor = $notatka->getUzytkownik();
        if($this->getUser() == $autor)
        {
            if($notatka->getKoniecEdycji() > new \DateTime('now') )
            {
                $em->remove($notatka);
            }else{
                $notatka->setStatus(false);
            }
            $em->flush();
        }

        return $this->redirect($this->generateUrl('frontend_pokaz_filie_klienta', array('id'=>$filia->getId())));
    }

    public function edytujNotatkeFiliiAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $notatka = $em->getRepository('DFPEtapIBundle:FiliaNotatka')->find($id);

        if(!$notatka)
        {
            throw $this->createNotFoundException('Nie znaleziono wskazanej notatki.');
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Route("/filia/{id}/edytuj", name="frontend_filia_edytuj")
     * @Template("@DFPEtapI/Frontend/Klient/editFilia.html.twig")
     * @Method({"GET", "PUT"})
     *
     */
    public function edytujFilieAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $filia Filia */
        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);
        $filiaPPP = new FiliaProcesPrzygotowaniaPowierzchni();
        $filiaPPP->setFilia($filia);

        //TODO dodać sprawdzenie, czy osoba która próbuje edytować filie ma odpowiednie uprawnienia

        if(!$filia)
        {
            throw $this->createNotFoundException('Nie znaleziono wskazanej filii.');
        }

        $aktualnePPP = new ArrayCollection();
        foreach ($filia->getFilieProcesyPrzygotowaniaPowierzchni() as $filiaPPP)
        {
            $aktualnePPP->add($filiaPPP);
        }

        $aktualnePA = new ArrayCollection();
        foreach($filia->getFilieProcesyAplikacji() as $filiaPA)
        {
            $aktualnePA->add($filiaPA);
        }

        $editFiliaForm = $this->createForm(new FiliaType(), $filia, array(
                'action'    => $this->generateUrl('frontend_filia_edytuj', array('id' => $filia->getId())),
                'method'    => 'PUT'
        ));

        $editFiliaForm->add('submit', 'submit', array('label' => 'Aktualizuj'));

        $editFiliaForm->handleRequest($request);
        if($editFiliaForm->isValid())
        {
            foreach($aktualnePPP as $ppp)
            {
                if(false === $filia->getFilieProcesyPrzygotowaniaPowierzchni()->contains($ppp))
                {
                    $filia->removeFilieProcesyPrzygotowaniaPowierzchnus($ppp);
                }
            }

            $em->persist($filia);
            $em->flush();

            return $this->redirect($this->generateUrl('frontend_pokaz_filie_klienta', array('id'=>$filia->getId())));
        }

        return array(
            'filia'     =>  $filia,
            'formularz' =>  $editFiliaForm->createView()
        );
    }

    /**
     * @Route("/filia/edytuj/ajax/metoda_aplikacji", name="frontend_filia_edytuj_ajax_metoda_aplikacji_opis")
     */
    public function pobierzOpisAplikacji()
    {
        $request = $this->container->get('request');
        $idMetodyAplikacji = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var $metodaAplikacji ProcesAplikacji
         */
        $metodaAplikacji = $em->getRepository('DFPEtapIBundle:ProcesAplikacji')->find($idMetodyAplikacji);

        $response = array("code"=>100, "success"=>true, "opis"=>$metodaAplikacji->getOpis());

        return new JsonResponse($response,200,array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/filia/edytuj/ajax/rodzaj_powierzchni", name="frontend_filia_edytuj_ajax_rodzaj_powierzchni_opis")
     */
    public function pobierzOpisRodzajowPowierzchni()
    {
        $request = $this->container->get('request');
        $idRodzajPowierzchni = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var $RodzajPowierzchni RodzajPowierzchni
         */
        $RodzajPowierzchni = $em->getRepository('DFPEtapIBundle:RodzajPowierzchni')->find($idRodzajPowierzchni);

        $response = array("code"=>100, "success"=>true, "opis"=>$RodzajPowierzchni->getOpis());

        return new JsonResponse($response,200,array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/filia/edytuj/ajax/proces_przygotowania_powierzchni", name="frontend_filia_edytuj_ajax_proces_przygotowania_powierzchni_opis")
     */
    public function pobierzOpisProcesowPrzygotowaniaPowierzchni()
    {
        $request = $this->container->get('request');
        $idProcesuPrzygotowaniaPowierzchni = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ProcesuPrzygotowaniaPowierzchni ProcesPrzygotowaniaPowierzchni
         */
        $ProcesuPrzygotowaniaPowierzchni = $em->getRepository('DFPEtapIBundle:ProcesPrzygotowaniaPowierzchni')->find($idProcesuPrzygotowaniaPowierzchni);

        $response = array("code"=>100, "success"=>true, "opis"=>$ProcesuPrzygotowaniaPowierzchni->getOpis());

        return new JsonResponse($response,200,array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/filia/edytuj/ajax/parametr_utwardzania_powloki", name="frontend_filia_edytuj_ajax_parametr_utwardzania_powloki_opis")
     */
    public function pobierzOpisParametrUtwardzaniaPowloki()
    {
        $request = $this->container->get('request');
        $idParametruUtwardzaniaPowloki = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ParametrUtwardzaniaPowloki ProcesUtwardzaniaPowloki
         */
        $ParametrUtwardzaniaPowloki = $em->getRepository('DFPEtapIBundle:ProcesUtwardzaniaPowloki')->find($idParametruUtwardzaniaPowloki);

        $response = array("code"=>100, "success"=>true, "opis"=>$ParametrUtwardzaniaPowloki->getOpis());

        return new JsonResponse($response,200,array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/filia/edytuj/ajax/wymagania_powloki", name="frontend_filia_edytuj_ajax_wymagania_powloki_opis")
     */
    public function pobierzOpisWymaganiaPowloki()
    {
        $request = $this->container->get('request');
        $idWymaganiaPowloki = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var $WymaganiaPowloki WymaganiaPowloki
         */
        $WymaganiaPowloki = $em->getRepository('DFPEtapIBundle:WymaganiaPowloki')->find($idWymaganiaPowloki);

        $response = array("code"=>100, "success"=>true, "opis"=>$WymaganiaPowloki->getOpis());

        return new JsonResponse($response,200,array('Content-Type'=>'application/json'));
    }

    /**
     * @Route("/filia/edytuj/ajax/wymagania_produktu", name="frontend_filia_edytuj_ajax_wymagania_produktu_opis")
     */
    public function pobierzOpisWymaganiaProduktu()
    {
        $request = $this->container->get('request');
        $idWymaganiaProduktu = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var $WymaganiaProduktu WymaganiaProduktu
         */
        $WymaganiaProduktu = $em->getRepository('DFPEtapIBundle:WymaganiaProduktu')->find($idWymaganiaProduktu);

        $response = array("code"=>100, "success"=>true, "opis"=>$WymaganiaProduktu->getOpis());

        return new JsonResponse($response,200,array('Content-Type'=>'application/json'));
    }
}