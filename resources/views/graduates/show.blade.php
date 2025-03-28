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
    <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-8 max-w-2xl mx-auto print:p-8 print:border-0 print:shadow-none relative">
        <!-- Watermark as an Image -->
        <img src="{{ asset('images/icon.jpg') }}" 
             alt="Watermark"
             class="absolute inset-0 w-[40%] h-[40%] object-contain opacity-20 print:opacity-20 print:w-[40%] print:h-[40%] pointer-events-none mx-auto my-auto">

        <div class="flex items-start gap-6 print:flex-row print:items-start relative z-10">
            <!-- Photo Section -->
            <div class="w-32 h-32 flex-shrink-0 print:w-32 print:h-32 print:mb-0">
    <div class="p-1 rounded-xl border border-gray-200">
        @if ($graduate->picture)
            <img src="{{ asset('storage/' . $graduate->picture) }}" 
                 alt="Graduate Picture"
                 class="w-full h-full object-cover rounded-lg">
        @else
            <img src="{{ asset('images/icon.jpg') }}" 
                 alt="Default Picture"
                 class="w-full h-full object-cover rounded-lg">
        @endif
    </div>
</div>

            <!-- Information Section -->
            <div class="flex-1 space-y-4 print:space-y-4">
                <!-- Header -->
                <div class="border-b-2 border-gray-200 pb-4 print:border-b-2 print:pb-4">
                    <p class="text-sm text-gray-600 print:text-black">FUAMI SHS Graduate Information</p>
                    <h2 class="text-2xl font-bold text-gray-900 print:text-black mt-2">
                        {{ $graduate->first_name }} 
                        {{ $graduate->middle_name }} 
                        {{ $graduate->last_name }}
                    </h2>
                </div>

                <!-- Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 print:grid-cols-2 print:gap-x-6 print:gap-y-3">
                    <div>
                        <p class="text-sm text-gray-600 print:text-black font-bold">LRN Number</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->ID_student }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black font-bold">Gender</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->gender ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black font-bold">Birthdate</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">
                            {{ $graduate->birthdate ? \Carbon\Carbon::parse($graduate->birthdate)->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black font-bold">Year Graduated</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->year_graduated }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black font-bold">SHS Program</p>
                        <p class="text-base font-medium text-gray-900 print:text-black">{{ $graduate->strand }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 print:text-black font-bold">Address</p>
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
        /* Hide unnecessary elements */
        .print\:hidden {
            display: none !important;
        }

        /* Ensure the watermark is visible during printing */
        .print\:opacity-20 {
            opacity: 0.2 !important;
        }

        /* Ensure the ID card layout matches the screen view */
        .print\:p-8 {
            padding: 2rem !important;
        }

        .print\:flex-row {
            flex-direction: row !important;
        }

        .print\:w-32 {
            width: 8rem !important;
        }

        .print\:h-32 {
            height: 8rem !important;
        }

        .print\:space-y-4 > * + * {
            margin-top: 1rem !important;
        }

        .print\:gap-x-6 {
            column-gap: 1.5rem !important;
        }

        .print\:gap-y-3 {
            row-gap: 0.75rem !important;
        }

        /* Ensure text colors are consistent */
        .print\:text-black {
            color: black !important;
        }

        /* Remove shadows and borders for printing */
        .print\:shadow-none {
            box-shadow: none !important;
        }

        .print\:border-0 {
            border: none !important;
        }

        .print\:border-b-2 {
            border-bottom-width: 2px !important;
        }
    }
</style>
@endsection