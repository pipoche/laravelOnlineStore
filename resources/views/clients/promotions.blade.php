@extends('layouts.master')
@section('content')
    <h1>Best Promotions Page</h1>

    <div class="promotions">
        <div class="container">
            <div class="container d-flex flex-wrap justify-content-center align-items-start min-vh-100">
                <div class="row">




                    @foreach ($packs as $pack)
                        <div class=" col-md-4 bg-card mt-3">
                            <div class="card centered-card">
                                <div class="card-body">
                                    <img src="{{ asset('images/packs/' . ($pack->image ?? 'default.jpg')) }}"
                                        class="top-svg mb-2" alt="{{ $pack->name }}">
                                    <h2 class="fw-bold fs-4">{{ $pack->name }}</h2>
                                    <address>
                                        <!-- Show up to 3 product names with "..." if more -->
                                        @php
                                            $productNames = $pack->products->pluck('nom')->take(3);
                                            $moreProducts = $pack->products->count() > 3;
                                        @endphp
                                        @foreach ($productNames as $name)
                                            {{ $name }} <br>
                                        @endforeach
                                        @if ($moreProducts)
                                            <span>...</span>
                                        @endif
                                    </address>

                                    <p style="color: green"> <i class="fas fa-dollar"></i>{{ $pack->price }} DH</p>



                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="{{route('showpack', ['id' => $pack->id])}}" class="btn custom-btn search-button">Show more informations</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
@endsection
