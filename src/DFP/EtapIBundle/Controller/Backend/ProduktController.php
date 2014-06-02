<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\Produkt;
use DFP\EtapIBundle\Form\ProduktType;

/**
 * Produkt controller.
 *
 * @Route("/produkty")
 */
class ProduktController extends Controller
{

    /**
     * Lists all Produkt entities.
     *
     * @Route("/", name="backend_produkty")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $kryteria = null;

        if($this->get('request')->query->get('filterField') && $this->get('request')->query->get('filterValue'))
        {
            $pole = $this->get('request')->query->get('filterField');
            $wartosc = $this->get('request')->query->get('filterValue');
            $kryteria = array('filterField'=>$pole,'filterValue'=>$wartosc);
        }

        $query = $em->getRepository('DFPEtapIBundle:Produkt')->getListaProduktowSearchQuery($kryteria);
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        return array(
            'lista_produktow'   => $pagination,
        );

    }
    /**
     * Creates a new Produkt entity.
     *
     * @Route("/", name="backend_produkty_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Produkt:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Produkt();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_produkty_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Produkt entity.
    *
    * @param Produkt $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Produkt $entity)
    {
        $form = $this->createForm(new ProduktType(), $entity, array(
            'action' => $this->generateUrl('backend_produkty_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new Produkt entity.
     *
     * @Route("/new", name="backend_produkty_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Produkt();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Produkt entity.
     *
     * @Route("/{id}", name="backend_produkty_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć produkty.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Produkt entity.
     *
     * @Route("/{id}/edit", name="backend_produkty_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć produkty.');
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
    * Creates a form to edit a Produkt entity.
    *
    * @param Produkt $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Produkt $entity)
    {
        $form = $this->createForm(new ProduktType(), $entity, array(
            'action' => $this->generateUrl('backend_produkty_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing Produkt entity.
     *
     * @Route("/{id}", name="backend_produkty_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Produkt:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć produktu.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_produkty_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Produkt entity.
     *
     * @Route("/{id}", name="backend_produkty_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można znaleźć produktu.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_produkty'));
    }

    /**
     * Creates a form to delete a Produkt entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_produkty_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
