<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Form\FiliaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Request;

/**
 * @Route("/filie")
 */
class FilieController extends Controller
{
    /**
     * TODO optymalizacja zapytania wyświetlającego całą listę filii
     *
     * @Route("/", name="backend_filie")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('DFPEtapIBundle:Filia')->getListaFiliiQuery();
//        $query =  $em->createQuery("SELECT f, k, fu, u FROM DFPEtapIBundle:Filia f INNER JOIN f.klient k LEFT JOIN f.filieUzytkownicy fu LEFT JOIN fu.uzytkownik u");
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),11);

        return array(
            'lista_filii'   => $pagination,
        );
    }

    /**
     * @param $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     * @Route("/{id}", name="backend_filia_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        if (!$filia) {
            throw $this->createNotFoundException('Nie znaleziono karty klienta.');
        }
        return array(
            'filia' => $filia,
        );
    }

    /**
     * @param Filia $filia
     * @return \Symfony\Component\Form\Form
     */
    public function createEditFrom(Filia $filia)
    {
        $form = $this->createForm(new FiliaType(), $filia, array(
                'action'    => $this->generateUrl('backend_filia_aktualizacja',array('id'=> $filia->getId())),
                'method'    => 'PUT',
        ));

        $form->add('submit','submit', array('label'=>'Zatwierdź'));

        return $form;
    }

    /**
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/Filie/edit.html.twig")
     * @Route("/{id}/edycja", name="backend_filia_edytuj")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        if(!$filia)
        {
            throw $this->createNotFoundException('Nie można znaleźć wskazanej filii.');
        }

        $editForm = $this->createEditFrom($filia);

        return array(
            'filia'     =>  $filia,
            'formularz' =>  $editForm->createView(),
        );

    }

    /**
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Route("/{id}", name="backend_filia_aktualizacja")
     * @Method("PUT")
     * @Template("@DFPEtapI/Backend/Filie/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        if(!$filia)
        {
            throw $this->createNotFoundException('Nie można znaleźć wskazanej filii.');
        }

        $editForm = $this->createEditFrom($filia);
        $editForm->handleRequest($request);

        if($editForm->isValid())
        {
            $filia->setKlient(1);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_filia_show',array('id'=>$id)));
        }

        return array(
            'filia'     =>  $filia,
            'formularz' =>  $editForm->createView(),
        );
    }
}
