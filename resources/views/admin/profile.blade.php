@extends('shared.dashboard')

@section('main')
    <div id="page-content-wrapper">
        <img src="{{ URL::asset('content/img/profile_thumbnail.png') }}" alt="thumbnail" class="col-lg-3 profile-photo">
        <div class="col-lg-9 profile-info">
            <label>Naam: </label> {{ $user->firstname . ' ' . $user->lastname }} <br>
            <label>E-mail:</label> {{ $user->email }}    <br>
            <label>Leeftijd:</label> {{ $user->age }}
        </div>
    </div>
@stop