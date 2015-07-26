<?php

namespace GCSV\FullCalendarBundle\Controller;

use GCSV\FullCalendarBundle\Entity\EventEntity;
use GCSV\FullCalendarBundle\Event\CalendarEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     *  Wyświetla Kalendarz oraz zwraca odpowiedź w postaci JSON dla każdego z wyświetlonych zdarzeń.
     */
    public function loadCalendarAction(Request $request)
    {
        $startDatetime = new \DateTime($request->get('start'));
        $endDatetime = new \DateTime($request->get('end'));

        /**
         * @var CalendarEvent $calendarEvent
         */
        $calendarEvent = $this->container->get('event_dispatcher')->dispatch(CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime, $request));
        $events = $calendarEvent->getEvents();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_events = array();

        /**
         * @var EventEntity $event
         */
        foreach($events as $event) {
            $return_events[] = $event->toArray();
        }

        $response->setContent(json_encode($return_events));

        return $response;
    }
}
