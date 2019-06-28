@extends('shared.dashboard')

@section('main')
    <div id="page-content-wrapper">

        {{ Form::hidden('id', $project->id, array('id' => 'projectId')) }}
        <div class="col-lg-12">
            <img src="{{ URL::asset('content/img/project_thumbnail.jpg') }}" alt="thumbnail" class="col-lg-3 project-photo">
            <div class="col-lg-6 project-info">
                <label>Naam: </label> <p>{{ $project->name }}</p>
                <label>Beschrijving: </label> <p> {{ $project->description }}  </p>
            </div>
            <div class="col-lg-3">
                <div class="col-lg-6" data-toggle="modal" data-target="#editProjectModal">
                    {{
                        Form::button('<span class="button-font"><span class="spacer"></span>Wijzig Project</span>', array(
                                                                            'class' => 'btn btn-warning glyphicon glyphicon-pencil',
                                                                            'data-toggle' => 'tooltip',
                                                                            'title' => 'Wijzig dit project',
                                                                            'data-placement' => 'left'))
                    }}
                </div>
                <div>
                    {{ Form::button('<span class="button-font"> Beoordeel project</span>', array('class' => 'btn btn-warning glyphicon glyphicon-tasks btn-score-project')) }}
                </div>
            </div>
            <div style="right: 10px; position: absolute; padding: 8px;">
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
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($students))
                        @foreach($students as $student)
                            <tr data-id="{{ $student->id }}" data-toggle="collapse" data-target="#student{{ $student->id }}" class="accordion-toggle">
                                <td> {{ $student->firstname . ' ' . $student->lastname }} </td>
                                <td> {{ $student->email }} </td>
                                <td> {{ $student->className }} </td>
                                <td> {{ $student->classYear }} </td>
                                <td> {{ $student->educationName }} </td>
                                <td> {{ $student->projectStart . ' - ' . $student->projectDeadline }} </td>
                                <td>
                                    <div class="glyphicon glyphicon-menu-down"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="hiddenRow">
                                    <div class="accordian-body collapse" id="student{{ $student->id }}">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Code</th>
                                                <th>Kerntaak</th>
                                                <th>Werkproces</th>
                                                <th>Score</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(count($student->workprocesses))
                                                @foreach($student->workprocesses as $studentWorkProcesses)

                                                        @if($studentWorkProcesses->score == 40) <?php $studentWorkProcesses->score = "O"; ?> @endif
                                                        @if($studentWorkProcesses->score == 60) <?php $studentWorkProcesses->score = "V"; ?> @endif
                                                        @if($studentWorkProcesses->score == 80) <?php $studentWorkProcesses->score = "G"; ?> @endif

                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $studentWorkProcesses->task }}</td>
                                                        <td>{{ $studentWorkProcesses->core_task }}</td>
                                                        <td>{{ $studentWorkProcesses->description }}</td>
                                                        <td>{{ $studentWorkProcesses->score }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="nothing-found">
                                                        <p>Geen scores gevonden</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
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
                <div class="col-lg-12" id="project-student-dropdown">
                    {{ Form::button('Voeg student toe', array('class' => 'btn btn-primary col-lg-3', 'data-toggle' => 'modal', 'data-target' => '#addPeriodToUserProjectModal')) }}
                </div>
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
                    @if(count($workprocessess))
                        @foreach($workprocessess as $workprocess)
                            <tr>
                                <td>{{ $workprocess->workProcessTask }}</td>
                                <td>{{ $workprocess->core_taskDescription }}</td>
                                <td>{{ $workprocess->workProcessDescription }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="nothing-found">
                                <p>Geen werkprocessen gevonden</p>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="col-lg-12" id="work-processes-dropdown">
                    {{ Form::select('work_process', $selectWorkProcesses, '' , array('class' => 'selectpicker col-lg-8', 'id' => 'select-workProcess', 'data-live-search' => 'true')) }}
                    {{ Form::button('Voeg werkproces toe', array('class' => 'btn btn-primary col-lg-4', 'id' => 'addWorkProcess')) }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editProjectModalLabel">Wijzig huidig project</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open() !!}
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('name', 'Naam') }}
                            {{ Form::text('name', $project->name, array('class' => 'form-control')) }}
                            <p class="has-error">{{ $errors->first('name') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('description', 'Beschrijving') }}
                            {{ Form::textarea('description', $project->description, array('class' => 'form-control')) }}
                            <p class="has-error">{{ $errors->first('description') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button('Close', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
                    {!! Form::submit('Wijzig project!', array('class' => 'btn btn-primary', '')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPeriodToUserProjectModal" tabindex="-1" role="dialog" aria-labelledby="addPeriodToUserProjectModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addPeriodToUserProjectModalLabel">New project</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open() !!}
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('project_student', 'Student') }}
                            {{ Form::select('project_student', $selectStudents, '' , array('class' => 'selectpicker col-lg-12', 'id' => 'select-project-student', 'data-live-search' => 'true')) }}
                        </div>
                    </div>
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('project_student_period', 'Periode') }}
                            {{ Form::select('project_student_period', $blocks, '' , array('class' => 'selectpicker col-lg-12', 'id' => 'select-project-student-period')) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button('Close', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
                    {!! Form::submit('Voeg student toe aan project', array('class' => 'btn btn-primary', 'id' => 'addUserToProject')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @if (Session::get('edit_project'))
        <script>
            $(function() {
                swal (
                    'Edited!',
                    'This project has been edited.',
                    'success'
                )
            });
        </script>
    @endif
@stop