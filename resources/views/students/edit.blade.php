@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Edit Student</h1>
    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        
        <!-- LRN Number -->
        <div class="mb-4">
            <label for="lrn_number" class="block text-sm font-medium text-gray-700">LRN Number</label>
            <input type="text" name="lrn_number" id="lrn_number" 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                   value="{{ old('lrn_number', $student->lrn_number) }}" maxlength="12">
            @error('lrn_number')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Optional field</p>
        </div>
        
        <!-- First Name -->
        <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                   value="{{ old('first_name', $student->first_name) }}" required maxlength="50">
            @error('first_name')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Middle Name -->
        <div class="mb-4">
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                   value="{{ old('middle_name', $student->middle_name) }}" maxlength="50">
            @error('middle_name')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Last Name -->
        <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="last_name" id="last_name" 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                   value="{{ old('last_name', $student->last_name) }}" required maxlength="50">
            @error('last_name')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Suffix -->
        <div class="mb-4">
            <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix</label>
            <select name="suffix" id="suffix" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- No Suffix --</option>
                <option value="Jr." {{ old('suffix', $student->suffix) == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                <option value="Sr." {{ old('suffix', $student->suffix) == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                <option value="II" {{ old('suffix', $student->suffix) == 'II' ? 'selected' : '' }}>II</option>
                <option value="III" {{ old('suffix', $student->suffix) == 'III' ? 'selected' : '' }}>III</option>
                <option value="IV" {{ old('suffix', $student->suffix) == 'IV' ? 'selected' : '' }}>IV</option>
                <option value="V" {{ old('suffix', $student->suffix) == 'V' ? 'selected' : '' }}>V</option>
                <option value="Others" {{ old('suffix', $student->suffix) == 'Others' ? 'selected' : '' }}>Others</option>
            </select>
            <div id="otherSuffixContainer" class="mt-2" @if(old('suffix', $student->suffix) != 'Others') style="display:none;" @endif>
                <input type="text" name="other_suffix" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                       value="{{ old('other_suffix', $student->suffix == 'Others' ? $student->suffix : '') }}" 
                       placeholder="Enter suffix" maxlength="10">
            </div>
        </div>
        
        <!-- Gender -->
        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select name="gender" id="gender" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-4">
    <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate</label>
    <input type="date" name="birthdate" id="birthdate" 
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
           value="{{ old('birthdate', $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('Y-m-d') : '') }}">
    @error('birthdate')
        <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>
        
        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <textarea name="address" id="address" rows="2"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                      maxlength="255">{{ old('address', $student->address) }}</textarea>
            @error('address')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- School Year -->
        <div class="mb-4">
            <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
            <select name="school_year" id="school_year" 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                   required>
                <option value="">-- Select School Year --</option>
                @foreach($schoolYears as $year)
                    <option value="{{ $year }}" {{ old('school_year', $student->school_year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            @error('school_year')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Photo -->
        <div class="mb-4">
            <label for="photo" class="block text-sm font-medium text-gray-700">Student Photo</label>
            <input type="file" name="photo" id="photo" 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @if($student->photo_path)
                <img src="{{ Storage::url($student->photo_path) }}" alt="Current Photo" class="mt-2 w-24 h-24 rounded-md">
                <div class="mt-2">
                    <input type="checkbox" name="remove_photo" id="remove_photo" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <label for="remove_photo" class="ml-2 text-sm text-gray-700">Remove current photo</label>
                </div>
            @endif
            @error('photo')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update</button>
            <a href="{{ route('students.index') }}" class="ml-4 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const suffixSelect = document.getElementById('suffix');
    const otherSuffixContainer = document.getElementById('otherSuffixContainer');
    
    suffixSelect.addEventListener('change', function() {
        if (this.value === 'Others') {
            otherSuffixContainer.style.display = 'block';
        } else {
            otherSuffixContainer.style.display = 'none';
        }
    });
});
</script>
@endsection