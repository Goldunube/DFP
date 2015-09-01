<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Uzytkownik;
use DFP\EtapIBundle\Form\ProfilType;
use DFP\EtapIBundle\Form\UzytkownikType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Backend Uzytkownik kontroler
 *
 * @Route("/uzytkownicy")
 */
class UzytkownikController extends Controller
{
    /**
     * Lista wszystkich użytkowników w systemie
     *
     * @Route("/", name="url_lista_uzytkownikow")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Uzytkownik/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:Uzytkownik')->getAllUsersQuery();

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),20);
        $pagination->setFiltrationTemplate('::filtration.html.twig');

        return array(
            'entities' => $pagination,
        );
    }

    /**
     * Creates new user
     *
     * @Route("/", name="backend_uzytkownik_create")
     * @Method("POST")
     * @Template("@DFPEtapI/Backend/Uzytkownik/new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $uzytkownik = new Uzytkownik();

        $form = $this->createCreateForm($uzytkownik);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $nazwiskoNormalize = $this->ClearPolishSigns($uzytkownik->getNazwisko());
            $nazwiskoNormalize = mb_strtolower($nazwiskoNormalize,'UTF-8');
            $nazwiskoNormalize = str_replace(' ', '_', $nazwiskoNormalize);
//            $nazwiskoNormalize = preg_replace('/[^0-9a-z\-]+/', '', $nazwiskoNormalize);
            $nazwiskoNormalize = preg_replace('/[\-]+/', '-', $nazwiskoNormalize);
            $nazwiskoNormalize = trim($nazwiskoNormalize, '-');
            $imieNormalize = $this->ClearPolishSigns($uzytkownik->getImie());
            $imieNormalize = mb_strtolower($imieNormalize,'UTF-8');
            $imieNormalize = str_replace(' ', '_', $imieNormalize);
            $username = strtolower( substr($imieNormalize,0,1) );
            $username .= $nazwiskoNormalize;
            $uzytkownik->setUsername($username);
            $uzytkownik->setEnabled(true);

            $em->persist($uzytkownik);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',array('title'=>'Udało się!','body'=>'Nowy użytkownik został poprawnie dodany do bazy danych.'));

            return $this->redirect($this->generateUrl('url_lista_uzytkownikow'));

        }else{
            $this->get('session')->getFlashBag()->add('danger',array('title'=>'Błąd!','body'=>'Nowy użytkownik nie został dodany. Popraw formularz i spróbuj ponownie.'));
        }

        return array(
            'entity'    =>  $uzytkownik,
            'form'      =>  $form->createView(),
        );

    }

    /**
     * Creates a form to create a Specjalizacja entity.
     *
     * @param Uzytkownik $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Uzytkownik $entity)
    {
        $form = $this->createForm(new UzytkownikType(), $entity, array(
                'action' => $this->generateUrl('backend_uzytkownik_create'),
                'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new Użytkownik entity.
     *
     * @Template()
     * @Route("/nowy", name="backend_uzytkownik_new")
     * @Method("GET")
     *
     * @return array ()
     */
    public function newAction()
    {
        $uzytkownik = new Uzytkownik();
        $form = $this->createCreateForm($uzytkownik);

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zaplecze\/uzytkownicy?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('url_lista_uzytkownikow');
        }

        return array(
            'entity'        =>  $uzytkownik,
            'form'          =>  $form->createView(),
            'back_link'     =>  $referer,
        );
    }

    /**
     * Wyświetla profil użytkownika
     *
     * @Route("/{slug}", name="backend_uzytkownik_show")
     * @Method("GET")
     * @Template()
     *
     * @param $slug
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $uzytkownik Uzytkownik
         */
        $uzytkownik = $em->getRepository('DFPEtapIBundle:Uzytkownik')->findOneBySlug($slug);

        if(!$uzytkownik)
        {
            throw $this->createNotFoundException('Nie można odnaleźć użytkownika.');
        }

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zaplecze\/uzytkownicy?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('url_lista_uzytkownikow');
        }

        $random = uniqid();

        return array(
            'uzytkownik'    =>  $uzytkownik,
            'random_string' =>  $random,
            'back_link'     =>  $referer,
        );
    }

    /**
     * Displays a form to edit an existing Specjalizacja entity.
     *
     * @Route("/{slug}/edycja", name="backend_uzytkownik_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $uzytkownik = $em->getRepository('DFPEtapIBundle:Uzytkownik')->findOneBySlug($slug);

        if (!$uzytkownik) {
            throw $this->createNotFoundException('Nie można odnaleźć użytkownika.');
        }

        $referer = $this->get('request')->headers->get('referer');
        if(!preg_match('/\/zaplecze\/uzytkownicy?(\/\d)/',$referer))
        {
            $referer = $this->get('router')->generate('url_lista_uzytkownikow');
        }

        $random = uniqid();

        $editForm = $this->createEditForm($uzytkownik);

        return array(
            'uzytkownik'    => $uzytkownik,
            'edit_form'     => $editForm->createView(),
            'random_string' =>  $random,
            'back_link'     =>  $referer,
        );
    }

    /**
     * Creates a form to edit a Specjalizacja entity.
     *
     * @param Uzytkownik $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Uzytkownik $entity)
    {
        $form = $this->createForm(new UzytkownikType(), $entity, array(
                'action' => $this->generateUrl('backend_uzytkownik_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));

        $form->add('profilUzytkownika', new ProfilType(), array());
        $form->remove('plainPassword');
        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing Uzytkownik entity.
     *
     * @Route("/{id}", name="backend_uzytkownik_update")
     * @Method("PUT")
     * @Template("@DFPEtapI/Backend/Uzytkownik/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $uzytkownik Uzytkownik
         */
        $uzytkownik = $em->getRepository('DFPEtapIBundle:Uzytkownik')->find($id);

        if (!$uzytkownik) {
            throw $this->createNotFoundException('Nie można odnaleźć użytkownika.');
        }

        $editForm = $this->createEditForm($uzytkownik);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_uzytkownik_edit', array('slug' => $uzytkownik->getSlug())));
        }

        return array(
            'uzytkownik'  => $uzytkownik,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Uzytkownik entity.
     *
     * @Route("/{id}", name="backend_uzytkownik_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $uzytkownik = $em->getRepository('DFPEtapIBundle:Uzytkownik')->find($id);

            if (!$uzytkownik) {
                throw $this->createNotFoundException('Nie można odnaleźć użytkownika.');
            }

            $em->remove($uzytkownik);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_lista_uzytkownikow'));
    }

    /**
     * Blokowanie użytkownika
     *
     * @Route(
     *      "/{slug}/ajax",
     *      name="backend_uzytkownik_update_ajax",
     *      options={"expose"=true}
     * )
     * @Method("PUT")
     * @ParamConverter("uzytkownik",options={"mapping" : {"slug" : "slug"} })
     * @Security("has_role('ROLE_KDFP')")
     */
    public function userLockerAction(Uzytkownik $uzytkownik)
    {
        $userEnabled = $this->get('request')->request->get('enabled') == "true" ? 1 : 0;
        $uzytkownik->setEnabled($userEnabled);

        $em = $this->getDoctrine()->getManager();
        $em->persist($uzytkownik);
        $em->flush();

        $response = new JsonResponse();
        $response->setData("Poprawnie zmieniono status użytkownika.");

        return $response;
    }

    /**
     * Creates a form to delete a Uzytkownik entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_lista_uzytkownikow', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
            ;
    }

    /**
     * @param $text
     * @return mixed
     */
    private function ClearPolishSigns($text)
    {
        $ReplacePolishSign = array(
            'ą' => 'a', 'Ą' => 'A', 'ę' => 'ę', 'Ę' => 'E', 'ć' => 'c', 'Ć' => 'C', 'ń' => 'n', 'Ń' => 'N', 'ł' => 'l', 'Ł' => 'L', 'ś' => 's', 'Ś' => 'S', 'ż' => 'z', 'Ż' => 'Z', 'ź' => 'z', 'Ź' => 'Z', 'ó' => 'o', 'Ó' => 'o'
        );

        return str_replace(array_keys($ReplacePolishSign), array_values($ReplacePolishSign), $text);
    }
}