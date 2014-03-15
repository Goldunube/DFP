<?php

namespace DFP\EtapIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PrzypisanieController extends Controller
{
    /**
     * @Route("/przypisz/{id}", name="backend_przypisz")
     * @Template()
     * @Method("PUT")
     */
    public function przypiszAction(Request $request, $id)
    {

    }

    public function createEditForm(FiliaUzytkownik $filiaUzytkownik)
    {
        $form = $this->createForm(new FiliaUzytkownikType(), $filiaUzytkownik, array(
                'action'    => $this->generateUrl('backend_przypisz', array('id' => $filiaUzytkownik->getId())),
                'method'    => 'PUT',

        ));

        $form->add('submit','submit', array('label'=>'Zatwierdź'));

        return $form;
    }

    /**
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Template()
     * @Route("/przypisz/{id}", name="backend_przypisanie_edycja")
     * @Method("GET")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getMenager();

        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        if (!$filia) {
            throw $this->createNotFoundException('Nie znaleziono karty klienta.');
        }

        $editForm = $this->createEditForm($filia);

        return array(
            'filia'     =>  $filia,
            'formularz' =>  $editForm->createView(),
        );
    }
}
