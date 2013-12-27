<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="zaplecze_glowna")
     * @Template("@DFPEtapI/Backend/index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
