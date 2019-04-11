@extends('layouts.app')

@section('content')
    <div style="display: flex; flex-direction: column; flex-wrap: nowrap">

        <div class="card-header" style=" width: 86%; margin-left:7%; margin-top:50px;">Erreur 404</div>
        <div class="flex card-body" style="height: auto; width: 86%; margin-left:7%; background-color: white">
            <div class="verticalflex" style="width: 100%;">
                <div>
                    <p><b>Sorry! The page you requested cannot be found.</b><br/>
                        The page you have selected may moved or is no longer available.</p>
                </div>
                <div>
                    <hr>
                </div>

                <div class="flex">
                    <a href="{{route('home')}}">&lt; Back to homepage</a>
                </div>
            </div>
        </div>

        </div>



@endsection
