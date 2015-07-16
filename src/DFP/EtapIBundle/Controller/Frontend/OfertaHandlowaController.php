<?php

namespace DFP\EtapIBundle\Controller\Frontend;

use DFP\EtapIBundle\Entity\Klient;
use DFP\EtapIBundle\Entity\OfertaHandlowa;
use DFP\EtapIBundle\Entity\OfertaProdukt;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * OfertaHandlowa frontend controller.
 *
 * @Route("/ofertyhandlowe")
 */
class OfertaHandlowaController extends Controller
{
    /**
     * Lista wszystkich Ofert Handlowych zalogowanego użytkownika
     *
     * @Route("/", name="frontend_oferty_handlowe_wszystkie")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->getListaMoichOfertHandlowych($this->getUser());

        $pagination = $paginator->paginate($query,$this->get('request')->query->get('strona',1),11);

        $nazwyStatusow = array(
            0   =>  "Oczekująca na technika",
//            1   =>  "Opracowywanie systemu malarskiego",
            1   =>  "Dobór systemu malarskiego",
            2   =>  "Oczekująca na koordynatora",
//            3   =>  "Tworzenie oferty handlowej",
            3   =>  "Generowanie oferty cenowej",
            4   =>  "Zrealizowana",
            5   =>  'Anulowana'
        );

        return array(
            'oferty_handlowe'   =>  $pagination,
            'statusy'           =>  $nazwyStatusow,
        );
    }

    /**
     * Generate Oferta Handlowa Sheet
     *
     * @param $id
     * @Route("/{id}/oferta_handlowa_pdf", name="oferta_handlowa_pdf")
     * @Method("GET")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generatePDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var OfertaHandlowa $entity
         */
        $entity = $em->getRepository('DFPEtapIBundle:OfertaHandlowa')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć oferty handlowej.');
        }

        /**
         * @var Klient $klient
         * @var OfertaProdukt $ofertaProdukt
         */
        $klient = $entity->getFilia()->getKlient();
        $produktyCenyLitry = new ArrayCollection();
        $produktyCenyKilogramy = new ArrayCollection();
        $produktyCenySztuki = new ArrayCollection();
        $opisy_produktow = new ArrayCollection();

        foreach($entity->getOfertyProdukty() as $ofertaProdukt)
        {
            $produkt = $ofertaProdukt->getProdukt();

            if(!$opisy_produktow->contains($produkt))
                $opisy_produktow->add($produkt);

            if($ofertaProdukt->getOpakowanieJednostka() === 'l')
                $produktyCenyLitry->add($ofertaProdukt);

            if($ofertaProdukt->getOpakowanieJednostka() === 'kg')
                $produktyCenyKilogramy->add($ofertaProdukt);

            if($ofertaProdukt->getOpakowanieJednostka() === 'szt')
                $produktyCenySztuki->add($ofertaProdukt);
        }

        $html = $this->renderView('@DFPEtapI/Frontend/OfertaHandlowa/oferta_handlowa.pdf.twig', array(
                'oferta'                    =>  $entity,
                'klient'                    =>  $klient,
                'opisy_produktow'           =>  $opisy_produktow,
                'lista_produktow_litry'     =>  $produktyCenyLitry,
                'lista_produktow_kilogramy' =>  $produktyCenyKilogramy,
                'lista_produktow_sztuki'    =>  $produktyCenySztuki,
            )
        );

        $pdf = $this->get('knp_snappy.pdf');
        $pdf->setOption('encoding','utf-8');
        $pdf->setOption('margin-left','0');
        $pdf->setOption('margin-right','0');
        $pdf->setOption('margin-bottom','0');

        return new Response(
            $pdf->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'filename="'.$klient->getNazwaSkrocona().'_oferta_handlowa('.$id.').pdf"'
            )
        );
    }
}
