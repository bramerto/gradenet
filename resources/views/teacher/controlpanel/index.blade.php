@extends('shared.dashboard')

@section('main')
        <!-- Page Content -->
<div id="page-content-wrapper">
    <div class="col-lg-12">
        <a href="{{ url('teacher/controlpanel/blocks') }}" class="block-container col-lg-3">
            <div class="control-panel-block col-lg-8 panel panel-default">
                <div class="panel-body">
                    <div class="glyphicon glyphicon-calendar"></div>
                    <span class="button-font">Periodes beheer</span>
                </div>
            </div>
        </a>
        {{--<a href="{{ url('teacher/controlpanel') }}" class="block-container col-lg-3">--}}
            {{--<div class="control-panel-block col-lg-8 panel panel-default">--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="glyphicon glyphicon-cog"></div>--}}
                    {{--<span class="button-font">Site instelling (WIP)</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</a>--}}
    </div>
</div>
@stop