@extends('shared.dashboard')

@section('main')
    <div id="page-content-wrapper">
        <div class="col-lg-12 profile-info">
            <div class="col-lg-2">
                <img src="{{ URL::asset('content/img/profile_thumbnail.png') }}" alt="thumbnail" class="profile-photo">
            </div>
            <div class="col-lg-9">
                <label>Naam: </label> {{ $student->firstname . ' ' . $student->lastname }} <br>
                <label>E-mail:</label> {{ $student->email }}    <br>
                <label>Klas:</label> {{ $student->className }}  <br>
                <label>Leeftijd:</label> {{ $student->age }}    <br>
                <label>Opleiding:</label> {{ $student->educationName }} <br>
                <label>Leerjaar: </label> {{ $student->year . 'e' }}
            </div>
            <div class="goback">
                <a href="{{ URL::previous() }}">Ga terug</a>
            </div>
        </div>

        <div class="col-lg-7 col-md-7 col-sm-12 table-header">
            <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-project-profile-overview">
                <thead>
                <tr>
                    <th>Project Naam</th>
                    <th>Project gestart</th>
                    <th>Project deadline</th>
                    <th>Afgerond</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if(count($projects))
                    @foreach($projects as $project)
                        <tr data-id="{{$project->id}}">
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->projectStart }}</td>
                            <td>{{ $project->projectDeadline }}</td>
                            <td>
                                @if($project->done)<div class="glyphicon glyphicon-ok" id="done-mark"></div>
                                @else <div class="glyphicon glyphicon-remove" id="done-mark"></div>
                                @endif
                            </td>

                            <td>{{ Form::button('<span class="button-font"> Bekijk Project</span>', array('class' => 'btn btn-info glyphicon glyphicon-stats btn-see-project-teacher')) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="nothing-found">
                            <p>Geen projecten gevonden</p>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <canvas id="competencestar" class="col-lg-5"></canvas>
        {{ Form::hidden('studentId', $student->id, array('id' => 'studentid')) }}
    </div>
@stop