{{-- resources/views/user.blade.php --}}

@extends('layouts.app') {{-- يرث من ملف layout رئيسي --}}

@section('title', 'User Profile') {{-- عنوان الصفحة --}}

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">User Profile</h1>

        {{-- بيانات المستخدم --}}
        <div class="mb-4">
            <label class="font-semibold">Name:</label>
            <p>{{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Email:</label>
            <p>{{ $user->email }}</p>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Joined At:</label>
            <p>{{ $user->created_at->format('d M Y') }}</p>
        </div>

        {{-- مثال على زر تعديل --}}
        <button class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Edit Profile
        </button>
    </div>
</div>
@endsection