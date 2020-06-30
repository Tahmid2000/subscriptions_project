@extends('layouts.app')
@section('content')
		<!-- Banner -->
			<section id="banner">
				<h1>Add a Subscription</h1>
            </section>
            
            <div class="container pt-5 d-flex justify-content-center">
                <div class="card">
                    <h5 class="card-header info-color white-text text-center py-4">
                        <strong>Add Subscription</strong>
                    </h5>
                    <div class="card-body px-5 pt-0" style="width: 30rem;">
                        <form method="POST" action="{{route('home')}}" style="color: #757575;" >
                            @csrf
                                <div class="form-group" >
                                    <label class="my-1 mr-2" for="subscription_name">Subscription Name</label>
                                    <input type="name" name="subscription_name" class="form-control @error('subscription_name') is-invalid @enderror" id="subscription_name"  style="text-transform:capitalize">
                                    @error('subscription_name')
                                        <span class="invalid-feedback" role="alert">
                                            <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="my-1 mr-2" for="price">Price</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="price" class="form-control @error('price') is-invalid @enderror" id="price" value="9.99" name="price" onfocus="this.value=''">
                                        @error('price')
                                            <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="my-1 mr-2" for="due_dates">First Due Date</label>
                                <input type="name" name="first_date" class="form-control @error('first_date') is-invalid @enderror" id="first_date"  placeholder="dd-mm-yyyy" value="{{$date}}" onfocus="this.value=''">
                                    @error('first_date')
                                        <span class="invalid-feedback" role="alert">
                                            <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="my-1 mr-2" for="period">Frequency</label>
                                    <select name="period" class="form-control @error('period') is-invalid @enderror" >
                                        <option value="Monthly">Monthly</option>
                                        <option value="Yearly">Yearly</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Quarterly">Quarterly</option>
                                    </select>
                                    @error('period')
                                        <span class="invalid-feedback" role="alert">
                                            <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            <button type="submit" class="btn btn-dark text-white float-right mb-5" style="width: 7rem;">Add <i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

    
@endsection

@push('js')
    <script>
        document.querySelector("#price").onkeypress = function(e) {
            return "1234567890.".indexOf(String.fromCharCode(e.which)) >= 0;
        }
        document.querySelector("#first_date").onkeypress = function(e) {
            return "1234567890-".indexOf(String.fromCharCode(e.which)) >= 0;
        }
        /* document.querySelector("#first_date").onkeypress = function(e){
            if(e.which == 8){
                
            } 
            let length = document.querySelector("#first_date").value.replace("-","").length;
            if (length == 2)
                document.querySelector("#first_date").value += '-';
            else if (length == 4)
                document.querySelector("#first_date").value += '-';
        } */
    </script>
@endpush