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

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->findBy(array(),array('dataZlozeniaZamowienia'=>'DESC'));

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),11);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Tworzenie oferty handlowej",
            4   =>  "Zrealizowana"
        );

        return array(
            'oferty_handlowe'   =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
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

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaOczekujacychNaDoborSystemuMalarskiegoQuery();

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),11);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Opracowywanie oferty handlowej",
            4   =>  "Zrealizowana"
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

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaOczekujacychNaOpracowanieOfertyHandlowejQuery();

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),11);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Opracowywanie oferty handlowej",
            4   =>  "Zrealizowana"
        );

        return array(
            'oczekujace'        =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
    }

    /**
     * Wyświetla formularz systemu malarskiego oraz dodaje system malarski do oferty handlowej
     *
     * @param $id
     * @param Request $request
     *
     * @Route("/{id}/opracowanie_systemu_malarskiego", name="backend_opracowanie_systemu_malarskiego")
     * @Template()
     * @Method({"GET", "POST"})
     * @return array
     */
    public function opracujSystemMalarskiAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $filia = $ofertaHandlowa->getFilia();
        $profileDzialalnosci = $filia->getProfileDzialalnosci();

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

        $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
            ->add('ofertyProfileSystemy','collection',array(
                    'type'          =>  new OfertaHandlowaProfilSystemType(),
                    'allow_add'     =>  true,
                    'by_reference'  =>  false,
                )
            )
            ->add('submit','submit',array(
                    'label'         =>  'Zatwierdź dobór',
                    'attr'          =>  array('class'=>'art-button zielony')
                )
            )
            ->getForm();

        $ofertaHandlowaForm->handleRequest($request);

        if($ofertaHandlowaForm->isValid())
        {
            $ofertaHandlowa->setStatus(3);
            $em->persist($ofertaHandlowa);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
        }

        return array(
            'oferta'        =>  $ofertaHandlowa,
            'filia'         =>  $filia,
            'form'          =>  $ofertaHandlowaForm->createView(),
        );
    }

    private function createNewSystemForm(SystemMalarski $system)
    {
        $form = $this->createForm(new SystemMalarskiType(), $system, array(
                'action'    =>  $this->generateUrl('backend_system_malarski_create'),
                'method'    =>  'POST'
            )
        );

        $form->add('submit', 'submit', array('label'=>'Utwórz'));

        return $form;
    }

    /**
     * Wyświetla formularz systemu malarskiego oraz dodaje system malarski do oferty handlowej
     *
     * @param $id
     * @param Request $request
     *
     * @Route("/{id}/dziala", name="dziala")
     * @Template()
     * @Method({"GET", "POST"})
     * @return array
     */
    public function dziala($id, Request $request) // DZIAŁA
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id); // KONF_1
        $profileDzialalnosci = $ofertaHandlowa->getFilia()->getProfileDzialalnosci();

        $profilSystem = new ProfilSystem();
        $profilSystem->setProfilDzialalnosci($profileDzialalnosci[1]);

        $profilSystemForm = $this->createForm(new ProfilSystemType(), $profilSystem, array(
            'method'    =>  'POST',
            'action'    =>  $this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id) ),
        )
        );

        $testForm = $this->createFormBuilder()
            ->setMethod('POST')
            ->setAction( $this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id) ) )
            ->add('profilSystem','collection',array(
                    'type'      =>  new ProfilSystemType($profilSystem),
                    'allow_add' =>  true,
                    'label'     =>  false
                )
            )
            ->add('submit','submit')
            ->getForm();

        $profilSystemForm->add('submit','submit');

        $ofertaProfilSystem = new OfertaHandlowaProfilSystem();

        foreach($testForm->get('profilSystem') as $profilSystem)
        {
//            $profilSystem->
        }

        $testForm->handleRequest($request);
        if($testForm->isValid())
        {
            foreach ($testForm->get('profilSystem') as $object) {
                $profilSystem = $object->getData();
                $em->persist($profilSystem);
                $ofertaProfilSystem->setProfilSystem($profilSystem);

            }
            $ofertaProfilSystem->setUwagi('Test2');
            $em->persist($ofertaProfilSystem);
            $ofertaHandlowa->addOfertyProfileSystemy($ofertaProfilSystem);
            $em->persist($ofertaHandlowa);

            $em->flush();
        }
        /*$profilSystemForm->handleRequest($request);
        if($profilSystemForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profilSystem);
            $ofertaProfilSystem->setProfilSystem($profilSystem);
            $ofertaProfilSystem->setUwagi('Test');
            $em->persist($ofertaProfilSystem);
            $ofertaHandlowa->addOfertyProfileSystemy($ofertaProfilSystem);
            $em->persist($ofertaHandlowa);
            $em->flush();
        }*/

        return array(
            'form_profil'           =>  $profilSystemForm->createView(),
            'test'  =>  $testForm->createView(),
        );
    }

    public function opracujSystemMalarskiDzialaAction($id, Request $request) // DZIAŁA
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id); // KONF_1

        $profilSystem = new ProfilSystem();
        $profilSystemForm = $this->createForm(new ProfilSystemType(), $profilSystem, array(
                'method'    =>  'POST',
                'action'    =>  $this->generateUrl('backend_opracowanie_systemu_malarskiego', array('id' => $id) ),
            )
        );

        $profilSystemForm->add('submit','submit');

        $ofertaProfilSystem = new OfertaHandlowaProfilSystem();


        $profilSystemForm->handleRequest($request);
        if($profilSystemForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profilSystem);
            $ofertaProfilSystem->setProfilSystem($profilSystem);
            $ofertaProfilSystem->setUwagi('Test');
            $em->persist($ofertaProfilSystem);
            $ofertaHandlowa->addOfertyProfileSystemy($ofertaProfilSystem);
            $em->persist($ofertaHandlowa);
            $em->flush();
        }

        return array(
            'form_profil'           =>  $profilSystemForm->createView(),
        );
    }
}
