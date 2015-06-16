<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use DFP\EtapIBundle\Entity\DoPobrania;
use DFP\EtapIBundle\Form\AktualnosciPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="strona_glowna")
     * @Template("@DFPEtapI/Frontend/index.html.twig")
     */
    public function indexAction()
    {
        $doPobraniaRepo = $this->getDoctrine()->getRepository('DFPEtapIBundle:DoPobrania');
        $allList = $doPobraniaRepo->findAllAktualnosciBySort();
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
        }

        $pagination = $paginator->paginate($allList, $this->get('request')->query->get('strona',1),10);

        return array(
            'wiadomosci'   =>  $pagination,
            'uprawnienia'   =>  $editPermissions,
            'csrf_provider' =>  isset($csrfProvider) ? $csrfProvider : null,
            'token'         =>  'DFPdel%d',
            'roles_table'   =>  $usersGroups
        );
    }

    /**
     * @Route("/aktualnosci/new",
     *      name="aktualnosci_new"
     * )
     * @Method({"GET","POST"})
     * @Template()
     * @Security("has_role('ROLE_KDFP') or has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $aktualnosciPost = new DoPobrania();
        $aktualnosciPost->setWiadomosciShow(1);

        $form = $this->createForm(new AktualnosciPostType(),$aktualnosciPost,array(
                'action'    =>  $this->generateUrl('aktualnosci_new'),
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
                $em->persist($aktualnosciPost);
                $em->flush();

                return $this->redirect($this->generateUrl('strona_glowna'));
            }
        }

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/aktualnosci/edytuj/{slug}", name="aktualnosci_edit")
     * @Method({"GET","PUT"})
     * @Template()
     * @ParamConverter("doPobrania", class="DFPEtapIBundle:DoPobrania",options={"mapping" : { "slug" : "slug" } })
     * @Security("has_role('ROLE_KDFP') or has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, DoPobrania $doPobrania)
    {
        if(!$doPobrania)
        {
            throw $this->createNotFoundException('Nie odnaleziono wskazanej do edycji encji.');
        }

        $form = $this->createForm(new AktualnosciPostType(),$doPobrania,array(
                'action'    =>  $this->generateUrl('aktualnosci_edit',array('slug'=>$doPobrania->getSlug())),
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

                return $this->redirect($this->generateUrl('strona_glowna'));
            }
        }

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * @Route("/aktualnosci/{id}/{token}",
     *      name="aktualnosci_usun",
     * )
     * @Method("DELETE")
     * @param $id
     * @param $token
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Security("has_role('ROLE_KDFP') or has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id, $token)
    {
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
