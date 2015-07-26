<?php
namespace GCSV\FullCalendarBundle\Entity;

/**
 * Klasa przechowująca informacje o zdarzeniach kalendarza
 */

class EventEntity 
{
    /**
     * @var mixed Unikatowy identyfikator zdarzenia (opcionalny).
     */
    protected $id;

    /**
     * @var mixed Unikatowy identyfikator terminu zdarzenia (opcionalny).
     */
    protected $terminId;
    
    /**
     * @var string Etykieta zdarzenia.
     */
    protected $title;
    
    /**
     * @var string Adres URL relatywny do obecnej ścieżki.
     */
    protected $url;
    
    /**
     * @var string Kolor tła etykiety.
     */
    protected $bgColor;
    
    /**
     * @var string Kolor tekstu etykiety.
     */
    protected $fgColor;

    /**
     * @var string Kolor ramki etykiety.
     */
    protected $bdColor;
    
    /**
     * @var string Klasa CSS dla etykiety zdarzenia.
     */
    protected $cssClass;
    
    /**
     * @var \DateTime Data rozpoczęcia zdarzenia.
     */
    protected $startDatetime;
    
    /**
     * @var \DateTime Data zakończenia zdarzenia.
     */
    protected $endDatetime;
    
    /**
     * @var boolean Zdarzenie całodniowe?
     */
    protected $allDay = false;

    /**
     * @var int Status zdarzenia technicznego.
     */
    protected $status = 0;

    /**
     * @var int Priorytet zadania
     */
    protected $priorytet = 0;

    /**
     * @var int Rodzaj zdarzenia technicznego.
     */
    protected $rodzaj;

    /**
     * @var int Klient zdarzenia technicznego.
     */
    protected $klient;

    /**
     * @var string Lokalizacja zdarzenia.
     */
    protected $lokalizacja;

    /**
     * @var string Technik.
     */
    protected $technik;

    /**
     * @var string Zlecający.
     */
    protected $zlecajacy;

    /**
     * @var array Niestandardowe pola.
     */
    protected $otherFields = array();
    
    public function __construct($title, \DateTime $startDatetime, \DateTime $endDatetime = null, $allDay = false)
    {
        $this->title = $title;
        $this->startDatetime = $startDatetime;
        $this->setAllDay($allDay);
        
        if ($endDatetime === null && $this->allDay === false) {
            throw new \InvalidArgumentException("W przypadku wizyt nie całodniowych, należy określić datę końca wizyty.");
        }
        
        $this->endDatetime = $endDatetime;
    }

    /**
     * Convert calendar event details to an array
     * 
     * @return array $event 
     */
    public function toArray()
    {
        $event = array();
        
        if ($this->id !== null) {
            $event['id'] = $this->id;
        }

        if ($this->terminId !== null) {
            $event['termin_id'] = $this->terminId;
        }
        
        $event['title'] = $this->title;
        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:sP");
        
        if ($this->url !== null) {
            $event['url'] = $this->url;
        }
        
        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
        }
        
        if ($this->fgColor !== null) {
            $event['textColor'] = $this->fgColor;
        }

        if ($this->bdColor !== null) {
            $event['borderColor'] = $this->bdColor;
        }
        
        if ($this->cssClass !== null) {
            $event['className'] = $this->cssClass;
        }

        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:sP");
        }

        if ($this->status !== null) {
            $event['status'] = $this->status;
        }

        if ($this->rodzaj !== null) {
            $event['rodzaj'] = $this->rodzaj;
        }

        if ($this->klient !== null) {
            $event['klient'] = $this->klient;
        }

        if ($this->lokalizacja !== null) {
            $event['lokalizacja'] = $this->lokalizacja;
        }

        if ($this->technik !== null) {
            $event['technik'] = $this->technik;
        }

        if ($this->zlecajacy !== null) {
            $event['zlecajacy'] = $this->zlecajacy;
        }

        if ($this->priorytet !== null) {
            $event['priorytet'] = $this->priorytet;
        }
        
        $event['allDay'] = $this->allDay;

        foreach ($this->otherFields as $field => $value) {
            $event[$field] = $value;
        }
        
        return $event;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setTerminId($terminId)
    {
        $this->terminId = $terminId;
    }

    public function getTerminId()
    {
        return $this->terminId;
    }
    
    public function setTitle($title) 
    {
        $this->title = $title;
    }
    
    public function getTitle() 
    {
        return $this->title;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setBgColor($color)
    {
        $this->bgColor = $color;
    }
    
    public function getBgColor()
    {
        return $this->bgColor;
    }
    
    public function setFgColor($color)
    {
        $this->fgColor = $color;
    }
    
    public function getFgColor()
    {
        return $this->fgColor;
    }

    public function setBdColor($color)
    {
        $this->bdColor = $color;
    }

    public function getBdColor()
    {
        return $this->bdColor;
    }
    
    public function setCssClass($class)
    {
        $this->cssClass = $class;
    }
    
    public function getCssClass()
    {
        return $this->cssClass;
    }
    
    public function setStartDatetime(\DateTime $start)
    {
        $this->startDatetime = $start;
    }
    
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }
    
    public function setEndDatetime(\DateTime $end)
    {
        $this->endDatetime = $end;
    }
    
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }
    
    public function setAllDay($allDay = false)
    {
        $this->allDay = (boolean) $allDay;
    }
    
    public function getAllDay()
    {
        return $this->allDay;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getRodzaj()
    {
        return $this->rodzaj;
    }

    /**
     * @param int $rodzaj
     */
    public function setRodzaj($rodzaj)
    {
        $this->rodzaj = $rodzaj;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addField($name, $value)
    {
        $this->otherFields[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function removeField($name)
    {
        if (!array_key_exists($name, $this->otherFields)) {
            return;
        }

        unset($this->otherFields[$name]);
    }

    public function getKlient()
    {
        return $this->klient;
    }

    public function setKlient($klient)
    {
        $this->klient = $klient;
    }

    public function getLokalizacja()
    {
        return $this->lokalizacja;
    }

    public function setLokalizacja($lokalizacja)
    {
        $this->lokalizacja = $lokalizacja;
    }

    public function getTechnik()
    {
        return $this->technik;
    }

    public function setTechnik($technik)
    {
        $this->technik = $technik;
    }

    public function getZlecajacy()
    {
        return $this->zlecajacy;
    }

    public function setZlecajacy($zlecajacy)
    {
        $this->zlecajacy = $zlecajacy;
    }

    public function getPriorytet()
    {
        return $this->priorytet;
    }

    public function setPriorytet($priorytet)
    {
        $this->priorytet = $priorytet;
    }
}
