<?php

namespace GCSV\MagazynBundle\Controller\Frontend;


use GCSV\MagazynBundle\Entity\StanMagazynuMAX;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MagazynMAXController
 * @package GCSV\MagazynBundle\Controller\Frontend
 *
 * @Route("/stan-magazynu-max")
 */
class MagazynMAXController extends Controller
{
    /**
     * @Route("/", name="stan_magazynu_max")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $stanyMagazynoweMAX = $em->getRepository('GCSVMagazynBundle:StanMagazynuMAX')->wyswietlMojStanMagazynowyMAXQuery($user);
        $symbolMagazynu = $user->getMagazyn()->getSymbol();
        $wartoscMagazynu = 0;

        /**
         * @var StanMagazynuMAX $pozycja
         */
        foreach($stanyMagazynoweMAX as $pozycja)
        {
            $wartoscMagazynu += $pozycja->getWartosc();
        }

        return array(
            'stan_magazynu'     =>  $stanyMagazynoweMAX,
            'wartosc_magazynu'  =>  $wartoscMagazynu,
            'symbol_magazynu'   =>  $symbolMagazynu
        );
    }
}