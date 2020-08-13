<?php

declare(strict_types = 1);

namespace App\Model;

use Nette;


class EventsManager {

    use Nette\SmartObject;

    // set database details
    private const
            TABLE_EVENTS = 'events',
            COLUMN_ID = 'id',
            COLUMN_EVENT_START_TIME = 'eventStartTime',
            COLUMN_EVENT_STOP_TIME = 'eventStopTime',
            COLUMN_ACTIVITY= 'activity';
            

    private $eventsToArray;
    
    /** @var Nette\Database\Context */
    private $database;
    
    public function __construct(Nette\Database\Context $database) {
            $this->database = $database;
    }

    /**
     * Add new event
     * @param type $values
     * @throws Exception
     */
    public function add($values): void {

        try {

            // insert details into db
            $insert = $this->database->table(self::TABLE_EVENTS)->insert([
                self::COLUMN_EVENT_START_TIME => strtotime($values->eventStartDate . ' ' . $values->eventStartTime),
                self::COLUMN_EVENT_STOP_TIME => strtotime($values->eventStopDate . ' ' . $values->eventStopTime),
                self::COLUMN_ACTIVITY => $values->activity,
            ]);
            
        } catch (\Exception $e) {
            throw new EventsException('Chyba při ukládání!' . $e->getMessage());
        }

    }

    /**
     * Edit event
     * @param  $values
     * @param int $eventId
     * @throws EventsException
     */
    public function edit($values, $eventId): void {

        // update details
        try {

            $event = $this->database->table('events')->get($eventId);
            $event->update([
                self::COLUMN_EVENT_START_TIME => strtotime($$values->eventStartDate . ' ' . $values->eventStartTime),
                self::COLUMN_EVENT_STOP_TIME => strtotime($values->eventStopDate . ' ' . $values->eventStopTime),
                self::COLUMN_ACTIVITY => $values->activity,
            ]);
        } catch (\Exception $e) {
            throw new EventsException('Chyba při ukládání článku do db!' . $e->getMessage());
        }
        
    }

    /**
     * get data form db
     * @return object
     */
    public function getEvents() {
        
        $events = $this->database->table('events')->order('eventStartTime ASC');
        return $events;
        
    }
    
    /**
     * Select overlapping events
     * @return array
     */
    public function conflictEvents() {
        
        $eventsArray = $this->eventsToArray();
        
        $overlapEvents = array();
        
        foreach ($eventsArray as $event1) {

            foreach ($eventsArray as $event2) {

                if ($event1['activity'] === $event2['activity']) {
                    continue;
                }
                
                if (($event1['event_start'] <= $event2['event_start']) && ($event2['event_start'] <= $event2['event_stop']) && ($event2['event_stop'] <= $event1['event_stop'])) {
                    $overlapEvents[] = array(
                        'primaryEvent' => $event1['activity'],
                        'overlapEvent' => $event2['activity']
                    );
                }
            }
        }
        
        return $overlapEvents;
    }
    
    private function eventsToArray() {
        
        $allEvents = $this->getEvents()->fetchAll();
        $eventArray = array();
        
        foreach ($allEvents as $event) {
            $eventArray[] = array(
                "id" => $event->id,
                "activity" => $event->activity,
                "event_start" => $event->eventStartTime,
                "event_stop" => $event->eventStopTime
            );
        }
        
        return $eventArray;
        
    }
    
}

class EventsException extends \Exception {}