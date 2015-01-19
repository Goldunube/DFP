<?php

namespace DFP\EtapIBundle\Controller\Frontend;


use DFP\EtapIBundle\Entity\StanyMagazynowe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class StanyMagazynoweController
 * @package DFP\EtapIBundle\Controller\Frontend
 * @Route("/stany-magazynonowe")
 */
class StanyMagazynoweController extends Controller
{
    /**
     * @Route("/", name="stany_magazynowe")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $stanyMagazynowe = $em->getRepository('DFPEtapIBundle:StanyMagazynowe')->findAll();

        $produktySpecjalne = array();
        $gruntyPodklady = array();
        $gruntoemalie = array();
        $konwertory = array();
        $pigmenty = array();
        $dodatki = array();
        /**
         * @var StanyMagazynowe $produkt
         */
        foreach($stanyMagazynowe as $produkt)
        {
            $indeks = $produkt->getIndeks();
            if(preg_match('/^EFP(-[^-]*)-(R|CT)\d+/',$indeks)) //PRODUKTY SPECJALNE
            {
                array_push($produktySpecjalne,$produkt);
            }elseif(preg_match('/^EPG/',$indeks)) // GRUNTY I PODKŁADY
            {
                array_push($gruntyPodklady,$produkt);
            }elseif(preg_match('/^EFP/',$indeks)) // GRUNTY I PODKŁADY
            {
                array_push($gruntoemalie,$produkt);
            }elseif(preg_match('/^EZX/',$indeks)) // GRUNTY I PODKŁADY
            {
                array_push($konwertory,$produkt);
            }elseif(preg_match('/^E(BP|BM)/',$indeks)) // GRUNTY I PODKŁADY
            {
                array_push($pigmenty,$produkt);
            }
            elseif(preg_match('/^EDL/',$indeks)) // DODATKI
            {
                array_push($dodatki,$produkt);
            }
        }

        return array(
            'produkty_specjalne' => $produktySpecjalne,
            'grunty_podklady' => $gruntyPodklady,
            'gruntoemalie' => $gruntoemalie,
            'konwertory' => $konwertory,
            'pigmenty' => $pigmenty,
            'dodatki' => $dodatki,
        );
    }
} 