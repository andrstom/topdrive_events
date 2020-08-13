<?php

declare(strict_types = 1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use App\Model\EventsManager;
use App\Model\DbHandler;

final class EventsFormFactory {

    use Nette\SmartObject;

    /** @var App\Forms\FormFactory */
    private $factory;

    /** @var App\Model\EventsManager */
    private $eventsManager;

    /** @var App\Model\DbHandler */
    private $dbHandler;

    public function __construct(FormFactory $factory,
                                EventsManager $eventsManager,
                                DbHandler $dbHandler) {
        $this->factory = $factory;
        $this->eventsManager = $eventsManager;
        $this->dbHandler = $dbHandler;
    }

    /**
     * Create event form
     * @param \App\Forms\callable $onSuccess
     * @return Form
     */
    public function create($eventId, callable $onSuccess): Form {

        $form = $this->factory->create();

        $form->addText('eventStartDate','Začátek události (den)')
                ->setType('date');
        
        $form->addText('eventStartTime','Začátek události (čas)')
                ->setType('time');
        
        $form->addText('eventStopDate','Konec události (den)')
                ->setType('date');
        
        $form->addText('eventStopTime','Konec události (čas)')
                ->setType('time');

        $form->addText('activity','Aktivita');

        $form->addSubmit('send', 'Uložit')
                ->setAttribute('class', 'btn btn-theme');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($eventId, $onSuccess): void {

            if (!$eventId) {

                // Add article
                $this->eventsManager->add($values);
            } else {

                // Edit article
                $this->eventsManager->edit($values, $eventId);
            }
            $onSuccess();
        };

        return $form;
    }
}