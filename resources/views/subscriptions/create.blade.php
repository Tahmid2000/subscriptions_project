@extends('layouts.app')
@section('content')
		<!-- Banner -->
			<section id="banner">
				<h1>Create a new Subscription.</h1>
            </section>
            
            <div class="container pt-5">
                <div style="width: 20rem;">
                    <form method="POST" action="{{route('home')}}">
                        @csrf
                            <div class="form-group" >
                                <label class="my-1 mr-2" for="service_name">Service Name</label>
                                <input type="name" class="form-control" id="service_name" name="subscription_name">
                            </div>
                            <div class="form-group">
                                <label class="my-1 mr-2" for="price">Price</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                    </div>
                                    <input type="price" class="form-control" id="price" placeholder="9.99" name="price">
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="my-1 mr-2" for="due_dates">Initial due date</label>
                                <input type="name" class="form-control" id="due_dates" placeholder="yyyy-mm-dd" name="first_date">
                            </div>
                            <div class="form-group">
                                <label class="my-1 mr-2" for="frequency">Frequency</label>
                                <select class="form-control" name="period">
                                    <option value="Monthly" selected>Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Quarterly">Quarterly</option>
                                </select>
                            </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

    
@endsection
