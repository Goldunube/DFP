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
        $editPermissions = false;

        $user = $this->getUser();
        $roles = $user->getRoles();

        if(in_array('ROLE_ADMIN',$roles) or in_array('ROLE_KDFP',$roles) or in_array('ROLE_KP',$roles) or in_array('ROLE_DYR',$roles))
        {
            $editPermissions = true;
        }

        return array(
            'do_pobrania'   =>  $allList,
            'uprawnienia'   =>  $editPermissions
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

        $form = $this->createForm(new DoPobraniaType(),$doPobrania,array(
                'action'    =>  $this->generateUrl('do_pobrania_new'),
                'method'    =>  "POST",
            )
        );
        $form
            ->add('submit','submit',array(
                    'label' =>  'Dodaj',
                    'attr'  =>  array('class'   =>  'btn-primary pull-right col-md-1')
                )
            );

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($doPobrania);
                $em->flush();

                return $this->redirect($this->generateUrl('do_pobrania'));
            }
        }

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

    /**
     * @Route("/do-pobrania/usun/{id}",
     *      name="do_pobrania_usun",
     * )
     * @param DoPobrania $doPobrania
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(DoPobrania $doPobrania)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$doPobrania)
        {
            throw $this->createNotFoundException('Załącznik, który próbujesz usunąć nie istnieje.');
        }

        $em->remove($doPobrania);
        $em->flush();

        return $this->redirect($this->generateUrl('do_pobrania'));
    }
} 