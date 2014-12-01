<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\OfertaHandlowa;
use DFP\EtapIBundle\Entity\OfertaProdukt;
use DFP\EtapIBundle\Entity\OfertaSystem;
use DFP\EtapIBundle\Entity\Produkt;
use DFP\EtapIBundle\Form\OfertaHandlowaProfilSystemType;
use DFP\EtapIBundle\Form\OfertaProduktType;
use DFP\EtapIBundle\Form\OfertaSystemType;
use DFP\EtapIBundle\Entity\OfertaCena;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * OfertaHandlowa controller.
 *
 * @Route("/ofertyhandlowe")
 */
class OfertaHandlowaController extends Controller
{

    /**
     * Lista wszystkich Ofert Handlowych
     *
     * @Route("/", name="backend_oferty_handlowe_wszystkie")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/OfertaHandlowa/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $kryteria = null;

        if($this->get('request')->query->get('filterField') && $this->get('request')->query->get('filterValue'))
        {
            $pole = $this->get('request')->query->get('filterField');
            $wartosc = $this->get('request')->query->get('filterValue');
            $kryteria = array('filterField'=>$pole,'filterValue'=>$wartosc);
        }

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaWszystkichOfertHandlowychSearchQuery($kryteria);

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),21);

        $deleteForms = new ArrayCollection();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        foreach($pagination as $ofertaHandlowa)
        {
            $deleteForms[$ofertaHandlowa->getId()] = $this->createDeleteForm($ofertaHandlowa->getId())->createView();
        }

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Tworzenie oferty handlowej",
            4   =>  "Zrealizowana",
            5   =>  "Anulowana"
        );

        return array(
            'oferty_handlowe'   =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
            'delete_forms'      =>  $deleteForms,
        );
    }

    /**
     * Deletes a OfertaHandlowa entity.
     *
     * @Route("/{id}", name="backend_oferty_handlowe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

            if (!$ofertaHandlowa) {
                throw $this->createNotFoundException('Brak możliwości usunięcia oferty handlowej.');
            }

            $em->remove($ofertaHandlowa);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_oferty_handlowe_wszystkie'));
    }

    /**
     * Creates a form to delete a OfertaHandlowa entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_oferty_handlowe_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
            ;
    }

    /**
     * Lista Ofert Handlowych oczekujących na dobór systemu malarskiego
     *
     * @Route("/oczekujace_sm", name="backend_oferty_handlowe_oczekujace_sm")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/OfertaHandlowa/listaOczekujacychSM.html.twig")
     */
    public function listaOczekujacychNaDoborSystemuMalarskiegoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $kryteria = null;

        if($this->get('request')->query->get('filterField') && $this->get('request')->query->get('filterValue'))
        {
            $pole = $this->get('request')->query->get('filterField');
            $wartosc = $this->get('request')->query->get('filterValue');
            $kryteria = array('filterField'=>$pole,'filterValue'=>$wartosc);
        }

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaOczekujacychNaDoborSystemuMalarskiegoSearchQuery($kryteria);

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Opracowywanie oferty handlowej",
            4   =>  "Zrealizowana",
            5   =>  "Anulowana"
        );

        return array(
            'oczekujace'        =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
    }

    /**
     * Lista Ofert Handlowych oczekujących na wykonanie oferty handlowej
     *
     * @Route("/oczekujace_oh", name="backend_oferty_handlowe_oczekujace_oh")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/OfertaHandlowa/listaOczekujacychOH.html.twig")
     */
    public function listaOczekujacychNaOpracowanieOfertyHandlowejAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $kryteria = null;

        if($this->get('request')->query->get('filterField') && $this->get('request')->query->get('filterValue'))
        {
            $pole = $this->get('request')->query->get('filterField');
            $wartosc = $this->get('request')->query->get('filterValue');
            $kryteria = array('filterField'=>$pole,'filterValue'=>$wartosc);
        }

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaOczekujacychNaOpracowanieOfertyHandlowejSearchQuery($kryteria);

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Opracowywanie oferty handlowej",
            4   =>  "Zrealizowana",
            5   =>  "Anulowana"
        );

        return array(
            'oczekujace'        =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
    }

    /**
     * Wyświetla zamówienie oferty handlowej
     *
     * @param $id
     *
     * @return array
     * @Route("/{id}/pokaz_oferte_handlowa", name="backend_pokaz_oferte_handlowa")
     * @Template()
     * @Method("GET")
     */
    public function pokazOferteHandlowaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $filia = $ofertaHandlowa->getFilia();

        $otworzDoborSystemuForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_otworz_opracowanie_systemu_malarskiego', array('id'=>$id)))
            ->setMethod('PUT')
            ->add('submit','submit',array(
                    'label' =>  'Otwórz zamówienie',
                    'attr'  =>  array('class'=>'art-button zielony')
                )
            )
            ->getForm();

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

                $previousUrl = $this->get('request')->headers->get('referer');

        return array(
            'oferta'                    =>  $ofertaHandlowa,
            'filia'                     =>  $filia,
            'otworzDoborSystemuForm'    =>  $otworzDoborSystemuForm->createView(),
            'powrot_url'                =>  $previousUrl,
            'notatka_kategorie'         =>  $kategorieNotatek,
        );
    }

    /**
     * Wyświetla zamówienie oferty handlowej z listy wszystkich Ofert Handlowych
     *
     * @param $id
     *
     * @return array
     * @Route("/{id}/pokaz_zrealizowana_oferte_handlowa", name="backend_pokaz_zrealizowana_oferte_handlowa")
     * @Template()
     * @Method("GET")
     */
    public function pokazZrealizowanaOferteHandlowaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $filia = $ofertaHandlowa->getFilia();

        $dobraneSystemy = $ofertaHandlowa->getOfertySystemy();

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Opracowywanie oferty handlowej",
            4   =>  "Zrealizowana",
            5   =>  "Anulowana"
        );

        $previousUrl = $this->get('request')->headers->get('referer');

        return array(
            'oferta'                    =>  $ofertaHandlowa,
            'filia'                     =>  $filia,
            'powrot_url'                =>  $previousUrl,
            'notatka_kategorie'         =>  $kategorieNotatek,
            'dobrane_systemy'           =>  $dobraneSystemy,
            'nazwy_statusow'            =>  $nazwyStatusow,
        );
    }

    /**
     * Otwiera / przypisuje opracowywanie systemu malarskiego do technika
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $id
     * @internal param $id
     *
     * @return array
     * @Route("/{id}/otworz_opracowanie_systemu_malarskiego", name="backend_otworz_opracowanie_systemu_malarskiego")
     * @Method("PUT")
     */
    public function otworzOpracowanieSystemuMalarskiegoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

        $otworzDoborSystemuForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_otworz_opracowanie_systemu_malarskiego', array('id'=>$id)))
            ->setMethod('PUT')
            ->add('submit','submit',array(
                    'label' =>  'Otwórz zamówienie',
                    'attr'  =>  array('class'=>'art-button zielony')
                )
            )
            ->getForm();

        $otworzDoborSystemuForm->handleRequest($request);

        if($otworzDoborSystemuForm->isValid())
        {
            //TODO Dodać sprawdzenie, czy osobą otwierającą dobór systemu jest technik

            $ofertaHandlowa->setStatus(1);
            $ofertaHandlowa->setTechnik($this->getUser());

            $em->persist($ofertaHandlowa);
            $em->flush();
        }

        $previousUrl = $this->get('request')->headers->get('referer');

        return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function zapiszOpracowanieSystemuMalarskiegoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

        $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id)))
            ->setMethod('POST')
            ->add('ofertySystemy','collection',array(
                    'type'          =>  new OfertaSystemType(),
                    'allow_add'     =>  true,
                    'by_reference'  =>  false,
                )
            )
            ->add('zapisz','submit',array(
                    'label'         =>  'Zapisz',
                    'attr'          =>  array('class'=>'art-button zielony')
                )
            )
            ->add('zamknij','submit',array(
                    'label'         =>  'Zapisz i zamknij',
                    'attr'          =>  array('class'=>'art-button pomaranczowy')
                )
            )
            ->add('anuluj','submit',array(
                    'label'         =>  'Anuluj zamówienie',
                    'attr'          =>  array('class'=>'art-button czerwony')
                )
            )
            ->getForm();

        $ofertaHandlowaForm->handleRequest($request);

        if($ofertaHandlowaForm->isValid())
        {
            $em->persist($ofertaHandlowa);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id)));
    }

    /**
     * Zapisuje opracowanie Systemu Malarskiego do Oferty Handlowej
     *
     * @param $id
     * @param Request $request
     *
     * @return array
     */
    private function zamknijOpracowanieSystemuMalarskiego(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

        $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id)))
            ->setMethod('POST')
            ->add('ofertySystemy','collection',array(
                    'type'          =>  new OfertaSystemType(),
                    'allow_add'     =>  true,
                    'by_reference'  =>  false,
                )
            )
            ->add('zapisz','submit',array(
                    'label'         =>  'Zapisz',
                    'attr'          =>  array('class'=>'art-button zielony')
                )
            )
            ->add('zamknij','submit',array(
                    'label'         =>  'Zapisz i zamknij',
                    'attr'          =>  array('class'=>'art-button pomaranczowy')
                )
            )
            ->add('anuluj','submit',array(
                    'label'         =>  'Anuluj zamówienie',
                    'attr'          =>  array('class'=>'art-button czerwony')
                )
            )
            ->getForm();

        $ofertaHandlowaForm->handleRequest($request);

        if($ofertaHandlowaForm->isValid())
        {
            $ofertaHandlowa->setStatus(2);
            $em->persist($ofertaHandlowa);
            $em->flush();

        }

        return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
    }

    /**
     * Anuluje zamówienie Oferty Handlowej
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function anulujOferteHandlowa(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->clear();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

        $ofertaHandlowa->setStatus(5);
        $ofertaHandlowa->setInfoAnulacja($this->get('request')->request->get('anulujInfo'));

        $em->persist($ofertaHandlowa);
        $em->flush();

        return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
    }

    /**
     * Wyświetla formularz systemu malarskiego oraz dodaje system malarski do oferty handlowej
     *
     * @param $id
     * @param Request $request
     *
     * @Route("/{id}/opracowanie_systemu_malarskiego", name="backend_opracowanie_systemu_malarskiego")
     * @Template()
     * @Method({"GET","POST"})
     * @return array
     */
    public function opracujSystemMalarskiAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $filia = $ofertaHandlowa->getFilia();
        $profileDzialalnosci = $filia->getProfileDzialalnosci();

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        if($ofertaHandlowa->getTechnik() != $this->getUser())
        {
            return $this->redirect($this->generateUrl('backend_pokaz_oferte_handlowa',array('id'=>$id)));
        }

        if($ofertaHandlowa->getStatus() == 1)
        {

        }

        if($ofertaHandlowa->getOfertySystemy()->isEmpty())
        {
            foreach ($profileDzialalnosci as $profilDzialanosci)
            {
                $ofertaSystem = new OfertaSystem();
                $ofertaSystem->setProfil($profilDzialanosci);
                $ofertaHandlowa->addOfertySystemy($ofertaSystem);
            }
        }else{
            /**
             * @var OfertaSystem $ofertaSystem
             * @var Produkt $warstwa1
             * @var Produkt $warstwa2
             * @var Produkt $warstwa3
             * @var Produkt $warstwa4
             */
            foreach($ofertaHandlowa->getOfertySystemy() as $ofertaSystem)
            {
                if($ofertaSystem->getWarstwa1())
                {
                    $warstwa1 = $ofertaSystem->getWarstwa1();
                    $warstwa1 = $em->merge($warstwa1);
                    $ofertaSystem->setWarstwa1($warstwa1);
                }
                if($ofertaSystem->getWarstwa2())
                {
                    $warstwa2 = $ofertaSystem->getWarstwa2();
                    $warstwa2 = $em->merge($warstwa2);
                    $ofertaSystem->setWarstwa2($warstwa2);
                }
                if($ofertaSystem->getWarstwa3())
                {
                    $warstwa3 = $ofertaSystem->getWarstwa3();
                    $warstwa3 = $em->merge($warstwa3);
                    $ofertaSystem->setWarstwa3($warstwa3);
                }
                if($ofertaSystem->getWarstwa4())
                {
                    $warstwa4 = $ofertaSystem->getWarstwa4();
                    $warstwa4 = $em->merge($warstwa4);
                    $ofertaSystem->setWarstwa4($warstwa4);
                }
            }
        }



        $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id)))
            ->setMethod('POST')
            ->add('ofertySystemy','collection',array(
                    'type'          =>  new OfertaSystemType(),
                    'allow_add'     =>  true,
                    'by_reference'  =>  false,
                )
            )
            ->add('zapisz','submit',array(
                    'label'         =>  'Zapisz',
                    'attr'          =>  array('class'=>'art-button zielony')
                )
            )
            ->add('zamknij','submit',array(
                    'label'         =>  'Zapisz i zamknij',
                    'attr'          =>  array('class'=>'art-button pomaranczowy')
                )
            )
            ->add('anuluj','submit',array(
                    'label'         =>  'Anuluj zamówienie',
                    'attr'          =>  array('class'=>'art-button czerwony','style'=>'display:none;')
                )
            )
            ->add('anulujInfo','textarea',array(
                    'mapped'        =>  false,
                    'required'      =>  false,
                    'label'         =>  false,
                    'attr'          =>  array('style'=>'width: 90%; height:100px;')
                )
            )
            ->getForm();

        $ofertaHandlowaForm->handleRequest($request);

        if($ofertaHandlowaForm->isValid())
        {
            if($ofertaHandlowaForm->has('zapisz') && $ofertaHandlowaForm->get('zapisz')->isClicked())
            {
                $this->zapiszOpracowanieSystemuMalarskiegoAction($request, $id);
                return $this->redirect($this->generateUrl('backend_opracowanie_systemu_malarskiego',array('id'=>$id)));

            }elseif($ofertaHandlowaForm->has('zamknij') && $ofertaHandlowaForm->get('zamknij')->isClicked())
            {
                $this->zamknijOpracowanieSystemuMalarskiego($request,$id);
                return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));

            }elseif($ofertaHandlowaForm->has('anuluj') && $ofertaHandlowaForm->get('anuluj')->isClicked()){

                $this->anulujOferteHandlowa($request, $id);
                return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
            }
        }

        $previousUrl = $this->get('request')->headers->get('referer');

        return array(
            'oferta'                    =>  $ofertaHandlowa,
            'filia'                     =>  $filia,
            'form'                      =>  $ofertaHandlowaForm->createView(),
            'powrot_url'                =>  $previousUrl,
            'notatka_kategorie'         =>  $kategorieNotatek,
        );
    }


    /**
     * Wyświetla formularz do opracowania oferty cenowej na podstawie wcześniej dobranego systemu malarskiego
     *
     * @param $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Route("/{id}/opracowanie_oferty_cenowej", name="backend_opracowanie_oferty_cenowej")
     * @Template()
     * @Method({"GET", "POST"})
     * @return array
     */
    public function opracujOferteCenowaAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $filia = $ofertaHandlowa->getFilia();

        $obecneCeny = new ArrayCollection();

        foreach($ofertaHandlowa->getOfertyProdukty() as $ofertaProdukt)
        {
            foreach ($ofertaProdukt->getCeny() as $cena) {
                $obecneCeny->add($cena);
            }
        }

        foreach ($ofertaHandlowa->getWybraneProdukty() as $produkt)
        {
            if($produkt instanceof Produkt)
            {
                $produkt = $em->getRepository('DFPEtapIBundle:Produkt')->find($produkt->getId());
                $ofertaProdukt = new OfertaProdukt();
                $ofertaProdukt->setProdukt($produkt);
                $cena = new OfertaCena();
                $ofertaProdukt->addCeny($cena);
                if(!$ofertaHandlowa->getOfertyProdukty()->contains($ofertaProdukt))
                    $ofertaHandlowa->getOfertyProdukty()->add($ofertaProdukt);
                $ofertaProdukt->setOferta($ofertaHandlowa);
            }
        }

//        var_dump($obecneCeny);
        $previousUrl = $this->get('request')->headers->get('referer');

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        $form = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_opracowanie_oferty_cenowej', array('id' => $id)))
            ->setMethod('POST')
            ->add('ofertyProdukty','collection',array(
                    'type'              =>  new OfertaProduktType(),
                    'allow_add'         =>  true,
                    'allow_delete'      =>  true,
                    'by_reference'      =>  false,
                )
            )
            ->add('zapisz','submit', array(
                    'label' =>  'Tylko zapisz',
                    'attr'  =>  array('class' => 'art-button zielony'),
                )
            )
            ->add('submit','submit', array(
                    'label' =>  'Zapisz i zamknij',
                    'attr'  =>  array('class' => 'art-button zielony'),
                )
            )
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid())
        {
            $redirectUrl = $this->generateUrl('backend_opracowanie_oferty_cenowej', array('id' => $id));
            if($form->get('submit')->isClicked())
            {
                $ofertaHandlowa->setStatus(4);
                $redirectUrl = $this->generateUrl('backend_oferty_handlowe_oczekujace_oh');

            }
            $ofertaHandlowa->setKoordynatorDFP($this->getUser());
            $em->persist($ofertaHandlowa);
            $em->flush();

            return $this->redirect($redirectUrl);
        }

        return array(
            'form'                      =>  $form->createView(),
            'oferta'                    =>  $ofertaHandlowa,
            'filia'                     =>  $filia,
            'powrot_url'                =>  $previousUrl,
            'notatka_kategorie'         =>  $kategorieNotatek,
        );
    }

    /**
     * Generate Oferta Handlowa Sheet
     *
     * @param $id
     * @Route("/{id}/oferta_handlowa_pdf", name="backend_oferta_handlowa_pdf")
     * @Method("GET")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generatePDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $klient = $entity->getFilia()->getKlient();

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć oferty handlowej.');
        }

        $html = $this->renderView('@DFPEtapI/Frontend/OfertaHandlowa/oferta_handlowa.pdf.twig', array(
                'oferta'        =>  $entity,
                'nazwa_klienta' =>  $klient
            )
        );

        $pdf = $this->get('knp_snappy.pdf');
        $pdf->setOption('encoding','utf-8');
        //$pdf->setOption('header-html','http://www.portaldfp.lh/app_dev.php/produkty/karta-techniczna-header');
        //$pdf->setOption('header-spacing',10);
        //$pdf->setOption('footer-spacing',10);
        //$pdf->setOption('margin-top',35);
        //$pdf->setOption('margin-left',0);
        //$pdf->setOption('margin-right',0);
        //$pdf->setOption('footer-html','http://www.portaldfp.lh/app_dev.php/produkty/karta-techniczna-footer');

        return new Response(
            $pdf->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'filename="'.$klient->getNazwaSkrocona().'_oferta_handlowa('.$id.').pdf"'
            )
        );
    }
}
