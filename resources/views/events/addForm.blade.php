<div class="modal fade" tabindex="-1" role="dialog" id="createEvent">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert" class="erroralert">

                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name">
                </div><div class="form-group">
                    <label for="types">Type</label>
                    <select class="form-control"  id="types">
                        @foreach(\App\Models\EventType::all() as $et)
                            <option value="{{$et->id}}">{{$et->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="school">School</label>
                    <select class="form-control" id="school" >
                        @foreach(\App\Models\School::orderBy('name')->get() as $school)
                            <option value="{{$school->school_id}}">{{$school->name}}</option>
                        @endforeach
                    </select>
                </div>

                            <div class="form-group">
                                <label for="date_beginning">From</label>

                                <div class="row">
                                    <div class="form-group  col">

                                        <input type="date" id="date_beginning" class="form-control col"/>

                                    </div><div class="form-group  col">

                                        <input type="number" id="date_beginning_h" class="form-control">

                                    </div>
                                    <p>:</p>
                                    <div class="form-group  col">

                                        <input type="number" id="date_beginning_m" class="form-control">

                                    </div>
                                </div>
                            </div>

                <div class="form-group">
                    <label for="date_end">To</label>

                    <div class="row">
                        <div class="form-group col">
                            <input type="date" id="date_end" class="form-control col"/>
                        </div>
                        <div class="form-group  col">

                            <input type="number" id="date_end_h" class="form-control">

                        </div>
                        <p>:</p>
                        <div class="form-group  col">

                            <input type="number" id="date_end_m" class="form-control">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="school">Fiscal Year</label>
                        <select class="form-control" id="fiscalYear" >
                            <option>{{\Carbon\Carbon::now()->addYear(-1)->year}}</option>
                                <option selected>{{\Carbon\Carbon::now()->year}}</option>
                            <option>{{\Carbon\Carbon::now()->addYear(1)->year}}</option>
                            <option>{{\Carbon\Carbon::now()->addYear(2)->year}}</option>
                            <option>{{\Carbon\Carbon::now()->addYear(3)->year}}</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group  col">
                            <label for="location">Location</label>
                            <input type="text" id="location" class="form-control">

                        </div>
                        <div class="form-group col">
                            <label for="country">Country</label>
                            <select id="country" class="form-control">
                                @foreach(\App\Models\Country::all() as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" min="0.0" step="0.1" id="price" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="is">Internal Structure</label>
                        <select id="is" class="form-control">
                            @foreach(\App\Models\InternalStructure::all() as $is)
                                <option value="{{$is->id}}">{{$is->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tp">Targeted Profiles</label>
                        <select id="tp" class="form-control" multiple aria-describedby="tpHelp">
                            @foreach(\App\Models\TargetedProfile::all() as $pf)
                                <option value="{{$pf->id}}">{{$pf->name}}</option>
                            @endforeach
                        </select>
                        <small id="tpHelp" class="form-text text-muted">CTRL+click to select multiple.</small>
                    </div>
                    <div class="form-group">
                        <label for="ambassadors">Ambassadors</label>
                        <select id="ambassadors" class="form-control" multiple aria-describedby="tpHelp">
                            @foreach(\App\User::all() as $pf)
                                <option value="{{$pf->user_id}}">{{$pf->username}}</option>
                            @endforeach
                        </select>
                        <small id="tpHelp" class="form-text text-muted">CTRL+click to select multiple.</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="internal">
                        <label class="form-check-label" for="internal">
                            Internal
                        </label>
                    </div>
                </div>
                </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveEvent()">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function saveEvent(){
        let internal;
        if (document.getElementById('internal').checked) {
            internal = 1;
        } else {
            internal = 0;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('events.addEvent')}}",
            type: "POST",
            data: {
                name     : document.getElementById('name').value,
                type     : document.getElementById('types').value,
                school   : document.getElementById('school').value,
                date_of_beginning   : document.getElementById('date_beginning').value,
                date_of_beginning_hour : parseInt(document.getElementById('date_beginning_h').value),
                date_of_beginning_minutes : parseInt(document.getElementById('date_beginning_m').value),
                date_of_end   : document.getElementById('date_end').value,
                date_of_end_hour : parseInt(document.getElementById('date_end_h').value),
                date_of_end_minutes : parseInt(document.getElementById('date_end_m').value),
                fiscalYear : document.getElementById('fiscalYear').value,
                location : document.getElementById('location').value,
                country  : document.getElementById('country').value,
                price    : document.getElementById('price').value,
                internal_structure       : document.getElementById('is').value,
                isInternal : internal,
                targeted_profiles : getSelectValues(document.getElementById('tp')),
                ambassadors : getSelectValues(document.getElementById('ambassadors'))
            },
            dataType: "html",
            success: function (json_doc) {
                console.log(json_doc);
                r = JSON.parse(json_doc);
                if(r.result){
                    showMessage("#general_alert", r.message, "success");
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

   function showMessage(where, element, type){
        $(where).html("<div class='alert alert-" + type + "'>"+element+"</div>");
           $('#createEvent').animate({ scrollTop: 0 }, 'slow');

    }
    function getSelectValues(el) {
        let result = [];
        let options = el.options;
        for (var i=0; i<options.length; i++) {
            let opt = options[i];
            if (opt.selected) {
                result.push(opt.value);
            }
        }
        return result;
    }
</script>
