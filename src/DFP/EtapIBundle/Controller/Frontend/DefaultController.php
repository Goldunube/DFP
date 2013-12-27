<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="strona_glowna")
     * @Template("@DFPEtapI/Frontend/index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
