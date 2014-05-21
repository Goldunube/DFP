<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\ProcesAplikacji;
use DFP\EtapIBundle\Form\ProcesAplikacjiType;

/**
 * ProcesAplikacji controller.
 *
 * @Route("/slowniki/procesaplikacji")
 */
class ProcesAplikacjiController extends Controller
{

    /**
     * Lists all ProcesAplikacji entities.
     *
     * @Route("/", name="url_procesaplikacji")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesAplikacji/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:ProcesAplikacji')->findBy(array(),array('nazwaProcesu'=>'ASC'));

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),11);

        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new ProcesAplikacji entity.
     *
     * @Route("/", name="url_procesaplikacji_create")
     * @Method("POST")
     * @Template("@DFPEtapI/Backend/ProcesAplikacji/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProcesAplikacji();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_procesaplikacji_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ProcesAplikacji entity.
    *
    * @param ProcesAplikacji $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProcesAplikacji $entity)
    {
        $form = $this->createForm(new ProcesAplikacjiType(), $entity, array(
            'action' => $this->generateUrl('url_procesaplikacji_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new ProcesAplikacji entity.
     *
     * @Route("/new", name="url_procesaplikacji_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesAplikacji/new.html.twig")
     */
    public function newAction()
    {
        $entity = new ProcesAplikacji();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProcesAplikacji entity.
     *
     * @Route("/{id}", name="url_procesaplikacji_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesAplikacji/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesAplikacji')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesAplikacji entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProcesAplikacji entity.
     *
     * @Route("/{id}/edit", name="url_procesaplikacji_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesAplikacji/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesAplikacji')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesAplikacji entity.');
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
    * Creates a form to edit a ProcesAplikacji entity.
    *
    * @param ProcesAplikacji $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProcesAplikacji $entity)
    {
        $form = $this->createForm(new ProcesAplikacjiType(), $entity, array(
            'action' => $this->generateUrl('url_procesaplikacji_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Edits an existing ProcesAplikacji entity.
     *
     * @Route("/{id}", name="url_procesaplikacji_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/ProcesAplikacji:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesAplikacji')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesAplikacji entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_procesaplikacji_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProcesAplikacji entity.
     *
     * @Route("/{id}", name="url_procesaplikacji_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:ProcesAplikacji')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProcesAplikacji entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_procesaplikacji'));
    }

    /**
     * Creates a form to delete a ProcesAplikacji entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_procesaplikacji_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
