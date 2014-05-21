<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\ProcesPrzygotowaniaPowierzchni;
use DFP\EtapIBundle\Form\ProcesPrzygotowaniaPowierzchniType;

/**
 * ProcesPrzygotowaniaPowierzchni controller.
 *
 * @Route("/slowniki/procesprzygotowaniapowierzchni")
 */
class ProcesPrzygotowaniaPowierzchniController extends Controller
{

    /**
     * Lists all ProcesPrzygotowaniaPowierzchni entities.
     *
     * @Route("/", name="url_procesprzygotowaniapowierzchni")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesPrzygotowaniaPowierzchni/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:ProcesPrzygotowaniaPowierzchni')->findBy(array(),array('nazwaProcesu'=>'ASC'));

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),11);

        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new ProcesPrzygotowaniaPowierzchni entity.
     *
     * @Route("/", name="url_procesprzygotowaniapowierzchni_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/ProcesPrzygotowaniaPowierzchni:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProcesPrzygotowaniaPowierzchni();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_procesprzygotowaniapowierzchni_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ProcesPrzygotowaniaPowierzchni entity.
    *
    * @param ProcesPrzygotowaniaPowierzchni $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProcesPrzygotowaniaPowierzchni $entity)
    {
        $form = $this->createForm(new ProcesPrzygotowaniaPowierzchniType(), $entity, array(
            'action' => $this->generateUrl('url_procesprzygotowaniapowierzchni_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new ProcesPrzygotowaniaPowierzchni entity.
     *
     * @Route("/new", name="url_procesprzygotowaniapowierzchni_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesPrzygotowaniaPowierzchni/new.html.twig")
     */
    public function newAction()
    {
        $entity = new ProcesPrzygotowaniaPowierzchni();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProcesPrzygotowaniaPowierzchni entity.
     *
     * @Route("/{id}", name="url_procesprzygotowaniapowierzchni_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesPrzygotowaniaPowierzchni/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesPrzygotowaniaPowierzchni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesPrzygotowaniaPowierzchni entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProcesPrzygotowaniaPowierzchni entity.
     *
     * @Route("/{id}/edit", name="url_procesprzygotowaniapowierzchni_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/ProcesPrzygotowaniaPowierzchni/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesPrzygotowaniaPowierzchni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesPrzygotowaniaPowierzchni entity.');
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
    * Creates a form to edit a ProcesPrzygotowaniaPowierzchni entity.
    *
    * @param ProcesPrzygotowaniaPowierzchni $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProcesPrzygotowaniaPowierzchni $entity)
    {
        $form = $this->createForm(new ProcesPrzygotowaniaPowierzchniType(), $entity, array(
            'action' => $this->generateUrl('url_procesprzygotowaniapowierzchni_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Edits an existing ProcesPrzygotowaniaPowierzchni entity.
     *
     * @Route("/{id}", name="url_procesprzygotowaniapowierzchni_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/ProcesPrzygotowaniaPowierzchni:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:ProcesPrzygotowaniaPowierzchni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProcesPrzygotowaniaPowierzchni entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_procesprzygotowaniapowierzchni_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProcesPrzygotowaniaPowierzchni entity.
     *
     * @Route("/{id}", name="url_procesprzygotowaniapowierzchni_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:ProcesPrzygotowaniaPowierzchni')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProcesPrzygotowaniaPowierzchni entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_procesprzygotowaniapowierzchni'));
    }

    /**
     * Creates a form to delete a ProcesPrzygotowaniaPowierzchni entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_procesprzygotowaniapowierzchni_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
