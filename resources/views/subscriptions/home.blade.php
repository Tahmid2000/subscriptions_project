@extends('layouts.app')

@push('css')
<style>
	html,
	body {
		overflow-x: hidden;
	}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@endpush
@section('content')
<section id="banner">
	<h1>Your Subscriptions</h1>
</section>
@if(Session::has('flash_message'))
<div class="container">
	<div class="d-flex justify-content-center">
		<div class="alert alert-success">
			{{ Session::get('flash_message') }}
		</div>
	</div>
</div>
@endif
<div class="d-flex justify-content-end px-5 mb-3">
	<form action="{{route('home')}}" method='GET'>
		{{-- <label for="sort">Sort By</label> --}}
		<select name="sort" id="" onchange="this.form.submit();" class="selectpicker">
			<option value="order" {{ ($sorted === 'order') ? 'selected' : ''}}>Order Added</option>
			<option value="upcoming" {{ ($sorted === 'upcoming') ? 'selected' : ''}}>Upcoming Payment
			</option>
			<option value="most_expensive" {{ ($sorted === 'most_expensive') ? 'selected' : ''}}>Most Expensive</option>
			<option value="least_expensive" {{ ($sorted === 'least_expensive') ? 'selected' : ''}}>Least Expensive
			</option>
			<optgroup label="Category" name="category">
				<option value="entertainment" {{ ($sorted === 'entertainment') ? 'selected' : ''}}>Entertainment
				</option>
				<option value="services" {{ ($sorted === 'services') ? 'selected' : ''}}>Services</option>
				<option value="work" {{ ($sorted === 'work') ? 'selected' : ''}}>Work</option>
				<option value="personal" {{ ($sorted === 'personal') ? 'selected' : ''}}>Personal</option>
				<option value="other" {{ ($sorted === 'other') ? 'selected' : ''}}>Other</option>
			</optgroup>

		</select>
	</form>
</div>
@if ($subscriptions)
@foreach($subscriptions->chunk(4) as $chunk)
<div class="row px-5">
	@foreach ($chunk as $sub)
	<div class="col-md-3">
		<div class="container">
			<div class="d-flex justify-content-center">
				<div class="card mb-3 animated zoomIn" style="width: 20rem;">
					<div class="card-body">
						<div class="d-flex justify-content-center">
							<h3 class="card-title mb-3" style="text-align: center; font-size: 200%;">
								{{ucwords($sub->subscription_name)}}
							</h3>
						</div>
						<div class="d-flex justify-content-center">
							<h5 class="card-subtitle text-muted" style="text-align: center; font-size: 150%;">Due:
								{{date("m-d-Y", strtotime($sub->next_date))}}</h5>
						</div>
						<div class="d-flex justify-content-center mb-2">
							<h5 class="card-subtitle text-muted mt-1" style="text-align: center; font-size: 150%;">
								Price:
								{{number_format($sub->price,2)}}</h5>
						</div>
						<div class="d-flex justify-content-center">
							<div class="btn-group" role="group" aria-label="Basic example">
								<form action="{{route('edit', $sub)}}">
									<button type="submit" class="btn btn-primary mr-4"
										style="padding: .375rem .75rem; width: 3rem; text-align: center">
										<i class="fas fa-edit" style="color: black;"></i>
									</button>
								</form>
								<button type="button" class="btn btn-danger"
									onclick="deleteSub({{$sub->id}}, '{{strval(ucwords($sub->subscription_name))}}');"
									style="padding:.375rem .75rem; border-radius:.125rem; width:3rem;">
									<i class="fas fa-trash-alt" style="color: black;"></i>
								</button>
								<form method="POST" action="{{route('delete', $sub)}}" id="{{$sub->id}}"
									style="display: none">
									<input type="hidden" name="_method" value="DELETE">
									@csrf
								</form>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endforeach
<div class="btn btn-dark">Hello</div>
@else
You have no subscriptions, add one!
@endif
<div class="d-flex justify-content-center">
	<a href="{{route('create')}}" class="btn btn-dark text-white" style="text-decoration: none">Add <i
			class="fas fa-plus"></i></a>
</div>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
	function deleteSub(id, subname){
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
			confirmButton: 'btn btn-danger',
			cancelButton: 'btn btn-success'
			},
			buttonsStyling: false
			})
			
			swalWithBootstrapButtons.fire({
			title: 'Are you sure?',
			text: `You want to delete the ${subname} subscription!`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'delete',
			cancelButtonText: 'Cancel',
			reverseButtons: true
			}).then((result) => {
				if (result.value) {
					event.preventDefault();
					document.getElementById(id).submit();
				}
		})
	}

	function addForm(){
		swal.withForm({
		title: 'Cool Swal-Forms example',
		text: 'Any text that you consider useful for the form',
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Get form data!',
		closeOnConfirm: true,
		formFields: [
		{ id: 'name', placeholder:'Name Field', required: true },
		{ id: 'nickname', placeholder:'Add a cool nickname' }
		]
		}, function(isConfirm) {
		// do whatever you want with the form data
		console.log(this.swalForm) // { name: 'user name', nickname: 'what the user sends' }
		})
	}
</script>
@endpush