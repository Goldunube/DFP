<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\WzornikKolorow;
use DFP\EtapIBundle\Form\WzornikKolorowType;

/**
 * WzornikKolorow controller.
 *
 * @Route("/slowniki/wzorniki-kolorow")
 */
class WzornikKolorowController extends Controller
{

    /**
     * Lists all WzornikKolorow entities.
     *
     * @Route("/", name="backend_wzornikkolorow")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/WzornikKolorow/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DFPEtapIBundle:WzornikKolorow')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new WzornikKolorow entity.
     *
     * @Route("/", name="backend_wzornikkolorow_create")
     * @Method("POST")
     * @Template("@DFPEtapI/Backend/Slowniki/WzornikKolorow/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new WzornikKolorow();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_wzornikkolorow_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a WzornikKolorow entity.
    *
    * @param WzornikKolorow $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(WzornikKolorow $entity)
    {
        $form = $this->createForm(new WzornikKolorowType(), $entity, array(
            'action' => $this->generateUrl('backend_wzornikkolorow_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new WzornikKolorow entity.
     *
     * @Route("/new", name="backend_wzornikkolorow_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/WzornikKolorow/new.html.twig")
     */
    public function newAction()
    {
        $entity = new WzornikKolorow();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a WzornikKolorow entity.
     *
     * @Route("/{id}", name="backend_wzornikkolorow_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/WzornikKolorow/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WzornikKolorow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć wzornika kolorów.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing WzornikKolorow entity.
     *
     * @Route("/{id}/edit", name="backend_wzornikkolorow_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/WzornikKolorow/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WzornikKolorow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć wzornika kolorów.');
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
    * Creates a form to edit a WzornikKolorow entity.
    *
    * @param WzornikKolorow $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(WzornikKolorow $entity)
    {
        $form = $this->createForm(new WzornikKolorowType(), $entity, array(
            'action' => $this->generateUrl('backend_wzornikkolorow_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing WzornikKolorow entity.
     *
     * @Route("/{id}", name="backend_wzornikkolorow_update")
     * @Method("PUT")
     * @Template("@DFPEtapI/Backend/Slowniki/WzornikKolorow/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:WzornikKolorow')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć wzornika kolorów.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_wzornikkolorow_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a WzornikKolorow entity.
     *
     * @Route("/{id}", name="backend_wzornikkolorow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:WzornikKolorow')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można znaleźć wzornika kolorów.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_wzornikkolorow'));
    }

    /**
     * Creates a form to delete a WzornikKolorow entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_wzornikkolorow_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
