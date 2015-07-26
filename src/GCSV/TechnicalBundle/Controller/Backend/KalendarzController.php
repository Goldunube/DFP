<?php

namespace GCSV\TechnicalBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Uzytkownik;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class Kalendarz
 * @package GCSV\TechnicalBundle\Controller\Backend
 * @Route("/kalendarz-dt")
 */
class KalendarzController extends Controller
{
    /**
     * Wyświetla kalendarz Działu Technicznego
     *
     * @Route("/", name="zaplecze_kalendarz_dt")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $technicy = $this->getDoctrine()->getManager()->getRepository('DFPEtapIBundle:Uzytkownik')->findAllUnlockTechnicy();
        $rodzajeZdarzenRepo = $this->getDoctrine()->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego');
        $rodzajeZdarzenAll = $rodzajeZdarzenRepo->findAll();
        $zlecajacyRepo = $this->getDoctrine()->getRepository('DFPEtapIBundle:Uzytkownik');
        $zlecajacy = $zlecajacyRepo->findAllUnclockOrderByImie();

        return array(
            'technicy'          =>  $technicy,
            'rodzajeZdarzen'    =>  $rodzajeZdarzenAll,
            'zlecajacy'         =>  $zlecajacy
        );
    }
} 