@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Heading -->
<h1 class="text-2xl font-semibold text-black mb-6">Add New Graduate</h1>

    <!-- Form -->
    <form action="{{ route('graduates.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm sm:rounded-lg p-6">
        @csrf

<!-- ID Number -->
<div class="mb-4">
    <label for="ID_student" class="block text-sm font-medium text-gray-700">ID Number:</label>
    <input type="text" name="ID_student" id="ID_student" value="{{ old('ID_student') }}" required
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
    @error('ID_student')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>


        <!-- First Name -->
        <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Middle Name -->
        <div class="mb-4">
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name (Optional)</label>
            <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('middle_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('last_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Gender -->
        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select name="gender" id="gender" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">-- Select Gender --</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Birthdate -->
        <div class="mb-4">
            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('birthdate')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Year Graduated -->
        <div class="mb-4">
    <label for="year_graduated" class="block text-sm font-medium text-gray-700">Year Graduated</label>
    <select name="year_graduated" id="year_graduated" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        <option value="">-- Select Year --</option>
        @foreach($years as $year)
            <option value="{{ $year }}" {{ old('year_graduated') == $year ? 'selected' : '' }}>{{ $year }}</option>
        @endforeach
    </select>
    @error('year_graduated')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

        <!-- SHS Program -->
        <div class="mb-4">
            <label for="strand" class="block text-sm font-medium text-gray-700">SHS Program</label>
            <select name="strand" id="strand" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option disabled selected hidden>--Select Program--</option>
                <optgroup label="--Academic Strand--" disabled></optgroup>
                <option value="Science, Technology, Engineering, Mathematics(STEM)" {{ old('strand') == 'Science, Technology, Engineering, Mathematics(STEM)' ? 'selected' : '' }}>STEM: Science, Technology, Engineering, Mathematics</option>
                <option value="Accountancy, Business, and Management(ABM)" {{ old('strand') == 'Accountancy, Business, and Management(ABM)' ? 'selected' : '' }}>ABM: Accountancy, Business, and Management</option>
                <option value="Humanities and Social Sciences(HUMSS)" {{ old('strand') == 'Humanities and Social Sciences(HUMSS)' ? 'selected' : '' }}>HUMSS: Humanities and Social Sciences</option>
                <option value="General Academic(GA)" {{ old('strand') == 'General Academic(GA)' ? 'selected' : '' }}>GA: General Academic</option>
                <optgroup label="--TVL Strand--" disabled></optgroup>
                <option value="ICT: Computer System Servicing" {{ old('strand') == 'ICT: Computer System Servicing' ? 'selected' : '' }}>ICT</option>
                <option value="HE: Food and Beverages Services, Bread and Pastry Production" {{ old('strand') == 'HE: Food and Beverages Services, Bread and Pastry Production' ? 'selected' : '' }}>HE: Food and Beverages Services, Bread and Pastry Production</option>
                <option value="IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance" {{ old('strand') == 'IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance' ? 'selected' : '' }}>IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance</option>
            </select>
            @error('strand')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Picture -->
        <div class="mb-6">
            <label for="picture" class="block text-sm font-medium text-gray-700">Picture</label>
            <input type="file" name="picture" id="picture"
                   class="mt-1 block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('picture')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex space-x-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-white rounded-md font-semibold text-white hover:bg-blue focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Submit
            </button>
            <a href="{{ route('graduates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection