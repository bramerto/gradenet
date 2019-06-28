@extends('shared.dashboard')

@section('main')

    <div class="col-lg-12 col-md-12 col-sm-12 table-header">
        <span class="col-lg-3 col-md-3 search-bar">
            <input type="text" class="form-control" id="studentfilter" onkeyup="Filter()" placeholder="Search for names..">
        </span>

        <table class="table-hover col-lg-12 col-md-12 col-sm-12" id="table-teacher-overview">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>E-mail</th>
                    <th>Leeftijd</th>
                    <th>Opleiding</th>
                    <th>Klas</th>
                    <th>Leerjaar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if(count($students))
                @foreach($students as $student)
                    <tr data-id="{{$student->id}}">
                        <td>{{ $student->firstname . ' ' . $student->lastname }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->age }}</td>
                        <td>{{ $student->educationName }}</td>
                        <td>{{ $student->className }}</td>
                        <td>{{ $student->year . 'e' }}</td>
                        <td>{{ Form::button('<span class="button-font"> Bekijk student</span>', array('class' => 'btn btn-info glyphicon glyphicon-stats btn-see-student')) }}</td>
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

        <script>
            function Filter() {
                var input, filter, table, tr, td, i;
                input = document.getElementById("studentfilter");
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

