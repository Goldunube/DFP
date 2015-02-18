<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Entity\FiliaUzytkownik;
use DFP\EtapIBundle\Form\FiliaUzytkownikType;
use DFP\EtapIBundle\Form\Filtry\ListaPrzypisanychFiltrType;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     * @Template()
     * @Route("/", name="backend_przypisanie_lista")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')->create(new ListaPrzypisanychFiltrType());
        $paginator = $this->get('knp_paginator');

        if($this->get('request')->query->has($form->getName()))
        {
            $form->submit($this->get('request')->query->get($form->getName()));

            $filterBuilder = $this->getDoctrine()->getManager()->getRepository('DFPEtapIBundle:FiliaUzytkownik')->createQueryBuilder('fu')
                ->select('u,fu,fi,kli')
                ->leftjoin('fu.uzytkownik','u')
                ->leftjoin('fu.filia','fi')
                ->leftjoin('fi.klient','kli');
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

            $result = $filterBuilder->getQuery()->getResult();

            $searchQuery = $request->query->get('lista_przypisanych_filter');
            $tempFilieUzytkownika = new ArrayCollection();

            if(isset($searchQuery['dostep']))
            {
                if($searchQuery['dostep'] == 0 and ($searchQuery['dostep']) != null)
                {
                    foreach($result as $filiaUzytkownika)
                    {
                        $filiaUzytkownika->checkIfBlock();
                        if(!$filiaUzytkownika->getRezerwacja() and $filiaUzytkownika->getBlokadaObrot() and $filiaUzytkownika->getBlokadaNotatka())
                        {
                            $tempFilieUzytkownika->add($filiaUzytkownika);
                        }
                    }
                }elseif($searchQuery['dostep'] == 1){
                    foreach($result as $filiaUzytkownika)
                    {
                        $filiaUzytkownika->checkIfBlock();
                        if($filiaUzytkownika->getRezerwacja() or !$filiaUzytkownika->getBlokadaObrot() or !$filiaUzytkownika->getBlokadaNotatka())
                        {
                            $tempFilieUzytkownika->add($filiaUzytkownika);
                        }
                    }
                }
                $filieUzytkownicy = $paginator->paginate($tempFilieUzytkownika, $this->get('request')->query->get('strona',1),25);
            }else{
                $filieUzytkownicy = $paginator->paginate($filterBuilder, $this->get('request')->query->get('strona',1),25);
            }
        }else{
            $filterBuilder = $em->getRepository('DFPEtapIBundle:FiliaUzytkownik')->createQueryBuilder('fu')
                ->select('u,fu,fi,kli')
                ->leftjoin('fu.uzytkownik','u')
                ->leftjoin('fu.filia','fi')
                ->leftjoin('fi.klient','kli');

            $query = $filterBuilder->getQuery();
            $filieUzytkownicy = $paginator->paginate($query, $this->get('request')->query->get('strona',1),25);

        }

        return array(
            'filie_uzytkownicy'     =>  $filieUzytkownicy,
            'form_filter'           =>  $form->createView()
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
        $filia = $filiaUzytkownik->getFilia();

        $session = $this->get('session');

        $updateForm = $this->createEditForm($filiaUzytkownik);
        $updateForm->handleRequest($request);

        if($updateForm->isValid())
        {
            $em->persist($filiaUzytkownik);
            $em->flush();

            $referers = $session->get('referers');

            if($referers['lista_przypisanych'])
            {
                return $this->redirect($referers['lista_przypisanych']);
            }
            return $this->redirect($this->generateUrl('backend_przypisanie_lista'));
        }

        $previousUrl = $this->get('request')->headers->get('referer');

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        return array(
            'filia'             =>  $filia,
            'przypisanie'       =>  $filiaUzytkownik,
            'formularz'         =>  $updateForm->createView(),
            'powrot_url'        =>  $previousUrl,
            'notatka_kategorie' =>  $kategorieNotatek
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

        $form->add('submit','submit', array(
                'label' =>  'Aktualizuj',
                'attr'  =>  array('class'=>'btn-zapisz')
            )
        );

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
        $filia = $filiaUzytkownik->getFilia();

        $previousUrl = $this->get('request')->headers->get('referer');

        $session = $this->get('session');
        $session->set('referers',array('lista_przypisanych' => $previousUrl));

        $editForm = $this->createEditForm($filiaUzytkownik);

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        return array(
            'filia'             =>  $filia,
            'przypisanie'       =>  $filiaUzytkownik,
            'formularz'         =>  $editForm->createView(),
            'powrot_url'        =>  $previousUrl,
            'notatka_kategorie' =>  $kategorieNotatek
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
     * @param $filiaId
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/{filiaId}", name="backend_przypisane_utworz")
     * @Template("@DFPEtapI/Backend/Przypisane/new.html.twig")
     * @Method("POST")
     */
    public function createPrzypisanieAction(Request $request, $filiaId)
    {
        $em = $this->getDoctrine()->getManager();
        $przypisanie = new FiliaUzytkownik();
        $przypisanie->setAkcept(true);
        $przypisanie->setPerm(false);

        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($filiaId);

        if(!$filia)
        {
            throw $this->createNotFoundException('Filia, do której chcesz przypisać użytkownika, nie istnieje');
        }

        $session = $this->get('session');

        $przypisanie->setFilia($filia);

        $form = $this->createForm(new FiliaUzytkownikType(), $przypisanie, array(
                'action'        =>  $this->generateUrl('backend_przypisane_utworz', array('filiaId'=>$filiaId )),
                'method'        =>  'POST',
            ));
        $form->add('submit','submit', array(
                'label'=>"Zapisz",
                'attr'  =>  array('class'=>'btn-zapisz')
            )
        );

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em->persist($przypisanie);
            $em->flush();

            $referers = $session->get('referers');

            if($referers['lista_przypisanych'])
            {
                return $this->redirect($referers['lista_przypisanych']);
            }
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

        $previousUrl = $this->get('request')->headers->get('referer');

        $session = $this->get('session');
        $session->set('referers',array('lista_przypisanych' => $previousUrl));

        $filiaUzytkownik = new FiliaUzytkownik();
        $filiaUzytkownik->setPoczatekPrzypisania(new \DateTime());
        $filiaUzytkownik->setKoniecPrzypisania(new \DateTime());
        $filiaUzytkownik->setFilia($filia);
        $form = $this->createForm(new FiliaUzytkownikType(), $filiaUzytkownik, array(
                'action'        =>  $this->generateUrl('backend_przypisane_utworz', array('filiaId'=>$filiaId )),
                'method'        =>  'POST',
            ));
        $form->add('submit','submit', array(
                'label'=>"Zapisz",
                'attr'  =>  array('class'=>'btn-zapisz')
            )
        );

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        return array(
            'filia'                 =>  $filia,
            'filia_uzytkownik'      =>  $filiaUzytkownik,
            'formularz'             =>  $form->createView(),
            'powrot_url'            =>  $previousUrl,
            'notatka_kategorie'     =>  $kategorieNotatek
        );
    }
}
