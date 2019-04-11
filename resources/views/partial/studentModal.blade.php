<div class="modal fade" tabindex="-1" role="dialog" id="showStudent_{{$student->student_id}}">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$student->lastname . " " . $student->firstname}}
                    ({{$student->gender == 1? "M": "F"}})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="flex" style="height: 500px;">
                    <div class="verticalflex" style="width: 60%; height: 100%; overflow-y: scroll; padding-right: 5px;">
                        <div>
                            <h3>Mail</h3>
                            <p style="margin-bottom: 0">{{$student->email}}</p>
                        </div>
                        <div style="margin: 0 ;">
                            <hr>
                        </div>
                        <div>
                            <h3>Phone</h3>
                            <p style="margin-bottom: 0">{{$student->phoneNumber}}</p>
                        </div>

                        <div style="margin: 0">
                            <hr>
                        </div>
                        <div class="flex" style="justify-content: space-between">
                            <div class="verticalflex">
                                <h3>Contract type</h3>
                                <p style="margin-bottom: 0">{{$student->contractTypeStudent->name}}</p>
                            </div>
                            <div class="verticalflex">
                                <h3>Status</h3>
                                <p style="margin-bottom: 0">{{$student->statusStudent->name}}</p>
                            </div>
                            <div class="verticalflex">
                                <h3>Work permit</h3>
                                <p style="margin-bottom: 0">{{$student->workPermit? "Needed" : "Not needed"}}</p>
                            </div>
                        </div>
                        <div style="margin: 0">
                            <hr>
                        </div>
                        <div>
                            <h3>Feedback</h3>
                            <p style="margin-bottom: 0">{{$student->feedback}}</p>
                        </div>
                        <div style="margin: 0">
                            <hr>
                        </div>

                        <div>
                            <h3>Comments</h3>
                            @if(auth()->user()->ambassadorType == "HR")
                                <div class="form-group postcomment">
                        <textarea type="text" class="form-control commentsection" style="height:50px;width: 80%"
                                  id="comment_student_{{$student->student_id}}"
                                  value="Add new comment" onfocus="this.value=''"></textarea>
                                    <input type="submit" id="saveComment" style="width: 20%" value="Post"
                                           class="dropdowntri searchButton savecomment"
                                           onclick="saveStudentComment{{$student->student_id}}()"/>
                                </div>
                            @endif
                            @foreach($student->comments as $comment)
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

                    <div class="verticalflex" id="cv_list_{{$student->student_id}}"
                         style="margin-left:2%;width: 38%; height: 100%; border-left: 1px solid rgba(0,0,0,0.1)">


                        @include('partial.cv_list')

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function saveStudentComment{{$student->student_id}}() {

        {{'let user_id = ' . auth()->user()->getAuthIdentifier(). ';'}}
        {{'let event_id= ' . $student->student_id}}
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('events.addStudentComment')}}",
            type: "POST",
            data: {
                comment: document.getElementById('comment_student_{{$student->student_id}}').value,
                user: user_id,
                event: event_id
            },
            dataType: "html",

            success: function (json_doc) {
                console.log(json_doc);
                console.log( document.getElementById('comment_student_{{$student->student_id}}'));
                r = JSON.parse(json_doc);
                if (r.result) {
                    showMessage("#general_alert", r.message, "success");
                    location.reload();
                } else {
                    showMessage(".alert", r.message, "danger");
                }
                console.log(json_doc);
            },
            error: function (jqXHR, exception) {
                alert("error");
                console.log(jqXHR, exception)
                showMessage(".alert", json_doc, "danger");
            },
            complete: function (result, status) {
                console.log(result);
            }

        });
    }

    function uploadFile_{{$student->student_id}}(fileInput) {
        var formData = new FormData();
        formData.append('file', fileInput.files[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{route('events.upload_student_cv', ['id'=> $student->student_id])}}',
            type: 'POST',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (data) {
                console.log(data);
                $('#cv_list_{{$student->student_id}}').html(data);

            }, error: function (jqXHR, exception) {
                alert("error");
                console.log(jqXHR, exception)
                showMessage(".alert", "t", "danger");
            },
        });
    }

</script>
