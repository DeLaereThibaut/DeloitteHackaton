@extends('layouts.app')

@section('content')

    <div class="verticalflex" style="width: 100%">




        <div class="flex" style="width: 86%; margin-left:7%; margin-top: 50px;">
            <div class="verticalflex" style="width: 65%; min-height:500px; margin-right: 5%">
                <div class="card-header">
                    <h2>{{$student->lastname . " " . $student->firstname}}</h2>
                </div>
                <div class="card-body" style="background-color: white">
                    <div class="flex" style="height: 500px;">
                        <div class="verticalflex" style="width: 100%; min-height: 100%; padding-right: 5px;">
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
                </div>
            </div>
                </div>
            </div>
            <div class="verticalflex" style="width: 30%; min-height:500px; background-color: white">
                <div class="card-header">
                    <h2>CVs</h2>
                </div>
                <div class="card-body" id="cv_list_{{$student->student_id}}">
                    @include('partial.cv_list')
                </div>
            </div>
        </div>




    </div>


<script>

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
                showMessage(".erroralert", "t", "danger");
            },
        });
    }
</script>


@endsection
