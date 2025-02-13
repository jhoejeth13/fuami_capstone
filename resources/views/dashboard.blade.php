@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Graduates Card -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105 relative">
                    <div class="p-6 text-white">
                        <div class="text-sm font-medium text-blue-100">
                            Total of FUAMI SHS Graduates
                        </div>
                        <div class="mt-2 text-3xl font-semibold">
                            {{ $totalGraduates }}
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-blue-100"><br>Last updated: {{ $lastUpdated->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <!-- Icon Background -->
                    <i class="fas fa-graduation-cap absolute bottom-4 right-4 text-white opacity-20 text-6xl"></i>
                </div>

                <!-- Employed Card -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105 relative">
                    <div class="p-6 text-white">
                        <div class="text-sm font-medium text-green-100">
                        FUAMI SHS Alumni Employed
                        </div>
                        <div class="mt-2 text-3xl font-semibold">
                            {{ $employed }}
                        </div>
                        <div class="mt-4"> 
                            <span class="text-sm text-green-100">Last updated: {{ $lastUpdated->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <!-- Icon Background -->
                    <i class="fas fa-briefcase absolute bottom-4 right-4 text-white opacity-20 text-6xl"></i>
                </div>

                <!-- Self-Employed Card -->
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105 relative">
                    <div class="p-6 text-white">
                        <div class="text-sm font-medium text-purple-100">
                        FUAMI SHS Alumni 
                        <div class="text-sm font-medium text-purple-100">
                        Self-Employed
                        </div>
                        </div>
                        <div class="mt-2 text-3xl font-semibold">
                            {{ $selfEmployed }}
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-purple-100">Last updated: {{ $lastUpdated->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <!-- Icon Background -->
                    <i class="fas fa-user-tie absolute bottom-4 right-4 text-white opacity-20 text-6xl"></i>
                </div>

                <!-- Unemployed Card -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105 relative">
                    <div class="p-6 text-white">
                        <div class="text-sm font-medium text-red-100">
                        FUAMI SHS Alumni Unemployed
                        </div>
                        <div class="mt-2 text-3xl font-semibold">
                            {{ $unemployed }}
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-red-100">Last updated: {{ $lastUpdated->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <!-- Icon Background -->
                    <i class="fas fa-user-slash absolute bottom-4 right-4 text-white opacity-20 text-6xl"></i>
                </div>
            </div>
        </div>
    </div>
@endsection