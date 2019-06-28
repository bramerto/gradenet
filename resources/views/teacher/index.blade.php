@extends('shared.dashboard')

@section('main')
        <!-- Page Content -->
<div id="page-content-wrapper">
    <div class="col-lg-7 col-md-12 col-sm-12 table-header">
        <table class="table table-hover col-lg-12 col-md-12" id="table-teacher-project-overview">
            <thead>
            <tr>
                <th>Periode</th>
                <th>Project</th>
                <th>Startdatum</th>
            </tr>
            </thead>
            <tbody>
            @if(count($projects))
                @foreach($projects as $project)
                    <tr data-id="{{ $project->id }}">
                        <td>{{ $project->period }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->date_start }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="nothing-found">
                        <p>Geen projecten gevonden</p>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@stop