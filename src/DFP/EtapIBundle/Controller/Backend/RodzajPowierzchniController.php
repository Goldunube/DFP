<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\RodzajPowierzchni;
use DFP\EtapIBundle\Form\RodzajPowierzchniType;

/**
 * RodzajPowierzchni controller.
 *
 * @Route("/slowniki/rodzajpowierzchni")
 * @package DFP\EtapIBundle\Controller\Backend
 */
class RodzajPowierzchniController extends Controller
{

    /**
     * Lists all RodzajPowierzchni entities.
     *
     * @Route("/", name="url_backend_rodzajpowierzchni")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DFPEtapIBundle:RodzajPowierzchni')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new RodzajPowierzchni entity.
     *
     * @Route("/", name="url_backend_rodzajpowierzchni_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/RodzajPowierzchni:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RodzajPowierzchni();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('url_backend_rodzajpowierzchni_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a RodzajPowierzchni entity.
    *
    * @param RodzajPowierzchni $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(RodzajPowierzchni $entity)
    {
        $form = $this->createForm(new RodzajPowierzchniType(), $entity, array(
            'action' => $this->generateUrl('url_backend_rodzajpowierzchni_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new RodzajPowierzchni entity.
     *
     * @Route("/new", name="url_backend_rodzajpowierzchni_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RodzajPowierzchni();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RodzajPowierzchni entity.
     *
     * @Route("/{id}", name="url_backend_rodzajpowierzchni_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:RodzajPowierzchni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RodzajPowierzchni entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RodzajPowierzchni entity.
     *
     * @Route("/{id}/edit", name="url_backend_rodzajpowierzchni_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:RodzajPowierzchni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RodzajPowierzchni entity.');
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
    * Creates a form to edit a RodzajPowierzchni entity.
    *
    * @param RodzajPowierzchni $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RodzajPowierzchni $entity)
    {
        $form = $this->createForm(new RodzajPowierzchniType(), $entity, array(
            'action' => $this->generateUrl('url_backend_rodzajpowierzchni_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing RodzajPowierzchni entity.
     *
     * @Route("/{id}", name="url_backend_rodzajpowierzchni_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/RodzajPowierzchni:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:RodzajPowierzchni')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RodzajPowierzchni entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('url_backend_rodzajpowierzchni_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RodzajPowierzchni entity.
     *
     * @Route("/{id}", name="url_backend_rodzajpowierzchni_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:RodzajPowierzchni')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RodzajPowierzchni entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('url_backend_rodzajpowierzchni'));
    }

    /**
     * Creates a form to delete a RodzajPowierzchni entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('url_backend_rodzajpowierzchni_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
