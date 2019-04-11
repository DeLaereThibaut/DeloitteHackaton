@if(count($events)==0)

@else
    <div class="alleventdiv">
        <ul class="eventList">
            @foreach($events as $event)
                <li>
                    <a href="{{route('events.detail', ['id'=> $event->event_id])}}" class="link">
                        <div style="width: 80%; margin-left:10%;">
                            <div class="card event" style="width: auto">
                                <div class="card-header head"><h2>{{$event->name}}</h2></div>

                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <div class="innerDiv date"
                                         style="font-size: 1.3em;">{{\Carbon\Carbon::parse($event->startDate)->format('d/m/Y H:i') . " - " . (\Carbon\Carbon::parse($event->startDate)->format('d/m/Y')==\Carbon\Carbon::parse($event->endDate)->format('d/m/Y') ? \Carbon\Carbon::parse($event->endDate)->format('H:i') : \Carbon\Carbon::parse($event->endDate)->format('d/m/Y H:i')) }}</div>
                                    <div class="innerDiv date" style="font-size:1.3em">{{$event->organiser->name}}</div>
                                </div>
                            </div>
                        </div>
                    </a></li>

            @endforeach
        </ul>
    </div>
    <div class="d-flex justify-content-center mt-2 mb-4">
        {{ $events->links() }}
    </div>
@endif


 