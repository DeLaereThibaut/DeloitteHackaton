@extends('layouts.app')

@section('content')

    <div>
        <div class="headEventsDiv">

            <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between;width: 80%; margin-left:10%;">
                <h1 class="title" style="margin-left:0px; margin-right:10px;">Events</h1>
                <div class="researchdiv" style="margin-top: 50px;">
                    <input class="form-control dropdowntri search"  type="search" name="search" id="search"
                           placeholder="Search" aria-label="Recipient's username with two button addons"
                           aria-describedby="button-addon4" style="margin-left: 0;">
                    <select class="dropdowntri"  style="cursor: pointer" id="filterBy">
                        <option>Name</option>
                        <option>Date</option>
                        <option>Country</option>
                        <option>School</option>
                        <option>Internal (Y/N)</option>
                        <option>Type</option>
                        <option>Structure</option>
                    </select>
                    <div class="input-group-append " id="button-addon4">

                        <input class="form-control dropdowntri searchButton" type="submit" value="Search" id="searchButton" onclick="filter()" style="margin-right: 10px;"/>
                    </div>
                </div>
                @if(auth()->user()->ambassadorType == "HR")
                <div class="input-group-append " id="button-addon6" style="padding-bottom:0; margin-top:50px;">
                    <input class="form-control dropdowntri searchButton" style="margin:5px 0 0 0; width: 150px; ;cursor: pointer;" type="submit" value="Add event" id="searchButton"  data-toggle="modal" data-target="#createEvent"/>
                </div>

                @endif
            </div>


        </div>
    </div>
    @include('partial.eventsList')
    @include('events.addForm')
    <script>

        function filter() {
            filters = document.getElementById('search').value;
            filterBy = document.getElementById('filterBy').value;
            {!! "baseRoute = '" . route('events.list') ."'"!!}
            if (filters != null && filters.trim() != "") {
                baseRoute = baseRoute + "/" + filterBy + "/" + filters;
            }
            window.location.replace(baseRoute);

        }
    </script>


@endsection
