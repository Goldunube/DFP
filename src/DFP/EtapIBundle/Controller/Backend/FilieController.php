<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/filie")
 */
class FilieController extends Controller
{
    /**
     * @Route("/", name="backend_filie")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('DFPEtapIBundle:Filia')->findAll();
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),50);

        return array(
            'lista_filii'   => $pagination,
        );
    }
}
