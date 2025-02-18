@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Edit Graduate</h1>
    <form action="{{ route('graduates.update', $graduate->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="ID_student" class="block text-sm font-medium text-gray-700">Student ID</label>
            <input type="text" name="ID_student" id="ID_student" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('ID_student', $graduate->ID_student) }}" required>
            @error('ID_student')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('first_name', $graduate->first_name) }}" required>
            @error('first_name')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('middle_name', $graduate->middle_name) }}">
            @error('middle_name')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('last_name', $graduate->last_name) }}" required>
            @error('last_name')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select name="gender" id="gender" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="">-- Select Gender --</option>
                <option value="Male" {{ old('gender', $graduate->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $graduate->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender', $graduate->gender) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('birthdate', $graduate->birthdate) }}">
            @error('birthdate')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="year_graduated" class="block text-sm font-medium text-gray-700">Year Graduated</label>
            <input type="number" name="year_graduated" id="year_graduated" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('year_graduated', $graduate->year_graduated) }}" required>
            @error('year_graduated')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="strand" class="block text-sm font-medium text-gray-700">SHS Program</label>
            <select name="strand" id="strand" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option disabled>--Select Program--</option>
                <optgroup label="Academic Strands">
                    <option value="Science, Technology, Engineering, Mathematics(STEM)" {{ old('strand', $graduate->strand) == 'STEM' ? 'selected' : '' }}>STEM</option>
                    <option value="Accountancy, Business, and Management(ABM)" {{ old('strand', $graduate->strand) == 'ABM' ? 'selected' : '' }}>ABM</option>
                    <option value="Humanities and Social Sciences(HUMSS)" {{ old('strand', $graduate->strand) == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                    <option value="General Academic(GA)" {{ old('strand', $graduate->strand) == 'GA' ? 'selected' : '' }}>GA</option>
                </optgroup>
                <optgroup label="TVL Strands">
                    <option value="ICT: Computer System Servicing" {{ old('strand', $graduate->strand) == 'ICT' ? 'selected' : '' }}>ICT</option>
                    <option value="HE: Food and Beverages Services, Bread and Pastry Production" {{ old('strand', $graduate->strand) == 'HE' ? 'selected' : '' }}>HE</option>
                    <option value="IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance" {{ old('strand', $graduate->strand) == 'IA' ? 'selected' : '' }}>IA</option>
                </optgroup>
            </select>
            @error('strand')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="address" id="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('address', $graduate->address) }}">
            @error('address')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="picture" class="block text-sm font-medium text-gray-700">Picture</label>
            <input type="file" name="picture" id="picture" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @if($graduate->picture)
                <img src="{{ asset('storage/' . $graduate->picture) }}" alt="Current Picture" class="mt-2 w-24 h-24 rounded-md">
                <div class="mt-2">
                    <input type="checkbox" name="remove_picture" id="remove_picture" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <label for="remove_picture" class="ml-2 text-sm text-gray-700">Remove current picture</label>
                </div>
            @endif
            @error('picture')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update</button>
            <a href="{{ route('graduates.index') }}" class="ml-4 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Cancel</a>
        </div>
    </form>
</div>
@endsection