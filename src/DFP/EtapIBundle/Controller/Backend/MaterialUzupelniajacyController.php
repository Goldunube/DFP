<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\MaterialUzupelniajacy;
use DFP\EtapIBundle\Form\MaterialUzupelniajacyType;

/**
 * MaterialUzupelniajacy controller.
 *
 * @Route("/slowniki/materialuzupelniajacy")
 */
class MaterialUzupelniajacyController extends Controller
{

    /**
     * Lists all MaterialUzupelniajacy entities.
     *
     * @Route("/", name="url_materialuzupelniajacy")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/MaterialUzupelniajacy/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:MaterialUzupelniajacy')->findBy(array(),array('nazwa'=>'ASC'));

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),11);

        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new MaterialUzupelniajacy entity.
     *
     * @Route("/", name="url_materialuzupelniajacy_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/MaterialUzupelniajacy:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialUzupelniajacy();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_materialuzupelniajacy_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a MaterialUzupelniajacy entity.
    *
    * @param MaterialUzupelniajacy $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(MaterialUzupelniajacy $entity)
    {
        $form = $this->createForm(new MaterialUzupelniajacyType(), $entity, array(
            'action' => $this->generateUrl('url_materialuzupelniajacy_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialUzupelniajacy entity.
     *
     * @Route("/new", name="url_materialuzupelniajacy_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/MaterialUzupelniajacy/new.html.twig")
     */
    public function newAction()
    {
        $entity = new MaterialUzupelniajacy();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialUzupelniajacy entity.
     *
     * @Route("/{id}", name="url_materialuzupelniajacy_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/MaterialUzupelniajacy/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:MaterialUzupelniajacy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialUzupelniajacy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialUzupelniajacy entity.
     *
     * @Route("/{id}/edit", name="url_materialuzupelniajacy_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/MaterialUzupelniajacy/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:MaterialUzupelniajacy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialUzupelniajacy entity.');
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
    * Creates a form to edit a MaterialUzupelniajacy entity.
    *
    * @param MaterialUzupelniajacy $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialUzupelniajacy $entity)
    {
        $form = $this->createForm(new MaterialUzupelniajacyType(), $entity, array(
            'action' => $this->generateUrl('url_materialuzupelniajacy_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Edits an existing MaterialUzupelniajacy entity.
     *
     * @Route("/{id}", name="url_materialuzupelniajacy_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/MaterialUzupelniajacy:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:MaterialUzupelniajacy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialUzupelniajacy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_materialuzupelniajacy_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialUzupelniajacy entity.
     *
     * @Route("/{id}", name="url_materialuzupelniajacy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:MaterialUzupelniajacy')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialUzupelniajacy entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_materialuzupelniajacy'));
    }

    /**
     * Creates a form to delete a MaterialUzupelniajacy entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_materialuzupelniajacy_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
