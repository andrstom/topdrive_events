<?php

declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Forms;
use App\Model\EventsManager;
use App\Model\DbHandler;

final class HomepagePresenter extends BasePresenter {

    /** @persistent */
    public $backlink = '';
    
    /** var type int */
    public $eventId;
    
    /** var type int */
    public $editEvent;
    
    /** @var App\Model\EventsManager */
    private $eventsManager;
    
    /** @var App\Model\EventsFormFactory */
    private $eventsFactory;
    
    /** @var App\Model\DbHandler */
    private $dbHandler;
    
    public function __construct(EventsManager $eventsManager,
                                DbHandler $dbHandler,
                                Forms\EventsFormFactory $eventsFactory) {
            $this->eventsManager = $eventsManager;
            $this->dbHandler = $dbHandler;
            $this->eventsFactory = $eventsFactory;
    }

    public function renderDefault(): void {

        // load events
        $this->template->events = $this->eventsManager->getEvents();
        $this->template->conflictEvents = $this->eventsManager->conflictEvents();

    }
    
    /**
     * Events form factory.
     */
    protected function createComponentEventsForm(): Form {
        return $this->eventsFactory->create($this->eventId, function (): void {
                    $this->restoreRequest($this->backlink);
                    $this->flashMessage('Hotovo', 'success');
                    $this->redirect('Homepage:default');
                });
    }
    
    public function actionEditEvent($id): void {
        
            $this->eventId = $id;

            $editEvent = $this->dbHandler->getEvents()->get($id);
            $this->editEvent = $editEvent;

            if (!$editEvent) {

                $this->error('Event nebyl nalezen');
            }

            $this['eventsForm']->setDefaults($editEvent->toArray());

            $this->template->event = $this->dbHandler->getEvents()->get($id);
    }
    
    /**
     * Delete event
     * @param type $id
     */
    public function actionDeleteEvent($id): void {

            $deleteEvent = $this->dbHandler->getEvents()->get($id);
            if (!$deleteEvent) {
                $this->error('Event nebyl nalezen');
            }

            $delete = $deleteEvent->delete();
            if ($delete) {
                $this->flashMessage('Event byl smazán!', 'success');
                $this->redirect('Homepage:default');
            } else {
                $this->flashMessage('CHYBA: Event nebyl smazán!', 'danger');
                $this->redirect('Homepage:default');
            }
    }
    
}