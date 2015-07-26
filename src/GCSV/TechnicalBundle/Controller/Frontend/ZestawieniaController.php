<?php

namespace GCSV\TechnicalBundle\Controller\Frontend;

use GCSV\CustomerBundle\Entity\Firma;
use GCSV\DniWolneBundle\Entity\TerminUrlopu;
use GCSV\RaportBundle\Entity\RaportTechniczny;
use GCSV\TechnicalBundle\Entity\StatusZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Model\ZestawieniePracDT;
use GCSV\UserBundle\Entity\Uzytkownik;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Zestawienia
 * @package GCSV\TechnicalBundle\Controller\Frontend
 * @Route("/zestawienia")
 * @Security("has_role('ROLE_ZESTAWIENIA')")
 */
class ZestawieniaController extends Controller
{
    /**
     * @Route(
     *      "/prace-dt/{dataOd}_{dataDo}",
     *      name="zestawienia_prac_dt",
     *      defaults={
     *          "dataOd"    =   "%pierwszy_dzien_ubieglego_miesiaca%",
     *          "dataDo"    =   "%ostatni_dzien_ubieglego_miesiaca%"
     *      }
     * )
     * @Template()
     * @Method("GET")
     */
    public function showZestawieniePracDTAction(\DateTime $dataOd, \DateTime $dataDo, Request $request)
    {
        $data = $request->query->all();
        if($data)
        {
            $dataOd = new \DateTime($data['dataOd']);
            $dataDo = new \DateTime($data['dataDo']);
        }
        $em = $this->getDoctrine()->getManager();
        $technicy = $em->getRepository('GCSVUserBundle:Uzytkownik')->findAllUnlockTechnicy();
        $terminyZdarzenTechnicznych = $em->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego')->getTerminyZdarzenTechnicznychByZakres($dataOd,$dataDo);
        $urlopy = $em->getRepository('GCSVDniWolneBundle:TerminUrlopu')->getTerminyUrlopowByZakres($dataOd,$dataDo);
        $raporty = $em->getRepository('GCSVRaportBundle:RaportTechniczny')->getRaportyTechniczneByZakres($dataOd,$dataDo);
        $receptury = $em->getRepository('GCSVRecepturaBundle:Receptura')->createQueryBuilder('rec')
            ->select('rec,count(rec),aut,zt,uzt,t')
            ->leftJoin('rec.Autor','aut')
            ->leftJoin('rec.zdarzenieTechniczne','zt')
            ->leftJoin('zt.uczestnikZdarzeniaTechnicznego','uzt')
            ->leftJoin('uzt.terminy','t')
            ->where('t.rozpoczecieWizyty <= :dataDo')
            ->andwhere('t.zakonczenieWizyty >= :dataOd')
            ->setParameters(array(
                    'dataOd'    =>  $dataOd->format('Y-m-d'),
                    'dataDo'    =>  $dataDo->format('Y-m-d')
                )
            )
            ->groupBy('aut.id')
            ->getQuery()->getResult();

        $zestawienieTbl = array();
        /**
         * @var Uzytkownik $technik
         */
        foreach($technicy as $technik)
        {
            $zestawienieTbl[$technik->getId()] = array("imienazwisko" => $technik->getImieNazwisko(),'ilosc_prace_biurowe'=>0,'ilosc_wizyt'=>0,'ilosc_dni'=>0,'ilosc_dni_wyjazdowych'=>0,'ilosc_dni_lokalnych'=>0,'ilosc_dni_urlopow_i_zwolnien'=>0,'ilosc_dni_urlopow'=>0,'ilosc_dni_zwolnien'=>0,'ilosc_raportow'=>0,'ilosc_receptur'=>0);
        }

        /**
         * @var TerminZdarzeniaTechnicznego $termin
         */
        foreach($terminyZdarzenTechnicznych as $termin)
        {
            $dataTemp = array();
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($termin->getRozpoczecieWizyty(),$interval,$termin->getZakonczenieWizyty());
            /**
             * @var Uzytkownik $technik
             */
            $technik = $termin->getUczestnikZdarzeniaTechnicznego()->getOsoba();
            $zdarzenieTechniczne = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne();
            foreach($period as $dzien)
            {
                if($dzien >= $dataOd and $dzien <= $dataDo)
                {
                    array_push($dataTemp,$dzien);
                }
            }
            $zestawienieTbl[$technik->getId()]['ilosc_dni'] += count($dataTemp);
            $zestawienieTbl[$technik->getId()]['ilosc_wizyt'] += 1;

            if($zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getNazwa() == 'Prace organizacyjne DT')
            {
                $zestawienieTbl[$technik->getId()]['ilosc_prace_biurowe'] += count($dataTemp);
            }else{
                if($termin->getUczestnikZdarzeniaTechnicznego()->getDystans() > $technik->getProfil()->getZasieg()*1000)
                {
                    $zestawienieTbl[$technik->getId()]['ilosc_dni_wyjazdowych'] += count($dataTemp);
                }else{
                    $zestawienieTbl[$technik->getId()]['ilosc_dni_lokalnych'] += count($dataTemp);
                }
            }
        }

        /**
         * @var TerminUrlopu $terminUrlopu
         */
        foreach($urlopy as $terminUrlopu)
        {
            $dataTemp = array();
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($terminUrlopu->getStart(),$interval,$terminUrlopu->getKoniec()->modify('+1day'));
            $uzytkownik = $terminUrlopu->getOsoba();

            /**
             * @var \DateTime $dzien
             */
            foreach($period as $dzien)
            {
                if($dzien >= $dataOd and $dzien <= $dataDo)
                {
                    if($dzien->format('w') != 6 and $dzien->format('w') != 0)
                    {
                        array_push($dataTemp,$dzien);
                    }
                }
            }

            $zestawienieTbl[$uzytkownik->getId()]['ilosc_dni_urlopow_i_zwolnien'] += count($dataTemp);
            $zestawienieTbl[$uzytkownik->getId()]['ilosc_dni_urlopow'] += count($dataTemp);
        }

        /**
         * @var RaportTechniczny $raportTechniczny
         */
        foreach($raporty as $raportTechniczny)
        {
            $technik = $raportTechniczny->getAutor();
            $zestawienieTbl[$technik->getId()]['ilosc_raportow'] += 1;
        }

        foreach($receptury as $autor)
        {
            $zestawienieTbl[$autor[0]->getAutor()->getId()]['ilosc_receptur'] = $autor[1];
        }


        return array(
            'data_od'               =>  $dataOd,
            'data_do'               =>  $dataDo,
            'technicy'              =>  $technicy,
            'zdarzenia_techniczne'  =>  $terminyZdarzenTechnicznych,
            'zestawienie'           =>  $zestawienieTbl,
        );
    }

    /**
     * Wyświetla zestawienie wizyt za dany okres po kontrachentach
     *
     * @Route(
     *      "/wizyty-po-klientach/{dataOd}_{dataDo}",
     *      name="zestawienie_wizyt_po_klientach",
     *      defaults={
     *          "dataOd"    =   "%pierwszy_dzien_ubieglego_miesiaca%",
     *          "dataDo"    =   "%ostatni_dzien_ubieglego_miesiaca%"
     *      }
     * )
     * @Template()
     * @Method("GET")
     */
    public function showWizytyPoKlientachAction(\DateTime $dataOd, \DateTime $dataDo, Request $request)
    {
        $data = $request->query->all();
        if($data)
        {
            $dataOd = new \DateTime($data['dataOd']);
            $dataDo = new \DateTime($data['dataDo']);
        }

        $rodzajeZdarzenTechnicznychRepo = $this->getDoctrine()->getRepository('GCSVTechnicalBundle:RodzajZdarzeniaTechnicznego');
        $rodzajeZdarzenTechnicznych = $rodzajeZdarzenTechnicznychRepo->findAll();

        $terminZdarzeniaTechnicznegoRepo = $this->getDoctrine()->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego');
        $terminZdarzeniaTechnicznego = $terminZdarzeniaTechnicznegoRepo->createQueryBuilder('tzt')
            ->select('tzt,utz,zt,rzt,odz,f')
            ->leftJoin('tzt.uczestnikZdarzeniaTechnicznego','utz')
            ->leftJoin('utz.zdarzenieTechniczne','zt')
            ->leftJoin('zt.rodzajZdarzeniaTechnicznego','rzt')
            ->leftJoin('zt.oddzialFirmy','odz')
            ->leftJoin('odz.firma','f')
            ->where('tzt.rozpoczecieWizyty <= :dataDo')
            ->andwhere('tzt.zakonczenieWizyty >= :dataOd')
            ->andwhere('zt.status IN (2,3)')
            ->setParameters(array(
                    'dataOd'    =>  $dataOd->format('Y-m-d'),
                    'dataDo'    =>  $dataDo->format('Y-m-d')
                )
            )
            ->getQuery()->getResult();

        $zestawienie = array();

        /**
         * @var TerminZdarzeniaTechnicznego $termin
         */
        foreach ($terminZdarzeniaTechnicznego as $termin) {
            $dataTemp = array();
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($termin->getRozpoczecieWizyty(),$interval,$termin->getZakonczenieWizyty());

            if($termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getOddzialFirmy())
            {
                /**
                 * @var Firma $firma
                 */
                $firma = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getOddzialFirmy()->getFirma();
                foreach($period as $dzien)
                {
                    if($dzien >= $dataOd and $dzien <= $dataDo)
                    {
                        array_push($dataTemp,$dzien);
                    }
                }
                if(isset($zestawienie[$firma->getId()]))
                {
                    $zestawienie[$firma->getId()]['wizyty'] += count($dataTemp);
                    if(isset($zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()]))
                    {
                        $zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()] += count($dataTemp);
                    }else{
                        $zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()] = 0;
                        $zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()] += count($dataTemp);
                    }
                }else{
                    $zestawienie[$firma->getId()]['wizyty'] = count($dataTemp);
                    $zestawienie[$firma->getId()]['firma'] = $firma->getNazwaSkrocona();
                    $zestawienie[$firma->getId()]['kod_max'] = $firma->getKodMax();
                    if(isset($zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()]))
                    {
                        $zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()] += count($dataTemp);
                    }else{
                        $zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()] = 0;
                        $zestawienie[$firma->getId()]['rodzajeWizyt'][$termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getId()] += count($dataTemp);
                    }
                }
            }
        }
        arsort($zestawienie);

        return array(
            'data_od'               =>  $dataOd,
            'data_do'               =>  $dataDo,
            'lista'                 =>  $zestawienie,
            'rodzaje_zdarzen'       =>  $rodzajeZdarzenTechnicznych
        );
    }

    /**
     * @Route(
     *      "/moje-prace-dt/{rok}/{miesiac}",
     *      name="moje_zestawienie_prac_dt",
     *      requirements={
     *          "rok"       :   "\d+",
     *          "miesiac"   :   "\d+"
     *      },
     *      defaults={
     *          "rok"       =   "%ubiegly_rok%",
     *          "miesiac"   =   "%ubiegly_miesiac%"
     *      }
     * )
     * @Method("GET")
     * @Template()
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showMojeZestawieniePracDTAction($rok,$miesiac)
    {
        $dataOd = new \DateTime();
        $dataOd->setDate($rok,$miesiac,1);
        $dataOd->setTime(0,0);
        $dataDo = clone $dataOd;
        $dataDo->modify('last day of this month');

        $uzytkownik = $this->getUser();
        if(!$uzytkownik)
        {
            throw $this->createNotFoundException('Nie odnaleziono użytkownika, dla którego próbujesz wygenerować zestawienie zdarzeń technicznych.');
        }
        $zestawienie = new ZestawieniePracDT($uzytkownik,$dataOd,$dataDo);

        $terminZdarzeniaTechnicznegoRepo = $this->getDoctrine()->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego');
        $terminyZdarzenTechnicznych = $terminZdarzeniaTechnicznegoRepo->getTerminyZdarzenTechnicznychByOsobaZakres($uzytkownik,$dataOd,$dataDo);

        $terminUrlopuRepo = $this->getDoctrine()->getRepository('GCSVDniWolneBundle:TerminUrlopu');
        $terminyUrlopow = $terminUrlopuRepo->getTerminyUrlopowByOsobaZakres($uzytkownik,$dataOd,$dataDo);

        $zestawienie->setZdarzenia($terminyZdarzenTechnicznych);
        $zestawienie->setTerminyUrlopow($terminyUrlopow);
        $zestawienie->generujPodsumowanie();

        /**
         * @var StatusZdarzeniaTechnicznego $status
         */
        $statusyRepo = $this->getDoctrine()->getRepository('GCSVTechnicalBundle:StatusZdarzeniaTechnicznego');
        $statusy = $statusyRepo->findAll();
        $statusyArray = array();
        $statusyClassArray = array();
        foreach($statusy as $status)
        {
            $statusyArray[$status->getWartosc()] = $status->getNazwa();
            switch($status->getWartosc())
            {
                case -2:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case -1:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case 0:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case 1:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case 2:
                    $statusyClassArray[$status->getWartosc()] = 'success';
                    break;
                case 3:
                    $statusyClassArray[$status->getWartosc()] = 'success';
                    break;
            }
        }

        return array(
            'technik'           =>  $uzytkownik,
            'terminy'           =>  $terminyZdarzenTechnicznych,
            'statusy'           =>  $statusyArray,
            'statusy_klasy'     =>  $statusyClassArray,
            'dataOd'            =>  $dataOd,
            'dataDo'            =>  $dataDo,
            'podsumowanie'      =>  $zestawienie
        );
    }

    /**
     * @Route(
     *      "/moje-prace-dt/redirect",
     *      name="moje_zestawienie_prac_dt_redirect"
     * )
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function showMojeZestawieniePracDTRedirectAction()
    {
        $rok = $this->get('request')->query->get('rok');
        $miesiac = $this->get('request')->query->get('miesiac');

        $url = $this->generateUrl('moje_zestawienie_prac_dt', array('rok' => $rok, 'miesiac' => $miesiac));

        return $this->redirect($url);
    }

    /**
     * @Route(
     *      "/prace-dt/{uzytkownik}/{dataOd}_{dataDo}",
     *      name="zestawienia_prac_dt_technik",
     *      requirements={
     *          "uzytkownik": "[a-zA-Z]+\-[a-zA-Z]+",
     *          "dataOd": "\d{2}\.\d{2}\.\d{4}",
     *          "dataDo": "\d{2}\.\d{2}\.\d{4}"
     *      }
     * )
     * @param \GCSV\UserBundle\Entity\Uzytkownik $uzytkownik
     * @param \DateTime $dataOd
     * @param \DateTime $dataDo
     * @ParamConverter("uzytkownik", options={"mapping" : {"uzytkownik" : "slug" } })
     * @Template("@GCSVTechnical/Frontend/Zestawienia/include/showTerminyZdarzenTechnicznychOsoby.html.twig")
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     */
    public function showTerminyZdarzenTechnicznychOsobyAction(Uzytkownik $uzytkownik,\DateTime $dataOd, \DateTime $dataDo)
    {
        if(!$uzytkownik)
        {
            throw $this->createNotFoundException('Nie odnaleziono użytkownika, dla którego próbujesz wygenerować zestawienie zdarzeń technicznych.');
        }
        $terminZdarzeniaTechnicznegoRepo = $this->getDoctrine()->getRepository('GCSVTechnicalBundle:TerminZdarzeniaTechnicznego');
        $terminyZdarzenTechnicznych = $terminZdarzeniaTechnicznegoRepo->getTerminyZdarzenTechnicznychByOsobaZakres($uzytkownik,$dataOd,$dataDo);

        /**
         * @var StatusZdarzeniaTechnicznego $status
         */
        $statusyRepo = $this->getDoctrine()->getRepository('GCSVTechnicalBundle:StatusZdarzeniaTechnicznego');
        $statusy = $statusyRepo->findAll();
        $statusyArray = array();
        $statusyClassArray = array();
        foreach($statusy as $status)
        {
            $statusyArray[$status->getWartosc()] = $status->getNazwa();
            switch($status->getWartosc())
            {
                case -2:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case -1:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case 0:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case 1:
                    $statusyClassArray[$status->getWartosc()] = 'danger';
                    break;
                case 2:
                    $statusyClassArray[$status->getWartosc()] = 'success';
                    break;
                case 3:
                    $statusyClassArray[$status->getWartosc()] = 'success';
                    break;
            }
        }

        return array(
            'technik'           =>  $uzytkownik,
            'terminy'           =>  $terminyZdarzenTechnicznych,
            'statusy'           =>  $statusyArray,
            'statusy_klasy'     =>  $statusyClassArray,
            'dataOd'            =>  $dataOd,
            'dataDo'            =>  $dataDo
        );
    }
}
