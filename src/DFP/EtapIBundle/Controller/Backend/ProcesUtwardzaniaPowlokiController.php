<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\ProcesUtwardzaniaPowloki;
use DFP\EtapIBundle\Form\ProcesUtwardzaniaPowlokiType;

/**
 * ProcesUtwardzaniaPowloki controller.
 *
 * @Route("/procesutwardzaniapowloki")
 */
class ProcesUtwardzaniaPowlokiController extends Controller
{

    /**
     * Lists all ProcesUtwardzaniaPowloki entities.
     *
     * @Route("/", name="url_procesutwardzaniapowloki")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesUtwardzaniaPowloki/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:ProcesUtwardzaniaPowloki')->findBy(array(),array('nazwaProcesu'=>'ASC'));

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),11);

        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new ProcesUtwardzaniaPowloki entity.
     *
     * @Route("/", name="url_procesutwardzaniapowloki_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/ProcesUtwardzaniaPowloki:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProcesUtwardzaniaPowloki();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_procesutwardzaniapowloki_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ProcesUtwardzaniaPowloki entity.
    *
    * @param ProcesUtwardzaniaPowloki $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProcesUtwardzaniaPowloki $entity)
    {
        $form = $this->createForm(new ProcesUtwardzaniaPowlokiType(), $entity, array(
            'action' => $this->generateUrl('url_procesutwardzaniapowloki_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new ProcesUtwardzaniaPowloki entity.
     *
     * @Route("/new", name="url_procesutwardzaniapowloki_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesUtwardzaniaPowloki/new.html.twig")
     */
    public function newAction()
    {
        $entity = new ProcesUtwardzaniaPowloki();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProcesUtwardzaniaPowloki entity.
     *
     * @Route("/{id}", name="url_procesutwardzaniapowloki_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesUtwardzaniaPowloki/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesUtwardzaniaPowloki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesUtwardzaniaPowloki entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProcesUtwardzaniaPowloki entity.
     *
     * @Route("/{id}/edit", name="url_procesutwardzaniapowloki_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesUtwardzaniaPowloki/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesUtwardzaniaPowloki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesUtwardzaniaPowloki entity.');
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
    * Creates a form to edit a ProcesUtwardzaniaPowloki entity.
    *
    * @param ProcesUtwardzaniaPowloki $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProcesUtwardzaniaPowloki $entity)
    {
        $form = $this->createForm(new ProcesUtwardzaniaPowlokiType(), $entity, array(
            'action' => $this->generateUrl('url_procesutwardzaniapowloki_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Edits an existing ProcesUtwardzaniaPowloki entity.
     *
     * @Route("/{id}", name="url_procesutwardzaniapowloki_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/ProcesUtwardzaniaPowloki:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesUtwardzaniaPowloki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesUtwardzaniaPowloki entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_procesutwardzaniapowloki_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProcesUtwardzaniaPowloki entity.
     *
     * @Route("/{id}", name="url_procesutwardzaniapowloki_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:ProcesUtwardzaniaPowloki')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProcesUtwardzaniaPowloki entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_procesutwardzaniapowloki'));
    }

    /**
     * Creates a form to delete a ProcesUtwardzaniaPowloki entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_procesutwardzaniapowloki_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
