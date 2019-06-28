@extends('shared.dashboard')

@section('main')
    <div class="col-lg-12 col-md-12 col-sm-12 table-header">
        {{ Form::hidden('id', $projectId, array('id' => 'projectId')) }}
        <div class="goback">
            <a href="{{ URL::previous() }}">Ga terug</a>
        </div>
        <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-project-useroverview">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>E-mail</th>
                    <th>Leeftijd</th>
                    <th>Leerjaar</th>
                    <th>Opleiding</th>
                    <th>Project periode</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if(count($students))
                @foreach($students as $student)
                    <tr data-id="{{ $student->id }}">
                        <td> {{ $student->firstname . ' ' . $student->lastname }} </td>
                        <td> {{ $student->email }} </td>
                        <td> {{ $student->className }} </td>
                        <td> {{ $student->classYear }} </td>
                        <td> {{ $student->educationName }} </td>
                        <td> {{ $student->projectStart . ' - ' . $student->projectDeadline }} </td>
                        <td>
                            {{ Form::button('<span class="button-font"> Beoordeel deze student</span>', array(
                                    'class' => 'btn btn-info glyphicon glyphicon-stats btn-score-student float-right'))
                            }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="nothing-found">
                        <p>Geen studenten gevonden</p>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>

    @if (Session::get('not_found'))
        <script>
            $(function() {
                swal (
                        'Scores not found',
                        'Add work processes to this project to score on it',
                        'error'
                )
            });
        </script>
    @endif
@stop