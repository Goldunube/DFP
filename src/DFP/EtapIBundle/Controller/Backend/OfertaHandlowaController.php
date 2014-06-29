<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\OfertaHandlowa;
use DFP\EtapIBundle\Entity\OfertaHandlowaProfilSystem;
use DFP\EtapIBundle\Entity\OfertaSystem;
use DFP\EtapIBundle\Entity\Produkt;
use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use DFP\EtapIBundle\Entity\ProfilSystem;
use DFP\EtapIBundle\Entity\SystemMalarski;
use DFP\EtapIBundle\Form\OfertaHandlowaProfilSystemType;
use DFP\EtapIBundle\Form\OfertaHandlowaType;
use DFP\EtapIBundle\Form\OfertaSystemType;
use DFP\EtapIBundle\Form\ProfilSystemType;
use DFP\EtapIBundle\Form\SystemMalarskiType;
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
     * Funkcja zwracająca dobrane Systemy Malarskie w postaci tablicy
     *
     * @param Request $request
     * @param $id
     * @return array|null
     */
    private function zwrocTabliceDobranychSystemowMalarskich(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

        $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id)))
            ->setMethod('POST')
            ->add('ofertyProfileSystemy','collection',array(
                    'type'          =>  new OfertaHandlowaProfilSystemType(),
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
            $tempOfertyProfileSystemy = Array();
            $i = 0;

            /**
             * @var $ofertaProfilSystem ofertaHandlowaProfilSystem
             */
            foreach($ofertaHandlowa->getOfertyProfileSystemy() as $ofertaProfilSystem)
            {

                /**
                 * @var $produkt Produkt
                 */
                foreach($ofertaProfilSystem->getProfilSystem()->getSystemMalarski()->getProdukty() as $produkt)
                {
                    $tempOfertyProfileSystemy[$i]['system'][] = $produkt->getId();
                }
                $tempOfertyProfileSystemy[$i]['profil'] = $ofertaProfilSystem->getProfilSystem()->getProfilDzialalnosci()->getId();
                $tempOfertyProfileSystemy[$i]['uwagi'] = $ofertaProfilSystem->getUwagi();
                $i++;
            }
            return $tempOfertyProfileSystemy;
        }

        return null;
    }

    /**
     * @param $tymczasowaTablica
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function zapiszOpracowanieSystemuMalarskiegoAction($tymczasowaTablica, $id)
    {
        if($tymczasowaTablica != null)
        {
            $em = $this->getDoctrine()->getManager();
            $em->clear();

            /**
             * @var $ofertaHandlowa OfertaHandlowa
             */
            $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

            $ofertaHandlowa->setTymczasoweProfileSystemy($tymczasowaTablica);

            $em->persist($ofertaHandlowa);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
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
        $em->clear();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

        $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id)))
            ->setMethod('POST')
            ->add('ofertyProfileSystemy','collection',array(
                    'type'          =>  new OfertaHandlowaProfilSystemType(),
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
            $systemyMalarskieCollection = $em->getRepository('DFP\EtapIBundle\Entity\SystemMalarski')->findAll();

            //SPRAWDŹ CZY DODAWANY SYSTEM ZNAJDUJE SIĘ JUŻ W BAZIE DANYCH POPRZEZ WYSZUKANIE PRODUKTÓW

            /**
             * @var OfertaHandlowaProfilSystem $ofertaProfilSystem
             */
            foreach($ofertaHandlowa->getOfertyProfileSystemy() as $ofertaProfilSystem)
            {
                $sprSystem = array();
                /**
                 * @var $system SystemMalarski
                 */
                foreach($systemyMalarskieCollection as $system)
                {
                    if($system->getProdukty()->getValues() === $ofertaProfilSystem->getProfilSystem()->getSystemMalarski()->getProdukty()->getValues())
                    {
                        $sprSystem[] = $system;
                    }
                }

                // SPRAWDZENIE CZY W BAZIE DANYCH ZNAJDUJE SIĘ ENCJA PROFIL_SYSTEM O PODANYM PROFILU DZIAŁALNOŚCI I SYSTEMIE MALARSKIM
                if(!empty($sprSystem))
                {
                    $query = $em->createQuery(
                        'SELECT ps
                        FROM DFPEtapIBundle:ProfilSystem ps
                        WHERE ps.profilDzialalnosci = :profil AND ps.systemMalarski = :system'
                    )
                    ->setParameters(array('profil'=>$ofertaProfilSystem->getProfilSystem()->getProfilDzialalnosci(), 'system'=>$sprSystem[0]))
                    ->setMaxResults(1);

                    $profilSystemCheck = $query->getOneOrNullResult();
                    if($profilSystemCheck)
                    {
                        $profilSystem =  $em->getRepository('DFPEtapIBundle:ProfilSystem')->find($profilSystemCheck->getId());
                        $ofertaProfilSystem->setProfilSystem($profilSystem);
                    }else{
                        $ofertaProfilSystem->getProfilSystem()->setSystemMalarski($sprSystem[0]);
                    }
                }

                $em->persist($ofertaProfilSystem);

            }

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
        $ofertaHandlowa->setInfoAnulacja($request->request->get('anulujInfo'));

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
            return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
        }

        if($ofertaHandlowa->getStatus() == 1)
        {

        }

        if($ofertaHandlowa->getOfertyProfileSystemy()->isEmpty())
        {
            foreach($profileDzialalnosci as $profilDzialalnosci)
            {
                $systemMalarski = new SystemMalarski();
                $profilSystem = new ProfilSystem();
                $profilSystem->setProfilDzialalnosci($profilDzialalnosci);
                $profilSystem->setSystemMalarski($systemMalarski);

                $ofertaProfilSystem = new OfertaHandlowaProfilSystem();
                $ofertaProfilSystem->setProfilSystem($profilSystem);
                $ofertaHandlowa->addOfertyProfileSystemy($ofertaProfilSystem);
            }
        }

        if(!is_null($ofertaHandlowa->getTymczasoweProfileSystemy()))
        {
            $ofertaHandlowa->getOfertyProfileSystemy()->clear();

            $tymczasoweProfileSystemy = $ofertaHandlowa->getTymczasoweProfileSystemy();
            foreach($tymczasoweProfileSystemy as $tempProfilSystem)
            {
                $newOfertaProfilSystem = new OfertaHandlowaProfilSystem();
                $newSystemMalarski = new SystemMalarski();
                $newProfilSystem = new ProfilSystem();

                foreach($tempProfilSystem['system'] as $produktId)
                {
                    $tempProdukt = $em->getRepository('DFPEtapIBundle:Produkt')->find($produktId);
                    $newSystemMalarski->addProdukty($tempProdukt);
                }

                $tempProfilDzialalnosci = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->find($tempProfilSystem['profil']);
                $newProfilSystem->setSystemMalarski($newSystemMalarski);
                $newProfilSystem->setProfilDzialalnosci($tempProfilDzialalnosci);
                $newOfertaProfilSystem->setProfilSystem($newProfilSystem);
                $newOfertaProfilSystem->setUwagi($tempProfilSystem['uwagi']);
                $ofertaHandlowa->addOfertyProfileSystemy($newOfertaProfilSystem);

                $em->persist($ofertaHandlowa);
            }
        }

        $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
            ->setAction($this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id)))
            ->setMethod('POST')
            ->add('ofertyProfileSystemy','collection',array(
                    'type'          =>  new OfertaHandlowaProfilSystemType(),
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
                $tablicaTymczasowegoDoboruSystemuMalarskiego = $this->zwrocTabliceDobranychSystemowMalarskich($request,$id);

                $this->zapiszOpracowanieSystemuMalarskiegoAction($tablicaTymczasowegoDoboruSystemuMalarskiego, $id);

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

        $dobraneSystemy = $ofertaHandlowa->getOfertyProfileSystemy();

        $previousUrl = $this->get('request')->headers->get('referer');


        $form = $this->createFormBuilder()
            ->add('submit','submit', array(
                    'label' =>  'Zamknij ofertę',
                    'attr'  =>  array('class' => 'art-button zielony'),
                )
            )
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid())
        {
            $ofertaHandlowa->setStatus(4);
            $ofertaHandlowa->setKoordynatorDFP($this->getUser());
            $em->persist($ofertaHandlowa);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_oh'));
        }

        return array(
            'form'              =>  $form->createView(),
            'oferta'            =>  $ofertaHandlowa,
            'filia'             =>  $filia,
            'powrot_url'        =>  $previousUrl,
            'dobrane_systemy'   =>  $dobraneSystemy,
        );
    }
}
