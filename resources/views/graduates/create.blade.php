@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-semibold text-black mb-6">Add New Graduate</h1>

    <form action="{{ route('graduates.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm sm:rounded-lg p-6" id="graduateForm">
        @csrf

        <!-- LRN Number -->
        <div class="mb-4">
            <label for="ID_student" class="block text-sm font-medium text-gray-700">LRN Number (Optional):</label>
            <input type="text" name="ID_student" id="ID_student" value="{{ old('ID_student') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   pattern="[0-9]*" minlength="12" maxlength="12">
            <p id="ID_student_error" class="mt-2 text-sm text-red-600 hidden">LRN must be exactly 12 digits</p>
            @error('ID_student')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- First Name -->
        <div class="mb-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   minlength="2" maxlength="50">
            <p id="first_name_error" class="mt-2 text-sm text-red-600 hidden">First name is required (2-50 characters)</p>
            @error('first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Middle Name -->
        <div class="mb-4">
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name (Optional)</label>
            <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   maxlength="50">
            <p id="middle_name_error" class="mt-2 text-sm text-red-600 hidden">Maximum 50 characters</p>
            @error('middle_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="mb-4">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   minlength="2" maxlength="50">
            <p id="last_name_error" class="mt-2 text-sm text-red-600 hidden">Last name is required (2-50 characters)</p>
            @error('last_name')
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

        <!-- Year Graduated -->
        <div class="mb-4">
            <label for="year_graduated" class="block text-sm font-medium text-gray-700">Year Graduated *</label>
            <select name="year_graduated" id="year_graduated" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">-- Select Year --</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ old('year_graduated') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            <p id="year_graduated_error" class="mt-2 text-sm text-red-600 hidden">Please select a graduation year</p>
            @error('year_graduated')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- SHS Program -->
        <div class="mb-4">
            <label for="strand" class="block text-sm font-medium text-gray-700">SHS Program *</label>
            <select name="strand" id="strand" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option disabled selected hidden>--Select Program--</option>
                <optgroup label="--Academic Strand--" disabled></optgroup>
                <option value="Science, Technology, Engineering, and Mathematics(STEM)" {{ old('strand') == 'Science, Technology, Engineering, and Mathematics(STEM)' ? 'selected' : '' }}>STEM: Science, Technology, Engineering, and Mathematics</option>
                <option value="Accountancy, Business, and Management(ABM)" {{ old('strand') == 'Accountancy, Business, and Management(ABM)' ? 'selected' : '' }}>ABM: Accountancy, Business, and Management</option>
                <option value="Humanities and Social Sciences(HUMSS)" {{ old('strand') == 'Humanities and Social Sciences(HUMSS)' ? 'selected' : '' }}>HUMSS: Humanities and Social Sciences</option>
                <option value="General Academic Strand(GAS)" {{ old('strand') == 'General Academic Strand(GAS)' ? 'selected' : '' }}>GAS: General Academic Strand</option>
                <optgroup label="--TVL Strand--" disabled></optgroup>
                <option value="ICT: Computer System Servicing" {{ old('strand') == 'ICT: Computer System Servicing' ? 'selected' : '' }}>ICT: Information Communication and Technology</option>
                <option value="HE: Food and Beverages Services, Bread and Pastry Production" {{ old('strand') == 'HE: Food and Beverages Services, Bread and Pastry Production' ? 'selected' : '' }}>HE: Food and Beverages Services, Bread and Pastry Production</option>
                <option value="IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance" {{ old('strand') == 'IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance' ? 'selected' : '' }}>IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance</option>
            </select>
            <p id="strand_error" class="mt-2 text-sm text-red-600 hidden">Please select a program</p>
            @error('strand')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                   minlength="5" maxlength="255">
            <p id="address_error" class="mt-2 text-sm text-red-600 hidden">Address is required (5-255 characters)</p>
            @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Picture -->
        <div class="mb-6">
            <label for="picture" class="block text-sm font-medium text-gray-700">Picture</label>
            <input type="file" name="picture" id="picture" accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p id="picture_error" class="mt-2 text-sm text-red-600 hidden">Please upload a valid image (JPEG, PNG, GIF) under 2MB</p>
            @error('picture')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex space-x-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-white rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Submit
            </button>
            <a href="{{ route('graduates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('graduateForm');
    
    // Error elements for each field
    const errorElements = {
        ID_student: document.getElementById('ID_student_error'),
        first_name: document.getElementById('first_name_error'),
        middle_name: document.getElementById('middle_name_error'),
        last_name: document.getElementById('last_name_error'),
        gender: document.getElementById('gender_error'),
        birthdate: document.getElementById('birthdate_error'),
        year_graduated: document.getElementById('year_graduated_error'),
        strand: document.getElementById('strand_error'),
        address: document.getElementById('address_error'),
        picture: document.getElementById('picture_error')
    };
    
    // Required fields (asterisk fields from your form)
    const requiredFields = [
        'first_name', 
        'last_name', 
        'gender', 
        'birthdate', 
        'year_graduated', 
        'strand', 
        'address'
    ];

    // Name fields that should auto-capitalize and reject numbers
    const nameFields = ['first_name', 'middle_name', 'last_name'];
    
    // Field validation functions
    const validators = {
        ID_student: (value) => {
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
            if (value && value.length > 50) return 'Middle name must be less than 50 characters';
            if (value && /\d/.test(value)) return 'Middle name cannot contain numbers';
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
        year_graduated: (value) => {
            if (!value) return 'Year graduated is required';
            return null;
        },
        strand: (value) => {
            if (!value) return 'Program is required';
            return null;
        },
        address: (value) => {
            if (!value.trim()) return 'Address is required';
            if (value.length < 5 || value.length > 255) return 'Address must be 5-255 characters';
            return null;
        },
        picture: (files) => {
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
                if (fieldId === 'picture') {
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
                if (fieldId === 'picture') return; // Handled separately
                validateField(fieldId, inputElement.value);
            });
            
            inputElement.addEventListener('change', () => {
                if (fieldId === 'picture') {
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
            if (fieldId === 'picture') {
                validateField(fieldId, null, inputElement.files);
            } else {
                validateField(fieldId, inputElement.value);
            }
        }
    });
});
</script>
@endsection