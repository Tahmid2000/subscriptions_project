@extends('layouts.app')
@section('content')
@push('css')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
    integrity="sha256-XPTBwC3SBoWHSmKasAk01c08M6sIA5gF5+sRxqak2Qs=" crossorigin="anonymous" />
@endpush
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
            <form method="POST" action="{{route('home')}}" style="color: #757575;">
                @csrf
                <div class="form-group">
                    <label class="my-1 mr-2" for="subscription_name">Subscription Name</label>
                    <input type="name" name="subscription_name"
                        class="form-control @error('subscription_name') is-invalid @enderror" id="subscription_name"
                        style="text-transform:capitalize" value="{{ old('subscription_name') }}">
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
                            <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                        </div>
                        <input type="price" class="form-control @error('price') is-invalid @enderror" id="price"
                            value="{{ old('price', 9.99) }}" name="price" onfocus="this.value=''">
                        @error('price')
                        <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                        </span>
                        @enderror

                    </div>

                </div>
                <div class="form-group">
                    <label class="my-1 mr-2" for="due_dates">First Due Date</label>
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <input type="text" name="first_date"
                            class="form-control datetimepicker-input @error('first_date') is-invalid @enderror"
                            data-target="#datetimepicker1" value="{{ old('first_date', $date) }}" />
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    @error('first_date')
                    <span class="invalid-feedback" role="alert">
                        <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="my-1 mr-2" for="period">Frequency</label>
                    <select name="period" class="form-control @error('period') is-invalid @enderror">
                        <option value="Monthly" {{ (old('period') === 'Monthly') ? 'selected' : ''}}>Monthly</option>
                        <option value="Yearly" {{ (old('period') === 'Yearly') ? 'selected' : ''}}>Yearly</option>
                        <option value="Weekly" {{ (old('period') === 'Weekly') ? 'selected' : ''}}>Weekly</option>
                        <option value="Quarterly" {{ (old('period') === 'Quarterly') ? 'selected' : ''}}>Quarterly
                        </option>
                    </select>
                    @error('period')
                    <span class="invalid-feedback" role="alert">
                        <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="my-1 mr-2" for="period">Category (Optional)</label>
                    <select name="category" class="form-control @error('category') is-invalid @enderror">
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
                    @error('category')
                    <span class="invalid-feedback" role="alert">
                        <p style="color: red; margin-bottom: -15px;">{{ $message }}</p>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark text-white float-right mb-5" style="width: 7rem;">Add <i
                        class="fas fa-plus"></i></button>
            </form>
        </div>
    </div>
</div>


@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.min.js"
    integrity="sha256-VBLiveTKyUZMEzJd6z2mhfxIqz3ZATCuVMawPZGzIfA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"
    integrity="sha256-z0oKYg6xiLq3yJGsp/LsY9XykbweQlHl42jHv2XTBz4=" crossorigin="anonymous"></script>
<script>
    $(function () {
        $("#datetimepicker1").datetimepicker();
      });
</script>
<script>
    document.querySelector("#price").onkeypress = function(e) {
            return "1234567890.".indexOf(String.fromCharCode(e.which)) >= 0;
        }
        document.querySelector("#first_date").onkeypress = function(e) {
            return "1234567890-".indexOf(String.fromCharCode(e.which)) >= 0;
        }
</script>
@endpush