<style>
    .max-w-20pc {
        max-width: 20%;
    }
    .max-w-md {
        max-width: 90rem;
    }
</style>


@extends('layouts.app')

@section('content')
<br>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between mb-6 print:hidden">
        <a href="{{ route('graduates.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Back to List
        </a>

        <!-- Print Button -->
        <button onclick="window.print()" 
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Print
        </button>
    </div>

    <!-- ID Card -->
    <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-6 max-w-md mx-auto print:p-4 print:border-0 print:shadow-none">
        <div class="flex items-center gap-4 print:flex-col print:items-start">
            <!-- Photo Section -->
            <div class="max-w-20pc flex-shrink-0 print:w-32 print:h-32 print:mb-4">
                <div class="p-1 rounded-xl">
                    @if ($graduate->picture)
                        <img src="{{ asset('storage/' . $graduate->picture) }}" 
                             alt="Graduate Picture"
                             class="w-full aspect-square object-cover rounded-lg mx-auto">
                    @else
                        <div class="w-full aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500 text-xs">No Photo</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Information Section -->
            <div class="flex-1 space-y-2 print:space-y-0">
                <!-- Header -->
                <div class="border-b-2 border-gray-200 pb-2 mb-2 print:border-0 print:pb-0 print:mb-0">
                    <p class="text-sm text-gray-600 print:text-black">FUAMI SHS Graduate Information</p> <br>
                    <p class="text-xs text-gray-600 mb-1 print:text-black print:font-bold">Full Name</p>
                    <h2 class="text-xl font-bold text-gray-900 print:text-black">
                        {{ $graduate->first_name }} 
                        {{ $graduate->middle_name }} 
                        {{ $graduate->last_name }}
                    </h2>
                </div>

                <!-- Details (One Line in Print) -->
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 print:grid-cols-1 print:gap-y-1">
                    <p><strong>Student ID:</strong> {{ $graduate->ID_student }}</p>
                    <p><strong>Gender:</strong> {{ $graduate->gender ?? 'N/A' }}</p>
                    <p><strong>Birthdate:</strong> 
                        {{ $graduate->birthdate ? \Carbon\Carbon::parse($graduate->birthdate)->format('M d, Y') : 'N/A' }}
                    </p>
                    <p><strong>Year Graduated:</strong> {{ $graduate->year_graduated }}</p>
                    <p><strong>SHS Program:</strong> {{ $graduate->strand }}</p>
                    <p><strong>Address:</strong> {{ $graduate->address ?? 'N/A' }}</p>
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
            padding: 4px !important;
        }
        .print\:grid-cols-1 {
            grid-template-columns: 1fr !important;
        }
        .print\:gap-y-1 {
            row-gap: 4px !important;
        }
        .print\:text-black {
            color: black !important;
        }
        .print\:font-bold {
            font-weight: bold !important;
        }
        .print\:w-32 {
            width: 128px !important;
        }
        .print\:h-32 {
            height: 128px !important;
        }
        .print\:mb-4 {
            margin-bottom: 16px !important;
        }
    }
</style>
@endsection