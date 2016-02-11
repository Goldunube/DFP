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

    /**
     * @Route("/slowniki", name="zaplecze_slowniki")
     * @Template("@DFPEtapI/Backend/Slowniki/index.html.twig")
     */
    public function listaSlownikowAction()
    {
        $slowniki = array(
            'Grupy klientów'            =>  $this->generateUrl('grupaklientow'),
            'Grupy produktów'           =>  $this->generateUrl('grupaproduktow'),
            'Kolory'                    =>  $this->generateUrl('backend_kolor'),
            'Materiały uzupełniające'   =>  $this->generateUrl('url_materialuzupelniajacy'),
            'Metody aplikacji farby'    =>  $this->generateUrl('url_procesaplikacji'),
            'Metody przygotowania powierzchni'  =>  $this->generateUrl('url_procesprzygotowaniapowierzchni'),
            'Parametry produktu'        =>  $this->generateUrl('url_wymaganiaproduktu'),
            'Parametry utwardzania powłoki'     =>  $this->generateUrl('url_procesutwardzaniapowloki'),
            'Profile działalności'      =>  $this->generateUrl('url_profiledzialalnosci'),
            'Rodzaje podłoża'           =>  $this->generateUrl('url_backend_rodzajpowierzchni'),
            'Wymagania powłoki lakierowej'      =>  $this->generateUrl('url_wymaganiapowloki'),
            'Wzorniki kolorów'          =>  $this->generateUrl('backend_wzornikkolorow'),
            'Rodzaje wizyt technicznych'=>  $this->generateUrl('backend_rodzaje_zdarzen_technicznych')
        );

        ksort($slowniki);

        return array(
            'slowniki'  =>  $slowniki
        );
    }
}
