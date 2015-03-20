<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use DFP\EtapIBundle\Entity\DoPobrania;
use DFP\EtapIBundle\Form\DoPobraniaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DoPobraniaController
 * @package GCSV\CoreBundle\Controller\Frontend
 */
class DoPobraniaController extends Controller
{
    /**
     * @Route("/do-pobrania", name="do_pobrania")
     * @Template()
     */
    public function indexAction()
    {
        $doPobraniaRepo = $this->getDoctrine()->getRepository('DFPEtapIBundle:DoPobrania');

        $allList = $doPobraniaRepo->findAll();

        return array(
            'do_pobrania'   =>  $allList
        );
    }

    /**
     * @Route("/do-pobrania/new",
     *      name="do_pobrania_new"
     * )
     * @Method({"GET","POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $doPobrania = new DoPobrania();

        $form = $this->createForm(new DoPobraniaType(),$doPobrania);

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/do-pobrania/{filename}", name="do_pobrania_pobierz")
     *
     */
    public function downloadAction($filename)
    {
        $path = $this->get('kernel')->getRootDir().'/../media/';
        $content = file_get_contents($path.$filename);

        $response = new Response();

        $response->headers->set('Content-Type','mime/type');
        $response->headers->set('Content-Disposition','attachment;filename="'.$filename);

        $response->setContent($content);
        return $response;
    }
} 