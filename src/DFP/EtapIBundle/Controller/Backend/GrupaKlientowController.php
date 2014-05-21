<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\GrupaKlientow;
use DFP\EtapIBundle\Form\GrupaKlientowType;

/**
 * GrupaKlientow controller.
 *
 * @Route("/slowniki/grupaklientow")
 */
class GrupaKlientowController extends Controller
{

    /**
     * Lists all GrupaKlientow entities.
     *
     * @Route("/", name="grupaklientow")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DFPEtapIBundle:GrupaKlientow')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new GrupaKlientow entity.
     *
     * @Route("/", name="grupaklientow_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/GrupaKlientow:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new GrupaKlientow();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('grupaklientow_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a GrupaKlientow entity.
    *
    * @param GrupaKlientow $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(GrupaKlientow $entity)
    {
        $form = $this->createForm(new GrupaKlientowType(), $entity, array(
            'action' => $this->generateUrl('grupaklientow_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GrupaKlientow entity.
     *
     * @Route("/new", name="grupaklientow_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new GrupaKlientow();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a GrupaKlientow entity.
     *
     * @Route("/{id}", name="grupaklientow_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:GrupaKlientow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GrupaKlientow entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing GrupaKlientow entity.
     *
     * @Route("/{id}/edit", name="grupaklientow_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:GrupaKlientow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GrupaKlientow entity.');
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
    * Creates a form to edit a GrupaKlientow entity.
    *
    * @param GrupaKlientow $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GrupaKlientow $entity)
    {
        $form = $this->createForm(new GrupaKlientowType(), $entity, array(
            'action' => $this->generateUrl('grupaklientow_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing GrupaKlientow entity.
     *
     * @Route("/{id}", name="grupaklientow_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/GrupaKlientow:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:GrupaKlientow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GrupaKlientow entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('grupaklientow_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a GrupaKlientow entity.
     *
     * @Route("/{id}", name="grupaklientow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:GrupaKlientow')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GrupaKlientow entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('grupaklientow'));
    }

    /**
     * Creates a form to delete a GrupaKlientow entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('grupaklientow_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
