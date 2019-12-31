<?php

namespace App\Calendar;

class Holiday
{
    const NEW_YEARS_DAY = "New Year's Day";
    const MARDI_GRAS = "Mardi Gras";
    const EASTER = "Easter";
    const MEMORIAL_DAY = "Memorial Day";
    const INDEPENDENCE_DAY = "Independence Day";
    const MOTHERS_DAY = "Mother's Day";
    const LABOR_DAY = "Labor Day";
    const FATHERS_DAY = "Father's Day";
    const THANKSGIVING = "Thanksgiving";
    const THANKSGIVING_FRI = "Friday";
    const CHRISTMAS_EVE = "Xmas Eve";
    const CHRISTMAS_DAY = "Xmas Day";
    const NEW_YEARS_EVE = "NYE";

    private $year;
    private $month;
    private $day;
    public $classname;
    public $label = null;

    public function __construct($year, $month, $day) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->run();
    }

    private function run() {
        switch ($this->month) {
            case 1:
                $this->new_years_day();
                break;
            case 2:
            case 3:
            case 4:
                $this->mardi_gras();
                $this->easter();
                break;
            case 5:
                $this->mothers_day();
                $this->memorial_day();
                break;
            case 6:
                $this->fathers_day();
                break;
            case 7:
                $this->independence_day();
                break;
            case 9:
                $this->labor_day();
                break;
            case 11:
                $this->thanksgiving();
                break;
            case 12:
                $this->christmas();
                $this->new_years_eve();
        }
    }

    private function new_years_day() {
        if ($this->day == 1) {
            // $this->label = self::NEW_YEARS_DAY;
            $date = "$this->year-$this->month-$this->day";
            $this->label = date("Y", strtotime($date));
            $this->classname = $this->year % 2 === 0 ? "away" : "home";
        }
    }

    private function mardi_gras() {
        $easter = easter_date($this->year);
        if (date("N", $easter) == 6)
            $easter += 86400;
        $month = date("n", strtotime("-47 days", $easter));
        $day = date("j", strtotime("-47 days", $easter));
        if ($month == $this->month && $day == $this->day) {
            $this->label = self::MARDI_GRAS;
            $this->classname = $this->year % 2 === 0 ? "home" : "away";
        }
    }

    private function easter() {
        $easter = easter_date($this->year);
        if (date("N", $easter) == 6)
            $easter += 86400;
        $month = date("n", $easter);
        $day = date("j", $easter);
        if ($month == $this->month && $day == $this->day) {
            $this->label = self::EASTER;
            $this->classname = $this->year % 2 === 0 ? "home" : "away";
        }
    }

    private function mothers_day() {
        $day = date("j", strtotime("second sunday of may $this->year"));
        if ($day == $this->day) {
            $this->label = self::MOTHERS_DAY;
            $this->classname = "away";
        }
    }

    private function memorial_day() {
        $day = date("j", strtotime("last monday of may $this->year"));
        if ($day == $this->day) {
            $this->label = self::MEMORIAL_DAY;
            $this->classname = $this->year % 2 === 0 ? "away" : "home";
        }
    }

    private function fathers_day() {
        $day = date("j", strtotime("third sunday of june $this->year"));
        if ($day == $this->day) {
            $this->label = self::FATHERS_DAY;
            $this->classname = "home";
        }
    }

    private function independence_day() {
        if ($this->day == 4) {
            $this->label = self::INDEPENDENCE_DAY;
            $this->classname = $this->year % 2 === 0 ? "away" : "home";
        }
    }

    private function labor_day() {
        $day = date("N", strtotime("$this->year-$this->month-$this->day"));
        if (30 - $this->day >= 23 && $day == 1) {
            $this->label = self::LABOR_DAY;
            $this->classname = $this->year % 2 === 0 ? "home" : "away";
        }
    }

    private function thanksgiving() {
        $day = date("j", strtotime("fourth thursday of november $this->year"));
        if ($day == $this->day) {
            $this->label = self::THANKSGIVING;
            $this->classname = $this->year % 2 === 0 ? "home" : "away";
        }
        elseif ($day + 1 == $this->day) {
            $this->label = self::THANKSGIVING_FRI;
            $this->classname = $this->year % 2 === 0 ? "away" : "home";
        }
    }

    private function christmas() {
        if ($this->day == 24) {
            $this->label = self::CHRISTMAS_EVE;
            $this->classname = $this->year % 2 === 0 ? "home" : "away";
        }
        elseif ($this->day == 25) {
            $this->label = self::CHRISTMAS_DAY;
            $this->classname = $this->year % 2 === 0 ? "away" : "home";
        }
    }

    private function new_years_eve() {
        if ($this->day == 31) {
            $this->label = self::NEW_YEARS_EVE;
            $this->classname = $this->year % 2 === 0 ? "away" : "home";
        }
    }

}

