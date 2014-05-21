<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use DFP\EtapIBundle\Form\ProfilDzialalnosciType;

/**
 * ProfilDzialalnosci controller.
 *
 * @Route("/slowniki/profildzialalnosci")
 */
class ProfilDzialalnosciController extends Controller
{

    /**
     * Lists all ProfilDzialalnosci entities.
     *
     * @Route("/", name="url_profiledzialalnosci")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProfilDzialalnosci/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->findAllOrderByName();

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),11);

        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new ProfilDzialalnosci entity.
     *
     * @Route("/", name="profildzialalnosci_create")
     * @Method("POST")
     * @Template("@DFPEtapI/Backend/ProfilDzialalnosci/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProfilDzialalnosci();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_profiledzialalnosci'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ProfilDzialalnosci entity.
    *
    * @param ProfilDzialalnosci $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProfilDzialalnosci $entity)
    {
        $form = $this->createForm(new ProfilDzialalnosciType(), $entity, array(
            'action' => $this->generateUrl('profildzialalnosci_create'),
            'method' => 'POST',
        ));

//        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProfilDzialalnosci entity.
     *
     * @Route("/new", name="profildzialalnosci_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProfilDzialalnosci/new.html.twig")
     */
    public function newAction()
    {
        $entity = new ProfilDzialalnosci();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProfilDzialalnosci entity.
     *
     * @Route("/{id}", name="profildzialalnosci_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProfilDzialalnosci/pokazKarteKlienta.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProfilDzialalnosci entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProfilDzialalnosci entity.
     *
     * @Route("/{id}/edit", name="profildzialalnosci_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProfilDzialalnosci/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProfilDzialalnosci entity.');
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
    * Creates a form to edit a ProfilDzialalnosci entity.
    *
    * @param ProfilDzialalnosci $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProfilDzialalnosci $entity)
    {
        $form = $this->createForm(new ProfilDzialalnosciType(), $entity, array(
            'action' => $this->generateUrl('profildzialalnosci_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Edits an existing ProfilDzialalnosci entity.
     *
     * @Route("/{id}", name="profildzialalnosci_update")
     * @Method("PUT")
     * @Template("@DFPEtapI/Backend/ProfilDzialalnosci/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProfilDzialalnosci entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('profildzialalnosci_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProfilDzialalnosci entity.
     *
     * @Route("/{id}/usun", name="profildzialalnosci_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można odnaleźć profilu działalności, który chcesz usunąć.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_profiledzialalnosci'));
    }

    /**
     * Creates a form to delete a ProfilDzialalnosci entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profildzialalnosci_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
