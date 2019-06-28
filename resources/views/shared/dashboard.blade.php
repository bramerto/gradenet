@extends('shared.layout')

@section('content')

    <div id="wrapper">
        <div id="sidebar-wrapper">
            <nav>
                <ul class="sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="#">
                            @foreach($navigationItems as $link => $navigationItem)
                                @if($link == '/student' || $link == '/teacher' || $link == '/admin')
                                    <a href="{{url($link)}}">{{$navigationItem}}</a>
                                @endif
                            @endforeach
                        </a>
                    </li>
                    @foreach(array_slice($navigationItems, 1) as $link => $navigationItem)
                        <li>
                            <a href="{{url($link)}}">{{$navigationItem}}</a>
                        </li>
                    @endforeach
                    <li id="logout">
                        <a href="{{ url('/logout') }}">Uitloggen</a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="main">
            @yield('main')
        </div>
    </div>
@stop