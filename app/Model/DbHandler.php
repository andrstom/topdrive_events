<?php
declare(strict_types = 1);

namespace App\Model;

use Nette;

class DbHandler {

    use Nette\SmartObject;

    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /**
     * Get Events
     * @return object
     */
    public function getEvents() {
        return $this->database->table('events');
    }

}
