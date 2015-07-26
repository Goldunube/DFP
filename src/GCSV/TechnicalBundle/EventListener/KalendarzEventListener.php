<?php

namespace GCSV\TechnicalBundle\EventListener;

use GCSV\DniWolneBundle\Entity\TerminUrlopu;
use GCSV\FullCalendarBundle\Event\CalendarEvent;
use GCSV\FullCalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\UczestnikZdarzeniaTechnicznego;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use GCSV\UserBundle\Entity\Uzytkownik;

class KalendarzEventListener
{
    private $entityManager;
    private $csrfProvider;

    public function __construct(EntityManager $entityManager, $tokenGeneratorInterface)
    {
        $this->entityManager    = $entityManager;
        $this->csrfProvider     = $tokenGeneratorInterface;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');
        $users = $request->get('users');

        if($filter != 'only_urlopy')
        {
            $query = $this->entityManager->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')
                ->createQueryBuilder('zdarzenia_techniczne')
                ->select('zdarzenia_techniczne,oddzialFirmy,firma,uczestnicy,terminy,uczestnik,kalendarz,adresy,rodzajZdarzenia')
                ->leftJoin('zdarzenia_techniczne.rodzajZdarzeniaTechnicznego','rodzajZdarzenia')
                ->leftJoin('zdarzenia_techniczne.oddzialFirmy','oddzialFirmy')
                ->leftJoin('oddzialFirmy.firma','firma')
                ->leftJoin('oddzialFirmy.adresy','adresy')
                ->leftJoin('zdarzenia_techniczne.uczestnikZdarzeniaTechnicznego','uczestnicy')
                ->leftJoin('uczestnicy.osoba','uczestnik')
                ->leftJoin('uczestnik.kalendarz','kalendarz')
                ->leftJoin('uczestnicy.terminy','terminy')
                ->where('terminy.rozpoczecieWizyty <= :koniec and terminy.zakonczenieWizyty >= :poczatek')
                ->setParameter('koniec', $endDate->format('Y-m-d H:i:s'))
                ->setParameter('poczatek', $startDate->format('Y-m-d H:i:s'));


            //if($users != 0)
            //{
            //$users = join(',',$users);
            $query->andWhere('uczestnicy.osoba IN (:users)');
            $query->setParameter('users',$users);
            //}

            $zdarzeniaTechniczne = $query->getQuery()->getResult();

            /**
             * @var ZdarzenieTechniczne $zdarzenieTechniczne
             */
            foreach($zdarzeniaTechniczne as $zdarzenieTechniczne)
            {
                /**
                 * @var UczestnikZdarzeniaTechnicznego $uczestnik
                 */
                foreach($zdarzenieTechniczne->getUczestnikZdarzeniaTechnicznego() as $uczestnik)
                {
                    /**
                     * @var Uzytkownik $osoba;
                     */
                    $osoba = $uczestnik->getOsoba();

                    if($osoba->getKalendarz())
                    {
                        $bgKolor = $osoba->getKalendarz()->getTloKolor();
                        $bdKolor = $osoba->getKalendarz()->getRamkaKolor();
                        $fgKolor = $osoba->getKalendarz()->getTekstKolor();
                    }else{
                        $bgKolor = '';
                        $bdKolor = '';
                        $fgKolor = '';
                    }
                    /**
                     * @var TerminZdarzeniaTechnicznego $termin
                     */
                    foreach ($uczestnik->getTerminy() as $termin)
                    {
                        if($zdarzenieTechniczne->getOddzialFirmy())
                        {
                            $title = $zdarzenieTechniczne->getOddzialFirmy()->getFirma()->getNazwaSkrocona();
                            $klientNazwa = $title;
                            $kodPocztowy = substr($zdarzenieTechniczne->getOddzialFirmy()->getAdresy()->first()->getKodPocztowy(),0,2).'-'.substr($zdarzenieTechniczne->getOddzialFirmy()->getAdresy()->first()->getKodPocztowy(),2);
                            $miasto = $zdarzenieTechniczne->getOddzialFirmy()->getAdresy()->first()->getMiasto();
                            $ulica = $zdarzenieTechniczne->getOddzialFirmy()->getAdresy()->first()->getUlica();
                            $lokalizacja = sprintf("ul. %s, %s %s",$ulica, $kodPocztowy, $miasto);
                        }else{
                            $title = $zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getNazwa();
                            $klientNazwa = "-";
                            $lokalizacja = 'mapa';
                        }

                        switch ($zdarzenieTechniczne->getStatus())
                        {
                            case -2:
                                $class = 'st-anulowane';
                                break;
                            case -1:
                                $class = 'st-odrzucone';
                                break;
                            case 0:
                                $class = 'st-nadeslane';
                                break;
                            case 1:
                                $class = 'st-zarezerwowane';
                                break;
                            case 2:
                                $class = 'st-zaakceptowane';
                                break;
                            default:
                                $class = '';
                        }

                        $eventEntity = new EventEntity($title, $termin->getRozpoczecieWizyty(), $termin->getZakonczenieWizyty());

                        $eventEntity->setId($zdarzenieTechniczne->getId());
                        $eventEntity->setTerminId($termin->getId());
                        $eventEntity->setStatus($zdarzenieTechniczne->getStatus());
                        $eventEntity->setPriorytet($zdarzenieTechniczne->getPriorytet());
                        $eventEntity->setKlient($klientNazwa);
                        $eventEntity->setLokalizacja($lokalizacja);
                        $eventEntity->setTechnik($osoba->getImieNazwisko());
                        $eventEntity->setZlecajacy($zdarzenieTechniczne->getOsobaZlecajaca()->getImie().' '.$zdarzenieTechniczne->getOsobaZlecajaca()->getNazwisko());
                        $eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
                        $eventEntity->setBgColor($bgKolor); //set the background color of the event's label
                        $eventEntity->setFgColor($fgKolor); //set the foreground color of the event's label
                        $eventEntity->setBdColor($bdKolor); //set the foreground color of the event's label
                        $eventEntity->setRodzaj($zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getNazwa());
                        $eventEntity->setCssClass('qtip-render '.$class); // a custom class you may want to apply to event labels
                        $eventEntity->addField('typZdarzenia','zdarzenie-dt');
                        $calendarEvent->addEvent($eventEntity);
                    }
                }
            }
        }


        /*  URLOPY I ZWOLNIENIA     */
        $query = $this->entityManager->getRepository('GCSVDniWolneBundle:TerminUrlopu')->createQueryBuilder('tuz')
            ->select('tuz')
            ->where('tuz.start <= :koniec and tuz.koniec >= :poczatek')
            ->setParameter('koniec', $endDate->format('Y-m-d'))
            ->setParameter('poczatek', $startDate->format('Y-m-d'))
            ->andwhere('tuz.osoba IN (:users)')
            ->setParameter('users',$users);

        $urlopyZwolnienia = $query->getQuery()->getResult();

        /**
         * @var TerminUrlopu $terminUrlopu
         */
        foreach($urlopyZwolnienia as $terminUrlopu)
        {
            $start = $terminUrlopu->getStart();
            $koniec = $terminUrlopu->getKoniec();
            $koniec->add(new \DateInterval('P1D'));
            $osoba = $terminUrlopu->getOsoba();
            $typ = $terminUrlopu->getTyp();
            if($osoba->getKalendarz())
            {
                $bgKolor = $osoba->getKalendarz()->getTloKolor();
                $bdKolor = $osoba->getKalendarz()->getRamkaKolor();
                $fgKolor = $osoba->getKalendarz()->getTekstKolor();
            }else{
                $bgKolor = '';
                $bdKolor = '';
                $fgKolor = '';
            }

            $title = $typ == 1 ? "Urlop" : 'Zwolnienie';
            $eventEntity = new EventEntity($title, $start, $koniec);
            $eventEntity->setId('urlop-'.$terminUrlopu->getId());
            $eventEntity->setTerminId($terminUrlopu->getId());
            $eventEntity->setTechnik($osoba->getImieNazwisko());
            $eventEntity->setAllDay(true);
            $eventEntity->setCssClass('fc-urlop');
            $eventEntity->setBgColor($bgKolor); //set the background color of the event's label
            $eventEntity->setFgColor($fgKolor); //set the foreground color of the event's label
            $eventEntity->setBdColor($bdKolor); //set the foreground color of the event's label
            $eventEntity->addField('typZdarzenia','urlop');
            $eventEntity->addField('csrfToken',$this->csrfProvider->generateCsrfToken('delUrlop%d',$terminUrlopu->getId()));
            $calendarEvent->addEvent($eventEntity);
        }
    }
} 