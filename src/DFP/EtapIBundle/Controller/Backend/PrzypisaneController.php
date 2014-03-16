<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Entity\FiliaUzytkownik;
use DFP\EtapIBundle\Form\FiliaUzytkownikType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PrzypisaneController
 * @package DFP\EtapIBundle\Controller\Backend
 * @Route("/przypisane")
 */
class PrzypisaneController extends Controller
{
    /**
     * @return array
     * @Template()
     * @Route("/", name="backend_przypisanie_lista")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('DFPEtapIBundle:Filia')->getListaFiliiQuery();
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),11);

        foreach($pagination as $filia)
        {
            foreach($filia->getFilieUzytkownicy() as $przypisany)
            {
                $deleteForms[$przypisany->getId()] = $this->createDeleteForm()->createView();
            }
        }

        /** @var $deleteForms array */

        return array(
            'lista_filii'   => $pagination,
            'delete_forms'   => $deleteForms,
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @throws NotFoundHttpException
     * @Route("/edytuj/{id}", name="backend_przypisane_aktualizuj")
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template("@DFPEtapI/Backend/Przypisane/edit.html.twig")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $filiaUzytkownik = $em->getRepository('DFPEtapIBundle:FiliaUzytkownik')->find($id);

        if(!$filiaUzytkownik)
        {
            throw $this->createNotFoundException('Brak przypisania.');
        }

        $updateForm = $this->createEditForm($filiaUzytkownik);
        $updateForm->handleRequest($request);

        if($updateForm->isValid())
        {
            $em->persist($filiaUzytkownik);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_przypisanie_lista'));
        }

        return array(
            'przypisanie'     =>  $filiaUzytkownik,
            'formularz' =>  $updateForm->createView(),
        );
    }

    /**
     * @param FiliaUzytkownik $filiaUzytkownik
     * @return \Symfony\Component\Form\Form
     */
    protected function createEditForm(FiliaUzytkownik $filiaUzytkownik)
    {
        $form = $this->createForm(new FiliaUzytkownikType(), $filiaUzytkownik, array(
                'action'    => $this->generateUrl('backend_przypisane_aktualizuj', array('id' => $filiaUzytkownik->getId())),
                'method'    => 'PUT',
        ));

        $form->add('submit','submit', array('label'=>'Aktualizuj'));

        return $form;
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     * @Template()
     * @Route("/edytuj/{id}", name="backend_przypisane_edycja")
     * @Method("GET")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $filiaUzytkownik = $em->getRepository('DFPEtapIBundle:FiliaUzytkownik')->find($id);

        if (!$filiaUzytkownik) {
            throw $this->createNotFoundException('Nie znaleziono karty klienta.');
        }

        $editForm = $this->createEditForm($filiaUzytkownik);

        return array(
            'przypisanie'     =>  $filiaUzytkownik,
            'formularz' =>  $editForm->createView(),
        );
    }

    /**
     * @Route("/{id}", name="backend_przypisane_usun")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $przypisanie = $em->getRepository('DFPEtapIBundle:FiliaUzytkownik')->find($id);

            if(!$przypisanie)
            {
                throw $this->createNotFoundException('Nie ma przypisania, które chcesz usunąć.');
            }

            $em->remove($przypisanie);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_przypisanie_lista'));
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label'=> 'Usuń'))
            ->getForm();
    }

    /**
     * @param Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/", name="backend_przypisane_utworz")
     * @Template("@DFPEtapI/Backend/Przypisane/new.html.twig")
     * @Method("POST")
     */
    public function createPrzypisanieAction(Request $request)
    {
        $przypisanie = new FiliaUzytkownik();
        $filia = new Filia();
        $przypisanie->setFilia($filia);

        $form = $this->createForm(new FiliaUzytkownikType(), $przypisanie, array(
                'action'        =>  $this->generateUrl('backend_przypisane_utworz'),
                'method'        =>  'POST',
            ));
        $form->add('filia','hidden', array(
                'data'  =>  'DFPEtapIBundle:Filia'
            ));
        $form->add('submit','submit', array('label'=>"Utwórz"));

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $przypisanie->setAkcept(true);
            $przypisanie->setPerm(false);
            $em->persist($przypisanie);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_przypisanie_lista'));
    }

    /**
     * @Route("/nowe/filia/{filiaId}", name="backend_przypisanie_nowe")
     * @Template()
     * @Method("GET")
     */
    public function newAction($filiaId)
    {
        $em = $this->getDoctrine()->getManager();
        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($filiaId);

        if(!$filia)
        {
            throw $this->createNotFoundException('Filia, do której chcesz przypisać użytkownika, nie istnieje');
        }

        $filiaUzytkownik = new FiliaUzytkownik();
        $filiaUzytkownik->setFilia($filia);
        $form = $this->createForm(new FiliaUzytkownikType(), $filiaUzytkownik, array(
                'action'        =>  $this->generateUrl('backend_przypisane_utworz'),
                'method'        =>  'POST',
            ));
        $form->add('filia','hidden', array(
                'data'  =>  'DFPEtapIBundle:Filia'
            ));
        $form->add('submit','submit', array('label'=>"Utwórz"));

        return array(
            'filia'                 =>  $filia,
            'filia_uzytkownik'      =>  $filiaUzytkownik,
            'formularz'             =>  $form->createView(),
        );
    }
}
