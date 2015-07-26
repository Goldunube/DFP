<?php

namespace GCSV\RaportBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GCSV\RaportBundle\Entity\RaportTechniczny;
use GCSV\RaportBundle\Form\RaportTechnicznyType;
use Symfony\Component\HttpFoundation\Response;

/**
 * RaportTechniczny controller.
 *
 * @Route("/raport-techniczny")
 */
class RaportTechnicznyController extends Controller
{

    /**
     * Lists all RaportTechniczny entities.
     *
     * @Route("/", name="raporty_techniczne")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GCSVRaportBundle:RaportTechniczny')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new RaportTechniczny entity.
     *
     * @Route("/", name="raport_techniczny_create")
     * @Method("POST")
     * @Template("GCSVRaportBundle:Frontend/RaportTechniczny:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RaportTechniczny();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('raport_techniczny_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RaportTechniczny entity.
     *
     * @param RaportTechniczny $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RaportTechniczny $entity)
    {
        $form = $this->createForm(new RaportTechnicznyType(), $entity, array(
            'action' => $this->generateUrl('raport_techniczny_create', array(  )),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new RaportTechniczny entity.
     *
     * @Route("/new", name="raport_techniczny_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RaportTechniczny();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RaportTechniczny entity.
     *
     * @Route(
     *      "/{id}/{_format}",
     *      defaults={"_format": "html"},
     *      name="raport_techniczny_show",
     *      requirements={
     *         "_format": "html|pdf",
     *         "id": "\d+"
     *     }
     * )
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $_format)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVRaportBundle:RaportTechniczny')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć raportu technicznego.');
        }
        if($_format == 'pdf')
        {
            $html = $this->renderView('GCSVRaportBundle:Frontend/RaportTechniczny:show.pdf.twig', array(
                    'raport'      => $entity,
                ),false
            );

            $pdf = $this->get('knp_snappy.pdf');
            $pdf->setOption('lowquality',false);
            $pdf->setOption('encoding','utf-8');
            $pdf->setOption('header-html',$this->generateUrl('raport_header',array(),true));
            $pdf->setOption('header-spacing',10);
            $pdf->setOption('footer-spacing',10);
            $pdf->setOption('margin-top',35);
            $pdf->setOption('margin-left',0);
            $pdf->setOption('margin-right',0);
            $pdf->setOption('margin-bottom',51);
            $pdf->setOption('footer-html',$this->generateUrl('raport_footer',array(),true));

            return new Response(
                $pdf->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'filename="raport_techniczny.pdf"'
                )
            );

/*            return $this->render('GCSVRaportBundle:Frontend/RaportTechniczny:show.'.$_format.'.twig', array(
                    'raport'      => $entity,
                )
            );*/
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'raport'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RaportTechniczny entity.
     *
     * @Route("/{id}/edit", name="raport_techniczny_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVRaportBundle:RaportTechniczny')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć raportu technicznego.');
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
    * Creates a form to edit a RaportTechniczny entity.
    *
    * @param RaportTechniczny $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RaportTechniczny $entity)
    {
        $form = $this->createForm(new RaportTechnicznyType(), $entity, array(
            'action' => $this->generateUrl('raport_techniczny_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing RaportTechniczny entity.
     *
     * @Route("/{id}", name="raport_techniczny_update")
     * @Method("PUT")
     * @Template("GCSVRaportBundle:Frontend/RaportTechniczny:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVRaportBundle:RaportTechniczny')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można odnaleźć raportu technicznego.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('raport_techniczny_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * (AJAX) Oznacza raport techniczny jako usunięty z bazy danych.
     *
     * @Route(
     *      "/{id}",
     *      name="raport_techniczny_soft_delete_ajax",
     *      condition="request.headers.get('X-Requested-With') == 'XMLHttpRequest'",
     *      options={"expose"=true}
     * )
     * @Method("DELETE")
     */
    public function ajaxSoftDeleteAction(RaportTechniczny $raport)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$raport)
        {
            throw $this->createNotFoundException("Nie można odnaleźć w bazie danych raportu technicznego, który chcesz usunąć.");
        }

        $response = new JsonResponse();
        if($raport->getAutor() == $this->getUser() or $this->get('security.context')->isGranted('ROLE_KOORDYNATOR_DT'))
        {
            $raport->setUsuniety(true);
            $em->flush();
            $responseMessage = Array("type" => "success","msg" => "Raport techniczny został usunięty.");
        }else{
            $responseMessage = Array("type" => "warning","msg" => "Nie masz odpowiednich uprawnień by usunąc ten raport techniczny.");
        }

        $response->setData($responseMessage);

        return $response;
    }

    /**
     * Deletes a RaportTechniczny entity.
     *
     * @Route("/{id}", name="raport_techniczny_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GCSVRaportBundle:RaportTechniczny')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można odnaleźć raportu technicznego.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('raporty_techniczne'));
    }

    /**
     * Creates a form to delete a RaportTechniczny entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('raport_techniczny_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
