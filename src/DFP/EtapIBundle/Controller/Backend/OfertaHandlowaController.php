<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\OfertaHandlowa;
use DFP\EtapIBundle\Entity\OfertaSystem;
use DFP\EtapIBundle\Entity\SystemMalarski;
use DFP\EtapIBundle\Form\OfertaSystemType;
use DFP\EtapIBundle\Form\SystemMalarskiType;
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
        $profileDzialalnosci = $ofertaHandlowa->getFilia()->getProfileDzialalnosci();

        $systemMalarski = new SystemMalarski();
        $systemForm = $this->createNewSystemForm($systemMalarski);

        $ofertaSystem = new OfertaSystem();
        $ofertaSystemForm = $this->createNewOfertaSystemForm($ofertaSystem);

        return array(
            'oferta'                =>  $ofertaHandlowa,
            'system_form'           =>  $systemForm->createView(),
            'oferta_system_form'    =>  $ofertaSystemForm->createView(),
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
}
