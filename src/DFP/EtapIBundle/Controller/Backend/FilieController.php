<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\Filia;
use DFP\EtapIBundle\Entity\FiliaNotatka;
use DFP\EtapIBundle\Entity\FiliaUzytkownik;
use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use DFP\EtapIBundle\Form\FiliaNotatkaType;
use DFP\EtapIBundle\Form\FiliaType;
use DFP\EtapIBundle\Form\FiliaUzytkownikType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction(Request $request)
    {
        $filia = new Filia();
        $klient = $filia->getKlient();

        $form = $this->createFormBuilder($klient)
            ->add('nazwaSkrocona',null,array(
                    'label'     =>  'Nazwa klienta:',
                    'required'  => false,
                )
            )
            ->add('submit','submit',array(
                    'label'   =>  'Szukaj',
                    'attr'    =>  array('class'=>'art-button maly')
                )
            )
            ->getForm();

        $kryteria = Array();

        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('DFPEtapIBundle:Filia')->getListaFiliiQuery($kryteria);
        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        $form->handleRequest($request);
        if($form->isValid())
        {
            $kryteria = $form->getData();
            $this->get('request')->query->set('strona',1);

            $em = $this->getDoctrine()->getManager();
            $paginator = $this->get('knp_paginator');
            $query = $em->getRepository('DFPEtapIBundle:Filia')->getListaFiliiQuery($kryteria);
            $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);
        }

        return array(
            'lista_filii'   =>  $pagination,
            'szukaj_form'   =>  $form->createView()
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

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        return array(
            'filia' => $filia,
            'notatka_kategorie' => $kategorieNotatek
        );
    }

    /**
     * @param Filia $filia
     * @return \Symfony\Component\Form\Form
     */
    public function createEditForm(Filia $filia)
    {
        $form = $this->createForm(new FiliaType(), $filia, array(
                'action'    => $this->generateUrl('backend_filia_aktualizacja',array('id'=> $filia->getId())),
                'method'    => 'PUT',
        ));

        $form->add('nazwaFilii',null,array(
                'label'         =>  'Nazwa filii:',
                'required'      =>  true,
            )
        );
        $form->add('filieUzytkownicy', 'collection', array(
                'type'          =>  new FiliaUzytkownikType(),
                'label'         =>  'Przypisani użytkownicy:',
                'allow_add'     =>  true,
                'allow_delete'  =>  true,
                'by_reference'  =>  false,
                'required'      =>  false,
        ));
        $form->add('stronaWWW','url',array(
                'label'     =>  'Adres strony WWW:',
                'required'  =>  false,
                'attr'      =>  array(
                    'placeholder'   =>  'Poprawny adres WWW musi zaczynać się od frazy `http://` np. `http://www.csv.pl`',
                )
            )
        );
        $form->add('submit','submit', array('label'=>'Aktualizuj'));

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
            throw $this->createNotFoundException('Nie znaleziono wskazanej filii.');
        }

        $editForm = $this->createEditForm($filia);
        $deleteForm = $this->createDeleteForm($id);
        $previousUrl = $this->getRequest()->headers->get('referer');
        $profileDzialalnosci = $em->getRepository('DFPEtapIBundle:ProfilDzialalnosci')->findAll();
        $tablicaProfileDzialalnosci = new ArrayCollection();

        /**
         * @var ProfilDzialalnosci $profil
         */
        foreach($profileDzialalnosci as $profil)
        {
            $tablicaProfileDzialalnosci[$profil->getId()] = $profil->getInfo();
        }

        return array(
            'filia'         =>  $filia,
            'formularz'     =>  $editForm->createView(),
            'delete_form'   =>  $deleteForm->createView(),
            'powrot_url'    =>  $previousUrl,
            'profile_dzialalnosci'  =>  $tablicaProfileDzialalnosci,
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

        /**
         * @var $filia Filia
         */
        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        if(!$filia)
        {
            throw $this->createNotFoundException('Nie można znaleźć wskazanej filii.');
        }

        $aktualne = new ArrayCollection();
        foreach ($filia->getFilieUzytkownicy() as $filiaUzytkownik)
        {
            $aktualne->add($filiaUzytkownik);
        }
        $filiaUzytkownik = new FiliaUzytkownik();
        $filiaUzytkownik->setPoczatekPrzypisania(new \DateTime('now'));
        $filiaUzytkownik->setAkcept(true);
        $filiaUzytkownik->setPerm(false);
        $filiaUzytkownik->setFilia($filia);
        $filia->getFilieUzytkownicy()->add($filiaUzytkownik);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($filia);
        $editForm->handleRequest($request);

        if($editForm->isValid())
        {
            foreach ($aktualne as $filiaUzytkownik)
            {
                if(false === $filia->getFilieUzytkownicy()->contains($filiaUzytkownik))
                {
                    $filia->removeFilieUzytkownicy($filiaUzytkownik);
                }
            }

            $em->persist($filia);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_filia_show',array('id'=>$id)));
        }

        return array(
            'filia'         =>  $filia,
            'formularz'     =>  $editForm->createView(),
            'delete_form'   =>  $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Filia entity.
     *
     * @Route("/{id}", name="backend_filia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

            if (!$filia) {
                throw $this->createNotFoundException('Brak możliwości usunięcia filii.');
            }

            $em->remove($filia);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_filie'));
    }

    /**
     * Creates a form to delete a Filia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_filia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
            ;
    }

    // TYMCZASOWO !!!!!!!!!!!!!!!

    /**
     * @param $id
     * @return array
     * @Route("/filia/{id}/notatka/", name="backend_filia_notatka_new")
     * @Template()
     * @Method("GET")
     */
    public function nowaNotatkaFiliiAction($id)
    {
        //TODO dodać sprawdzenie, czy osoba zalogowana może dodawać notatki do tej filii.

        $em = $this->getDoctrine()->getManager();
        $notatka = new FiliaNotatka();

        /* @var $filia Filia*/
        $filia  = $em->getRepository('DFPEtapIBundle:Filia')->find($id);

        $form = $this->createForm(new FiliaNotatkaType(), $notatka, array(
                'action'    =>  $this->generateUrl('backend_filia_notatka_stworz' ,array('id'=>$filia->getId())),
                'method'    =>  "POST",
            ));

        $form->add('submit','submit',array('label' => 'Dodaj'));

        $previousUrl = $this->getRequest()->headers->get('referer');

        return array(
            'form'      => $form->createView(),
            'powrot_url'    =>  $previousUrl,
        );

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/filia/{id}/notatka/", name="backend_filia_notatka_stworz")
     * @Method("POST")
     */
    public function stworzNotatkaFiliiAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $filia Filia */
        $filia = $em->getRepository('DFPEtapIBundle:Filia')->find($id);
        $notatka = new FiliaNotatka();

        $form = $this->createForm(new FiliaNotatkaType(), $notatka, array(
                'action'    =>  $this->generateUrl('backend_filia_notatka_stworz' ,array('id'=>$filia->getId())),
                'method'    =>  "POST",
            ));
        $form->add('submit','submit',array('label' => 'Dodaj'));

        $form->handleRequest($request);

        if($form->isValid())
        {
            $notatka->setStatus(true);
            $notatka->setDataSporzadzenia(new \DateTime('now'));
            $notatka->setKoniecEdycji(new \DateTime('+30 minutes'));
            $notatka->setFilia($filia);
            $notatka->setUzytkownik($this->getUser());

            $em->persist($notatka);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_filia_show',array('id'=>$id)));
        }
    }

    /**
     * @param $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/filia/notatka/{id}/usun", name="backend_filia_notatka_usun")
     */
    public function usunNotatkeFiliiAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        /* @var $notatka FiliaNotatka */
        $notatka = $em->getRepository('DFPEtapIBundle:FiliaNotatka')->find($id);

        /* @var $filia Filia */
        $filia = $notatka->getFilia();
        if(!$notatka)
        {
            throw $this->createNotFoundException('Notatka, którą chcesz usunąć, nie istnieje.');
        }

        $em->remove($notatka);
        $em->flush();

/*        $autor = $notatka->getUzytkownik();
        if($this->getUser() == $autor)
        {
            if($notatka->getKoniecEdycji() > new \DateTime('now') )
            {
                $em->remove($notatka);
            }else{
                $notatka->setStatus(false);
            }
            $em->flush();
        }*/

        return $this->redirect($this->generateUrl('backend_filia_show', array('id'=>$filia->getId())));
    }
}
