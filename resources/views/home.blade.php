@extends('layouts.app')

@section('content')
    <div style="display: flex; flex-direction: column; flex-wrap: nowrap">

        <div class="card-header" style=" width: 86%; margin-left:7%; margin-top:50px;">Statistics</div>
        <div class="flex card-body" style="height: auto; width: 86%; margin-left:7%; background-color: white">
            <div class="verticalflex" style="width: 100%;">
                <div class="flex" style="width: 100%; flex-wrap: wrap; justify-content: center">
                    <div class="pie" style="width: calc(100% / 4)">
                        <div id="StatChart_1"></div>
                        <?= \Lava::render('PieChart', 'StatChart_1', 'StatChart_1') ?>
                    </div>
                    <div class="pie" style="width: calc(100% / 4)">
                        <div id="StatChart_2"></div>
                        <?= \Lava::render('PieChart', 'StatChart_2', 'StatChart_2') ?>
                    </div>
                    <div class="pie" style="width: calc(100% / 4)">
                        <div id="StatChart_3"></div>
                        <?= \Lava::render('PieChart', 'StatChart_3', 'StatChart_3') ?>
                    </div>
                    <div class="pie" style="width: calc(100% / 4)">
                        <div id="StatChart_4"></div>
                        <?= \Lava::render('PieChart', 'StatChart_4', 'StatChart_4') ?>
                    </div>
                </div>
                <div>
                    <hr>
                </div>

                <div class="flex">
                    <div class="statdiv"><p>Number of School: {{\App\Models\School::all()->count()}}</p></div>
                    <div class="statdiv"><p>Number of Events: {{\App\Models\SchoolEvent::all()->count()}}</p></div>
                    <div class="statdiv"><p> Number of Students: {{\App\Models\Student::all()->count()}}</p></div>
                </div>
            </div>
        </div>

        <div class="flex" style="width: 86%; margin-left: 7%; justify-content: space-between">
            <div class="verticalflex" style="width: 100%; margin-right: 50px">
                <h1 class="title" style="margin-left: 0">Current events</h1>
                <ul class="eventList">
                    @foreach(\App\Models\SchoolEvent::current()->get() as $event)
                        <li>
                            <a href="{{route('events.detail', ['id'=>$event->event_id])}}" class="link">
                                <div class="card event" >
                                    <div class="card-header head">{{$event->name}}</div>

                                    <div class="card-body">

                                        <div class="innerDiv date"
                                             style="height: 50%;">{{\Carbon\Carbon::parse($event->startDate)->format('d/m/Y H:i') . " - " . (\Carbon\Carbon::parse($event->startDate)->format('d/m/Y')==\Carbon\Carbon::parse($event->endDate)->format('d/m/Y') ? \Carbon\Carbon::parse($event->endDate)->format('H:i') : \Carbon\Carbon::parse($event->endDate)->format('d/m/Y H:i')) }}</div>
                                        <div class="innerDiv organizer" style="height: 50%;">{{$event->organiser->name}}</div>


                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="verticalflex"  style="width: 100%">
                <h1 class="title" style="margin-left: 0">Future events</h1>
                <ul class="eventList">
                    @foreach(\App\Models\SchoolEvent::future()->limit(5)->get() as $event)
                        <li>
                            <a href="{{route('events.detail', ['id'=>$event->event_id])}}" class="link">
                                <div class="card event">
                                    <div class="card-header head">{{$event->name}}</div>

                                    <div class="card-body">

                                        <div class="innerDiv date"
                                             style="height: 50%;">{{\Carbon\Carbon::parse($event->startDate)->format('d/m/Y H:i') . " - " . (\Carbon\Carbon::parse($event->startDate)->format('d/m/Y')==\Carbon\Carbon::parse($event->endDate)->format('d/m/Y') ? \Carbon\Carbon::parse($event->endDate)->format('H:i') : \Carbon\Carbon::parse($event->endDate)->format('d/m/Y H:i')) }}</div>
                                        <div class="innerDiv organizer" style="height: 50%;">{{$event->organiser->name}}</div>


                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        </div>



@endsection
