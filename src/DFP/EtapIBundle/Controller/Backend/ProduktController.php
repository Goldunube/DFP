<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\ProduktUtwardzacz;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DFP\EtapIBundle\Entity\Produkt;
use DFP\EtapIBundle\Form\ProduktType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Produkt controller.
 *
 * @Route("/produkty")
 */
class ProduktController extends Controller
{

    /**
     * Lists all Produkt entities.
     *
     * @Route("/", name="backend_produkty")
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

        $query = $em->getRepository('DFPEtapIBundle:Produkt')->getListaProduktowSearchQuery($kryteria);
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        return array(
            'lista_produktow'   => $pagination,
        );

    }
    /**
     * Creates a new Produkt entity.
     *
     * @Route("/", name="backend_produkty_create")
     * @Method("POST")
     * @Template("DFPEtapIBundle:Backend/Produkt:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Produkt();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_produkty_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Produkt entity.
    *
    * @param Produkt $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Produkt $entity)
    {
        $form = $this->createForm(new ProduktType(), $entity, array(
            'action' => $this->generateUrl('backend_produkty_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new Produkt entity.
     *
     * @Route("/new", name="backend_produkty_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Produkt();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Produkt entity.
     *
     * @Route("/{id}", name="backend_produkty_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć produkty.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Produkt entity.
     *
     * @Route("/{id}/edit", name="backend_produkty_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $entity Produkt
         */
        $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć produkty.');
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
    * Creates a form to edit a Produkt entity.
    *
    * @param Produkt $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Produkt $entity)
    {
        $form = $this->createForm(new ProduktType(), $entity, array(
            'action' => $this->generateUrl('backend_produkty_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
                'label' => 'Aktualizuj',
                'attr'  =>  array('class'=>'btn-zapisz')
            )
        );

        return $form;
    }
    /**
     * Edits an existing Produkt entity.
     *
     * @Route("/{id}", name="backend_produkty_update")
     * @Method("PUT")
     * @Template("DFPEtapIBundle:Backend/Produkt:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $entity Produkt
         */
        $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć produktu.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $session = $this->get('session');

        if($request->isMethod('PUT'))
        {
            if ($editForm->isValid()) {
                /**
                 * Sprowadzenie wartości czasu magaazynowania do ilości miesięcy
                 */
                $jednostkaCzasuMagazynowania = $editForm['czasMagazynowaniaJednostka']->getData();
                $czasMagazynowania = $editForm['czasMagazynowania']->getData();
                $entity->setCzasMagazynowania($czasMagazynowania, $jednostkaCzasuMagazynowania);

                /**
                 * Sprowadzenie wałaściwości mechanicznych do ilości godzin
                 */
                $cechyTechniczneForm = $editForm['cechyTechniczneProduktu'];
                $wlasciwosciMechaniczne = $cechyTechniczneForm['wlasciwosciMechaniczne']->getData();
                $wlasciwosciMechaniczneJednostka = $cechyTechniczneForm['wlasciwosciMechaniczneJednostka']->getData();
                $entity->getCechyTechniczneProduktu()->setWlasciwosciMechaniczne($wlasciwosciMechaniczne, $wlasciwosciMechaniczneJednostka);

                /**
                 * Sprowadzenie wprowadzonych wartości czasu do ilości sekund
                 */
                $suszenieForm = $editForm['suszenie'];
                $pylosuchosc = $suszenieForm['pylosuchoscCzasOtoczenie']->getData();
                $pylosuchoscJednostka = $suszenieForm['pylosuchoscCzasOtoczenieJednostka']->getData();
                $entity->getSuszenie()->setPylosuchoscCzasOtoczenie($pylosuchosc, $pylosuchoscJednostka);

                $dotyk = $suszenieForm['dotykCzasOtoczenie']->getData();
                $dotykJednostka = $suszenieForm['dotykCzasOtoczenieJednostka']->getData();
                $entity->getSuszenie()->setDotykCzasOtoczenie($dotyk, $dotykJednostka);

                $pelneUtwardzenie = $suszenieForm['utwardzenieCzasOtoczenie']->getData();
                $pelneUtwardzenieJednostka = $suszenieForm['utwardzenieCzasOtoczenieJednostka']->getData();
                $entity->getSuszenie()->setUtwardzenieCzasOtoczenie($pelneUtwardzenie, $pelneUtwardzenieJednostka);

                $wstepneKabina = $suszenieForm['wstepneCzasKabina']->getData();
                $wstepneKabinaJednostka = $suszenieForm['wstepneCzasKabinaJednostka']->getData();
                $entity->getSuszenie()->setWstepneCzasKabina($wstepneKabina, $wstepneKabinaJednostka);

                $doceloweKabina = $suszenieForm['doceloweCzasKabina']->getData();
                $doceloweKabinaJednostka = $suszenieForm['doceloweCzasKabinaJednostka']->getData();
                $entity->getSuszenie()->setDoceloweCzasKabina($doceloweKabina, $doceloweKabinaJednostka);

                $em->persist($entity);
                $em->flush();

                $session->getFlashBag()->add('success','Informacje o produkcie zostały zaktualizowane poprawnie.');

                return $this->redirect($this->generateUrl('backend_produkty_edit', array('id' => $id)));
            }else{
                $session->getFlashBag()->add('danger','Uwaga! Formularz zawiera błędy. Wszelkie wprowadzone dane nie zostaną zapmietane dopóki nie poprawisz błędu i ponownie nie klikniesz AKTUALIZUJ.');
            }
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Produkt entity.
     *
     * @Route("/{id}", name="backend_produkty_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można znaleźć produktu.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_produkty'));
    }

    /**
     * Creates a form to delete a Produkt entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_produkty_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                    'label' => 'Usuń',
                    'attr'  =>  array('class'=>'btn-usun')
                )
            )
            ->getForm()
        ;
    }

    /**
     * Generate Product Technical Sheet
     *
     * @param $id
     * @Route("/{id}/karta-techniczna", name="backend_produkt_karta_techniczna_pdf")
     * @Method("GET")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generatePDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DFPEtapIBundle:Produkt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć produkty.');
        }

        $html = $this->renderView('@DFPEtapI/Backend/Produkt/karta_techniczna.html.twig', array(
                'produkt'    => $entity,
            )
        );

        $pdf = $this->get('knp_snappy.pdf');
        $pdf->setOption('encoding','utf-8');
        $pdf->setOption('header-html',$this->generateUrl('karta_techniczna_header',array(),true));
        $pdf->setOption('header-spacing',10);
        $pdf->setOption('footer-spacing',10);
        $pdf->setOption('margin-top',35);
        $pdf->setOption('margin-left',0);
        $pdf->setOption('margin-right',0);
        $pdf->setOption('footer-html',$this->generateUrl('karta_techniczna_footer',array(),true));

        return new Response(
            $pdf->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'filename="karta_techniczna.pdf"'
            )
        );
    }
}
