@extends('layouts.app')
@section('content')

		<!-- Banner -->
			<section id="banner">
				<h1>Your Subscriptions</h1>
			</section>
		<a href="{{route('create')}}" class="btn btn-dark text-white" style="text-decoration: none">Add a Subscription</a>
			<div class="container mt-5 d-flex justify-content-center">
				<div class="card text-white bg-danger mb-3" style="width: 30rem;">
					<div class="card-header" style="font-size: 150%;">Service Name</div>
					<div class="card-body">
						<h4 class="card-title" style="color: white;">Due Date</h4>
						<p class="card-text">Price</p>
					</div>
				</div>
			</div>
			<div class="container my-3 d-flex justify-content-center">
				<div class="card text-white bg-primary mb-3" style="width: 30rem;">
					<div class="card-header" style="font-size: 150%;">Service Name</div>
					<div class="card-body">
						<h4 class="card-title text-white">Due Date</h4>
						<p class="card-text">Price</p>
					</div>
				</div>
			</div>
			<div class="container my-3 d-flex justify-content-center">
				<div class="card text-white bg-success mb-3" style="width: 30rem;">
					<div class="card-header" style="font-size: 150%;">Service Name</div>
					<div class="card-body">
						<h4 class="card-title" style="color: white;">Due Date</h4>
						<p class="card-text">Price</p>
					</div>
				</div>
			</div>

		{{-- <!-- One -->
			<section id="one" class="wrapper">
				<div class="inner">
					<div class="flex flex-3">
						<article>
							<header>
								<h3>Magna tempus sed amet<br /> aliquam veroeros</h3>
							</header>
							<p>Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu.</p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
						</article>
						<article>
							<header>
								<h3>Interdum lorem pulvinar<br /> adipiscing vitae</h3>
							</header>
							<p>Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu.</p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
						</article>
						<article>
							<header>
								<h3>Libero purus magna sapien<br /> sed ullamcorper</h3>
							</header>
							<p>Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu.</p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
						</article>
					</div>
				</div>
			</section>

		<!-- Two -->
			<section id="two" class="wrapper style1 special">
				<div class="inner">
					<header>
						<h2>Ipsum Feugiat</h2>
						<p>Semper suscipit posuere apede</p>
					</header>
					<div class="flex flex-4">
						<div class="box person">
							<div class="image round">
								<img src="images/pic03.jpg" alt="Person 1" />
							</div>
							<h3>Magna</h3>
							<p>Cipdum dolor</p>
						</div>
						<div class="box person">
							<div class="image round">
								<img src="images/pic04.jpg" alt="Person 2" />
							</div>
							<h3>Ipsum</h3>
							<p>Vestibulum comm</p>
						</div>
						<div class="box person">
							<div class="image round">
								<img src="images/pic05.jpg" alt="Person 3" />
							</div>
							<h3>Tempus</h3>
							<p>Fusce pellentes</p>
						</div>
						<div class="box person">
							<div class="image round">
								<img src="images/pic06.jpg" alt="Person 4" />
							</div>
							<h3>Dolore</h3>
							<p>Praesent placer</p>
						</div>
					</div>
				</div>
			</section>

		<!-- Three -->
			<section id="three" class="wrapper special">
				<div class="inner">
					<header class="align-center">
						<h2>Nunc Dignissim</h2>
						<p>Aliquam erat volutpat nam dui </p>
					</header>
					<div class="flex flex-2">
						<article>
							<div class="image fit">
								<img src="images/pic01.jpg" alt="Pic 01" />
							</div>
							<header>
								<h3>Praesent placerat magna</h3>
							</header>
							<p>Praesent dapibus, nequen id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor lorem ipsum.</p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
						</article>
						<article>
							<div class="image fit">
								<img src="images/pic02.jpg" alt="Pic 02" />
							</div>
							<header>
								<h3>Fusce pellentesque tempus</h3>
							</header>
							<p>Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit. Pellentesque egestas sem. Suspendisse commodo ullamcorper magna non comodo sodales tempus.</p>
							<footer>
								<a href="#" class="button special">More</a>
							</footer>
						</article>
					</div>
				</div>
			</section> --}}
    
@endsection
