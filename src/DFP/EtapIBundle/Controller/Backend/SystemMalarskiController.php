<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\SystemMalarski;
use DFP\EtapIBundle\Form\SystemMalarskiType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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
}
