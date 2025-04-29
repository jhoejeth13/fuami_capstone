@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Tracer Study Response</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tracer.update', $response->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
              x-data="{ employmentStatus: '{{ old('employment_status', $response->employment_status) }}', organizationType: '{{ old('organization_type', $response->organization_type) }}', occupationalClassification: '{{ old('occupational_classification', $response->occupational_classification) }}' }">
        @csrf
        @method('PUT')
        
            <!-- Personal Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                            First Name
                        </label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $response->first_name) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="middle_name">
                            Middle Name
                        </label>
                        <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $response->middle_name) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                            Last Name
                        </label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $response->last_name) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="suffix">
                            Suffix
                        </label>
                        <select name="suffix" id="suffix" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach($suffixOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('suffix', $response->suffix) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="age">
                            Age
                        </label>
                        <input type="number" name="age" id="age" value="{{ old('age', $response->age) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">
                            Gender
                        </label>
                        <select name="gender" id="gender" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="Male" {{ old('gender', $response->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $response->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="birthdate">
                            Birthdate
                        </label>
                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', $response->birthdate ? $response->birthdate->format('Y-m-d') : '') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="civil_status">
                            Civil Status
                        </label>
                        <select name="civil_status" id="civil_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="Single" {{ old('civil_status', $response->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status', $response->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status', $response->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status', $response->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="religion">
                            Religion
                        </label>
                        <select name="religion" id="religion" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               onchange="handleReligionChange()">
                            <option value="">Select Religion</option>
                            <option value="Roman Catholic" {{ old('religion', $response->religion) == 'Roman Catholic' ? 'selected' : '' }}>Roman Catholic</option>
                            <option value="Christian" {{ old('religion', $response->religion) == 'Christian' ? 'selected' : '' }}>Christian</option>
                            <option value="Islam" {{ old('religion', $response->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Iglesia ni Cristo" {{ old('religion', $response->religion) == 'Iglesia ni Cristo' ? 'selected' : '' }}>Iglesia ni Cristo</option>
                            <option value="Seventh-day Adventist" {{ old('religion', $response->religion) == 'Seventh-day Adventist' ? 'selected' : '' }}>Seventh-day Adventist</option>
                            <option value="Baptist" {{ old('religion', $response->religion) == 'Baptist' ? 'selected' : '' }}>Baptist</option>
                            <option value="Born Again" {{ old('religion', $response->religion) == 'Born Again' ? 'selected' : '' }}>Born Again</option>
                            <option value="Jehovah's Witness" {{ old('religion', $response->religion) == "Jehovah's Witness" ? 'selected' : '' }}>Jehovah's Witness</option>
                            <option value="Others" {{ !in_array(old('religion', $response->religion), ['Roman Catholic', 'Christian', 'Islam', 'Iglesia ni Cristo', 'Seventh-day Adventist', 'Baptist', 'Born Again', "Jehovah's Witness"]) ? 'selected' : '' }}>Others</option>
                        </select>
                        <input type="text" name="religion_other" id="religion_other"
                               value="{{ !in_array(old('religion', $response->religion), ['Roman Catholic', 'Christian', 'Islam', 'Iglesia ni Cristo', 'Seventh-day Adventist', 'Baptist', 'Born Again', "Jehovah's Witness"]) ? old('religion', $response->religion) : '' }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-2"
                               placeholder="Please specify religion"
                               style="display: none;">
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Address Information</h3>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                            Address
                        </label>
                        <input type="text" name="address" id="address" value="{{ old('address', $response->address) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="barangay">
                            Barangay
                        </label>
                        <input type="text" name="barangay" id="barangay" value="{{ old('barangay', $response->barangay) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="municipality">
                            Municipality
                        </label>
                        <input type="text" name="municipality" id="municipality" value="{{ old('municipality', $response->municipality) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="province">
                            Province
                        </label>
                        <input type="text" name="province" id="province" value="{{ old('province', $response->province) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="region">
                            Region
                        </label>
                        <input type="text" name="region" id="region" value="{{ old('region', $response->region) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <!-- Education Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Education Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="shs_track">
                            SHS Track
                        </label>
                        <select name="shs_track" id="shs_track" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="Academic" {{ old('shs_track', $response->shs_track) == 'Academic' ? 'selected' : '' }}>Academic</option>
                            <option value="Technical-Vocational-Livelihood" {{ old('shs_track', $response->shs_track) == 'Technical-Vocational-Livelihood' ? 'selected' : '' }}>Technical-Vocational-Livelihood</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="educational_attainment">
                            Educational Attainment
                        </label>
                        <input type="text" name="educational_attainment" id="educational_attainment" value="{{ old('educational_attainment', $response->educational_attainment) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="year_graduated">
                            Year Graduated
                        </label>
                        <select name="year_graduated" id="year_graduated" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ old('year_graduated', $response->year_graduated) == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                            Phone Number
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $response->phone) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $response->email) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>
            
            <!-- Employment Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Employment Information</h3>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="employment_status">
                        Employment Status *
                    </label>
                    <select name="employment_status" id="employment_status" 
                            x-model="employmentStatus"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                        <option value="">Select Status</option>
                        <option value="Employed" {{ old('employment_status', $response->employment_status) == 'Employed' ? 'selected' : '' }}>Employed</option>
                        <option value="Unemployed" {{ old('employment_status', $response->employment_status) == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                    </select>
                </div>

                <!-- Employed Fields -->
                <div x-show="employmentStatus === 'Employed'" x-cloak>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="employer_name">
                                Employer Name *
                            </label>
                            <input type="text" name="employer_name" id="employer_name"
                                   value="{{ old('employer_name', $response->employer_name) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="organization_type">
                                Organization Type *
                            </label>
                            <select name="organization_type" id="organization_type"
                                    x-model="organizationType"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Select Type</option>
                                <option value="Government" {{ old('organization_type', $response->organization_type) == 'Government' ? 'selected' : '' }}>Government</option>
                                <option value="Private Company" {{ old('organization_type', $response->organization_type) == 'Private Company' ? 'selected' : '' }}>Private Company</option>
                                <option value="Non-Profit/NGO" {{ old('organization_type', $response->organization_type) == 'Non-Profit/NGO' ? 'selected' : '' }}>Non-Profit/NGO</option>
                                <option value="International Organization" {{ old('organization_type', $response->organization_type) == 'International Organization' ? 'selected' : '' }}>International Organization</option>
                                <option value="Educational Institution" {{ old('organization_type', $response->organization_type) == 'Educational Institution' ? 'selected' : '' }}>Educational Institution</option>
                                <option value="Healthcare" {{ old('organization_type', $response->organization_type) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="Financial Services" {{ old('organization_type', $response->organization_type) == 'Financial Services' ? 'selected' : '' }}>Financial Services</option>
                                <option value="Technology" {{ old('organization_type', $response->organization_type) == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Manufacturing" {{ old('organization_type', $response->organization_type) == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                <option value="Retail" {{ old('organization_type', $response->organization_type) == 'Retail' ? 'selected' : '' }}>Retail</option>
                                <option value="Others (please specify)" {{ old('organization_type', $response->organization_type) == 'Others (please specify)' ? 'selected' : '' }}>Others (please specify)</option>
                            </select>
                            <div x-show="organizationType === 'Others (please specify)'" x-cloak class="mt-2">
                                <input type="text" name="organization_type_other" id="organization_type_other"
                                       value="{{ old('organization_type_other', $response->organization_type_other) }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       placeholder="Please specify organization type">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="occupational_classification">
                                Occupational Classification *
                            </label>
                            <select name="occupational_classification" id="occupational_classification"
                                    x-model="occupationalClassification"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Select Classification</option>
                                @foreach($occupationClassifications as $category => $classifications)
                                    <optgroup label="{{ $category }}">
                                        @foreach($classifications as $classification)
                                            <option value="{{ $classification }}" {{ old('occupational_classification', $response->occupational_classification) == $classification ? 'selected' : '' }}>
                                                {{ $classification }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <div x-show="occupationalClassification === 'Others (please specify)'" x-cloak class="mt-2">
                                <input type="text" name="occupational_classification_other" id="occupational_classification_other"
                                       value="{{ old('occupational_classification_other', $response->occupational_classification_other) }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       placeholder="Please specify occupational classification">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="job_situation">
                                Employment Type *
                            </label>
                            <select name="job_situation" id="job_situation"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Select Type</option>
                                <option value="Regular" {{ old('employment_type', $response->employment_type) == 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="Contractual" {{ old('employment_type', $response->employment_type) == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                <option value="Probationary" {{ old('employment_type', $response->employment_type) == 'Probationary' ? 'selected' : '' }}>Probationary</option>
                                <option value="Project-based" {{ old('employment_type', $response->employment_type) == 'Project-based' ? 'selected' : '' }}>Project-based</option>
                                <option value="Permanent" {{ old('employment_type', $response->employment_type) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                <option value="Part-time" {{ old('employment_type', $response->employment_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="years_in_company">
                                Years in Company
                            </label>
                            <input type="text" name="years_in_company" id="years_in_company"
                                   value="{{ old('years_in_company', $response->years_in_company) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   placeholder="e.g. 2 years">
                        </div>
                    </div>
                </div>

                <!-- Unemployed Fields -->
                <div x-show="employmentStatus === 'Unemployed'" x-cloak>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="unemployment_reason">
                            Reason for Unemployment
                        </label>
                        <textarea name="unemployment_reason" id="unemployment_reason"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                  rows="3">{{ old('unemployment_reason', $response->unemployment_reason) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Response
                </button>
                <a href="{{ route('tracer-responses.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
        </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

<script>
// document.addEventListener('alpine:init', () => {
//     Alpine.data('formData', () => ({
//         employmentStatus: '{{ old('employment_status', $response->employment_status) }}',
//         organizationType: '{{ old('organization_type', $response->organization_type) }}',
//         occupationalClassification: '{{ old('occupational_classification', $response->occupational_classification) }}',
//     }))
// })

function handleReligionChange() {
    const religionSelect = document.getElementById('religion');
    const religionOtherInput = document.getElementById('religion_other');
    
    if (religionSelect.value === 'Others') {
        religionOtherInput.style.display = 'block';
        religionOtherInput.setAttribute('required', 'required');
    } else {
        religionOtherInput.style.display = 'none';
        religionOtherInput.removeAttribute('required');
    }
}

// Call the function on page load
document.addEventListener('DOMContentLoaded', function() {
    handleReligionChange();
});
</script>
@endsection