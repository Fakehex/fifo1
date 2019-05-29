<?php

namespace App\EventListener;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarListener
{
    private $evenementRepository;
    private $router;

    public function __construct(
        EvenementRepository $evenementRepository,
        UrlGeneratorInterface $router
    ) {
        $this->evenementRepository = $evenementRepository;
        $this->router = $router;
    }

    public function load(CalendarEvent $calendar): void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $evenements = $this->evenementRepository->findAllSortedDate();
          //  ->createQueryBuilder('evenement')
          //  ->where('evenement.date')
          //  ->setParameter('start', $start->format('Y-m-d H:i:s'))
          //  ->setParameter('end', $end->format('Y-m-d H:i:s'))
          //  ->getQuery()
          //  ->getResult()
        ;
        $i = 0;
        foreach ($evenements as $evenement) {
            // this create the events with your data (here booking data) to fill calendar

            $bookingEvent = new Event(
                $evenement->getTitre(),
                $evenement->getDate(),
                null // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $bookingEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $page = (int) ($i++/5);
            $page++;
            $bookingEvent->addOption('url', $this->router->generate('evenements', ['page'=> $page,'_fragment' => 'ancre'.$evenement->getId()]));

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($bookingEvent);
        }
    }
}
