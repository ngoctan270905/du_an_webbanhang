@extends('layouts.profile_user')

@section('title', 'Thông tin cá nhân')

@section('main-content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        @include('profile.partials.update-profile-information-form')
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        @include('profile.partials.update-password-form')
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        @include('profile.partials.delete-user-form')
    </div>
@endsection