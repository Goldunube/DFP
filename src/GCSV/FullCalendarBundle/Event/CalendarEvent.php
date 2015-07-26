<?php

namespace GCSV\FullCalendarBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use GCSV\FullCalendarBundle\Entity\EventEntity;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Zdarzenie użyte do przechowywania EventEntitys
 */
class CalendarEvent extends Event
{
    const CONFIGURE = 'calendar.load_events';

    private $startDatetime;
    
    private $endDatetime;
    
    private $request;

    private $events;

    /**
     * Constructor method requires a start and end time for event listeners to use.
     *
     * @param \DateTime $start Begin datetime to use
     * @param \DateTime $end End datetime to use
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function __construct(\DateTime $start, \DateTime $end, Request $request = null)
    {
        $this->startDatetime = $start;
        $this->endDatetime = $end;
        $this->request = $request;
        $this->events = new ArrayCollection();
    }

    public function getEvents()
    {
        return $this->events;
    }
    
    /**
     * If the event isn't already in the list, add it
     * 
     * @param EventEntity $event
     * @return CalendarEvent $this
     */
    public function addEvent(EventEntity $event)
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }
        
        return $this;
    }
    
    /**
     * Get start datetime 
     * 
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Get end datetime 
     * 
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * Get request
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
