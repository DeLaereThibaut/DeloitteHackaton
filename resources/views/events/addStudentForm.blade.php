<div class="modal fade" tabindex="-1" role="dialog" id="createStudent">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student - Ambassador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" class="form-control">
                        @foreach(\App\Models\StudentStatus::all() as $is)
                            <option value="{{$is->id}}">{{$is->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="ct">Contract type</label>
                    <select id="ct" class="form-control">
                        @foreach(\App\Models\ContractType::all() as $is)
                            <option value="{{$is->id}}">{{$is->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wp">
                        <label class="form-check-label" for="wp">
                            Need work permit
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="feedback">Feedback</label>
                    <textarea type="text" class="form-control"  style="max-height: 400px;" id="feedback"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="next" data-dismiss="modal" data-toggle="modal" data-target="#createStudentStep2">Next
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="createStudentStep2">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert" class="erroralert">

                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname">
                    </div>
                    <div class="form-group col">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname">
                    </div>
                </div>
                <div class="form-group">
                    @foreach(\App\Models\Gender::all() as $gender)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" value="{{$gender->id}}" type="radio" name="gender" id="gender_{{$gender->id}}" />
                            <label class="form-check-label" for="gender_{{$gender->id}}">{{$gender->name}}</label>
                        </div>
                    @endforeach
                </div><div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="phnumber">Phone Number</label>
                    <input type="text" class="form-control" id="phnumber">
                </div>
                <div class="form-group">
                    <select class="form-control"  id="targeted_profile">
                    @foreach($schoolevent->targetProfiles as $et)
                        <option value="{{$et->id}}">{{$et->name}}</option>
                    @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" id="previous" data-dismiss="modal" data-toggle="modal" data-target="#createStudent">Previous</button>
                <button type="button" class="btn btn-primary" id="next" onclick="saveStudent()">Confirm
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    function launch() {
        [].forEach.call(document.getElementsByTagName('input'), function (s){if(s.getAttribute('type') != 'submit' && s.getAttribute('type') != 'radio' && s.getAttribute('type') != 'checkbox'&& s.getAttribute('type') != 'button') s.value = ""});
        [].forEach.call(document.getElementsByTagName('textarea'), function (s){s.value = ""});
    }

    function saveStudent(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('events.addStudent', $schoolevent->event_id)}}",
            type: "POST",
            data: {
                lastname     : document.getElementById('lastname').value,
                firstname     : document.getElementById('firstname').value,
                gender     : getRadioValue("gender"),
                email     : document.getElementById('email').value,
                phone_number     : document.getElementById('phnumber').value,
                targeted_profile     : document.getElementById('targeted_profile').value,
                status     : document.getElementById('status').value,
                contract_type     : document.getElementById('ct').value,
                need_work_permit     : document.getElementById('wp').checked,
                feedback     : document.getElementById('feedback').value,

            },
            dataType: "html",
            success: function (json_doc) {
                console.log(json_doc);
                r = JSON.parse(json_doc);
                if(r.result){
                    showMessage("#general_alert", r.message, "success");
                    $('#createStudentStep2').modal('toggle');
                    location.reload();
                }   else{
                    showMessage(".erroralert", r.message, "danger");
                }
                console.log(json_doc);
            },
            error: function (jqXHR, exception) {
                alert("error");
                //displayError(jqXHR, exception)
                //showMessage("#alert", json_doc, "danger");
            },
            complete: function (result, status) {
                console.log(result);
            }

        });

    }
    function getRadioValue(name){
        var radios = document.getElementsByName(name);

        for (var i = 0, length = radios.length; i < length; i++)
        {
            if (radios[i].checked)
            {
                console.log(i + ": " + radios[i].value);
                return radios[i].value;
            }
        }
    }
    function showMessage(where, element, type){
        $(where).html("<div class='alert alert-" + type + "'>"+element+"</div>");
        $('#createStudentStep2').animate({ scrollTop: 0 }, 'slow');

    }
</script>
