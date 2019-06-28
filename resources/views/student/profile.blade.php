@extends('shared.dashboard')

@section('main')
    <div id="page-content-wrapper">
        <img src="{{ URL::asset('content/img/profile_thumbnail.png') }}" alt="thumbnail" class="col-lg-3 profile-photo">
        <div class="col-lg-9 profile-info">
            <label>Naam: </label> {{ $student->firstname . ' ' . $student->lastname }} <br>
            <label>E-mail:</label> {{ $student->email }}    <br>
            <label>Klas:</label> {{ $student->className }}  <br>
            <label>Leeftijd:</label> {{ $student->age }}    <br>
            <label>Opleiding:</label> {{ $student->educationName }} <br>
            <label>Leerjaar: </label> {{ $student->year . 'e' }}
        </div>
    </div>
@stop