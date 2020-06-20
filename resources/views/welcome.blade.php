@extends('layouts.app')
@section('content')
		<!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="index.html" class="logo">Subsort</a>
					<nav id="nav">
						 @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
					<a href="{{route('about')}}">About</a>
					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>
			</header>

		<!-- Banner -->
			<section id="banner" style="height: 100%">
				<h1>Welcome to Subsort</h1>
				<p>A free tool to seamlessly manage your subscriptions. Log in or register to begin.</p>
			</section>
			<section id="main" class="wrapper">
				<div class="inner">	
					<h2 id="content">Sample Content</h2>
					<p style="font-size: 150%">Tired of forgetting about your subscriptions?</p>
				</div>
			</section>
					
		

    
@endsection
