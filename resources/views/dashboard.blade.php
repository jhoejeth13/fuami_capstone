@extends('layouts.app')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Graduates Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-100">
                            Total of  FUAMI SHS Graduates
                        </div>
                        <div class="mt-2 text-3xl font-semibold">
                            {{ $totalGraduates }}
                        </div>
                    </div>
                </div>

                <!-- Employed Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-100">
                            Employed
                        </div>
                        <div class="mt-2 text-3xl font-semibold text-green-600 dark:text-green-400">
                            {{ $employed }}
                        </div>
                    </div>
                </div>

                <!-- Self-Employed Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            Self-Employed
                        </div>
                        <div class="mt-2 text-3xl font-semibold text-purple-600 dark:text-purple-400">
                            {{ $selfEmployed }}
                        </div>
                    </div>
                </div>

                <!-- Unemployed Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-100">
                            Unemployed
                        </div>
                        <div class="mt-2 text-3xl font-semibold text-red-600 dark:text-red-400">
                            {{ $unemployed }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection