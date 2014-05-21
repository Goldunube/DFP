<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\WymaganiaProduktu;
use DFP\EtapIBundle\Form\WymaganiaProduktuType;

/**
 * WymaganiaProduktu controller.
 *
 * @Route("/slowniki/wymaganiaproduktu")
 */
class WymaganiaProduktuController extends Controller
{

    /**
     * Lists all WymaganiaProduktu entities.
     *
     * @Route("/", name="url_wymaganiaproduktu")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaProduktu/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:WymaganiaProduktu')->findBy(array(),array('nazwaParametru'=>'ASC'));

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),11);

        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new WymaganiaProduktu entity.
     *
     * @Route("/", name="url_wymaganiaproduktu_create")
     * @Method("POST")
     * @Template("@DFPEtapI/Backend/WymaganiaProduktu/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new WymaganiaProduktu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_wymaganiaproduktu_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a WymaganiaProduktu entity.
    *
    * @param WymaganiaProduktu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(WymaganiaProduktu $entity)
    {
        $form = $this->createForm(new WymaganiaProduktuType(), $entity, array(
            'action' => $this->generateUrl('url_wymaganiaproduktu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new WymaganiaProduktu entity.
     *
     * @Route("/new", name="url_wymaganiaproduktu_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaProduktu/new.html.twig")
     */
    public function newAction()
    {
        $entity = new WymaganiaProduktu();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a WymaganiaProduktu entity.
     *
     * @Route("/{id}", name="url_wymaganiaproduktu_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaProduktu/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WymaganiaProduktu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WymaganiaProduktu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing WymaganiaProduktu entity.
     *
     * @Route("/{id}/edit", name="url_wymaganiaproduktu_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/WymaganiaProduktu/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WymaganiaProduktu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WymaganiaProduktu entity.');
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
    * Creates a form to edit a WymaganiaProduktu entity.
    *
    * @param WymaganiaProduktu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(WymaganiaProduktu $entity)
    {
        $form = $this->createForm(new WymaganiaProduktuType(), $entity, array(
            'action' => $this->generateUrl('url_wymaganiaproduktu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Edits an existing WymaganiaProduktu entity.
     *
     * @Route("/{id}", name="url_wymaganiaproduktu_update")
     * @Method("PUT")
     * @Template("@DFPEtapI/Backend/WymaganiaProduktu/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WymaganiaProduktu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find WymaganiaProduktu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_wymaganiaproduktu_update', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a WymaganiaProduktu entity.
     *
     * @Route("/{id}", name="url_wymaganiaproduktu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:WymaganiaProduktu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find WymaganiaProduktu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_wymaganiaproduktu'));
    }

    /**
     * Creates a form to delete a WymaganiaProduktu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_wymaganiaproduktu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
