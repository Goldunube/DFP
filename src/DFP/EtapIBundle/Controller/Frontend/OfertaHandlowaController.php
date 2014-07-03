<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * OfertaHandlowa frontend controller.
 *
 * @Route("/ofertyhandlowe")
 */
class OfertaHandlowaController extends Controller
{
    /**
     * Lista wszystkich Ofert Handlowych zalogowanego użytkownika
     *
     * @Route("/", name="frontend_oferty_handlowe_wszystkie")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaMoichOfertHandlowych($this->getUser());

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),11);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
//            1   =>  "Opracowywanie systemu malarskiego",
            1   =>  "Dobór systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
//            3   =>  "Tworzenie oferty handlowej",
            3   =>  "Generowanie oferty cenowej",
            4   =>  "Zrealizowana",
            5   =>  'Anulowana'
        );

        return array(
            'oferty_handlowe'   =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
    }
}
