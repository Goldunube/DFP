<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use DFP\EtapIBundle\Entity\DoPobrania;
use DFP\EtapIBundle\Form\DoPobraniaType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Method("GET")
     */
    public function indexAction()
    {
        $doPobraniaRepo = $this->getDoctrine()->getRepository('DFPEtapIBundle:DoPobrania');
        $allList = $doPobraniaRepo->findAllBySort();
        $editPermissions = false;
        $paginator = $this->get('knp_paginator');

        $usersGroups = array(
            'ROLE_TECHNIK'  =>  'Technik',
            'ROLE_HDFP'     =>  'Handlowc DFP',
            'ROLE_HWPS'     =>  'WPS',
            'ROLE_FDFP'     =>  'Freelancer',
            'ROLE_RLS'      =>  'RLS',
            'ROLE_RKS'      =>  'RKS',
        );

        if($this->get('security.authorization_checker')->isGranted('ROLE_KDFP') or $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $editPermissions = true;
            $csrfProvider = $this->get('form.csrf_provider');
        }else{
            $tempList = new ArrayCollection();
            $user = $this->getUser();
            $userRoles = $user->getRoles();

            /**
             * @var DoPobrania $doPobraniaEntity
             */
            foreach($allList as $doPobraniaEntity)
            {
                $allowedGroups = $doPobraniaEntity->getAllowedGroups();
                if(count(array_intersect($allowedGroups,$userRoles))>0)
                {
                    $tempList->add($doPobraniaEntity);
                }
            }
            $allList = $tempList;
        }

        $pagination = $paginator->paginate($allList, $this->get('request')->query->get('strona',1),10);

        return array(
            'do_pobrania'   =>  $pagination,
            'uprawnienia'   =>  $editPermissions,
            'csrf_provider' =>  isset($csrfProvider) ? $csrfProvider : null,
            'token'         =>  'DFPdel%d',
            'roles_table'   =>  $usersGroups
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
     * @Route("/do-pobrania/{slug}", name="do_pobrania_pobierz")
     * @Method("GET")
     */
    public function downloadAction($slug)
    {
        /**
         * @var DoPobrania $doPobrania
         */
        $doPobrania = $this->getDoctrine()->getManager()->getRepository('DFPEtapIBundle:DoPobrania')->findOneBy(array('slug'=>$slug));
        if(!$doPobrania)
        {
            throw $this->createNotFoundException('Załącznik, który próbujesz usunąć nie istnieje.');
        }

        $file = $doPobrania->getZalacznik()->getAbsolutePath();
        $filename = $doPobrania->getSlug().'.'.$doPobrania->getZalacznik()->getTyp();
        $content = file_get_contents($file);

        $response = new Response();

        $response->headers->set('Content-Type','mime/type');
        $response->headers->set('Content-Disposition','attachment;filename="'.$filename);

        $response->setContent($content);
        return $response;
    }

    /**
     * @Route("/do-pobrania/edytuj/{slug}", name="do_pobrania_edit")
     * @Method({"GET","PUT"})
     * @Template()
     * @ParamConverter("doPobrania", class="DFPEtapIBundle:DoPobrania",options={"mapping" : { "slug" : "slug" } })
     */
    public function editAction(Request $request, DoPobrania $doPobrania)
    {
        if(!$doPobrania)
        {
            throw $this->createNotFoundException('Nie odnaleziono wskazanej do edycji encji.');
        }

        $form = $this->createForm(new DoPobraniaType(),$doPobrania,array(
                'action'    =>  $this->generateUrl('do_pobrania_edit',array('slug'=>$doPobrania->getSlug())),
                'method'    =>  'PUT'
            )
        );
        $form
            ->add('submit','submit',array(
                    'label' =>  'Aktualizuj',
                    'attr'  =>  array('class' => 'btn-primary pull-right col-md-1')
                )
            );

        if($request->isMethod('PUT'))
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
     * @Route("/do-pobrania/{id}/{token}",
     *      name="do_pobrania_usun",
     * )
     * @Method("DELETE")
     * @param $id
     * @param $token
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction($id, $token)
    {
        $this->denyAccessUnlessGranted('ROLE_KDFP',null,'Nie masz odpowiednich uprawnień by usunąć załącznik');
        $validToken = sprintf('DFPdel%d',$id);
        if(!$this->get('form.csrf_provider')->isCsrfTokenValid($validToken,$token))
        {
            throw $this->createAccessDeniedException('Błędny token akcji usuwania.');
        }

        $em = $this->getDoctrine()->getManager();
        $doPobrania = $em->getRepository('DFPEtapIBundle:DoPobrania')->find($id);

        if(!$doPobrania)
        {
            throw $this->createNotFoundException('Załącznik, który próbujesz usunąć nie istnieje.');
        }

        $em->remove($doPobrania);
        $em->flush();

        return new JsonResponse(array(
            'status'    =>  'ok',
            'message'   =>  'Załącznik został usunięty.'
        ));
    }
}