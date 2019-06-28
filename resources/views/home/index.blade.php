@extends('shared.layout')

@section('content')
    <div class="container">
        <header>
            <h1><span class="accent">G</span>radenet</h1>
            <hr>
        </header>
        <section>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>Welkom<span class="accent">!</span></h1>
                <p>
                    Welkom bij Gradenet! Een online webapplicatie die alle resultaten zowel in als buiten school overzichtelijk en kenbaar wilt maken.
                </p>
                <p>
                    We streven als groep jonge ontwikkelaars om inzicht te geven op vele aspecten van het leren. De vele onoverzichtelijke lijsten die
                    daarbij horen willen we uit het raam gooien door van een webapplicatie een heel mooi overzichtelijk stuk software te maken en de
                    student en docent beter inzicht, flexibiliteit en interactie met het onderwijs geven.
                </p>
                <p>
                    Druk snel op de login knop om in te loggen en je resultaten te zien of beheren!
                </p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div id="home-login">
                    <p>Bekijk je resultaten en projecten. Keep up your grades!</p>
                    <a href="{{ url('login') }}"><button class="btn btn-success btn-lg" id="btn-home-login">Login</button></a>
                </div>
            </div>
        </section>
    </div>
@stop