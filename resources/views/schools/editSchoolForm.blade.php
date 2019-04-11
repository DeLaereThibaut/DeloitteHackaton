<div class="modal fade" tabindex="-1" role="dialog" id="editSchool">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert" class="erroralert">

                </div>
                <div class="form-group">
                    <label for="schoolname">School Name</label>
                    <input type="text" class="form-control" id="schoolname" value="{{$school->name}}">
                </div>
                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text" class="form-control" id="website" value="{{$school->website}}">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" value="{{$school->address}}">
                </div>
                <div class="form-group">
                    <label for="tp">Targeted Profiles</label>
                    <select id="tp" class="form-control" multiple aria-describedby="tpHelp">
                        @foreach(\App\Models\TargetedProfile::all() as $pf)
                            <option
                                value="{{$pf->id}}" {{($school->targetProfiles->contains($pf)?'selected':'')}}>{{$pf->name}}</option>
                        @endforeach

                    </select>
                    <small id="tpHelp" class="form-text text-muted">CTRL+click to select multiple.</small>
                </div>
                <div class="form-group">
                    <label for="sponsored">Sponsored amount :</label>
                    <input type="text" class="form-control" id="sponsored" value="{{$school->sponsored}}">
                </div>
                <div class="form-group">
                    <label for="is">Internal Structure</label>
                    <select id="is" class="form-control">
                        @foreach(\App\Models\InternalStructure::all() as $is)
                            <option
                                value="{{$is->id}}" {{($school->internalStructures->id == $is->id?'selected':'')}}>{{$is->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="ambassadors">Ambassadors</label>
                    <select id="ambassadors_{{$school->school_id}}" class="form-control" multiple aria-describedby="tpHelp">
                        @foreach(\App\User::all() as $pf)
                            <option value="{{$pf->user_id}}" {{($school->ambassador->contains($pf)?'selected':'')}}>{{$pf->username}}</option>
                        @endforeach
                    </select>
                    <small id="tpHelp" class="form-text text-muted">CTRL+click to select multiple.</small>
                </div>
                <div class="form-group check">
                    <label for="targeted">Targeted?</label>
                    <input type="checkbox" class="form-control myCheckbox"
                           id="targeted" {{($school->targeted == 1?'checked':'')}}>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveChanges" onclick="editSchool()">Save changes
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>

    function editSchool() {
            {{'let school_id= ' . $school->school_id}}
        let schoolname = document.getElementById('schoolname').value;
        let website = document.getElementById('website').value;
        let address = document.getElementById('address').value;
        let internal_structure = document.getElementById('is').value;
        let targeted_profiles = getSelectValues(document.getElementById('tp'));
        let ambassadors = getSelectValues(document.getElementById('ambassadors_{{$school->school_id}}'));
        let targeted;
        let sponsored = document.getElementById('sponsored').value;
        if (document.getElementById('targeted').checked) {
            targeted = 1;
        } else {
            targeted = 0;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('school.editSchool')}}",
            type: "POST",
            data: {
                school_id: school_id,
                schoolname: schoolname,
                website: website,
                address: address,
                internal_structure: internal_structure,
                targeted_profiles: targeted_profiles,
                sponsored: sponsored,
                targeted: targeted,
                ambassador: ambassadors,
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
                console.log(jqXHR, exception);
                showMessage(".erroralert", json_doc, "danger");
            },
            complete: function (result, status) {
                console.log(result);
            }

        });
    }

    function getSelectValues(el) {
        let result = [];
        let options = el.options;
        for (var i = 0; i < options.length; i++) {
            let opt = options[i];
            if (opt.selected) {
                result.push(opt.value);
            }
        }
        return result;
    }
</script>
