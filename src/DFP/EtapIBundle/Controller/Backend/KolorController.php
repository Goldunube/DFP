<?php

namespace DFP\EtapIBundle\Controller\Backend;

use Doctrine\Common\Cache\ArrayCache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\Kolor;
use DFP\EtapIBundle\Form\KolorType;

/**
 * Kolor controller.
 *
 * @Route("/slowniki/kolory")
 */
class KolorController extends Controller
{

    /**
     * Lists all Kolor entities.
     *
     * @Route("/", name="backend_kolor")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/Kolor/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DFPEtapIBundle:Kolor')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Kolor entity.
     *
     * @Route("/", name="backend_kolor_create")
     * @Method("POST")
     * @Template("@DFPEtapI/Backend/Slowniki/Kolor/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Kolor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_kolor_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Kolor entity.
    *
    * @param Kolor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Kolor $entity)
    {
        $form = $this->createForm(new KolorType(), $entity, array(
            'action' => $this->generateUrl('backend_kolor_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new Kolor entity.
     *
     * @Route("/new", name="backend_kolor_new")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/Kolor/new.html.twig")
     */
    public function newAction()
    {
        $entity = new Kolor();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Kolor entity.
     *
     * @Route("/{id}", name="backend_kolor_show")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/Kolor/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Kolor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć koloru.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Kolor entity.
     *
     * @Route("/{id}/edit", name="backend_kolor_edit")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Slowniki/Kolor/edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Kolor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć koloru.');
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
    * Creates a form to edit a Kolor entity.
    *
    * @param Kolor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Kolor $entity)
    {
        $form = $this->createForm(new KolorType(), $entity, array(
            'action' => $this->generateUrl('backend_kolor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing Kolor entity.
     *
     * @Route("/{id}", name="backend_kolor_update")
     * @Method("PUT")
     * @Template("@DFPEtapI/Backend/Slowniki/Kolor/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Kolor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć koloru.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_kolor_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Kolor entity.
     *
     * @Route("/{id}", name="backend_kolor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:Kolor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można znaleźć koloru.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_kolor'));
    }

    /**
     * Creates a form to delete a Kolor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_kolor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }

    /**
     * Pobiera wszystkie kolory zapisane w bazie danych i zwrace je w postaci tablicy JSON
     *
     * @return JsonResponse
     * @Route("/ajax/kolory", name="backend_ajax_kolory")
     */
    public function pobierzListeWszystkichKolorowAjaxAction()
    {
        $em = $this->getDoctrine()->getManager();

        $term = $this->get('request')->query->get('term');

        $kolory = $em->getRepository('DFPEtapIBundle:Kolor')->getListaKolorow($term);

        $data = array();
        foreach($kolory as $kolor)
        {
            $data[] = Array('label'=>$kolor->getNazwa(),'category'=>$kolor->getWzornikKoloru()->getNazwa());
        }

        return new JsonResponse($data);
    }
}
