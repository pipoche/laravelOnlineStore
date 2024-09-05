@extends('layouts.dashboard')

@section('pagecontent')
    @include('profile.partials.update-profile-information-form')
    @include('profile.partials.update-password-form')
    @include('profile.partials.delete-user-form')

@endsection
