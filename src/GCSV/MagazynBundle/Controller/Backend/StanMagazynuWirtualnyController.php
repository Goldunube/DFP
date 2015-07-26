<?php

namespace GCSV\MagazynBundle\Controller\Backend;

use Doctrine\Common\Collections\ArrayCollection;
use GCSV\MagazynBundle\Entity\StanMagazynuWirtualny;
use GCSV\MagazynBundle\Form\StanMagazynuWirtualnyType;
use GCSV\MagazynBundle\Form\UzytkownikStanMagazynuWirtualnyType;
use GCSV\UserBundle\Entity\Uzytkownik;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StanMagazynuWirtualnyController
 * @package GCSV\MagazynBundle\Controller\Frontend
 *
 * @Route("/stan-magazynu-wirtualny")
 */
class StanMagazynuWirtualnyController extends Controller
{
    /**
     * @Route(
     *      "/lista/{strona}",
     *      requirements={"strona" = "\d+"},
     *      defaults={"strona" = 1},
     *      name="zaplecze_magazyny_uzytkownikow")
     * @Template()
     * @Method("GET")
     */
    public function indexAction($strona)
    {
        $magazyny = $this->getDoctrine()->getManager()->getRepository('GCSVMagazynBundle:Magazyn')->findAll();

        //$paginator = $this->get('knp_paginator');
        //$paginacja = $paginator->paginate($stanyMagazynoweWirtualny,$strona,50);

        return array(
            'uzytkownicyMagazyny' => $magazyny
        );
    }

    /**
     * @Route(
     *      "/{uzytkownik}/new",
     *      requirements={"\d+"},
     *      name="zaplecze_stan_magazynu_wirtualnego_new"
     * )
     * @Template()
     * @Method({"GET","POST"})
     */
    public function newAction(Uzytkownik $uzytkownik, Request $request)
    {
        $stanMagazynuWirtualny = new StanMagazynuWirtualny();
        $stanMagazynuWirtualny->setUzytkownik($uzytkownik);

        $form = $this->createForm(new StanMagazynuWirtualnyType(), $stanMagazynuWirtualny, array(
                'method'    =>  'POST',
                'action'    =>  $this->generateUrl('zaplecze_stan_magazynu_wirtualnego_new', array('uzytkownik'=>$uzytkownik->getId()))
            )
        );

        $form->add('submit','submit',array('label'=>'Dodaj'));

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($stanMagazynuWirtualny);
                $em->flush();
            }
        }

        return array(
            'form'  =>  $form->createView()
        );
    }

    /**
     * Wyświetla stan wirtualnego magazunu użytkownika
     *
     * @Route(
     *      "/{uzytkownik}",
     *      requirements={"\d+"},
     *      name="zaplecze_stan_magazynu_wirtualnego_show"
     * )
     * @Method("GET")
     * @Template()
     */
    public function showAction(Uzytkownik $uzytkownik)
    {
        if(!$uzytkownik)
        {
            throw $this->createNotFoundException('Nie znaleziono użytkownika.');
        }

        $stanMagazynuWirtualny = $this->getDoctrine()->getManager()->getRepository('GCSVMagazynBundle:StanMagazynuWirtualny')->findByUzytkownik($uzytkownik);

        return array(
            'stanMagazynu'  =>  $stanMagazynuWirtualny,
            'uzytkownik'    =>  $uzytkownik
        );
    }

    /**
     * Edycja stanu wirtualnego magazynu użytkownika
     *
     * @Route(
     *      "/{uzytkownik}/edit",
     *      requirements={"\d+"},
     *      name="zaplecze_stan_magazynu_wirtualnego_edit"
     * )
     * @Method({"GET","PUT"})
     * @param \GCSV\UserBundle\Entity\Uzytkownik $uzytkownik
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     * @Template()
     */
    public function editAction(Uzytkownik $uzytkownik, Request $request)
    {
        if(!$uzytkownik)
        {
            throw $this->createNotFoundException('Nie znaleziono użytkownika.');
        }

        $stanMagazynuOryginalny = new ArrayCollection();
        foreach ($uzytkownik->getStanyMagazynoweWirtualne() as $stanMagazynu) {
            $stanMagazynuOryginalny->add($stanMagazynu);
        }

        $form = $this->createForm(new UzytkownikStanMagazynuWirtualnyType(),$uzytkownik,array(
                'action'    =>  $this->generateUrl('zaplecze_stan_magazynu_wirtualnego_edit', array('uzytkownik' => $uzytkownik->getId())),
                'method'    =>  "PUT"
            )
        );
        $form->add('submit','submit',array('label'=>'Aktualizuj'));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            foreach ($stanMagazynuOryginalny as $stanMagazynu) {
                if (false === $uzytkownik->getStanyMagazynoweWirtualne()->contains($stanMagazynu)) {
                    $uzytkownik->getStanyMagazynoweWirtualne()->removeElement($stanMagazynu);
                    $em->persist($stanMagazynu);
                }
            }

            $em->persist($uzytkownik);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success',array('title'=>'Stan magazynu zaktualizowany!','body'=>sprintf("Stan magazynu wirtualnego użytkownika %s został zaktualizowany.",$uzytkownik->getImieNazwisko())));

            return $this->redirect($this->generateUrl('zaplecze_stan_magazynu_wirtualnego_show', array('uzytkownik' =>  $uzytkownik->getId())));
        }

        return array(
            'form'          =>  $form->createView(),
            'uzytkownik'    =>  $uzytkownik
        );
    }
}
