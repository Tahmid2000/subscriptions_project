@extends('layouts.app')

@push('css')
<style>
	html,
	body {
		overflow-x: hidden;
		padding-right: 0 !important;
	}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
	integrity="sha256-XPTBwC3SBoWHSmKasAk01c08M6sIA5gF5+sRxqak2Qs=" crossorigin="anonymous" />
@endpush
@section('content')
<div class="container">
	<section class="card wow fadeIn" style="background-color: #42378f;
background-image: linear-gradient(315deg, #42378f 0%, #f53844 74%); margin-top: 100px;">

		<!-- Content -->
		<div class="card-body text-white text-center py-5 px-5 my-5" style="font-size: 120%;">

			<h1 class="mb-4">
				<strong>Your Subscriptions</strong>
			</h1>
			<p>
				<strong>Welcome! These are all your subscriptions.</strong>
			</p>
			<p class="mb-4">
				<strong>You can see the upcoming pay dates and prices of all your subscriptions. You can also sort by
					different categories to get a view of the subscriptions in the way you prefer.
				</strong>
			</p>
		</div>
		<!-- Content -->
	</section>
</div>
<div class="d-flex justify-content-center my-3">
	<form action="{{route('home')}}" method='GET'>
		{{-- <label for="sort">Sort By</label> --}}
		<select name="sort" id="" onchange="this.form.submit();" class="selectpicker"
			data-style="background-color: blue;" style="background-color: #f44336" 3>
			<option value=" order" {{ ($sorted === 'order') ? 'selected' : ''}}>Order Added</option>
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
@if(Session::has('flash_message'))
<div class="container">
	<div class="d-flex justify-content-center">
		<div class="alert alert-success">
			{{ Session::get('flash_message') }}
		</div>
	</div>
</div>
@endif
@if ($subscriptions)
<div class="row px-5">
	@php
	$index = 1;
	@endphp
	@foreach ($subscriptions as $sub)
	<div class="col-lg-3 col-md-4">
		<div class="container">
			<div class="d-flex justify-content-center">
				<div class="card mb-3 animated zoomIn" style="width: 24rem; /* max-height: 1%; */">
					<div class="card-body">
						<div class="d-flex justify-content-center mb-1">

							<div class="d-flex justify-content-center">
								<h3 class="card-title mb-3"
									style="text-align: center; font-size: 200%; overflow: hidden;">
									{{ucwords($sub->subscription_name)}} <img
										src="https://logo.clearbit.com/{{str_replace(' ', '',$sub->subscription_name)}}.com?size=35"
										{{-- width="35" height="35" --}} onerror="this.remove();">
							</div>
							</h3>
						</div>
						<div class="d-flex justify-content-center">
							@if (date("m/d/Y", strtotime($sub->next_date)) === date("m/d/Y",
							strtotime($date)))
							<h5 class="card-subtitle text-muted" style="text-align: center; font-size: 150%;">
								Due:
								<span style="color: red;">Today</span>

							</h5>
							@elseif((strtotime($sub->next_date) - strtotime($date))/86400 <= 7) <h5
								class="card-subtitle text-muted" style="text-align: center; font-size: 150%; ;">
								Due:
								<span style="color: orange">{{date("m/d/Y", strtotime($sub->next_date))}}</span>
								</h5>
								@else
								<h5 class="card-subtitle text-muted" style="text-align: center; font-size: 150%;">
									Due:
									{{date("m/d/Y", strtotime($sub->next_date))}}
								</h5>
								@endif

						</div>
						<div class="d-flex justify-content-center mb-2">
							<h5 class="card-subtitle text-muted mt-1" style="text-align: center; font-size: 150%;">
								Price:
								{{number_format($sub->price,2)}}</h5>
						</div>
						<div class="d-flex justify-content-center">
							<div class="btn-group" role="group" aria-label="Basic example">
								@php
								$firstDate = date("m/d/Y", strtotime($sub->first_date));
								$nextDate = date("m/d/Y", strtotime($sub->next_date));
								if ($sub->end_date != null)
								$endDate = date("m/d/Y", strtotime($sub->end_date));
								else
								$endDate = 'None';
								@endphp
								<button type="button" class="btn btn-warning mr-3"
									style="padding: .375rem .75rem; width: 3rem; text-align: center; border-radius: .125rem;"
									onclick="viewSub('{{ucwords($sub->subscription_name)}}', '{{$sub->price}}', '{{$firstDate}}', '{{$nextDate}}', '{{$endDate}}','{{$sub->period}}', '{{ucwords($sub->category)}}')"
									title="View Details">
									<i class="fas fa-eye" style="color: black;"></i>
								</button>
								<button type="button" class="btn btn-primary mr-3"
									style="padding: .375rem .75rem; width: 3rem; text-align: center; border-radius: .125rem;"
									{{-- onclick="editForm({{$sub->id}})" --}}title="Edit" data-toggle="modal"
									data-target="#editModal-{{$sub->id}}">
									<i class="fas fa-edit" style="color: black;"></i>
								</button>
								<button type="button" class="btn btn-danger" title="Delete"
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
	<div class="modal fade" id="editModal-{{$sub->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit {{ucwords($sub->subscription_name)}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{route('update', $sub)}}" id='editForm-{{$sub->id}}'>
						@csrf
						@method('PUT')
						<div class="form-group">
							<label class="my-1 mr-2" for="subscription_name">Subscription Name</label>
							<input type="name" name="subscription_name" class="form-control"
								id="subscription_name_{{$sub->id}}" style="text-transform:capitalize"
								value="{{$sub->subscription_name}}" readonly>
							<span class="invalid-feedback" role="alert">
								<p style="color: red; margin-bottom: -15px;"
									id="subscription_name_{{$sub->id}}_message">
								</p>
							</span>
						</div>
						<div class="form-group">
							<label class="my-1 mr-2" for="price">Price</label>
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
								</div>
								<input type="price" class="form-control" id="price_{{$sub->id}}"
									value="{{old('price',$sub->price)}}" name="price">
								<span class="invalid-feedback" role="alert">
									<p style="color: red; margin-bottom: -15px;" id="price_{{$sub->id}}_message">
									</p>
								</span>
							</div>

						</div>
						<div class="form-group">
							<label class="my-1 mr-2" for="due_dates">First Due Date</label>
							<div class="input-group date" id="datetimepicker1-{{$sub->id}}" data-target-input="nearest">
								<input type="text" name="first_date" class="form-control datetimepicker-input"
									data-target="#datetimepicker1-{{$sub->id}}"
									value="{{ old('first_date', date("m/d/Y", strtotime($sub->first_date))) }}"
									id="first_date_{{$sub->id}}" />
								<div class="input-group-append" data-target="#datetimepicker1-{{$sub->id}}"
									data-toggle="datetimepicker">
									<div class="input-group-text"><i class="fa fa-calendar"></i></div>
								</div>
								<span class="invalid-feedback" role="alert">
									<p style="color: red; margin-bottom: -15px;" id="first_date_{{$sub->id}}_message">
									</p>
								</span>
							</div>

						</div>
						<div class="form-group">
							<label class="my-1 mr-2" for="period">Frequency</label>
							<select name="period" class="form-control">
								<option value="Monthly" {{($sub->period == 'Monthly') ? 'selected' : ''}}
									{{ (old('period') === 'Monthly') ? 'selected' : ''}}>Monthly</option>
								<option value="Yearly" {{($sub->period == 'Yearly') ? 'selected' : ''}}
									{{ (old('period') === 'Yearly') ? 'selected' : ''}}>Yearly</option>
								<option value="Weekly" {{($sub->period == 'Weekly') ? 'selected' : ''}}
									{{ (old('period') === 'Weekly') ? 'selected' : ''}}>Weekly</option>
								<option value="Quarterly" {{($sub->period == 'Quarterly') ? 'selected' : ''}}
									{{ (old('period') === 'Quarterly') ? 'selected' : ''}}>Quarterly
								</option>
							</select>
							<span class="invalid-feedback" role="alert">
								<p style="color: red; margin-bottom: -15px;" id="frequency_{{$sub->id}}_message">
								</p>
							</span>
						</div>
						<div class="form-group">
							<label class="my-1 mr-2" for="period">Category (Optional)</label>
							<select name="category" class="form-control">
								<option>Select One</option>
								<option value="entertainment" {{($sub->category == 'entertainment') ? 'selected' : ''}}
									{{ (old('category') === 'entertainment') ? 'selected' : ''}}>
									Entertainment
								</option>
								<option value="services" {{($sub->category == 'services') ? 'selected' : ''}}
									{{ (old('category') === 'services') ? 'selected' : ''}}>Services
								</option>
								<option value="work" {{($sub->category == 'work') ? 'selected' : ''}}
									{{ (old('category') === 'work') ? 'selected' : ''}}>Work
								</option>
								<option value="personal" {{($sub->category == 'personal') ? 'selected' : ''}}
									{{ (old('category') === 'personal') ? 'selected' : ''}}>Personal
								</option>
								<option value="other" {{($sub->category == 'other') ? 'selected' : ''}}
									{{ (old('category') === 'other') ? 'selected' : ''}}>Other
								</option>
							</select>
							<span class="invalid-feedback" role="alert">
								<p style="color: red; margin-bottom: -15px;" id="category_{{$sub->id}}_message">
								</p>
							</span>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success" onclick="editSub('{{$sub->id}}')">UPDATE <i
							class="fas fa-edit"></i></button>
					</form>
				</div>
			</div>
		</div>
	</div>
	@php
	$threeCols = ($index % 3) == 0;
	$fourCols = ($index % 4) == 0;
	@endphp
	@if ($threeCols && $fourCols)
	<div class="clearfix visible-lg visible-md"></div>
	@elseif ($fourCols)
	{{-- After 4 cols --}}
	<div class="clearfix visible-lg"></div>
	@elseif ($threeCols)
	{{-- After 3 cols --}}
	<div class="clearfix visible-md"></div>
	@endif
	@php
	$index++;
	@endphp
	@endforeach

</div>
@endif
<input type="hidden" value="{{route('home')}}" id="home_path">
<div class="d-flex justify-content-center">
	<div class="btn btn-dark" data-toggle="modal" data-target="#addSub">Add <i class="fas fa-plus"></i></div>
</div>
<!-- Modal -->
<div class="modal fade" id="addSub" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Subscription</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('home')}}" style="color: #757575;" id="addSubForm">
					@csrf
					<div class="form-group">
						<label class="my-1 mr-2" for="subscription_name">Subscription Name</label>
						<input type="name" name="subscription_name" class="form-control" id="subscription_name_add"
							style="text-transform:capitalize" value="{{ old('subscription_name') }}">
						<span class="invalid-feedback" role="alert">
							<p style="color: red; margin-bottom: -15px;" id="subscription_name_add_message">
							</p>
						</span>
					</div>
					<div class="form-group">
						<label class="my-1 mr-2" for="price">Price</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
							</div>
							<input type="price" class="form-control" id="price_add" value="{{ old('price', 9.99) }}"
								name="price" onfocus="this.value=''">
							<span class="invalid-feedback" role="alert">
								<p style="color: red; margin-bottom: -15px;" id="price_add_message">
								</p>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="my-1 mr-2" for="due_dates">First Due Date</label>
						<div class="input-group date" id="datetimepicker1-add" data-target-input="nearest">
							<input type="text" name="first_date" class="form-control datetimepicker-input"
								data-target="#datetimepicker1-add" value="{{ old('first_date', $date) }}"
								id="first_date_add" />
							<div class="input-group-append" data-target="#datetimepicker1-add"
								data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
							<span class="invalid-feedback" role="alert">
								<p style="color: red; margin-bottom: -15px;" id="first_date_add_message">
								</p>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="my-1 mr-2" for="period">Frequency</label>
						<select name="period" class="form-control">
							<option value="Monthly" {{ (old('period') === 'Monthly') ? 'selected' : ''}}>Monthly
							</option>
							<option value="Yearly" {{ (old('period') === 'Yearly') ? 'selected' : ''}}>Yearly</option>
							<option value="Weekly" {{ (old('period') === 'Weekly') ? 'selected' : ''}}>Weekly</option>
							<option value="Quarterly" {{ (old('period') === 'Quarterly') ? 'selected' : ''}}>Quarterly
							</option>
						</select>
						<span class="invalid-feedback" role="alert">
							<p style="color: red; margin-bottom: -15px;" id="frequency_add_message">
							</p>
						</span>
					</div>
					<div class="form-group">
						<label class="my-1 mr-2" for="period">Category (Optional)</label>
						<select name="category" class="form-control">
							<option>Select One</option>
							<option value="entertainment" {{ (old('category') === 'entertainment') ? 'selected' : ''}}>
								Entertainment
							</option>
							<option value="services" {{ (old('category') === 'services') ? 'selected' : ''}}>Services
							</option>
							<option value="work" {{ (old('category') === 'work') ? 'selected' : ''}}>Work</option>
							<option value="personal" {{ (old('category') === 'personal') ? 'selected' : ''}}>Personal
							</option>
							<option value="other" {{ (old('category') === 'other') ? 'selected' : ''}}>Other
							</option>
						</select>
						<span class="invalid-feedback" role="alert">
							<p style="color: red; margin-bottom: -15px;" id="category_add_message">
							</p>
						</span>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-success">Add <i class="fas fa-plus"></i></button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.min.js"
	integrity="sha256-VBLiveTKyUZMEzJd6z2mhfxIqz3ZATCuVMawPZGzIfA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"
	integrity="sha256-z0oKYg6xiLq3yJGsp/LsY9XykbweQlHl42jHv2XTBz4=" crossorigin="anonymous"></script>
<script>
	function deleteSub(id, subname){
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
			confirmButton: 'btn btn-danger z-depth-0',
			cancelButton: 'btn btn-success z-depth-0'
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

	$('#addSubForm').submit(function(e){
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: document.getElementById('addSubForm').getAttribute('action'),
			dataType: 'json',
			data: $('#addSubForm').serialize(),
			success: function(data){
				location.reload();
				return false;
			},
			error: function(data){
				var errors = data.responseJSON;
				for(error in errors['message']){
					$(`#${error}_add`).addClass('is-invalid');
					document.getElementById(`${error}_add_message`).innerHTML = errors['message'][error][0];
				}
				var all = ['subscription_name', 'price', 'first_date']
				var success = all.filter(function(obj) { return !(obj in errors['message']); });
				for(var i = 0; i < success.length; i++){
					if($(`#${success[i]}_add`).hasClass('is-invalid'))
					{
						$(`#${success[i]}_add`).removeClass('is-invalid');
						document.getElementById(`${success[i]}_add_message`).innerHTML = "";
					}
					
				}
			}
		})
	})
function editSub(id){
	$(`#editForm-${id}`).one('submit',function(e){
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: document.getElementById(`editForm-${id}`).getAttribute('action'),
			dataType: 'json',
			data: $(`#editForm-${id}`).serialize(),
			success: function(data){
				location.reload();
				return false;
			},
			error: function(data){
				var errors = data.responseJSON;
				for(error in errors['message']){
					$(`#${error}_${id}`).addClass('is-invalid');
					document.getElementById(`${error}_${id}_message`).innerHTML = errors['message'][error][0];
					console.log(document.getElementById(`${error}_${id}_message`));
				}
				var all = ['subscription_name', 'price', 'first_date']
				var success = all.filter(function(obj) { return !(obj in errors['message']); });
				for(var i = 0; i < success.length; i++){
					if($(`#${success[i]}_${id}`).hasClass('is-invalid'))
					{
						$(`#${success[i]}_${id}`).removeClass('is-invalid');
						document.getElementById(`${success[i]}_${id}_message`).innerHTML = "";
					}
					
				}
			}
		})
	})
}
function viewSub(name, price, firstDate, nextDate, endDate, frequency, category){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-primary z-depth-0',
			},
			buttonsStyling: false
		})
		
		swalWithBootstrapButtons.fire({
			title: `<strong>${name}</strong>`,
			icon: 'info',
			html:
			'<b>Price: </b>$' + price + '<br>' +
			'<b>First Date: </b>' +firstDate + '<br>' +
			'<b>Next Date: </b>' +nextDate + '<br>' +
			/* '<b>End Date: </b>' +endDate + '<br>' + */
			'<b>Frequency: </b>' +frequency + '<br>' +
			'<b>Category: </b>' +category,
			showCloseButton: true,
			focusConfirm: false,
			confirmButtonText:
			'OK',
		})
	}
</script>

@endpush