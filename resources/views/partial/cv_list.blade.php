




<div class="verticalflex" style="height: 100%">
    <div class="verticalflex" style="height: 80%; width: 100%;">
        <div class="flex" style="justify-content: center">
            <label for="avatar"><h3>CV of the student</h3></label>
        </div>

        <ul style="overflow-y: scroll; height:100%;max-height: 100%">
            @foreach(\Illuminate\Support\Facades\Storage::disk('public')->files('CV/' . $student->student_id) as $file)
                <a href="{{route('events.get_student_cv', ['id' => $student->student_id, 'name'=>basename($file)])}}"><li>{{basename($file)}} </li></a>
                <hr>
            @endforeach
        </ul>
    </div>
    <div class="flex" style="height: 20%; width: 100%; justify-content: center;margin-top:10%">
        <input type="file" id="CV_{{$student->student_id}}" style="background-color: white;height:50%; margin-top: 10%" name="CV" onchange="uploadFile_{{$student->student_id}}(this)">
    </div>
</div>