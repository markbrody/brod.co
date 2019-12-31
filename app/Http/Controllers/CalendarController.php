<?php

namespace App\Http\Controllers;

use App\Calendar\Month;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * @var int $year
     */
    private $year;

    /**
     * @var int $month
     */
    private $month;

    public function index($year=null, $month=null) {
        $this->year = $this->year($year);
        $this->month = $this->month($month);
        $calendar = new Month($this->year, $this->month);
        return view("calendar", ["calendar" => $calendar]);
    }

    public static function year($year) {
        return preg_match("/^20\d{2}$/", $year) ? $year : date("Y");
    }

    public static function month($month) {
        return intval($month) > 0 && intval($month) < 13 ? $month : date("n");
    }

}
