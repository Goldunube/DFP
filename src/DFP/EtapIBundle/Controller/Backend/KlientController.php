<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Filia;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\Klient;
use DFP\EtapIBundle\Form\KlientType;

/**
 * Backend Klient controller.
 *
 * @Route("/klient")
 */
class KlientController extends Controller
{

    /**
     * Lists all Klient entities.
     *
     * @Route("/", name="backend_klient")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:Klient')->getListaKlientowQuery();

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),21);

        return array(
            'lista_klientow' => $pagination,
        );
    }
    /**
     * Creates a new Klient entity.
     *
     * @Route("/", name="klient_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/Klient:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Klient();
        $entity->setDataZalozenia(new \DateTime('now'));
        $entity->setAktywny();

        $filia = new Filia();
        if($filia->getNazwaFilii() == null)
        {
            $filia->setNazwaFilii('Filia Główna');
        }
        $filia->setKlient($entity);
        $entity->getFilie()->add($filia);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->persist($filia);
            $em->flush();

            return $this->redirect($this->generateUrl('klient_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Klient entity.
    *
    * @param Klient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Klient $entity)
    {
        $form = $this->createForm(new KlientType(), $entity, array(
            'action' => $this->generateUrl('klient_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new Klient entity.
     *
     * @Route("/new", name="backend_klient_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Klient();
        $filia = new Filia();
        $entity->getFilie()->add($filia);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Klient entity.
     *
     * @Route("/{id}", name="klient_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Klient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Klient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Klient entity.
     *
     * @Route("/{id}/edit", name="klient_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Klient/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Klient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Klient entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'        => $entity,
            'form'          => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Klient entity.
    *
    * @param Klient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Klient $entity)
    {
        $form = $this->createForm(new KlientType(), $entity, array(
            'action' => $this->generateUrl('klient_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing Klient entity.
     *
     * @Route("/{id}", name="klient_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/Klient:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Klient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie udało się znaleźć encji Klienta.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('klient_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Klient entity.
     *
     * @Route("/{id}", name="klient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $klient = $em->getRepository('DFPEtapIBundle:Klient')->find($id);
//            $klient->getFilie();

            if (!$klient) {
                throw $this->createNotFoundException('Brak możliwości usunięcia klienta.');
            }

            $em->remove($klient);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_klient'));
    }

    /**
     * Creates a form to delete a Klient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('klient_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
