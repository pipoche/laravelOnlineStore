@extends('layouts.dashboard')

@section('dashboardcss')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('pagecontent')
    <div class="row">
        <div class="mt-2 mb-2">
            <div class="card mt-5">
                <table id="ordersTable" class="table ">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="{{ $order->notificationstatus ? '' : 'bg-dark text-white' }}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ number_format($order->total_price, 2) }} MAD</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $order->orderstatus == 'pending' ? 'warning' : ($order->orderstatus == 'delivering' ? 'info' : ($order->orderstatus == 'cancelled' ? 'danger' : 'success')) }}">
                                        {{ ucfirst($order->orderstatus) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm"><i
                                            class="fas fa-eye"></i> View</a>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updatestatus{{$order->id }}"> Update <i class="fas fa-pen"></i></button>
                                </td>
                            </tr>
                            <div id="updatestatus{{$order->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Update order {{$order->id }} status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('orders.update' , ['id' => $order->id ])}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="radio-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="status_pending" name="orderstatus" value="pending">
                                                    <label class="form-check-label" for="status_pending">
                                                        Pending
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="status_delivering" name="orderstatus" value="delivering">
                                                    <label class="form-check-label" for="status_delivering">
                                                        Delivering
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="status_completed" name="orderstatus" value="completed">
                                                    <label class="form-check-label" for="status_completed">
                                                        Completed
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="status_cancelled" name="orderstatus" value="cancelled">
                                                    <label class="form-check-label" for="status_cancelled">
                                                        Cancelled
                                                    </label>
                                                </div>
                                            </div>
                                            
                
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close</button>
                                                <button type="submit" class="btn btn-primary">Update Status <i
                                                        class="fas fa-arrow-right"></i> </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

      
    </div>
@endsection

@section('dashboardscripts')
@endsection
