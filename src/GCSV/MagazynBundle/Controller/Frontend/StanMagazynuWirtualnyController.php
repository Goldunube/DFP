<?php

namespace GCSV\MagazynBundle\Controller\Frontend;

use GCSV\MagazynBundle\Entity\StanMagazynuWirtualny;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StanMagazynuWirtualnyController
 * @package GCSV\MagazynBundle\Controller\Frontend
 *
 * @Route("/stan-magazynu-wirtualny")
 */
class StanMagazynuWirtualnyController extends Controller
{
    /**
     * @Route(
     *      "/{strona}",
     *      requirements={"strona" = "\d+"},
     *      defaults={"strona" = 1},
     *      name="stan_magazynu_wirtualny")
     * @Template()
     * @Method("GET")
     */
    public function indexAction($strona)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $stanyMagazynoweWirtualny = $em->getRepository('GCSVMagazynBundle:StanMagazynuWirtualny')->wyswietlMojStanMagazynowyWirtualnyQuery($user);
        $wartoscMagazynu = 0;

        /**
         * @var StanMagazynuWirtualny $pozycja
         */
        foreach($stanyMagazynoweWirtualny as $pozycja)
        {
            $wartoscMagazynu += $pozycja->getWartosc();
        }

        //$paginator = $this->get('knp_paginator');
        //$paginacja = $paginator->paginate($stanyMagazynoweWirtualny,$strona,50);

        return array(
            'stan_magazynu'     =>  $stanyMagazynoweWirtualny,
            'wartosc_magazynu'  =>  $wartoscMagazynu,
        );
    }

    /**
     * @Route(
     *      "/produkty/ajax-get-products/{term}",
     *      name="ajax_get_products",
     *      defaults={"term" = ""},
     *      options={"expose"=true}
     * )
     * @Method("GET")
     */
    public function ajaxGetProductsListAction($term)
    {
        $em = $this->getDoctrine()->getManager();

        $result = $em->getRepository('GCSVMagazynBundle:Produkt')->getProductsList($term,true);

        $response = new JsonResponse();
        $response->setData($result);

        return $response;
    }
}
