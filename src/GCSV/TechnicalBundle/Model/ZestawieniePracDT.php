<?php

namespace GCSV\TechnicalBundle\Model;


use Doctrine\Common\Collections\ArrayCollection;
use GCSV\DniWolneBundle\Entity\TerminUrlopu;
use GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego;
use GCSV\UserBundle\Entity\Uzytkownik;

class ZestawieniePracDT
{
    protected $uzytkownik;
    protected $zdarzenia;
    protected $terminyUrlopow;
    protected $dataOd;
    protected $dataDo;
    protected $wizytyLokalne = 0;
    protected $wizytyWyjazdowe = 0;
    protected $szkoleniaWewnetrzne = 0;
    protected $praceBiurowe = 0;
    protected $urlopy = 0;
    protected $zwolnienia = 0;
    protected $raportyTechniczne = 0;
    protected $notatkiWewnetrzne = 0;
    protected $raportyZuzycia = 0;
    protected $receptury = 0;


    public function __construct(Uzytkownik $uzytkownik,\DateTime $dataOd,\DateTime $dataDo)
    {
        $this->uzytkownik = $uzytkownik;
        $this->dataOd = $dataOd;
        $this->dataDo = $dataDo;
        $this->zdarzenia = new ArrayCollection();
        $this->terminyUrlopow = new ArrayCollection();
    }

    public function setZdarzenia($zdarzenia)
    {
        $this->zdarzenia = $zdarzenia;
    }

    public function addZdarzenia(TerminZdarzeniaTechnicznego $zdarzenie)
    {
        if(!$this->zdarzenia->contains($zdarzenie))
        {
            $this->zdarzenia->add($zdarzenie);
        };

        return $this;
    }

    public function removeZdarzenia(TerminZdarzeniaTechnicznego $zdarzenie)
    {
        $this->zdarzenia->remove($zdarzenie);
    }

    public function getZdarzenia()
    {
        return $this->zdarzenia;
    }

    public function setTerminyUrlopow($terminyUrlopow)
    {
        $this->terminyUrlopow = $terminyUrlopow;
    }

    public function addTerminyUrlopow(TerminUrlopu $terminUrlopu)
    {
        if(!$this->terminyUrlopow->contains($terminUrlopu))
            $this->terminyUrlopow->add($terminUrlopu);
    }

    public function removeTerminyUrlopow(TerminUrlopu $terminUrlopu)
    {
        $this->terminyUrlopow->remove($terminUrlopu);
    }

    public function getTerminyUrlopow()
    {
        return $this->terminyUrlopow;
    }

    /**
     * @param mixed $dataDo
     */
    public function setDataDo($dataDo)
    {
        $this->dataDo = $dataDo;
    }

    /**
     * @return mixed
     */
    public function getDataDo()
    {
        return $this->dataDo;
    }

    /**
     * @param mixed $dataOd
     */
    public function setDataOd($dataOd)
    {
        $this->dataOd = $dataOd;
    }

    /**
     * @return mixed
     */
    public function getDataOd()
    {
        return $this->dataOd;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $notatkiWewnetrzne
     */
    public function setNotatkiWewnetrzne($notatkiWewnetrzne)
    {
        $this->notatkiWewnetrzne = $notatkiWewnetrzne;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNotatkiWewnetrzne()
    {
        return $this->notatkiWewnetrzne;
    }

    /**
     * @param mixed $uzytkownik
     */
    public function setUzytkownik($uzytkownik)
    {
        $this->uzytkownik = $uzytkownik;
    }

    /**
     * @return mixed
     */
    public function getUzytkownik()
    {
        return $this->uzytkownik;
    }

    /**
     * @param int $praceBiurowe
     */
    public function setPraceBiurowe($praceBiurowe)
    {
        $this->praceBiurowe = $praceBiurowe;
    }

    /**
     * @return int
     */
    public function getPraceBiurowe()
    {
        return $this->praceBiurowe;
    }

    /**
     * @param int $szkoleniaWewnetrzne
     */
    public function setSzkoleniaWewnetrzne($szkoleniaWewnetrzne)
    {
        $this->szkoleniaWewnetrzne = $szkoleniaWewnetrzne;
    }

    /**
     * @return int
     */
    public function getSzkoleniaWewnetrzne()
    {
        return $this->szkoleniaWewnetrzne;
    }

    /**
     * @param int $wizytyLokalne
     */
    public function setWizytyLokalne($wizytyLokalne)
    {
        $this->wizytyLokalne = $wizytyLokalne;
    }

    /**
     * @return int
     */
    public function getWizytyLokalne()
    {
        return $this->wizytyLokalne;
    }

    /**
     * @param int $wizytyWyjazdowe
     */
    public function setWizytyWyjazdowe($wizytyWyjazdowe)
    {
        $this->wizytyWyjazdowe = $wizytyWyjazdowe;
    }

    /**
     * @return int
     */
    public function getWizytyWyjazdowe()
    {
        return $this->wizytyWyjazdowe;
    }

    /**
     * @param int $urlopy
     */
    public function setUrlopy($urlopy)
    {
        $this->urlopy = $urlopy;
    }

    /**
     * @return int
     */
    public function getUrlopy()
    {
        return $this->urlopy;
    }

    /**
     * @param int $zwolnienia
     */
    public function setZwolnienia($zwolnienia)
    {
        $this->zwolnienia = $zwolnienia;
    }

    /**
     * @return int
     */
    public function getZwolnienia()
    {
        return $this->zwolnienia;
    }

    /**
     * @param int $raportyTechniczne
     */
    public function setRaportyTechniczne($raportyTechniczne)
    {
        $this->raportyTechniczne = $raportyTechniczne;
    }

    /**
     * @return int
     */
    public function getRaportyTechniczne()
    {
        return $this->raportyTechniczne;
    }

    /**
     * @param int $raportyZuzycia
     */
    public function setRaportyZuzycia($raportyZuzycia)
    {
        $this->raportyZuzycia = $raportyZuzycia;
    }

    /**
     * @return int
     */
    public function getRaportyZuzycia()
    {
        return $this->raportyZuzycia;
    }

    /**
     * @param int $receptury
     */
    public function setReceptury($receptury)
    {
        $this->receptury = $receptury;
    }

    /**
     * @return int
     */
    public function getReceptury()
    {
        return $this->receptury;
    }



    public function generujPodsumowanie()
    {
        /**
         * @var TerminZdarzeniaTechnicznego $termin
         */
        foreach ($this->zdarzenia as $termin)
        {
            $zdarzenieTechniczne = $termin->getUczestnikZdarzeniaTechnicznego()->getZdarzenieTechniczne();
            $rodzajZdarzenia = $zdarzenieTechniczne->getRodzajZdarzeniaTechnicznego()->getNazwa();
            $dystans = $termin->getUczestnikZdarzeniaTechnicznego()->getDystans() / 1000;
            $zasieg = $this->uzytkownik->getProfil()->getZasieg();
            $iloscDni = $termin->getIloscDni($this->dataOd,$this->dataDo);

            if($zdarzenieTechniczne->getStatus() == 2)
            {
                switch ($rodzajZdarzenia) {
                    case "Prace organizacyjne DT":
                        $this->praceBiurowe += $iloscDni;
                        break;
                    case "Szkolenie wewnętrzne":
                        $this->szkoleniaWewnetrzne += $iloscDni;
                        break;
                    default:
                        if($dystans <= $zasieg)
                        {
                            $this->wizytyLokalne += $iloscDni;
                        }else{
                            $this->wizytyWyjazdowe += $iloscDni;
                        }
                }
            }

            $this->raportyTechniczne += $zdarzenieTechniczne->getRaportyTechniczne()->count();
            $this->notatkiWewnetrzne += $zdarzenieTechniczne->getNotatki()->count();
            $this->raportyZuzycia += $zdarzenieTechniczne->getRaportyZuzyc()->count();
            $this->receptury += $zdarzenieTechniczne->getReceptury()->count();
        }

        /**
         * @var TerminUrlopu $terminUrlopu
         */
        foreach ($this->terminyUrlopow as $terminUrlopu) {
            $typ = $terminUrlopu->getTyp();
            $iloscDni = $terminUrlopu->getIloscDni($this->dataOd,$this->dataDo);

            switch ($typ) {
                case TerminUrlopu::URLOP :
                    $this->urlopy += $iloscDni;
                    break;
                case  TerminUrlopu::ZWOLNIENIE :
                    $this->zwolnienia += $iloscDni;
                    break;
            }
        }


    }
}