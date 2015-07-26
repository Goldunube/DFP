<?php

namespace GCSV\TechnicalBundle\Controller\Backend;

use GCSV\DniWolneBundle\Entity\TerminUrlopu;
use GCSV\RaportBundle\Entity\RaportTechniczny;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\UserBundle\Entity\Uzytkownik;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Zestawienia
 * @package GCSV\TechnicalBundle\Controller\Backend
 * @Route("/zestawienia")
 */
class ZestawieniaController extends Controller
{
    /**
     * @Route(
     *      "/prace-dt/{dataOd}_{dataDo}",
     *      name="zaplecze_zestawienia_prac_dt",
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
        $listaTerminowZdarzenTechnicznych = array();
        /**
         * @var Uzytkownik $technik
         */
        foreach($technicy as $technik)
        {
            $zestawienieTbl[$technik->getId()] = array("slug" => $technik->getSlug(), "imienazwisko" => $technik->getImieNazwisko(),'ilosc_prace_biurowe'=>0,'ilosc_wizyt'=>0,'ilosc_dni'=>0,'ilosc_dni_wyjazdowych'=>0,'ilosc_dni_lokalnych'=>0,'ilosc_dni_sw'=>0,'ilosc_dni_urlopow_i_zwolnien'=>0,'ilosc_dni_urlopow'=>0,'ilosc_dni_zwolnien'=>0,'ilosc_raportow'=>0,'ilosc_receptur'=>0);
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
            }elseif($zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getNazwa() == 'Szkolenie wewnętrzne'){
                $zestawienieTbl[$technik->getId()]['ilosc_dni_sw'] += count($dataTemp);
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
            switch($terminUrlopu->getTyp())
            {
                case TerminUrlopu::URLOP :
                    $zestawienieTbl[$uzytkownik->getId()]['ilosc_dni_urlopow'] += count($dataTemp);
                    break;
                case TerminUrlopu::ZWOLNIENIE :
                    $zestawienieTbl[$uzytkownik->getId()]['ilosc_dni_zwolnien'] += count($dataTemp);
                    break;
            }
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
            'zestawienie'           =>  $zestawienieTbl,
            'lista_zdarzen'         =>  $listaTerminowZdarzenTechnicznych
        );
    }
}
