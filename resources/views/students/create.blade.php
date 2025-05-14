@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Heading -->
    <h1 class="text-2xl font-semibold text-black mb-6">Add New Student</h1>

    <!-- Form -->
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm sm:rounded-lg p-6" id="studentForm">
        @csrf

        <!-- LRN Number -->
        <div class="mb-4">
            <label for="lrn_number" class="block text-sm font-medium text-gray-700">LRN Number (Optional)</label>
            <input type="text" name="lrn_number" id="lrn_number" value="{{ old('lrn_number') }}" maxlength="12"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <p id="lrn_number_error" class="mt-2 text-sm text-red-600 hidden">LRN must be exactly 12 digits</p>
            @error('lrn_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- First Name -->
        <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required maxlength="50"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <p id="first_name_error" class="mt-2 text-sm text-red-600 hidden">First name is required (2-50 characters, no numbers)</p>
            @error('first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Middle Name -->
        <div class="mb-4">
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name (Optional)</label>
            <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}" maxlength="50"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <p id="middle_name_error" class="mt-2 text-sm text-red-600 hidden">Middle name cannot contain numbers</p>
            @error('middle_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required maxlength="50"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <p id="last_name_error" class="mt-2 text-sm text-red-600 hidden">Last name is required (2-50 characters, no numbers)</p>
            @error('last_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Suffix -->
        <div class="mb-4">
            <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix (Optional)</label>
            <select name="suffix" id="suffix" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                @foreach($suffixOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('suffix') == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <div id="otherSuffixContainer" class="mt-2 hidden">
                <input type="text" name="other_suffix" id="other_suffix" placeholder="Enter suffix" maxlength="10" value="{{ old('other_suffix') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            @error('suffix')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('other_suffix')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Gender -->
        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
            <select name="gender" id="gender" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">-- Select Gender --</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            <p id="gender_error" class="mt-2 text-sm text-red-600 hidden">Please select a gender</p>
            @error('gender')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Birthdate -->
        <div class="mb-4">
            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate *</label>
            <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   max="{{ date('Y-m-d') }}">
            <p id="birthdate_error" class="mt-2 text-sm text-red-600 hidden">Please enter a valid birthdate (not in the future)</p>
            @error('birthdate')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
            <textarea name="address" id="address" rows="2" maxlength="255" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('address') }}</textarea>
            <p id="address_error" class="mt-2 text-sm text-red-600 hidden">Address is required (5-255 characters)</p>
            @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- School Year -->
        <div class="mb-4">
            <label for="school_year" class="block text-sm font-medium text-gray-700">School Year *</label>
            <select name="school_year" id="school_year" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">-- Select School Year --</option>
                @foreach($schoolYears as $year)
                    <option value="{{ $year }}" {{ old('school_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            <p id="school_year_error" class="mt-2 text-sm text-red-600 hidden">Please select a school year</p>
            @error('school_year')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Photo -->
        <div class="mb-6">
            <label for="photo" class="block text-sm font-medium text-gray-700">Student Photo</label>
            <input type="file" name="photo" id="photo" accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p id="photo_error" class="mt-2 text-sm text-red-600 hidden">Please upload a valid image (JPEG, PNG, GIF) under 2MB</p>
            @error('photo')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex space-x-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-white rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Submit
            </button>
            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('studentForm');
    
    // Error elements for each field
    const errorElements = {
        lrn_number: document.getElementById('lrn_number_error'),
        first_name: document.getElementById('first_name_error'),
        middle_name: document.getElementById('middle_name_error'),
        last_name: document.getElementById('last_name_error'),
        gender: document.getElementById('gender_error'),
        birthdate: document.getElementById('birthdate_error'),
        address: document.getElementById('address_error'),
        school_year: document.getElementById('school_year_error'),
        photo: document.getElementById('photo_error')
    };
    
    // Required fields
    const requiredFields = [
        'first_name', 
        'last_name', 
        'gender', 
        'birthdate', 
        'address',
        'school_year'
    ];

    // Name fields that should auto-capitalize and reject numbers
    const nameFields = ['first_name', 'middle_name', 'last_name'];
    
    // Field validation functions
    const validators = {
        lrn_number: (value) => {
            if (value && !/^\d{12}$/.test(value)) {
                return 'LRN must be exactly 12 digits';
            }
            return null;
        },
        first_name: (value) => {
            if (!value.trim()) return 'First name is required';
            if (value.length < 2 || value.length > 50) return 'First name must be 2-50 characters';
            if (/\d/.test(value)) return 'First name cannot contain numbers';
            return null;
        },
        middle_name: (value) => {
            if (value && /\d/.test(value)) return 'Middle name cannot contain numbers';
            if (value && value.length > 50) return 'Middle name must be less than 50 characters';
            return null;
        },
        last_name: (value) => {
            if (!value.trim()) return 'Last name is required';
            if (value.length < 2 || value.length > 50) return 'Last name must be 2-50 characters';
            if (/\d/.test(value)) return 'Last name cannot contain numbers';
            return null;
        },
        gender: (value) => {
            if (!value) return 'Gender is required';
            return null;
        },
        birthdate: (value) => {
            if (!value) return 'Birthdate is required';
            const today = new Date();
            const birthdate = new Date(value);
            if (birthdate > today) return 'Birthdate cannot be in the future';
            return null;
        },
        address: (value) => {
            if (!value.trim()) return 'Address is required';
            if (value.length < 5 || value.length > 255) return 'Address must be 5-255 characters';
            return null;
        },
        school_year: (value) => {
            if (!value) return 'School year is required';
            return null;
        },
        photo: (files) => {
            if (files.length > 0) {
                const file = files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    return 'Please upload a valid image (JPEG, PNG, GIF)';
                }
                if (file.size > 2048 * 1024) {
                    return 'Image must be smaller than 2MB';
                }
            }
            return null;
        }
    };
    
    // Auto-capitalize first letter of each word in name fields
    function autoCapitalizeNames() {
        nameFields.forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input) {
                input.addEventListener('input', function() {
                    // Get current cursor position
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    
                    // Capitalize each word
                    this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
                    
                    // Restore cursor position
                    this.setSelectionRange(start, end);
                });
            }
        });
    }

    // Prevent numbers in name fields
    function preventNumbersInNames() {
        nameFields.forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[0-9]/g, '');
                });
            }
        });
    }

    // Validate a single field
    function validateField(fieldId, value, files = null) {
        const error = validators[fieldId](files || value);
        const errorElement = errorElements[fieldId];
        const inputElement = document.getElementById(fieldId);
        
        if (error) {
            errorElement.textContent = error;
            errorElement.classList.remove('hidden');
            inputElement.classList.add('border-red-500');
            return false;
        } else {
            errorElement.classList.add('hidden');
            inputElement.classList.remove('border-red-500');
            return true;
        }
    }
    
    // Validate entire form
    function validateForm() {
        let isValid = true;
        
        // First validate all required fields to show all errors
        requiredFields.forEach(fieldId => {
            const inputElement = document.getElementById(fieldId);
            if (!validateField(fieldId, inputElement.value)) {
                isValid = false;
            }
        });
        
        // Then validate optional fields
        Object.keys(validators).forEach(fieldId => {
            if (!requiredFields.includes(fieldId)) {
                const inputElement = document.getElementById(fieldId);
                if (fieldId === 'photo') {
                    if (!validateField(fieldId, null, inputElement.files)) {
                        isValid = false;
                    }
                } else if (inputElement.value) { // Only validate if there's a value
                    if (!validateField(fieldId, inputElement.value)) {
                        isValid = false;
                    }
                }
            }
        });
        
        return isValid;
    }
    
    // Initialize name field behaviors
    autoCapitalizeNames();
    preventNumbersInNames();
    
    // Real-time validation on input/change
    Object.keys(validators).forEach(fieldId => {
        const inputElement = document.getElementById(fieldId);
        if (inputElement) {
            inputElement.addEventListener('input', () => {
                if (fieldId === 'photo') return; // Handled separately
                validateField(fieldId, inputElement.value);
            });
            
            inputElement.addEventListener('change', () => {
                if (fieldId === 'photo') {
                    validateField(fieldId, null, inputElement.files);
                } else {
                    validateField(fieldId, inputElement.value);
                }
            });
        }
    });
    
    // Form submission validation
    form.addEventListener('submit', function(event) {
        // Validate all fields on submit
        if (!validateForm()) {
            event.preventDefault();
            // Scroll to first error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Initial validation for any pre-filled fields
    Object.keys(validators).forEach(fieldId => {
        const inputElement = document.getElementById(fieldId);
        if (inputElement && inputElement.value) {
            if (fieldId === 'photo') {
                validateField(fieldId, null, inputElement.files);
            } else {
                validateField(fieldId, inputElement.value);
            }
        }
    });

    // Suffix field handling
    const suffixSelect = document.getElementById('suffix');
    const otherSuffixContainer = document.getElementById('otherSuffixContainer');
    const otherSuffixInput = document.getElementById('other_suffix');

    function toggleSuffixField() {
        if (suffixSelect.value === 'Others') {
            otherSuffixContainer.classList.remove('hidden');
            otherSuffixInput.setAttribute('required', 'required');
        } else {
            otherSuffixContainer.classList.add('hidden');
            otherSuffixInput.removeAttribute('required');
            otherSuffixInput.value = '';
        }
    }

    // Set up event listener
    suffixSelect.addEventListener('change', toggleSuffixField);

    // Initialize on page load
    toggleSuffixField();


});
</script>
@endsection