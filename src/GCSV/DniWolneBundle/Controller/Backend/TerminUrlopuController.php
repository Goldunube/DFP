<?php

namespace GCSV\DniWolneBundle\Controller\Backend;

use Doctrine\Common\Collections\ArrayCollection;
use GCSV\UserBundle\Entity\Uzytkownik;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use GCSV\DniWolneBundle\Entity\TerminUrlopu;
use GCSV\DniWolneBundle\Form\TerminUrlopuType;

/**
 * TerminUrlopu controller.
 *
 * @Route("zaplecze/urlopy")
 */
class TerminUrlopuController extends Controller
{

    /**
     * Lists all TerminUrlopu entities.
     *
     * @Route("/", name="zaplecze_urlopy")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GCSVDniWolneBundle:TerminUrlopu')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("/kalendarz", name="zaplecze_urlopy_kalendarz")
     * @Method("GET")
     * @Template()
     */
    public function showKalendarzAction()
    {
        $technicy = $this->getDoctrine()->getManager()->getRepository('GCSVUserBundle:Uzytkownik')->findAllUnlockTechnicy();
        $technicyWschod = new ArrayCollection();
        $technicyPolnoc = new ArrayCollection();
        $technicyPoludnie = new ArrayCollection();

        $entity = new TerminUrlopu();
        $form   = $this->createCreateForm($entity);

        /**
         * @var Uzytkownik $technik
         */
        foreach ($technicy as $technik)
        {
            switch ($technik->getStrefa()->getNazwa())
            {
                case 'Strefa Wschód':
                    $technicyWschod->add($technik);
                    break;
                case 'Strefa Północ':
                    $technicyPolnoc->add($technik);
                    break;
                case 'Strefa Południe':
                    $technicyPoludnie->add($technik);
                    break;
            }
        }

        if($this->get('security.context')->isGranted('ROLE_KOORDYNATOR_DT'))
        {
            $csrfProvider = $this->get('form.csrf_provider');
        }

        return array(
            'technicy'          =>  $technicy,
            'technicyWschod'    =>  $technicyWschod,
            'technicyPolnoc'    =>  $technicyPolnoc,
            'technicyPoludnie'  =>  $technicyPoludnie,
            'csrfProvider'      =>  isset($csrfProvider) ? $csrfProvider : null,
            'tokenName'         =>  'delUrlop%d',
            'form'              =>  $form->createView()
        );
    }

    /**
     * Creates a new TerminUrlopu entity.
     *
     * @Route(
     *      "/",
     *      name="termin_urlopu_create",
     *      options={"expose"=true}
     * )
     * @Method("POST")
     * @Security("has_role('ROLE_KOORDYNATOR_DT')")
     */
    public function createAction(Request $request)
    {
        $entity = new TerminUrlopu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $jsonResponse = new JsonResponse();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $jsonResponse->setData(array(
                    'status'    =>  'ok',
                    'message'   =>  'Popranwnie wprowadzono nowy termin urlopu.'
                )
            );
        }else{
            $jsonResponse->setData(array(
                    'status'    =>  'bad',
                    'message'   =>  'Wystąpił błąd podczas próby dodania nowego terminu urlopu.'
                )
            );
        }

        return $jsonResponse;
    }

    /**
     * Creates a form to create a TerminUrlopu entity.
     *
     * @param TerminUrlopu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TerminUrlopu $entity)
    {
        $form = $this->createForm(new TerminUrlopuType(), $entity, array(
            'action' => $this->generateUrl('termin_urlopu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Dodaj'));

        return $form;
    }

    /**
     * Displays a form to create a new TerminUrlopu entity.
     *
     * @Route("/nowy", name="termin_urlopu_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TerminUrlopu();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TerminUrlopu entity.
     *
     * @Route("/{id}", name="termin_urlopu_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVDniWolneBundle:TerminUrlopu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TerminUrlopu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TerminUrlopu entity.
     *
     * @Route("/{id}/edytuj", name="termin_urlopu_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVDniWolneBundle:TerminUrlopu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TerminUrlopu entity.');
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
    * Creates a form to edit a TerminUrlopu entity.
    *
    * @param TerminUrlopu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TerminUrlopu $entity)
    {
        $form = $this->createForm(new TerminUrlopuType(), $entity, array(
            'action' => $this->generateUrl('termin_urlopu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing TerminUrlopu entity.
     *
     * @Route(
     *      "/{id}/{dataOd}_{dataDo}",
     *      name="termin_urlopu_update",
     *      options={"expose"=true}
     * )
     * @Method("PUT")
     * @Security("has_role('ROLE_KOORDYNATOR_DT')")
     */
    public function updateAction($id,$dataOd,$dataDo)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GCSVDniWolneBundle:TerminUrlopu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TerminUrlopu entity.');
        }

        $dataOd = new \DateTime($dataOd);
        $dataDo = new \DateTime($dataDo);

        $entity->setStart($dataOd);
        $entity->setKoniec($dataDo);

        $em->flush();

        $jsonResponse = new JsonResponse();
        $jsonResponse->setData("Poprawnie zmodyfikowano termin urlopu.");

        return $jsonResponse;
    }

    /**
     * Deletes a TerminUrlopu entity.
     *
     * @Route("/{id}", name="termin_urlopu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GCSVDniWolneBundle:TerminUrlopu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TerminUrlopu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('zaplecze_urlopy_kalendarz'));
    }

    /**
     * @Route(
     *      "/delete/{urlopId}/{token}",
     *      name="zaplecze_ajax_delete_urlop",
     *      options={"expose"=true}
     * )
     * @param \GCSV\DniWolneBundle\Entity\TerminUrlopu $urlopId
     * @param $token
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Security("has_role('ROLE_KOORDYNATOR_DT')")
     */
    public function deleteAjaxAction(TerminUrlopu $urlopId, $token)
    {
        if(!$urlopId)
        {
            throw $this->createNotFoundException('Nie znaleziono terminu urlopu.');
        }

        $validToken = sprintf('delUrlop%d',$urlopId->getId());
        if($this->get('form.csrf_provider')->isCsrfTokenValid($validToken, $token))
        {
              throw $this->createAccessDeniedException('Błędny token akcji.');
        };
        $em = $this->getDoctrine()->getManager();
        $em->remove($urlopId);
        $em->flush();

        $jsonResponse = new JsonResponse();
        $jsonResponse->setData(array(
                'status'    =>  'ok',
                'message'   =>  'Termin urlopu został usunięty.'
            )
        );

        return $jsonResponse;
    }

    /**
     * Creates a form to delete a TerminUrlopu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('termin_urlopu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
