@extends('layouts.app')

@section('content')
    <div style="display: flex; flex-direction: column; flex-wrap: nowrap">
        <div class="flex">
            <p class="title" style="margin-left: 7%;">{{$schoolevent->name}}</p>
            @if(auth()->user()->ambassadorType == "HR")
            <div class="input-group-append contactdiv " id="button-addon6">
                <input style="width: 100%; margin-top:60px;margin-left: 50px;" class="form-control dropdowntri addcontact" type="button" value="Edit Event"
                       data-toggle="modal" data-target="#editEvent"/>
            </div>
            @endif
        </div>

        @include('events.editEvent')
        <div class="card-header" style=" width: 86%; margin-left:7%; margin-top:50px;">Statistics</div>
        <div class="flex card-body" style="height: auto; width: 86%; margin-left:7%; background-color: white">
            <div class="verticalflex" style="width: 100%;">
                <div class="flex" style="width: 100%; flex-wrap: wrap; justify-content: center">
                    <div class="pie">
                        <div id="StatChart_1"></div>
                        <?= \Lava::render('PieChart', 'StatChart_1', 'StatChart_1') ?>
                    </div>
                    <div class="pie">
                        <div id="StatChart_2"></div>
                        <?= \Lava::render('PieChart', 'StatChart_2', 'StatChart_2') ?>
                    </div>
                    <div class="pie">
                        <div id="StatChart_3"></div>
                        <?= \Lava::render('PieChart', 'StatChart_3', 'StatChart_3') ?>
                    </div>
                    <div class="pie">
                        <div id="StatChart_4"></div>
                        <?= \Lava::render('PieChart', 'StatChart_4', 'StatChart_4') ?>
                    </div>
                    <div class="pie">
                        <div id="StatChart_5"></div>
                        <?= \Lava::render('PieChart', 'StatChart_5', 'StatChart_5') ?>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="flex">
                    <div class="statdiv" style="width: 100%">Number of
                        Students:{{$schoolevent->students->count()}}</div>
                </div>
            </div>
        </div>


        <h2 class="title" style="margin-left:7%;">Student list</h2>
        <div class="flex"
             style="margin-top: 40px; width: 86%; margin-left: 7%; justify-content: space-between; margin-bottom: 50px;">
            <div class="verticalflex" style="width: 80%;">
                <div class="flex"
                     style="background-color:#86bc25; color:white; border-top-left-radius: 3px; border-top-right-radius: 3px">
                    <p class="titlep">Name and firstname</p>
                    <p class="titlep">Status</p>
                    <p class="titlep">Contract type</p>
                </div>
                <div class="studentlist" style="width:100%">

                    <ul style="list-style:  none">
                        {{--nom, type contrat, status--}}
                        @foreach($schoolevent->students as $student)
                            <li data-toggle="modal" class="studentlistli"
                                data-target="#showStudent_{{$student->student_id}}">
                                <div class="flex">
                                    <p class="listp">{{$student->lastname . " " . $student->firstname}}</p>
                                    <p class="listp">{{$student->statusStudent->name}}</p>
                                    <p class="listp">{{$student->contractTypeStudent->name}}</p>
                                </div>

                                <hr style="margin: 0;">
                            </li>
                            @include("partial.studentModal")
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="flex" style="height:45px;">
                <input style="margin-right: 0;" class="btn button" type="submit" value="Add student" data-toggle="modal"
                       data-target="#createStudent" onclick="launch()">
            </div>
        </div>

    </div>


    <div class="flex" style="justify-content: space-between; width: 86%;margin-left:7%;margin-top: 50px;">
        <div class="eventdetails" style="background-color: white;">
            <div class="card-header">{{$schoolevent->name}}</div>
            <div class="card-body">
                <h3>Country: </h3>
                <p>{{$schoolevent->country->name}}</p>
                <hr>
                <h3>Location: </h3>
                <p>{{$schoolevent->location}}</p>
                <hr>
                <h3>Start Date: </h3>
                <p>{{$schoolevent->startDate}} End Date: {{$schoolevent->endDate}}</p>
                <hr>
                <h3>Fiscal Year: </h3>
                <p>{{$schoolevent->fiscalYear}}</p>
                <hr>
                <h3>Event Price: </h3>
                <p>{{$schoolevent->eventPrice}} $</p>
                <hr>
                <h3>Event Type: </h3>
                <p>{{$schoolevent->type->name}}</p>
            </div>

        </div>
        <div class="eventdetails">
            <div class="verticalflex">
                <div class="verticalflex">
                    <div class="card-header" style="width: 100%">Ambassador</div>
                    <div class="card-body" style="height: auto; background-color: white">
                        @foreach($schoolevent->ambassadors as $ambassadors)
                            @if($ambassadors->ambassadorType=='normal')
                                <li>{{$ambassadors->username}}</li>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="verticalflex">
                    <div class="card-header" style="width: 100%">HR Ambassador</div>
                    <div class="card-body" style="height: auto; background-color: white">
                        @foreach($schoolevent->ambassadors as $ambassadors)
                            @if($ambassadors->ambassadorType=='HR')
                                <li>{{$ambassadors->username}}</li>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex" style="width: 100%;height: auto">
        <div class="detailsbox" style="width: 100%; margin-left:7%; padding:0">
            <div class="commentdetails">
                <h2 class="title" style="margin-left:0;">Comments</h2>
                @if(auth()->user()->ambassadorType == "HR")
                    <div class="form-group postcomment">
                        <textarea type="text" class="form-control commentsection" style="height:50px" id="comment"
                                  value="Add new comment" onfocus="this.value=''"></textarea>
                        <input type="submit" id="saveComment" value="Post" class="dropdowntri searchButton savecomment"
                               onclick="saveEventComment()"/>
                    </div>
                @endif
                @foreach($schoolevent->comments as $comment)
                    <div class="flexcomment">
                        <p style="font-weight:bold">{{$comment->user->username}}</p>
                        <p style="margin-left: 15px; color:#777777">{{$comment->date}}</p>
                    </div>
                    <div>
                        <p>{{$comment->comments}}</p>
                    </div>
                    <hr style="width: 90%; background-color: rgba(134,188,37,0.4)">

                @endforeach

            </div>
        </div>
    </div>
    @include('events.addStudentForm')
    <script>
        function saveEventComment() {

            {{'let user_id = ' . auth()->user()->getAuthIdentifier(). ';'}}
            {{'let event_id= ' . $schoolevent->event_id}}
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('events.addComment')}}",
                type: "POST",
                data: {
                    comment: document.getElementById('comment').value,
                    user: user_id,
                    event: event_id
                },
                dataType: "html",

                success: function (json_doc) {
                    console.log(json_doc);
                    r = JSON.parse(json_doc);
                    if (r.result) {
                        showMessage("#general_alert", r.message, "success");
                        location.reload();
                    } else {
                        showMessage(".erroralert", r.message, "danger");
                    }
                    console.log(json_doc);
                },
                error: function (jqXHR, exception) {
                    alert("error");
                    console.log(jqXHR, exception)
                    showMessage(".erroralert", json_doc, "danger");
                },
                complete: function (result, status) {
                    console.log(result);
                }

            });
        }

        function showMessage(where, element, type) {
            $(where).html("<div class='alert alert-" + type + "'>" + element + "</div>");
            $('#createEvent').animate({scrollTop: 0}, 'slow');

        }
    </script>
    @include('events.addForm')
@endsection
