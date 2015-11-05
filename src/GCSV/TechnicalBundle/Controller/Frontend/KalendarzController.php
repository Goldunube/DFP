<?php

namespace GCSV\TechnicalBundle\Controller\Frontend;

use Doctrine\Common\Collections\ArrayCollection;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use DFP\EtapIBundle\Entity\Uzytkownik;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Kalendarz (Frontend)
 * @package GCSV\TechnicalBundle\Controller\Frontend
 * @Route("/kalendarz-dt")
 */
class KalendarzController extends Controller
{
    /**
     * Wyświetla kalendarz Działu Technicznego
     *
     * @Route("/", name="kalendarz_dfp")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $technicy = $this->getDoctrine()->getManager()->getRepository('DFPEtapIBundle:Uzytkownik')->findAllUnlockTechnicy();

        return array(
            'technicy'          =>  $technicy,
        );
    }

    /**
     * Wyświetla kalendarz Działu Technicznego
     *
     * @Route("/moj", name="moj_kalendarz_dt")
     * @Method("GET")
     * @Template()
     */
    public function showMojKalendarzAction()
    {
        $technicy = $this->getDoctrine()->getManager()->getRepository('GCSVUserBundle:Uzytkownik')->findAllUnlockTechnicy(true);

        $technicyWschod = new ArrayCollection();
        $technicyPolnoc = new ArrayCollection();
        $technicyPoludnie = new ArrayCollection();

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

        return array(
            'technicyWschod'  => $technicyWschod,
            'technicyPolnoc'  => $technicyPolnoc,
            'technicyPoludnie'  => $technicyPoludnie,
        );
    }

    /**
     * @Route(
     *      "/{technik}.{_format}",
     *      defaults={"_format" : "ics"},
     *      requirements={"_format" : "ics"},
     *      name="udostepniony_kalendarz_dt"
     * )
     * @Method("GET")
     */
    public function shareAction($technik)
    {

        $em = $this->getDoctrine()->getManager();

        /**
         * @var Uzytkownik $technik
         */
        $technik = $em->getRepository('GCSVUserBundle:Uzytkownik')->findOneBySlug($technik);
        if(!$technik)
        {
            throw $this->createNotFoundException('Nie można odnaleźć użytkownika.');
        }

        $zdarzenia = $em->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')->getListaMoichWizytQuery($technik)->getResult();
        $imieNazwisko = $technik->getImieNazwisko();
        $contentHTML = <<<HTML
BEGIN:VCALENDAR\r
PRODID:-//$imieNazwisko//Kalendarz DT//PL\r
VERSION:2.0\r
CALSCALE:GREGORIAN\r
METHOD:PUBLISH\r
X-WR-CALNAME:$imieNazwisko (GCSV DT)\r
X-WR-TIMEZONE:Europe/Warsaw\r
X-WR-CALDESC:Kalendarz Techniczny Grupy CSV Sp. z o.o\r
HTML;

        /**
         * @var TerminZdarzeniaTechnicznego $termin
         */
        foreach($zdarzenia as $termin)
        {
            $status = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getStatus();
            switch($status)
            {
                case -2:
                    $statusName = 'CANCELLED';
                    break;
                case -1:
                    $statusName = 'CANCELLED';
                    break;
                case 2:
                    $statusName = 'CONFIRMED';
                    break;
                case 3:
                    $statusName = 'CONFIRMED';
                    break;
                default:
                    $statusName = 'TENTATIVE';
            }
            $tid = $termin->getId();
            if($termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getOddzialFirmy())
            {
                $title = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getOddzialFirmy()->getFirma()->getNazwaSkrocona();
                $kodMax = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getOddzialFirmy()->getFirma()->getKodMax();
            }else{
                $title = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getRodzajZdarzeniaTechnicznego()->getNazwa();
                $kodMax = "";
            }
            $start = $termin->getRozpoczecieWizyty()->format('Ymd');
            $koniec = $termin->getZakonczenieWizyty()->format('Ymd');
            $dataModyfikacji = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getDataModyfikacji()->format('Ymd\THis\Z');
            $lat = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getSzerokoscGeo();
            $lng = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getDlugoscGeo();
            $opis = trim($termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne()->getOpis());
            $opis = preg_replace('/\r\n/', '\n',$opis);

            $contentHTML .= <<<HTML
BEGIN:VEVENT\r
DTSTART;VALUE=DATE:$start\r
DTEND;VALUE=DATE:$koniec\r
SUMMARY:$title\r
UID:$tid@csv.pl\r
STATUS:$statusName\r
LAST-MODIFIED:$dataModyfikacji\r
LOCATION:$lat,$lng\r
DESCRIPTION:$opis\r
X-GCSV-KODMAX:$kodMax\r
END:VEVENT\r\n
HTML;
        }

        $contentHTML .= "END:VCALENDAR";

        $filename = 'GCSV-kalendarz-dt-'.$technik->getSlug().'.ics';

        $response = new Response();

        $response->setContent($contentHTML);
        $response->headers->set('Content-Description','Udostępniony Kalendarz DT');
        $response->headers->set('Content-Disposition','attachment; filename='.$filename);
        $response->headers->set('Content-Type','text/calendar');
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }
} 