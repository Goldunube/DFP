<?php

namespace DFP\EtapIBundle\Controller\Backend;

use DFP\EtapIBundle\Entity\OfertaHandlowa;
use DFP\EtapIBundle\Entity\OfertaHandlowaProfilSystem;
use DFP\EtapIBundle\Entity\OfertaSystem;
use DFP\EtapIBundle\Entity\Produkt;
use DFP\EtapIBundle\Entity\ProfilDzialalnosci;
use DFP\EtapIBundle\Entity\ProfilSystem;
use DFP\EtapIBundle\Entity\SystemMalarski;
use DFP\EtapIBundle\Form\OfertaHandlowaProfilSystemType;
use DFP\EtapIBundle\Form\OfertaHandlowaType;
use DFP\EtapIBundle\Form\OfertaSystemType;
use DFP\EtapIBundle\Form\ProfilSystemType;
use DFP\EtapIBundle\Form\SystemMalarskiType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * OfertaHandlowa controller.
 *
 * @Route("/ofertyhandlowe")
 */
class OfertaHandlowaController extends Controller
{

    /**
     * Lista wszystkich Ofert Handlowych
     *
     * @Route("/", name="backend_oferty_handlowe_wszystkie")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/OfertaHandlowa/index.html.twig")
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

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaWszystkichOfertHandlowychSearchQuery($kryteria);

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),21);

        $deleteForms = new ArrayCollection();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        foreach($pagination as $ofertaHandlowa)
        {
            $deleteForms[$ofertaHandlowa->getId()] = $this->createDeleteForm($ofertaHandlowa->getId())->createView();
        }

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Tworzenie oferty handlowej",
            4   =>  "Zrealizowana"
        );

        return array(
            'oferty_handlowe'   =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
            'delete_forms'      =>  $deleteForms,
        );
    }

    /**
     * Deletes a OfertaHandlowa entity.
     *
     * @Route("/{id}", name="backend_oferty_handlowe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);

            if (!$ofertaHandlowa) {
                throw $this->createNotFoundException('Brak możliwości usunięcia oferty handlowej.');
            }

            $em->remove($ofertaHandlowa);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_oferty_handlowe_wszystkie'));
    }

    /**
     * Creates a form to delete a OfertaHandlowa entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_oferty_handlowe_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
            ;
    }

    /**
     * Lista Ofert Handlowych oczekujących na dobór systemu malarskiego
     *
     * @Route("/oczekujace_sm", name="backend_oferty_handlowe_oczekujace_sm")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/OfertaHandlowa/listaOczekujacychSM.html.twig")
     */
    public function listaOczekujacychNaDoborSystemuMalarskiegoAction()
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

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaOczekujacychNaDoborSystemuMalarskiegoSearchQuery($kryteria);

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Opracowywanie oferty handlowej",
            4   =>  "Zrealizowana"
        );

        return array(
            'oczekujace'        =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
    }

    /**
     * Lista Ofert Handlowych oczekujących na wykonanie oferty handlowej
     *
     * @Route("/oczekujace_oh", name="backend_oferty_handlowe_oczekujace_oh")
     * @Method("GET")
     * @Template("@DFPEtapI/Backend/OfertaHandlowa/listaOczekujacychOH.html.twig")
     */
    public function listaOczekujacychNaOpracowanieOfertyHandlowejAction()
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

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaOczekujacychNaOpracowanieOfertyHandlowejSearchQuery($kryteria);

        $pagination = $paginator->paginate($query, $this->get('request')->query->get('strona',1),21);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
            1   =>  "Opracowywanie systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
            3   =>  "Opracowywanie oferty handlowej",
            4   =>  "Zrealizowana"
        );

        return array(
            'oczekujace'        =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
    }

    /**
     * Wyświetla formularz systemu malarskiego oraz dodaje system malarski do oferty handlowej
     *
     * @param $id
     * @param Request $request
     *
     * @Route("/{id}/opracowanie_systemu_malarskiego", name="backend_opracowanie_systemu_malarskiego")
     * @Template()
     * @Method({"GET", "POST"})
     * @return array
     */
    public function opracujSystemMalarskiAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $filia = $ofertaHandlowa->getFilia();
        $profileDzialalnosci = $filia->getProfileDzialalnosci();

        $kategorieNotatek = array(
            1 => 'Wymagania klienta',
            2 => 'Informacje handlowe',
            3 => 'Harmonogram działań',
            4 => 'Notatki z wizyt'
        );

        if($ofertaHandlowa->getStatus() == 1)
        {
            if($ofertaHandlowa->getOfertyProfileSystemy()->isEmpty())
            {
                foreach($profileDzialalnosci as $profilDzialalnosci)
                {
                    $systemMalarski = new SystemMalarski();
                    $profilSystem = new ProfilSystem();
                    $profilSystem->setProfilDzialalnosci($profilDzialalnosci);
                    $profilSystem->setSystemMalarski($systemMalarski);

                    $ofertaProfilSystem = new OfertaHandlowaProfilSystem();
                    $ofertaProfilSystem->setProfilSystem($profilSystem);
                    $ofertaHandlowa->addOfertyProfileSystemy($ofertaProfilSystem);
                }
            }

            $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
                ->add('ofertyProfileSystemy','collection',array(
                        'type'          =>  new OfertaHandlowaProfilSystemType(),
                        'allow_add'     =>  true,
                        'by_reference'  =>  false,
                    )
                )
                ->add('zapisz','submit',array(
                        'label'         =>  'Zapisz',
                        'attr'          =>  array('class'=>'art-button zielony')
                    )
                )
                ->add('submit','submit',array(
                        'label'         =>  'Zatwierdź dobór',
                        'attr'          =>  array('class'=>'art-button zielony')
                    )
                )
                ->getForm();
        }else{
            $ofertaHandlowaForm = $this->createFormBuilder($ofertaHandlowa)
                ->add('otworz','submit',array(
                        'label'         =>  'Otwórz zamówienie',
                        'attr'          =>  array('class'=>'art-button zielony')
                    )
                )
                ->getForm();
        }

        $ofertaHandlowaForm->handleRequest($request);

        if($ofertaHandlowaForm->isValid())
        {

            if($ofertaHandlowaForm->has('otworz') && $ofertaHandlowaForm->get('otworz')->isClicked())
            {
                $ofertaHandlowa->setStatus(1);
                $ofertaHandlowa->setTechnik($this->getUser());
            }else{

                if($ofertaHandlowaForm->has('submit') && $ofertaHandlowaForm->get('submit')->isClicked())
                {
                    //$ofertaHandlowa->setStatus(3);
                    //$ofertaHandlowa->setTechnik($this->getUser());
                }

                $systemyMalarskieCollection = $em->getRepository('DFP\EtapIBundle\Entity\SystemMalarski')->findAll();

                //SPRAWDŹ CZY DODAWANY SYSTEM ZNAJDUJE SIĘ JUŻ W BAZIE DANYCH POPRZEZ WYSZUKANIE PRODUKTÓW

                /**
                * @var OfertaHandlowaProfilSystem $ofertaProfilSystem
                */
                foreach($ofertaHandlowa->getOfertyProfileSystemy() as $ofertaProfilSystem)
                {
//                    $test2 = $ofertaProfilSystem->getProfilSystem()->getSystemMalarski();

                    $test[] = $ofertaProfilSystem->getProfilSystem()->getSystemMalarski()->getId();

                    echo '<hr> ID OPS: '.$ofertaProfilSystem->getId().'<br>';
                    echo 'ID System: '.$ofertaProfilSystem->getProfilSystem()->getSystemMalarski()->getId().'<br>';
                    echo 'Produkty :';
                    foreach($ofertaProfilSystem->getProfilSystem()->getSystemMalarski()->getProdukty() as $produkt)
                    {
                        echo $produkt->getId().'; ';
                    }
                    echo '<br>';

                    /**
                     * @var $system SystemMalarski
                     */
                    foreach($systemyMalarskieCollection as $system)
                    {
                        if($system->getProdukty()->getValues() === $ofertaProfilSystem->getProfilSystem()->getSystemMalarski()->getProdukty()->getValues())
                        {
                            echo 'ID Systemu zawierającego produkty:'.$system->getId().'<br>';
                            $ofertaProfilSystem->getProfilSystem()->setSystemMalarski($system);

                        }else{
                            echo 'nieprawda <br>';
                        }
                    }

                    echo 'NOWY ID System: '.$ofertaProfilSystem->getProfilSystem()->getSystemMalarski()->getId().'<br>';
                    $em->persist($ofertaProfilSystem);

                }

//                $systemyMalarskieCollection = $em->getRepository('DFP\EtapIBundle\Entity\SystemMalarski')->findAll();
//                $profilSystemCollection = $em->getRepository('DFP\EtapIBundle\Entity\ProfilSystem')->findAll();

//                /**
//                 * @var OfertaHandlowaProfilSystem $ofertaProfilSystem
//                 */
//                foreach ($ofertaHandlowa->getOfertyProfileSystemy() as $ofertaProfilSystem) {
//
//                    /**
//                     * @var ProfilSystem $profilSystem
//                     */
//                    $profilSystem = $ofertaProfilSystem->getProfilSystem();
//
//                    /**
//                     * @var SystemMalarski $systemMalarski
//                     */
//                    $systemMalarski = $profilSystem->getSystemMalarski();
//                    $wprowadzany = $systemMalarski->getProdukty()->toArray();
//
//                    /**
//                     * @var SystemMalarski $znalezionySystemMalarski
//                     */
//                    foreach ($systemyMalarskieCollection as $znalezionySystemMalarski)
//                    {
//
//                        $znaleziony = $znalezionySystemMalarski->getProdukty()->toArray();
//
//                        if(array_diff($wprowadzany, $znaleziony) || array_diff($znaleziony, $wprowadzany))
//                        {
//
//                        }else{
//                            $profilSystem->setSystemMalarski($znalezionySystemMalarski);
//                        }
//                    }
//
//                    /**
//                     * @var ProfilSystem $znalezionyProfilSystem
//                     */
//                    foreach($profilSystemCollection as $znalezionyProfilSystem)
//                    {
//                        if($profilSystem->getProfilDzialalnosci() == $znalezionyProfilSystem->getProfilDzialalnosci() && $profilSystem->getSystemMalarski() == $znalezionyProfilSystem->getSystemMalarski())
//                        {
//                            $ofertaProfilSystem->setProfilSystem($znalezionyProfilSystem);
//                        }
//                    }
//                }
            }

            $em->persist($ofertaHandlowa);
            $em->flush();
//
//            return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_sm'));
        }

        $previousUrl = $this->get('request')->headers->get('referer');

        return array(
            'oferta'            =>  $ofertaHandlowa,
            'filia'             =>  $filia,
            'form'              =>  $ofertaHandlowaForm->createView(),
            'powrot_url'        =>  $previousUrl,
            'notatka_kategorie' =>  $kategorieNotatek,
            'test'              =>  $test,
        );
    }

    /**
     * Wyświetla formularz do opracowania oferty cenowej na podstawie wcześniej dobranego systemu malarskiego
     *
     * @param $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Route("/{id}/opracowanie_oferty_cenowej", name="backend_opracowanie_oferty_cenowej")
     * @Template()
     * @Method({"GET", "POST"})
     * @return array
     */
    public function opracujOferteCenowaAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $ofertaHandlowa OfertaHandlowa
         */
        $ofertaHandlowa = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        $filia = $ofertaHandlowa->getFilia();

        $dobraneSystemy = $ofertaHandlowa->getOfertyProfileSystemy();

        $previousUrl = $this->get('request')->headers->get('referer');


        $form = $this->createFormBuilder()
            ->add('submit','submit', array(
                    'label' =>  'Zamknij ofertę',
                    'attr'  =>  array('class' => 'art-button zielony'),
                )
            )
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid())
        {
            $ofertaHandlowa->setStatus(4);
            $ofertaHandlowa->setKoordynatorDFP($this->getUser());
            $em->persist($ofertaHandlowa);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_oferty_handlowe_oczekujace_oh'));
        }

        return array(
            'form'              =>  $form->createView(),
            'oferta'            =>  $ofertaHandlowa,
            'filia'             =>  $filia,
            'powrot_url'        =>  $previousUrl,
            'dobrane_systemy'   =>  $dobraneSystemy,
        );
    }
}
