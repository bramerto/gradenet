@extends('shared.dashboard')

@section('main')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="col-lg-7 col-md-7 col-sm-12 table-header">
            <table class="table table-hover col-lg-12 col-md-12">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Deadline</th>
                        <th>Voortgang</th>
                    </tr>
                </thead>
                <tbody>

                @if(count($current_projects))
                    @foreach($current_projects as $current_project)
                        <tr>
                            {{--@if(strtotime($current_project->deadline) > strtotime('-3 day'))class="warning"--}}

                            {{--@elseif(strtotime($current_project->deadline) > strtotime('-7 day')) class="danger"--}}
                            {{--@endif--}}

                            <td>{{ $current_project->name }}</td>
                            <td>{{ $current_project->deadline }}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $current_project->progress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{$current_project->progress}}%;">
                                        {{ $current_project->progress }}%
                                    </div>
                                </div>
                            </td>
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
        <canvas id="competencestar" class="col-lg-5"></canvas>
    </div>
@stop