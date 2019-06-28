@extends('shared.dashboard')

@section('main')
    <span data-toggle="modal" data-target="#newStudentModal">
        {{
            Form::button('<span class="button-font"><span class="spacer"></span>Nieuwe gebruiker</span>', array(
                                                                    'class' => 'btn btn-primary glyphicon glyphicon-plus',
                                                                    'id' => 'btn-new-modal',
                                                                    'data-toggle' => 'tooltip',
                                                                    'title' => 'Voeg een nieuwe gebruiker toe',
                                                                    'data-placement' => 'left'))
        }}
    </span>

    <div class="col-lg-12 col-md-12 col-sm-12 table-header">
        <span class="col-lg-3 col-md-3 search-bar">
            <input type="text" class="form-control" id="userfilter" onkeyup="Filter()" placeholder="Search for names..">
        </span>

        <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-teacher-overview">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Rol</th>
                    <th>E-mail</th>
                    <th>Leeftijd</th>
                    <th>Opleiding</th>
                    <th>Klas</th>
                    <th>Leerjaar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr data-id="{{$user->id}}">
                    <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
                    <td>{{ $user->roleName}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->age }}</td>
                    <td>{{ $user->educationName }}</td>
                    <td>{{ $user->className }}</td>
                    <td>{{ $user->year . 'e' }}</td>
                    <td>{{ Form::button('<span class="button-font"> Edit user</span>', array('class' => 'btn btn-info glyphicon glyphicon-cog btn-see-student')) }}</td>
                    <td>{{ Form::button('', array('class' => 'btn btn-danger glyphicon glyphicon-trash btn-delete-project')) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="newStudentModal" tabindex="-1" role="dialog" aria-labelledby="newStudentModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="newStudentModalLabel">Nieuwe gebruiker</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open() !!}
                        <div class=" col-lg-12">
                            <div class="form-group">
                                {{ Form::label('email', 'Email') }}
                                {{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
                                <p class="has-error">{{ $errors->first('email') }}</p>
                            </div>
                        </div>
                        <div class=" col-lg-12">
                            <div class="form-group">
                                {{ Form::label('firstname', 'Voornaam') }}
                                {{ Form::text('firstname', Input::old('firstname'), array('class' => 'form-control')) }}
                                <p class="has-error">{{ $errors->first('firstname') }}</p>
                            </div>
                        </div>
                        <div class=" col-lg-12">
                            <div class="form-group">
                                {{ Form::label('lastname', 'Achternaam') }}
                                {{ Form::text('lastname', Input::old('lastname'), array('class' => 'form-control')) }}
                                <p class="has-error">{{ $errors->first('lastname') }}</p>
                            </div>
                        </div>
                        <div class=" col-lg-3">
                            <div class="form-group">
                                {{ Form::label('age', 'Leeftijd') }}
                                {{ Form::number('age', Input::old('age'), array('class' => 'form-control', 'max' => 200, 'min' => 1)) }}
                                <p class="has-error">{{ $errors->first('age') }}</p>
                            </div>
                        </div>
                        <div class=" col-lg-12">
                            <div class="form-group">
                                {{ Form::label('class', 'Klas') }}
                                {{ Form::select('class', array('1' => "VCIT3G4"), '', array('class' => 'selectpicker col-lg-10')) }}
                                <p class="has-error">{{ $errors->first('class') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Close', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) }}
                        {!! Form::submit('Maak nieuw gebruiker aan!', array('class' => 'btn btn-primary', 'data-toggle' => 'tooltip', 'title' => 'Wachtwoord word automatisch gegenereerd')) !!}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <script>
            function Filter() {
                var input, filter, table, tr, td, i;
                input = document.getElementById("userfilter");
                filter = input.value.toUpperCase();
                table = document.getElementById("table-teacher-overview");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
    </div>
@stop

