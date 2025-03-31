@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Edit Tracer Study Response</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tracer.update', $response->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Include the form fields from your tracer-study-form.blade.php -->
        <!-- Make sure to populate them with the existing data -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <!-- Personal Information -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $response->first_name) }}" 
                               class="w-full px-3 py-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $response->middle_name) }}" 
                               class="w-full px-3 py-2 border rounded-md">
                    </div>
                    <!-- Add all other fields similarly -->
                </div>
            </div>
            
            <!-- Add other sections (Education, Employment, etc.) -->
            
            <div class="flex justify-end mt-6">
                <a href="{{ route('tracer.responses') }}" class="px-4 py-2 bg-gray-300 rounded-md mr-2">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    Update Record
                </button>
            </div>
        </div>
    </form>
</div>
@endsection