@extends('layouts.app')
@section('content')
		<!-- Banner -->
			<section id="banner">
				<h1>Add a Subscription</h1>
            </section>
            
            <div class="container pt-5 d-flex justify-content-center">
                <div style="width: 20rem;">
                    <form method="POST" action="{{route('home')}}">
                        @csrf
                            <div class="form-group" >
                                <label class="my-1 mr-2" for="service_name">Service Name</label>
                                <input type="name" class="form-control" id="service_name" name="subscription_name" style="text-transform:capitalize">
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
                                <label class="my-1 mr-2" for="due_dates">Initial Due Date</label>
                                <input type="name" class="form-control" id="first_date" name="first_date" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
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
                        <button type="submit" class="btn btn-primary float-right mb-5" style="width: 5rem;">Add</button>
                    </form>
                </div>
            </div>

    
@endsection

@push('js')
    <script>
        document.querySelector("#price").onkeypress = function(e) {
            return "1234567890.".indexOf(String.fromCharCode(e.which)) >= 0;
        }
        document.querySelector("#first_date").onkeypress = function(e) {
            return "1234567890/".indexOf(String.fromCharCode(e.which)) >= 0;
        }
    </script>
@endpush