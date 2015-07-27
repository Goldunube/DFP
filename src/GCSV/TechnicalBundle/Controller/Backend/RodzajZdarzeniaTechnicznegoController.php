<?php

namespace GCSV\TechnicalBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GCSV\TechnicalBundle\Entity\RodzajZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Form\RodzajZdarzeniaTechnicznegoType;

/**
 * RodzajZdarzeniaTechnicznego controller.
 *
 * @Route("/rodzaj-zdarzenia-technicznego")
 */
class RodzajZdarzeniaTechnicznegoController extends Controller
{

    /**
     * Lists all RodzajZdarzeniaTechnicznego entities.
     *
     * @Route("/", name="backend_rodzaje_zdarzen_technicznych")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new RodzajZdarzeniaTechnicznego entity.
     *
     * @Route("/", name="backend_rodzaj_zdarzenia_technicznego_create")
     * @Method("POST")
     * @Template("GCSVTechnicalBundle:Backend/RodzajZdarzeniaTechnicznego:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RodzajZdarzeniaTechnicznego();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_rodzaje_zdarzen_technicznych'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RodzajZdarzeniaTechnicznego entity.
     *
     * @param RodzajZdarzeniaTechnicznego $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RodzajZdarzeniaTechnicznego $entity)
    {
        $form = $this->createForm(new RodzajZdarzeniaTechnicznegoType(), $entity, array(
            'action' => $this->generateUrl('backend_rodzaj_zdarzenia_technicznego_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new RodzajZdarzeniaTechnicznego entity.
     *
     * @Route("/new", name="backend_rodzaj_zdarzenia_technicznego_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RodzajZdarzeniaTechnicznego();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RodzajZdarzeniaTechnicznego entity.
     *
     * @Route("/{id}", name="backend_rodzaj_zdarzenia_technicznego_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć szukanego rodzaju zdarzenia technicznego.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RodzajZdarzeniaTechnicznego entity.
     *
     * @Route("/{id}/edit", name="backend_rodzaj_zdarzenia_technicznego_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć szukanego rodzaju zdarzenia technicznego.');
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
    * Creates a form to edit a RodzajZdarzeniaTechnicznego entity.
    *
    * @param RodzajZdarzeniaTechnicznego $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RodzajZdarzeniaTechnicznego $entity)
    {
        $form = $this->createForm(new RodzajZdarzeniaTechnicznegoType(), $entity, array(
            'action' => $this->generateUrl('backend_rodzaj_zdarzenia_technicznego_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing RodzajZdarzeniaTechnicznego entity.
     *
     * @Route("/{id}", name="backend_rodzaj_zdarzenia_technicznego_update")
     * @Method("PUT")
     * @Template("GCSVTechnicalBundle:Backend/RodzajZdarzeniaTechnicznego:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć szukanego rodzaju zdarzenia technicznego.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_rodzaj_zdarzenia_technicznego_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RodzajZdarzeniaTechnicznego entity.
     *
     * @Route("/{id}", name="backend_rodzaj_zdarzenia_technicznego_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można odnaleźć szukanego rodzaju zdarzenia technicznego.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_rodzaje_zdarzen_technicznych'));
    }

    /**
     * Creates a form to delete a RodzajZdarzeniaTechnicznego entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_rodzaj_zdarzenia_technicznego_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
