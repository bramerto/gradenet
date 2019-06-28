@extends('shared.dashboard')

@section('main')
<!-- Page Content -->
<div class="col-lg-12 col-md-12 col-sm-12 table-header">
    <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-teacher-overview">
        <thead>
        <tr>
            <th>Code</th>
            <th>Werk Proces</th>
            <th>Kerntaak</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        {!! Form::open(array('action' => array('TeacherController@storeGrades'))) !!}
            @if(count($allProjectWorkProcesses))
                @foreach($allProjectWorkProcesses as $wp)
                    <tr data-id="{{$wp->id}}">
                        <td>{{ $wp->id }}</td>
                        <td>{{ $wp->workProcessTask }}</td>
                        <td>{{ $wp->workProcessDescription }}</td>
                        <td>{{ $wp->core_taskDescription }}</td>
                        <td>{{ Form::select('grade'. $wp->id, array(40 => "O", 60 => "V",80 => "G"), Input::old('grade'. $wp->id), array('class' => 'form-control')) }}</td>
                        <td>{{ Form::hidden('projectid', explode("/",$_SERVER['REQUEST_URI'])[3]) }}</td>
                        <td>{{ Form::hidden('id', $id = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1)) }}</td>
                    </tr>

                @endforeach
            @else
                <tr>
                    <td colspan="6" class="nothing-found">
                        <p>Geen werk processen gevonden</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="col-lg-12" style="margin-top: 20px">
    {{Form::submit('Beoordelingen invoeren', array('class' => 'btn btn-primary')) }}
    {{Form::close()}}
</div>


@stop