<?php

namespace App\Calendar;

class Day
{

    /**
     * @var int $year
     */
    public $year;

    /**
     * @var int $month
     */
    public $month;

    /**
     * @var int $day
     */
    public $day;

    /**
     * @var object $custody
     */
    public $custody;

    /**
     * @var object $holiday
     */
    public $holiday;

    public function __construct($year, $month, $day) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->custody = new Custody($year, $month, $day);
        $this->holiday = new Holiday($year, $month, $day);
    }

    public function current() {
        return $this->year == date("Y") &&
               $this->month == date("n") && 
               $this->day == date("j");
    }

}

