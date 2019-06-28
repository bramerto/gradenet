@extends('shared.dashboard')

@section('main')
    <div class="col-lg-12 col-md-12 col-sm-12 table-header">
        <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-project-overview">
            <thead>
            <tr>
                <th>Afgerond</th>
                <th>Project Naam</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr data-id="{{$project->id}}">
                        <td>
                            @if($project->done)<div class="glyphicon glyphicon-ok" id="done-mark"></div>
                            @else <div class="glyphicon glyphicon-remove" id="done-mark"></div>
                            @endif
                        </td>
                        <td>{{ $project->name }}</td>

                        <td>{{ Form::button('<span class="button-font"> Bekijk Project</span>', array('class' => 'btn btn-info glyphicon glyphicon-stats float-right btn-student-see-project')) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
@stop