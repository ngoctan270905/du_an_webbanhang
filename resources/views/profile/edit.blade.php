@extends('layouts.profile_user')

@section('content')
<div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                @include('profile.partials.profile-sidebar')
            </div>
            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection