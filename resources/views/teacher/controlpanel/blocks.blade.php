@extends('shared.dashboard')

@section('main')
    <div class="col-lg-12 col-md-12 col-sm-12 table-header">
        <div class="goback">
            <a href="{{url('teacher/controlpanel')}}">Ga terug</a>
        </div>
        <span data-toggle="modal" data-target="#newPeriodModal">
            {{
                Form::button('<span class="button-font"><span class="spacer"></span>Nieuwe periode</span>', array(
                                                                        'class' => 'btn btn-primary glyphicon glyphicon-plus',
                                                                        'id' => 'btn-new-modal',
                                                                        'data-toggle' => 'tooltip',
                                                                        'title' => 'Voeg een nieuwe periode toe',
                                                                        'data-placement' => 'left'))
            }}
        </span>
        <table class="table-hover col-lg-12 col-md-12 col-sm-12">
            <thead>
            <tr>
                <th>Periode</th>
                <th>Startdatum</th>
                <th>Eind datum</th>
                <th>School jaar</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($blocks))
                @foreach($blocks as $block)
                    <tr data-id="{{$block->id}}">
                        <td class="blockNumber">{{ $block->period }}</td>
                        <td class="date_start">{{ $block->date_start }}</td>
                        <td class="date_end">{{ $block->date_end }}</td>
                        <td data-id="{{ $block->schoolyearId }}" class="schoolyearId">{{ $block->schoolyear }}</td>
                        <td>
                            {{ Form::button('', array('class' => 'btn btn-danger glyphicon glyphicon-trash float-right btn-delete-period')) }}
                            <span class="spacer float-right"></span>
                            {{ Form::button('<span class="button-font"> Wijzig periode</span>', array(
                                            'class' => 'btn btn-warning glyphicon glyphicon-pencil float-right btn-modal-edit-period',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#editPeriodModal',
                                        )
                                )
                            }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="nothing-found">-
                        <p>Geen periodes gevonden</p>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="newPeriodModal" tabindex="-1" role="dialog" aria-labelledby="newPeriodModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="newPeriodModalLabel">Nieuwe periode</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('id' => 'add-period')) !!}
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('period', 'Periode') }}
                            {{ Form::number('period', Input::old('period'), array('class' => 'form-control', 'max' => 100, 'min' => 1)) }}
                            <p class="has-error" id="periodError">{{ $errors->first('period') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-6">
                        <div class="form-group">
                            {{ Form::label('date_start', 'Start datum') }}
                            <input type='text' name="date_start" class="form-control datepicker" value="{{  Input::old('date_start') }}"/>
                            <p class="has-error date_startError">{{ $errors->first('date_start') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-6">
                        <div class="form-group">
                            {{ Form::label('date_end', 'Eind datum') }}
                            <input type='text' name="date_end" class="form-control datepicker" value="{{  Input::old('date_end') }}"/>
                            <p class="has-error" id="date_endError">{{ $errors->first('date_end') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('schoolyear', 'Schooljaar') }}
                            {{ Form::select('schoolyear', $schoolyears, '', array('class' => 'form-control selectpicker')) }}
                            <p class="has-error" id="schoolyearError">{{ $errors->first('schoolyear') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ Form::button('Close', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
                    {!! Form::submit('Voeg nieuwe periode toe!', array('class' => 'btn btn-primary btn-add-period')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPeriodModal" tabindex="-1" role="dialog" aria-labelledby="editPeriodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editPeriodModalLabel">Edit period</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('url' => 'teacher/controlpanel/block/edit','id' => 'add-period')) !!}
                    {{ Form::hidden('id', '', array('id' => 'periodId')) }}
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('editPeriod', 'Periode') }}
                            {{ Form::number('editPeriod', Input::old('editPeriod'), array('class' => 'form-control', 'max' => 100, 'min' => 1)) }}
                            <p class="has-error" id="editPeriodError">{{ $errors->first('editPeriod') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-6">
                        <div class="form-group">
                            {{ Form::label('editDate_start', 'Start datum') }}
                            <input type='text' name="editDate_start" class="form-control datepickeredit" value="{{  Input::old('editDate_start') }}"/>
                            <p class="has-error editDate_startError">{{ $errors->first('editDate_start') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-6">
                        <div class="form-group">
                            {{ Form::label('editDate_end', 'Eind datum') }}
                            <input type='text' name="editDate_end" class="form-control datepickeredit" value="{{  Input::old('editDate_end') }}"/>
                            <p class="has-error" id="editDate_endError">{{ $errors->first('editDate_end') }}</p>
                        </div>
                    </div>
                    <div class=" col-lg-12">
                        <div class="form-group">
                            {{ Form::label('editSchoolyear', 'Schooljaar') }}
                            {{ Form::select('editSchoolyear', $schoolyears, Input::old('editSchoolyear'), array('class' => 'form-control selectpicker')) }}
                            <p class="has-error" id="editSchoolyearError">{{ $errors->first('editSchoolyear') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Wijzig deze periode!', array('class' => 'btn btn-primary btn-edit-period')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @if ($errors->first('period') || $errors->first('date_start') || $errors->first('date_end') || $errors->first('schoolyear'))
        <script>
            $(function() {
                $('#btn-new-modal').trigger('click');
            });
        </script>

    @elseif($errors->first('editPeriod') || $errors->first('editDate_start') || $errors->first('editDate_end') || $errors->first('editSchoolyear'))
        <script>
            $(function() {

                var periodId = {{ Input::old('id') }};

                if(periodId) {

                    $('tr[data-id="{{ Input::old('id') }}"]').find('.btn-modal-edit-period').trigger('click',
                            [{
                                id: periodId
                            }]
                    );
                }
            });
        </script>
    @endif

    @if (Session::get('add_period'))
        <script>
            $(function() {
                swal (
                    'Added!',
                    'This period has been added.',
                    'success'
                )
            });
        </script>

    @elseif (Session::get('edit_period'))
        <script>
            $(function() {
                swal (
                    'Edited!',
                    'This period has been edited',
                    'success'
                )
            });
        </script>
    @endif
@stop