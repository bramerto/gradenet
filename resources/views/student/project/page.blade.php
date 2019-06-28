@extends('shared.dashboard')

@section('main')
    <div id="page-content-wrapper">
        {{ Form::hidden('id', $project->id, array('id' => 'projectId')) }}
        <div class="col-lg-12 project-info">

            <img src="{{ URL::asset('content/img/project_thumbnail.jpg') }}" alt="thumbnail" class="col-lg-3 project-photo">
            <div class="col-lg-6">
                <label>Naam: </label>           <p>{{ $project->name }}</p>
                <label>Beschrijving: </label>   <p> {{ $project->description }}  </p>
            </div>
            <div class="col-lg-3">
                {{ Form::button('<span class="button-font"> Zie jouw projectscores</span>', array('class' => 'btn btn-warning glyphicon glyphicon-eye-open',
                'data-toggle' => 'modal', 'data-target' => '#seeProjectScores')) }}
            </div>
            <div class="btn btn-link">
                <a href="{{ URL::previous() }}">Ga terug</a>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-7 col-md-7 col-sm-12 table-header">
                <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-project-useroverview">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>E-mail</th>
                        <th>Klas</th>
                        <th>Leerjaar</th>
                        <th>Opleiding</th>
                        <th>Project periode</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($projectStudents))
                        @foreach($projectStudents as $projectStudent)
                            <tr data-id="{{ $projectStudent->id }}" data-toggle="collapse" data-target="#student{{ $projectStudent->id }}" class="accordion-toggle">
                                <td> {{ $projectStudent->firstname . ' ' . $projectStudent->lastname }} </td>
                                <td> {{ $projectStudent->email }} </td>
                                <td> {{ $projectStudent->className }} </td>
                                <td> {{ $projectStudent->classYear }} </td>
                                <td> {{ $projectStudent->educationName }} </td>
                                <td> {{ $projectStudent->projectStart . ' - ' . $projectStudent->projectDeadline }} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="nothing-found">
                                <p>Geen studenten gevonden voor dit project!</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>

                </table>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 table-header">
                <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-project-workoverview">
                    <thead>
                    <tr>
                        <th>Werkproces Code</th>
                        <th>Kerntaak</th>
                        <th>Workproces</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($projectWorkProcesses))
                        @foreach($projectWorkProcesses as $projectWorkProcess)
                            <tr>
                                <td>{{ $projectWorkProcess->workProcessTask }}</td>
                                <td>{{ $projectWorkProcess->core_taskDescription }}</td>
                                <td>{{ $projectWorkProcess->workProcessDescription }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">
                                <p>Geen werkprocesses gevonden voor dit project!</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="seeProjectScores" tabindex="-1" role="dialog" aria-labelledby="seeProjectScoresLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="seeProjectScoresLabel">Project scores</h4>
                </div>
                <div class="modal-body">
                    <table class="col-lg-12">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Code</th>
                                <th>Werkproces</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($studentScores))
                            @foreach($studentScores as $studentScore)
                                @if($studentScore->score == 40){{$studentScore->score = "O"}}@endif
                                @if($studentScore->score == 60){{$studentScore->score = "V"}}@endif
                                @if($studentScore->score == 80){{$studentScore->score = "G"}}@endif
                                <tr>
                                    <td></td>
                                    <td>{{ $studentScore->task }}</td>
                                    <td>{{ $studentScore->description }}</td>
                                    <td>{{ $studentScore->score }}</td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="4">
                                <p>Geen scores gevonden voor dit project!</p>
                            </td>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop