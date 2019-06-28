@extends('shared.layout')

@section('content')
    <div class="container">
        <header>
            <h1><span class="accent">G</span>radenet</h1>
            <div class="goback">
                <a href="{{ URL::previous() }}">Ga terug</a>
            </div>
            <hr>
        </header>
        <div class="col-lg-6 col-md-6">
            {!! Form::open(['route' => 'sessions.store']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    {{ Form::label('email', 'E-mail:', array('class' => '')) }}
                    {{ Form::email('email', '', array('class' => 'form-control', 'data-toggle' => 'tooltip',
                                                'title' => 'Vul hier je mail in waar je op bent geregistreerd', 'data-placement' => 'right')) }}
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 div-spacer">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    {{ Form::label('password', 'Wachtwoord:', array('class' => '')) }}
                    {{ Form::password('password', array('class' => 'form-control', 'data-toggle' => 'tooltip',
                                                'title' => 'Je wachtwoord heb je gekregen van school, vul deze hier in', 'data-placement' => 'right')) }}
                </div>
            </div>
            <div>
                <div class="col-lg-4 col-md-4 col-sm-4 div-spacer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        {!! Form::submit('Login', array('class' => 'form-control btn btn-success')) !!}
                    </div>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@stop
