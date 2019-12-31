@extends("layouts.base")

@section("head")
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
<link rel="icon" href="{{ asset('images/calendar/favicon.ico') }}" sizes="16x16 32x32 48x48 64x64" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon-precomposed" href="{{ asset('images/calendar/apple-touch-icon.png' ) }}" />
@endsection

@section("template")
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex">
            <h5 class="flex-fill">{{ $calendar->title }}</h5>
            <a class="btn btn-sm btn-light border mr-2" href="{{ route('calendar') }}">Today</a>
            <div class="btn-group">
                <a class="btn btn-sm btn-light border border-right-0" href='{{ route("calendar") . "/{$calendar->previous_month->year}/{$calendar->previous_month->month}" }}'>
                    <span class="mdi mdi-chevron-left"></span>
                </a>
                <a class="btn btn-sm btn-light border" href='{{ route("calendar") . "/{$calendar->next_month->year}/{$calendar->next_month->month}" }}'>
                    <span class="mdi mdi-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="row px-2">
    @foreach($calendar->labels as $label)
        <div class="col calendar-label border p-0 bg-light text-center">{{ $label }}</div>
    @endforeach
    </div>
    @foreach($calendar->weeks as $week)
    <div class="row px-2">
        @foreach($week as $day)
        <div class="calendar-day col border p-0 {{ $day->current() ? 'bg-light' : '' }}">
            <div class="w-100 text-right mb-2 pr-1 {{ $day->current() ? 'font-weight-bold' : '' }}">{{ $day->day }}</div>
            <div class="progress bg-transparent rounded-0">
            @if($day->custody->status == "arrive")
                <div class="progress-bar bg-warning w-50"></div>
                <div class="progress-bar bg-info w-50 pl-1 text-left">
                    {{ $day->custody->label }}
                </div>
            @elseif ($day->custody->status == "home")
                <div class="progress-bar bg-info w-100 mx-0"></div>
            @elseif ($day->custody->status == "depart")
                <div class="progress-bar bg-info w-50"></div>
                <div class="progress-bar bg-warning w-50 pl-1 text-left">
                    {{ $day->custody->label }}
                </div>
            @else
                <div class="progress-bar bg-warning w-100 mx-0"></div>
            @endif
            </div>
            @if($day->holiday->label)
            <div class="progress bg-transparent rounded-0 mt-1">
                <div class="progress-bar w-100 mx-0 pl-1 text-left {{ $day->holiday->classname == 'home' ? 'bg-info' : 'bg-warning' }}">
                    {{ $day->holiday->label }}
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endforeach
</div>
@endsection

@section("scripts")
<script>
</script>
@endsection
