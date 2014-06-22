<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\SystemMalarski;
use DFP\EtapIBundle\Form\SystemMalarskiType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SystemMalarskiController
 * @package DFP\EtapIBundle\Controller\Backend
 * @Route("/systemy_malarskie")
 */
class SystemMalarskiController extends Controller
{
    /**
     * @Route("/utworzSystemMalarski", name="backend_system_malarski_create")
     * @Template()
     */
    public function utworzSystemMalarskiAction(Request $request)
    {
        $systemMalarski = new SystemMalarski();
        $form = $this->createNewSystemForm($systemMalarski);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($systemMalarski);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
    }

    private function createNewSystemForm(SystemMalarski $system)
    {
        $form = $this->createForm(new SystemMalarskiType(), $system, array(
                'action'    =>  '#',
                'method'    =>  'POST'
            )
        );

        $form->add('submit', 'submit', array('label'=>'Utwórz'));

        return $form;
    }

    /**
     * Lists all SystemMalarski entities.
     *
     * @Route("/", name="backend_system_malarski")
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

        $query = $em->getRepository('DFPEtapIBundle:SystemMalarski')->getListaSystemowMalarskichSearchQuery($kryteria);
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        return array(
            'systemy_malarskie' => $pagination,
        );
    }
    /**
     * Creates a new SystemMalarski entity.
     *
     * @Route("/", name="backend_system_malarski_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/SystemMalarski:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SystemMalarski();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_system_malarski_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SystemMalarski entity.
     *
     * @param SystemMalarski $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SystemMalarski $entity)
    {
        $form = $this->createForm(new SystemMalarskiType(), $entity, array(
                'action' => $this->generateUrl('backend_system_malarski_create'),
                'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new SystemMalarski entity.
     *
     * @Route("/new", name="backend_system_malarski_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SystemMalarski();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SystemMalarski entity.
     *
     * @Route("/{id}", name="backend_system_malarski_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:SystemMalarski')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć wskazanego systemu malarskiego.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SystemMalarski entity.
     *
     * @Route("/{id}/edit", name="backend_system_malarski_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:SystemMalarski')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć wskazanego systemu malarskiego.');
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
     * Creates a form to edit a SystemMalarski entity.
     *
     * @param SystemMalarski $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SystemMalarski $entity)
    {
        $form = $this->createForm(new SystemMalarskiType(), $entity, array(
                'action' => $this->generateUrl('backend_system_malarski_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing SystemMalarski entity.
     *
     * @Route("/{id}", name="backend_system_malarski_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/SystemMalarski:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:SystemMalarski')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć wskazanego systemu malarskiego.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_system_malarski_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SystemMalarski entity.
     *
     * @Route("/{id}", name="backend_system_malarski_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:SystemMalarski')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można odnaleźć wskazanego systemu malarskiego.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_system_malarski'));
    }

    /**
     * Creates a form to delete a SystemMalarski entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_system_malarski_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
            ;
    }
}
