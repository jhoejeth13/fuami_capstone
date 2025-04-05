@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-800 mb-3">Create New Record</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Select the type of record you want to create. Your data will be securely stored and can be accessed later through the appropriate dashboard section.</p>
        </div>
        
        <!-- Selection Cards -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Junior High School Student Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
                <div class="h-3 bg-blue-600"></div>
                <div class="p-6">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-user-graduate text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Junior High School Student</h2>
                    <p class="text-gray-600 text-center mb-6">Create a new record for a Junior High School student with complete personal and academic information.</p>
                    
                    <ul class="space-y-2 mb-6 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Personal and contact information
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Academic details including LRN
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Upload student photo
                        </li>
                    </ul>
                    
                    <div class="text-center">
                        <a href="{{ route('students.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-300">
                            <i class="fas fa-plus-circle mr-2"></i> Create JHS Record
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Senior High School Graduate Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
                <div class="h-3 bg-indigo-600"></div>
                <div class="p-6">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-user-tie text-indigo-600 text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Senior High School Graduate</h2>
                    <p class="text-gray-600 text-center mb-6">Create a new record for a Senior High School graduate with complete academic and tracking information.</p>
                    
                    <ul class="space-y-2 mb-6 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Complete graduate profile
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Academic track and specialization
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Employment tracking capabilities
                        </li>
                    </ul>
                    
                    <div class="text-center">
                        <a href="{{ route('graduates.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                            <i class="fas fa-plus-circle mr-2"></i> Create SHS Record
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Option -->
        <div class="mt-10 text-center">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Looking for something else?</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('tracer-responses.index') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-300 flex items-center">
                    <i class="fas fa-search mr-2"></i> Alumni Tracer
                </a>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-300 flex items-center">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 