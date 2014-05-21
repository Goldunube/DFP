<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\WymaganiaPowloki;
use DFP\EtapIBundle\Form\WymaganiaPowlokiType;

/**
 * WymaganiaPowloki controller.
 *
 * @Route("/slowniki/wymaganiapowloki")
 */
class WymaganiaPowlokiController extends Controller
{

    /**
     * Lists all WymaganiaPowloki entities.
     *
     * @Route("/", name="url_wymaganiapowloki")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaPowloki/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:WymaganiaPowloki')->findBy(array(),array('nazwaParametru'=>'ASC'));

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),11);

        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new WymaganiaPowloki entity.
     *
     * @Route("/", name="url_wymaganiapowloki_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/WymaganiaPowloki:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new WymaganiaPowloki();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_wymaganiapowloki_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a WymaganiaPowloki entity.
    *
    * @param WymaganiaPowloki $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(WymaganiaPowloki $entity)
    {
        $form = $this->createForm(new WymaganiaPowlokiType(), $entity, array(
            'action' => $this->generateUrl('url_wymaganiapowloki_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new WymaganiaPowloki entity.
     *
     * @Route("/new", name="url_wymaganiapowloki_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaPowloki/new.html.twig")
     */
    public function newAction()
    {
        $entity = new WymaganiaPowloki();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a WymaganiaPowloki entity.
     *
     * @Route("/{id}", name="url_wymaganiapowloki_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaPowloki/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WymaganiaPowloki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WymaganiaPowloki entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing WymaganiaPowloki entity.
     *
     * @Route("/{id}/edit", name="url_wymaganiapowloki_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaPowloki/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WymaganiaPowloki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WymaganiaPowloki entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a WymaganiaPowloki entity.
    *
    * @param WymaganiaPowloki $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(WymaganiaPowloki $entity)
    {
        $form = $this->createForm(new WymaganiaPowlokiType(), $entity, array(
            'action' => $this->generateUrl('url_wymaganiapowloki_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Edits an existing WymaganiaPowloki entity.
     *
     * @Route("/{id}", name="url_wymaganiapowloki_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/WymaganiaPowloki:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WymaganiaPowloki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WymaganiaPowloki entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_wymaganiapowloki_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a WymaganiaPowloki entity.
     *
     * @Route("/{id}", name="url_wymaganiapowloki_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:WymaganiaPowloki')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find WymaganiaPowloki entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_wymaganiapowloki'));
    }

    /**
     * Creates a form to delete a WymaganiaPowloki entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_wymaganiapowloki_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
