@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h1 class="text-xl font-bold text-white">Edit SHS Graduate Tracer Response</h1>
            </div>

            <div class="p-6">
    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif

        @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <div class="font-bold">Please fix the following errors:</div>
                        <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

                <form action="{{ route('tracer.update', $response->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
                    <!-- Personal Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $response->first_name) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-2">
                                <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                        <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $response->middle_name) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-2">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $response->last_name) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-1">
                                <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix</label>
                                <select name="suffix" id="suffix" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @foreach($suffixOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('suffix', $response->suffix) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                            <div class="sm:col-span-1">
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" id="gender" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="Male" {{ old('gender', $response->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $response->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                            <div class="sm:col-span-2">
                                <label for="birthdate" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="birthdate" id="birthdate" 
                                    value="{{ old('birthdate', $response->birthdate ? date('Y-m-d', strtotime($response->birthdate)) : '') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-1">
                                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                                <input type="number" name="age" id="age" value="{{ old('age', $response->age) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-2">
                                <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
                                <select name="civil_status" id="civil_status" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="Single" {{ old('civil_status', $response->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status', $response->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status', $response->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status', $response->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                    </div>

                            <div class="sm:col-span-2">
                                <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                        <select name="religion" id="religion" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                               placeholder="Please specify religion"
                               style="display: none;">
                    </div>
                </div>
            </div>

                    <!-- Address Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Address Information</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $response->address) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-2">
                                <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                        <input type="text" name="barangay" id="barangay" value="{{ old('barangay', $response->barangay) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-2">
                                <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality</label>
                        <input type="text" name="municipality" id="municipality" value="{{ old('municipality', $response->municipality) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-2">
                                <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                        <input type="text" name="province" id="province" value="{{ old('province', $response->province) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-3">
                                <label for="region" class="block text-sm font-medium text-gray-700">Region</label>
                        <input type="text" name="region" id="region" value="{{ old('region', $response->region) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <input type="text" name="country" id="country" value="{{ old('country', $response->country ?? 'Philippines') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>

                    <!-- Education Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Education Information</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="shs_track" class="block text-sm font-medium text-gray-700">SHS Track</label>
                                <select name="shs_track" id="shs_track" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Program</option>
                                    <optgroup label="Academic Strand">
                                        <option value="STEM" {{ old('shs_track', $response->shs_track) == 'STEM' ? 'selected' : '' }}>STEM - Science, Technology, Engineering, and Mathematics</option>
                                        <option value="ABM" {{ old('shs_track', $response->shs_track) == 'ABM' ? 'selected' : '' }}>ABM - Accountancy, Business, and Management</option>
                                        <option value="HUMSS" {{ old('shs_track', $response->shs_track) == 'HUMSS' ? 'selected' : '' }}>HUMSS - Humanities and Social Sciences</option>
                                        <option value="GAS" {{ old('shs_track', $response->shs_track) == 'GAS' ? 'selected' : '' }}>GAS - General Academic Strand</option>
                                    </optgroup>
                                    <optgroup label="TVL Strand">
                                        <option value="ICT" {{ old('shs_track', $response->shs_track) == 'ICT' ? 'selected' : '' }}>ICT - Information and Communications Technology</option>
                                        <option value="HE" {{ old('shs_track', $response->shs_track) == 'HE' ? 'selected' : '' }}>HE - Home Economics</option>
                                        <option value="IA" {{ old('shs_track', $response->shs_track) == 'IA' ? 'selected' : '' }}>IA - Industrial Arts</option>
                                        <option value="AFA" {{ old('shs_track', $response->shs_track) == 'AFA' ? 'selected' : '' }}>AFA - Agri-Fishery Arts</option>
                                    </optgroup>
                                    <optgroup label="Other Strands">
                                        <option value="Sports" {{ old('shs_track', $response->shs_track) == 'Sports' ? 'selected' : '' }}>Sports Track</option>
                                        <option value="Arts and Design" {{ old('shs_track', $response->shs_track) == 'Arts and Design' ? 'selected' : '' }}>Arts and Design Track</option>
                                    </optgroup>
                        </select>
                    </div>

                            <div class="sm:col-span-3">
                                <label for="year_graduated" class="block text-sm font-medium text-gray-700">Year Graduated</label>
                                <select name="year_graduated" id="year_graduated" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @foreach($years as $year)
                                        <option value="{{ $year }}" {{ old('year_graduated', $response->year_graduated) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

                    <!-- Contact Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $response->phone) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $response->email) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
            
                    <!-- Employment Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Employment Information</h2>
                        <div class="space-y-6">
                            <div>
                                <label for="employment_status" class="block text-sm font-medium text-gray-700">Employment Status</label>
                    <select name="employment_status" id="employment_status" 
                            x-model="employmentStatus"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="">Select Status</option>
                        <option value="Employed" {{ old('employment_status', $response->employment_status) == 'Employed' ? 'selected' : '' }}>Employed</option>
                        <option value="Unemployed" {{ old('employment_status', $response->employment_status) == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                    </select>
                </div>

                <!-- Employed Fields -->
                <div x-show="employmentStatus === 'Employed'" x-cloak>
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="employer_name" class="block text-sm font-medium text-gray-700">Employer Name</label>
                                        <input type="text" name="employer_name" id="employer_name" value="{{ old('employer_name', $response->employer_name) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                                    <div class="sm:col-span-3">
                                        <label for="employer_address" class="block text-sm font-medium text-gray-700">Employer Address</label>
                                        <input type="text" name="employer_address" id="employer_address" value="{{ old('employer_address', $response->employer_address) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                                    <div class="sm:col-span-3">
                                        <label for="organization_type" class="block text-sm font-medium text-gray-700">Organization Type</label>
                            <select name="organization_type" id="organization_type"
                                    x-model="organizationType"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Please specify organization type">
                            </div>
                        </div>

                                    <div class="sm:col-span-3">
                                        <label for="occupational_classification" class="block text-sm font-medium text-gray-700">Occupational Classification</label>
                            <select name="occupational_classification" id="occupational_classification"
                                    x-model="occupationalClassification"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       placeholder="Please specify occupational classification">
                            </div>
                        </div>

                                    <div class="sm:col-span-3">
                                        <label for="job_situation" class="block text-sm font-medium text-gray-700">Employment Type</label>
                            <select name="job_situation" id="job_situation"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">Select Type</option>
                                            <option value="Regular" {{ old('job_situation', $response->job_situation) == 'Regular' ? 'selected' : '' }}>Regular</option>
                                            <option value="Contractual" {{ old('job_situation', $response->job_situation) == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                            <option value="Probationary" {{ old('job_situation', $response->job_situation) == 'Probationary' ? 'selected' : '' }}>Probationary</option>
                                            <option value="Project-based" {{ old('job_situation', $response->job_situation) == 'Project-based' ? 'selected' : '' }}>Project-based</option>
                                            <option value="Permanent" {{ old('job_situation', $response->job_situation) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                            <option value="Part-time" {{ old('job_situation', $response->job_situation) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            </select>
                        </div>

                                    <div class="sm:col-span-3">
                                        <label for="years_in_company" class="block text-sm font-medium text-gray-700">Years in Company</label>
                            <input type="text" name="years_in_company" id="years_in_company"
                                   value="{{ old('years_in_company', $response->years_in_company) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                   placeholder="e.g. 2 years">
                        </div>
                    </div>
                </div>

                <!-- Unemployed Fields -->
                <div x-show="employmentStatus === 'Unemployed'" x-cloak>
                    <div>
                                    <label for="unemployment_reason" class="block text-sm font-medium text-gray-700">Reason for Unemployment</label>
                                    <textarea name="unemployment_reason" id="unemployment_reason" rows="4"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('unemployment_reason', $response->unemployment_reason) }}</textarea>
                                </div>
                    </div>
                </div>
            </div>

                    <div class="flex justify-between">
                        <a href="{{ route('tracer-responses.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                           title="Back to List">
                            <i class="fas fa-arrow-left mr-2"></i> Back to List
                        </a>

                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                title="Save Changes">
                            <i class="fas fa-save mr-2"></i> Save Changes
                </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('formData', () => ({
        employmentStatus: '{{ old('employment_status', $response->employment_status) }}',
        organizationType: '{{ old('organization_type', $response->organization_type) }}',
        occupationalClassification: '{{ old('occupational_classification', $response->occupational_classification) }}',
    }))
})

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
@endpush
@endsection