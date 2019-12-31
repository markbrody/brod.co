<?php

namespace App\Calendar;

class Custody
{
    const START_DATE = '2015-07-30';

    private $year;
    private $month;
    private $day;
    public $status;
    public $label = null;
    public $classnames;

    public function __construct($year, $month, $day) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->run();
    }

    private function run() {
        $this->offset();
        $this->status();
    }

    public function offset() {
        $date = "$this->month/$this->day/$this->year";
        if (strtotime($date) > strtotime(self::START_DATE)) {
            $start = new \DateTime(self::START_DATE);
            $end = new \DateTime($date);
            $diff = $start->diff($end);
            $this->offset = $diff->days;
        }
    }

    public function status() {
        $modulo = intval($this->offset) % 4;
        switch ($modulo) {
            case 1:
                $this->status = "home";
                $this->classnames = ["home"];
                break;
            case 2:
                $this->status = "depart";
                $this->classnames = ["home-end", "away-begin"];
                $this->label = "mom";
                break;
            case 3:
                $this->status = "away";
                $this->classnames = ["away"];
                break;
            default:
                $this->status = "arrive";
                $this->classnames = ["away-end", "home-begin"];
                $this->label = "dad";
        }
    }

}

