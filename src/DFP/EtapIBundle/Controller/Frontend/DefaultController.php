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

    /**
     * @Route("/wyszukiwarka/klienci-wolni/", name="wyszukiwarka_jeden")
     */
    public function wyszukajJedenAction()
    {
        return $this->redirect($this->generateUrl('strona_w_budowie'));
    }

    /**
     * @Route("/wyszukiwarka/klienci-zajeci", name="wyszukiwarka_dwa")
     */
    public function wyszukajDwaAction()
    {
        return $this->redirect($this->generateUrl('strona_w_budowie'));
    }
}
