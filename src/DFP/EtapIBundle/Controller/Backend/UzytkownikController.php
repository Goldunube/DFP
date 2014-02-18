<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Backend Uzytkownik kontroler
 *
 * @Route("/uzytkownicy")
 */
class UzytkownikController extends Controller
{
    /**
     * Lista wszystkich użytkowników w systemie
     *
     * @Route("/", name="url_lista_uzytkownikow")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Uzytkownik/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:Uzytkownik')->findBy(array(),array('imie'=>'ASC'));

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),20);

        return array(
            'entities' => $pagination,
        );
    }
}