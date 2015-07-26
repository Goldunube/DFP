<?php

namespace GCSV\RaportBundle\Controller\Frontend;

use GCSV\MagazynBundle\Entity\StanMagazynuWirtualny;
use GCSV\RaportBundle\Entity\RaportZuzyciaProdukt;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GCSV\RaportBundle\Entity\RaportZuzycia;
use GCSV\RaportBundle\Form\RaportZuzyciaType;

/**
 * RaportZuzycia controller.
 *
 * @Route("/raporty-zuzycia")
 */
class RaportZuzyciaController extends Controller
{

    /**
     * Lists all RaportZuzycia entities.
     *
     * @Route("/", name="raporty_zuzycia")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $raportyZuzycia = $em->getRepository('GCSVRaportBundle:RaportZuzycia')->findAll();

        return array(
            'entities' => $raportyZuzycia,
        );
    }

    /**
     * Creates a new RaportZuzycia entity.
     *
     * @Route("/", name="raport_zuzycia_create")
     * @Method("POST")
     * @Template("GCSVRaportBundle:Frontend/RaportZuzycia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $stanMagazynuWirtualnego = $em->getRepository('GCSVMagazynBundle:StanMagazynuWirtualny')->wyswietlMojStanMagazynowyWirtualnyQuery($user);

        $entity = new RaportZuzycia();
        $entity->setAutor($user);

        /**
         * @var StanMagazynuWirtualny $pozycja
         */
        foreach($stanMagazynuWirtualnego as $pozycja)
        {
            $raportZuzyciaProdukt = new RaportZuzyciaProdukt();
            $raportZuzyciaProdukt->setProdukt($pozycja->getProdukt());
            $entity->addRaportZuzyciaProdukty($raportZuzyciaProdukt);
        }
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('raport_zuzycia_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'stan_magazynu_wirtualnego' =>  $stanMagazynuWirtualnego
        );
    }

    /**
     * Creates a form to create a RaportZuzycia entity.
     *
     * @param RaportZuzycia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RaportZuzycia $entity)
    {
        $form = $this->createForm(new RaportZuzyciaType(), $entity, array(
            'action' => $this->generateUrl('raport_zuzycia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Zapisz raport'));

        return $form;
    }

    /**
     * Displays a form to create a new RaportZuzycia entity.
     *
     * @Route("/new", name="raport_zuzycia_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $stanMagazynuWirtualnego = $em->getRepository('GCSVMagazynBundle:StanMagazynuWirtualny')->wyswietlMojStanMagazynowyWirtualnyQuery($user);

        $entity = new RaportZuzycia();
        $entity->setAutor($user);

        /**
         * @var StanMagazynuWirtualny $pozycja
         */
        foreach($stanMagazynuWirtualnego as $pozycja)
        {
            $raportZuzyciaProdukt = new RaportZuzyciaProdukt();
            $raportZuzyciaProdukt->setProdukt($pozycja->getProdukt());
            $entity->addRaportZuzyciaProdukty($raportZuzyciaProdukt);
        }

        $form   = $this->createCreateForm($entity);

        return array(
            'entity'                    =>  $entity,
            'form'                      =>  $form->createView(),
            'stan_magazynu_wirtualnego' =>  $stanMagazynuWirtualnego
        );
    }

    /**
     * Finds and displays a RaportZuzycia entity.
     *
     * @Route("/{id}", name="raport_zuzycia_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(RaportZuzycia $raportZuzycia)
    {
        if(!$raportZuzycia)
        {
            throw $this->createNotFoundException('Nie odnaleziono raportu zużycia.');
        }

        return array(
            'raportZuzycia' =>  $raportZuzycia,
        );
    }

    /**
     * Usuwa raport zużycia wraz z produktami
     *
     * @Route(
     *      "/{id}/usun/{token}",
     *      name="raport_zuzycia_delete",
     *      requirements={"id" = "\d+"},
     *      condition="request.headers.get('X-Requested-With') == 'XMLHttpRequest'",
     *      options={"expose"=true}
     * )
     * @Method("DELETE")
     */
    public function deleteAction(RaportZuzycia $raportZuzycia, $token)
    {
        if(!$raportZuzycia)
        {
            throw $this->createNotFoundException('Nie odnaleziono raportu zużycia, który chciałbyś usunąć.');
        }
        $id = $raportZuzycia->getId();
        $validToken = sprintf('delRaport%d',$id);
        if(!$this->get('form.csrf_provider')->isCsrfTokenValid($validToken, $token))
        {
            throw $this->createAccessDeniedException('Błędny token akcji.');
        };

        $em = $this->getDoctrine()->getManager();
        $user = $raportZuzycia->getAutor();
        if($user != $this->getUser())
        {
            throw $this->createAccessDeniedException('Nie masz uprawień by usuwać nie swoje raporty zużyć.');
        }
        if($raportZuzycia->getAkceptacja())
        {
            throw $this->createAccessDeniedException('Nie masz uprawnień by usuwać zaakceptowany raport zużycia.');
        }
        $stanMagazynuWirtualnego = $em->getRepository('GCSVMagazynBundle:StanMagazynuWirtualny')->wyswietlMojStanMagazynowyWirtualnyQuery($user);
        $raportZuzyciaProdukty = $raportZuzycia->getRaportZuzyciaProdukty();

        /**
         * @var RaportZuzyciaProdukt $raportZuzyciaProdukt
         */
        foreach($raportZuzyciaProdukty as $raportZuzyciaProdukt)
        {
            foreach($stanMagazynuWirtualnego as $pozycja)
            {
                if($pozycja->getProdukt() == $raportZuzyciaProdukt->getProdukt())
                {
                    $aktuanlaIlosc = $pozycja->getIlosc() + $raportZuzyciaProdukt->getIloscZuzyta() + $raportZuzyciaProdukt->getIloscZostawiona();
                    $pozycja->setIlosc($aktuanlaIlosc);
                    $em->persist($pozycja);
                }
            }
        }

        $em->remove($raportZuzycia);
        $em->flush();

        $jsonResponse = new JsonResponse();
        $jsonResponse->setData(array('code'=>'ok','message'=>'Raport zyżycia został usunięty.'));

        return $jsonResponse;
    }
}
