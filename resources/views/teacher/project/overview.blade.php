@extends('shared.dashboard')

@section('main')
        <span data-toggle="modal" data-target="#newProjectModal">
            {{
                Form::button('<span class="button-font"><span class="spacer"></span>Nieuw Project</span>', array(
                                                                        'class' => 'btn btn-primary glyphicon glyphicon-plus',
                                                                        'id' => 'btn-new-modal',
                                                                        'data-toggle' => 'tooltip',
                                                                        'title' => 'Voeg een nieuw project toe',
                                                                        'data-placement' => 'left'))
            }}
        </span>

    <div class="col-lg-12 col-md-12 col-sm-12 table-header">
        <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-teacher-project-overview">
            <thead>
                <tr>
                    <th>Afgerond</th>
                    <th>Project Naam</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if(count($projects))
                @foreach($projects as $project)
                    <tr data-id="{{$project->id}}">
                        <td>
                            @if($project->done)<div class="glyphicon glyphicon-ok" id="done-mark"></div>
                            @else <div class="glyphicon glyphicon-remove" id="done-mark"></div>
                            @endif
                        </td>
                        <td>{{ $project->name }}</td>
                        <td>
                            {{ Form::button('', array('class' => 'btn btn-danger glyphicon glyphicon-trash float-right btn-delete-project')) }}
                            <span class="spacer float-right"></span>
                            {{ Form::button('<span class="button-font"> Beoordeel project</span>', array('class' => 'btn btn-warning glyphicon glyphicon-tasks btn-score-project float-right')) }}
                            <span class="spacer float-right"></span>
                            {{ Form::button('<span class="button-font"> Bekijk project</span>', array('class' => 'btn btn-info glyphicon glyphicon-stats btn-see-project float-right')) }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="nothing-found">
                        <p>Geen project(en) gevonden</p>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-labelledby="newProjectModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="newProjectModalLabel">New project</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open() !!}
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('name', 'Naam') }}
                            {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                            <p class="has-error">{{ $errors->first('name') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('description', 'Beschrijving') }}
                            {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
                            <p class="has-error">{{ $errors->first('description') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button('Close', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
                    {!! Form::submit('Maak nieuw project!', array('class' => 'btn btn-primary')) !!}
                </div>
            </div>
        </div>
    </div>

    @if (Session::get('add_project'))
        <script>
            $(function() {
                swal (
                        'Added!',
                        'This project has been added.',
                        'success'
                )
            });
        </script>
    @endif
@stop