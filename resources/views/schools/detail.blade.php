@extends('layouts.app')

@section('content')
    <div style="display: flex; flex-direction: column; flex-wrap: nowrap">
        <div class="flex">

            <p class="title" style="margin-left: 7%">{{$school->name}}</p>
            @if(auth()->user()->ambassadorType == "HR")
            <div class="input-group-append contactdiv " id="button-addon6">
            <input class="form-control dropdowntri addcontact" style="margin-top: 60px; margin-left: 50px;" type="button" value="Edit School"
                   data-toggle="modal" data-target="#editSchool"/>
        </div>
                @endif
        </div>
        <div class="card-header" style=" width: 86%; margin-left:7%; margin-top:50px;"><h2>School stats</h2></div>
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
                </div>
                <div>
                    <hr>
                </div>
                <div class="flex">
                    <div class="statdiv" style="width: 50%">Number of Events:{{$eventsCount}}</div>
                    <div class="statdiv" style="width: 50%">Number of Students:{{$studentsCount}}</div>
                </div>
            </div>
        </div>

        <div class="flex" style="justify-content: space-between; width: 86%;margin-left:7%;margin-top: 50px;">


           <div class="verticalflex" style="width: 60%; justify-content: space-between">

               <div class="schooldetailbox" style="width: 100%;">
                   <div class="card schooldetails" style="height: auto">
                       <div class="card-header"><h2>{{$school->name}}'s information</h2></div>
                       <div class="card-body">
                           <h3 class="detailsinschool">Website: </h3>
                           <a href='http://{{$school->website}}' class="detailsinschool">{{$school->website}}</a>
                           <hr>
                           <h3 class="detailsinschool">Address:</h3>
                           <p class="detailsinschool"> {{$school->address}}</p>
                           <hr>
                           <h3 class="detailsinschool">Targeted Profiles: </h3>
                           <ul style="margin-bottom: 25px;">
                               @foreach($school->targetProfiles as $profiles)
                                   <li class="detailsinschool">{{$profiles->name}}</li>
                               @endforeach
                           </ul>
                           <hr>
                           <h3 class="detailsinschool">Ambassador(s): </h3>
                           <ul>
                               @foreach($school->ambassador as $ambassadors)
                                   <li class="detailsinschool">{{$ambassadors->username}}</li>
                               @endforeach
                           </ul>
                       </div>
                   </div>
               </div>

               <div class="flex" style="width: 100%;height: auto">
                   <div class="detailsbox" style="width: 100%; padding:0">
                       <div class="commentdetails" style="width: 100%;">
                           <h2 class="title" style="margin-left:0;">Comments</h2>
                           @if(auth()->user()->ambassadorType == "HR")
                               <div class="form-group postcomment">
                        <textarea type="text" class="form-control commentsection" style="height:50px" id="comment_{{$school->school_id}}"
                                  value="Add new comment" onfocus="this.value=''"></textarea>
                                   <input type="submit" id="saveComment" value="Post" class="dropdowntri searchButton savecomment"
                                          onclick="saveComment()"/>
                               </div>
                           @endif
                           @foreach($school->comments as $comment)
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

           </div>


            <div class="verticalflex" style="width: 30%;">
                <div class="contactBox" style="width: 100%;">
                    <div class="card event" style="margin-left: 0;margin-right: 0; width: 100%">
                        <div class="card-header"><h2>Contact</h2></div>
                        <div class="card-body" style="padding-bottom: 0">
                            @foreach($school->contacts as $contact)
                                <h2>{{$contact->firstname}} {{$contact->lastname}}</h2>
                                <p style="color: rgba(0,0,0,0.7)">Phone: {{$contact->phone}}</p>
                                <span style="color: rgba(0,0,0,0.7)">Mail: </span><span><a
                                            href="mailto:{{$contact->email}}">{{$contact->email}}</a></span>
                                <p>{{$contact->position}}</p>
                                <hr>
                            @endforeach
                        </div>
                        @if(auth()->user()->ambassadorType == "HR")
                            <div class="input-group-append contactdiv " id="button-addon6" style="margin: 10px">
                                <input class="form-control dropdowntri addcontact" type="button" value="Add new contact"
                                       data-toggle="modal" data-target="#createContact"/>
                            </div>
                        @endif
                    </div>
                </div>
            </div>







        </div>

    </div>
    <script>
        function saveComment() {

            {{'let user_id = ' . auth()->user()->getAuthIdentifier(). ';'}}
            {{'let school_id= ' . $school->school_id . ';'}}
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('school.addComment')}}",
                type: "POST",
                data: {
                    comment: document.getElementById('comment_{{$school->school_id}}').value,
                    user: user_id,
                    school: school_id
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
    @include('schools.addContactForm')
    @include('schools.editSchoolForm')
@endsection


