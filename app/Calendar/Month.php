<?php 

namespace App\Calendar;

class Month
{
    public $labels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    private $year;
    public $month;
    private $unixtime;
    private $num_days;
    private $start_day;
    public $today;
    public $title;
    public $offset;
    public $previous_month;
    public $next_month;
    private $days = [];
    public $weeks;
    public $holidays;

    public function __construct($year=null, $month=null) {

        $year = intval($year) > 2015 ? $year : date('Y');
        $month = intval($month) > 0 ? $month : date('n');
        $month_start = "$month/1/$year";

        $this->year = $year;
        $this->month = $month;
        $this->unixtime = strtotime($month_start);
        $this->num_days = date('t', $this->unixtime);
        $this->start_day = date('w', $this->unixtime);
        $this->today = $this->year . $this->month == date('Yn') ? date('j') : 0;
        $this->title = date('F Y', $this->unixtime);
        // $this->offset = Custody::offset($month_start);
        $this->previous_month = $this->previous_month();
        $this->next_month = $this->next_month();
        $this->holidays = $this->list_holidays();
        $this->build();
    }

    public function current() {
        return $this->year == date("Y") && $this->month == date("n");
    }

    private function previous_month() {
        $previous = (object) [
            "year" => $this->year,
            "month" => $this->month - 1,
        ];

        if ($previous->month == 0) {
            $previous->year = $this->year - 1;
            $previous->month = 12;
        }

        $previous->days = date("t", strtotime("$this->month/$this->year/01"));

        return $previous;
    }

    private function next_month() {
        $next = (object) [
            "year" => $this->year,
            "month" => $this->month + 1,
        ];

        if ($next->month == 13) {
            $next->year = $this->year + 1;
            $next->month = 1;
        }

        return $next;
    }

    private function build() {
        $this->days();
        $this->weeks();
    }

    private function days() {
        foreach ($this->previous_days() as $day)
            $this->days[] = new Day($this->previous_month->year,
                                    $this->previous_month->month, $day);
        foreach ($this->current_days() as $day)
            $this->days[] = new Day($this->year, $this->month, $day,
                                    $this->offset++);
        foreach ($this->next_days() as $day)
            $this->days[] = new Day($this->next_month->year,
                                    $this->next_month->month, $day);
    }

    private function previous_days() {
        for ($i=$this->start_day - 1; $i>=0; $i--)
            yield $this->previous_month->days - $i;
    }

    private function current_days() {
        for ($i=1; $i<=$this->num_days; $i++)
            yield $i;
    }

    private function next_days() {
        $last_day = 7 - count($this->days) % 7;
        for ($i=1; $i<=$last_day; $i++)
            yield $i;
    }

    private function weeks() {
        for ($w=0; $w<(count($this->days) / 7); $w++)
            for ($d=0; $d<7; $d++)
                $this->weeks[$w][] = $this->days[7 * $w + $d];
    }

    private function list_holidays() {
        $holidays = array();
        if ($this->month == 1)
            $holidays[1] = "New Year's Day";
        elseif ($this->month == 7)
            $holidays[4] = "Independence Day";
        elseif ($this->month == 12)
            $holidays[25] = "Christmas";
        return $holidays;
    }

    private function thanksgiving() {
        $offset = $this->start_day + 1;
        if ($offset < 5)
            $day = 21 + $offset;
        //else
    }
}

