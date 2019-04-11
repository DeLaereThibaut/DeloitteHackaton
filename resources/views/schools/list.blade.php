@extends('layouts.app')




@section('content')

    <div class="verticalflex">
        <div class="flex" style="margin-left: 10%;width: 80%; justify-content: space-between">
                        <h1 class="title" style="margin-left: 0">Schools</h1>
                        @if(auth()->user()->ambassadorType == "HR")
                            <div class="input-group-append " id="button-addon6">
                                <input class="form-control dropdowntri"
                                       style="cursor: pointer; margin-top:50px; width: 150px; margin-right:0;" type="submit"
                                       value="Add school" id="searchButton" data-toggle="modal"
                                       data-target="#createSchool"/>
                            </div>
                        @endif
        </div>

        @if(count($schools)==0)
            <p>No schools are registered.</p>
        @else
            <div class="flex" style="width: 80%; margin-left: 10%">
                <ul style="list-style: none; width: 100%; padding:0">
                    @foreach($schools as $school)

                        <li>
                            <a href="{{route('school.detail', ['id'=> $school->school_id])}}" class="link">
                                <div>
                                    <div class="card event" style="width: auto">
                                        <div class="card-header head">
                                            <h2>{{$school->name}}</h2>
                                        </div>
                                        <div class="card-body" style="height: 100px">
                                            <div class="innerDiv date" style="font-size:1.3em">
                                                <p>{{$school->address}}</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="d-flex justify-content-center mt-2 mb-4">
                {{ $schools->links() }}
            </div>


        @endif

    </div>
    @include('schools.addSchoolForm')

@endsection
