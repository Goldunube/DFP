<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Entity\Klient;
use DFP\EtapIBundle\Entity\Uzytkownik;
use DFP\EtapIBundle\Entity\FiliaUzytkownik;
use DFP\EtapIBundle\Entity\FiliaNotatka;
use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use DFP\EtapIBundle\Form\FiliaNotatkaType;
use DFP\EtapIBundle\Form\FiliaType;
use DFP\EtapIBundle\Form\KlientType;
use DFP\EtapIBundle\Form\KartaKlientaPodstawowaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;
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
        $filiaUzytkownik->setKoniecPrzypisania(new \DateTime('+7 days'));
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
        $filiaUzytkownik->setKoniecPrzypisania(new \DateTime('+7 days'));
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
        return array(
            'filia' => $filia,
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
        $filia  = $em->getRepository('DFPEtapIBundle:Filia')->find($id);
        $notatka->setFilia($filia);
        $notatka->setUzytkownik($this->getUser());

        $form = $this->createForm(new FiliaNotatkaType(), $notatka, array(
                'action'    =>  $this->generateUrl('frontend_filia_notatka_stworz' ,array('id'=>$filia->getId())),
                'method'    =>  "POST",
        ));

        $form->add('submit','submit',array('label' => 'Dodaj'));

        return array(
            'notatka'   => $notatka,
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
        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);
        $notatka = new FiliaNotatka();
        $notatka->setStatus(true);
        $notatka->setDataSporzadzenia(new \DateTime('now'));
        $notatka->setKoniecEdycji(new \DateTime('+30 minutes'));
        $notatka->setFilia($filia);
        $notatka->setUzytkownik($this->getUser());

        $form = $this->createForm(new FiliaNotatkaType(), $notatka, array(
                'action'    =>  $this->generateUrl('url_dodaj_filie_klienta'),
                'method'    =>  "POST",
        ));
        $form->add('submit','submit',array('label' => 'Dodaj'));

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notatka);
            $em->flush();

            return $this->redirect($this->generateUrl('frontend_pokaz_filie_klienta',array('id'=>$id)));
        }
    }

    //TODO dodać funkcję edycji i usuwania notatek
}