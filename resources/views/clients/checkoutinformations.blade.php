@extends('layouts.master')

@section('content')
    <div class="container   text-center ">
        <h2 class="my-4">Order Information</h2>
        <form action="{{route('order.presubmit')}}" method="POST">
            @csrf
            <!-- Client Information Form -->
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter your email" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" id="phone" class="form-control"
                            placeholder="Enter your phone number" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control"
                            placeholder="Enter your address" required>
                    </div>
                </div>
            </div>

            <input type="hidden" name="orderdetails" id="orderdetails" >            
            <button type="submit" class="btn btn-primary btn-lg m-5">Proceed to Review</button>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Retrieve the order details from sessionStorage
            let orderDetails = JSON.parse(sessionStorage.getItem('orderdetails'));

            document.getElementById('orderdetails').value =  JSON.stringify(orderDetails) ;
         
            console.log(orderDetails);

           
            let carta = JSON.parse(sessionStorage.getItem('cart'));
            console.log(carta);
            let customer_info = JSON.parse(sessionStorage.getItem('customer_info'));
            console.log(customer_info);
            
        });
    </script>
@endsection
