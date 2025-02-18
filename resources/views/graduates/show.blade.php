@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Action Buttons -->
    <div class="flex justify-between mb-6 print:hidden">
        <!-- Back Button -->
        <a href="{{ route('graduates.index') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> <!-- Font Awesome Arrow Left Icon -->
            Back to List
        </a>

        <!-- Print Button -->
        <button onclick="window.print()" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all flex items-center gap-2">
            <i class="fas fa-print"></i> <!-- Font Awesome Print Icon -->
            Print
        </button>
    </div>

    <!-- ID Card -->
    <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-8 max-w-2xl mx-auto print:p-4 print:border-0 print:shadow-none">
        <div class="flex items-start gap-6 print:flex-col print:items-start">
            <!-- Photo Section -->
            <div class="w-32 h-32 flex-shrink-0 print:w-28 print:h-28 print:mb-4">
                <div class="p-1 rounded-xl border border-gray-200">
                    @if ($graduate->picture)
                        <img src="{{ asset('storage/' . $graduate->picture) }}" 
                             alt="Graduate Picture"
                             class="w-full h-full object-cover rounded-lg">
                    @else
                        <div class="w-full h-full bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500 text-xs">No Photo</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Information Section -->
            <div class="flex-1 space-y-4 print:space-y-2">
                <!-- Header -->
                <div class="border-b-2 border-gray-200 pb-4 print:border-0 print:pb-2">
                    <p class="text-sm text-gray-600 print:text-black">FUAMI SHS Graduate Information</p>
                    <h2 class="text-2xl font-bold text-gray-900 print:text-black mt-2">
                        {{ $graduate->first_name }} 
                        {{ $graduate->middle_name }} 
                        {{ $graduate->last_name }}
                    </h2>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 print:grid-cols-2 print:gap-x-4 print:gap-y-2">
                    <div>
                        <p class="text-sm text-gray-600 print:text-black">Student ID</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->ID_student }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black">Gender</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->gender ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black">Birthdate</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">
                            {{ $graduate->birthdate ? \Carbon\Carbon::parse($graduate->birthdate)->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black">Year Graduated</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->year_graduated }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black">SHS Program</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->strand }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black">Address</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styling -->
<style>
    @media print {
        body {
            background: white;
            margin: 0;
            padding: 0;
        }
        .print\:hidden {
            display: none !important;
        }
        .print\:border-0 {
            border: none !important;
        }
        .print\:shadow-none {
            box-shadow: none !important;
        }
        .print\:p-4 {
            padding: 1rem !important;
        }
        .print\:text-black {
            color: black !important;
        }
        .print\:w-28 {
            width: 7rem !important;
        }
        .print\:h-28 {
            height: 7rem !important;
        }
        .print\:mb-4 {
            margin-bottom: 1rem !important;
        }
        .print\:grid-cols-2 {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        .print\:gap-x-4 {
            column-gap: 1rem !important;
        }
        .print\:gap-y-2 {
            row-gap: 0.5rem !important;
        }
    }
</style>
@endsection