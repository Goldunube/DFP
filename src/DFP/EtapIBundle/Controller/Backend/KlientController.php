<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use DFP\EtapIBundle\Form\FiliaType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $kryteria = null;

        if($this->get('request')->query->get('filterField') && $this->get('request')->query->get('filterValue'))
        {
            $pole = $this->get('request')->query->get('filterField');
            $wartosc = $this->get('request')->query->get('filterValue');
            $kryteria = array('filterField'=>$pole,'filterValue'=>$wartosc);
        }

        $query = $em->getRepository('DFPEtapIBundle:Klient')->getListaKlientowQuery($kryteria);

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
        $em = $this->getDoctrine()->getManager();

        $entity = new Klient();

        $filia = new Filia();
        $filia->setKlient($entity);
        $entity->getFilie()->add($filia);

        $profileDzialalnosci = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->findAll();
        $tablicaProfileDzialalnosci = new ArrayCollection();

        /**
         * @var ProfilDzialalnosci $profil
         */
        foreach($profileDzialalnosci as $profil)
        {
            $tablicaProfileDzialalnosci[$profil->getId()] = $profil->getInfo();
        }

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        /* @var $istniejacyKlient Klient */
        $istniejacyKlient = $em->getRepository('DFPEtapIBundle:Klient')->findOneByNIP($form->getData()->getNip());

        //SPRAWDZENIE CZY KLIENT ISTNIEJE W BAZIE DANYCH
        if($istniejacyKlient)
        {
            if($form->isValid())
            {
                $istniejacyKlient->getFilie()->add($filia);
                $filia->setNazwaFilii('Oddział');
                $filia->setKlient($istniejacyKlient);
                $em->persist($filia);
                $em->flush();

                return $this->redirect($this->generateUrl('backend_klient'));
            }
        }else{
            if ($form->isValid()) {
                $entity->setKanalDystrybucji('DFP');
                $entity->setDataZalozenia(new \DateTime('now'));
                $entity->setAktywny();
                if($filia->getNazwaFilii() == null)
                {
                    $filia->setNazwaFilii('Filia Główna');
                }

                $em->persist($entity);
                $em->persist($filia);
                $em->flush();

                return $this->redirect($this->generateUrl('backend_klient'));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'profile_dzialalnosci'  =>  $tablicaProfileDzialalnosci,
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
        $form->add('filie', 'collection', array(
                    'type'      =>  new FiliaType(),
                    'label'     =>  false,
                    'options'   => array('label' => false),
            )
        );

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
        $em = $this->getDoctrine()->getManager();
        $entity = new Klient();
        $filia = new Filia();
        $entity->getFilie()->add($filia);

        $profileDzialalnosci = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->findAll();
        $tablicaProfileDzialalnosci = new ArrayCollection();

        /**
         * @var ProfilDzialalnosci $profil
         */
        foreach($profileDzialalnosci as $profil)
        {
            $tablicaProfileDzialalnosci[$profil->getId()] = $profil->getInfo();
        }

        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'profile_dzialalnosci'  =>  $tablicaProfileDzialalnosci,

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

        /**
         * @var Klient $entity
         */
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

        /**
         * @var Klient $entity
         */
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

    /**
     * @Route("/ajax/spr_nip", name="backend_sprawdz_czy_jest_juz_nip")
     */
    public function sprawdzCzyIstniejeKlientPoNipAjaxAction()
    {
        $request = $this->container->get('request');
        $nip = $request->query->get('nip');

        $em = $this->getDoctrine()->getManager();

        /**
         * @var Klient $klient
         */
        $klient = $em->getRepository('DFPEtapIBundle:Klient')->findOneByNIP($nip);
        $nip_response =  $klient ? true : false ;
        $response = array("code"=>100, "success"=>true, 'nip'=>$nip_response);

        return new JsonResponse($response,200,array('Content-Type'=>'application/json'));
    }
}
