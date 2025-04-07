@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Fix the toggle sidebar button -->
            <button id="toggleSidebar" 
                    class="text-blue-200 hover:text-white focus:outline-none"
                    aria-label="Toggle Sidebar"
                    title="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Fix the mobile toggle button -->
            <button id="mobileToggle" 
                    class="mr-4 text-gray-600 hover:text-blue-600 md:hidden"
                    aria-label="Toggle Mobile Menu"
                    title="Toggle Mobile Menu">
                <i class="fas fa-bars"></i>
            </button>

            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h1 class="text-xl font-bold text-white">Edit JHS Graduate Tracer Response</h1>
            </div>

            <div class="p-6">
                <!-- Display any validation errors -->
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <div class="font-bold">Please fix the following errors:</div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

                <form action="{{ route('tracer.update-jhs', $response->id) }}" method="POST" class="space-y-6">
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
                                    <option value="Divorced" {{ old('civil_status', $response->civil_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ old('civil_status', $response->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status', $response->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                    </div>

                            <div class="sm:col-span-2">
                                <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                                <input type="text" name="religion" id="religion" value="{{ old('religion', $response->religion) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>

                    <!-- Address Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Address Information</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="address" class="block text-sm font-medium text-gray-700">Purok/Street Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $response->address) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                                <input type="text" name="barangay" id="barangay" 
                                    value="{{ old('barangay', App\Helpers\LocationHelper::getBarangayName($response->barangay)) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality/City</label>
                                <input type="text" name="municipality" id="municipality" 
                                    value="{{ old('municipality', App\Helpers\LocationHelper::getCityName($response->municipality)) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                                <input type="text" name="province" id="province" 
                                    value="{{ old('province', App\Helpers\LocationHelper::getProvinceName($response->province)) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="region" class="block text-sm font-medium text-gray-700">Region</label>
                                <input type="text" name="region" id="region" 
                                    value="{{ old('region', App\Helpers\LocationHelper::getRegionName($response->region)) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $response->postal_code) }}"
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
                            <div class="sm:col-span-2">
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
                                <select name="employment_status" id="employment_status" onchange="toggleEmploymentFields()"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Status</option>
                                    <option value="Employed" {{ old('employment_status', $response->employment_status) == 'Employed' ? 'selected' : '' }}>Employed</option>
                                    <option value="Unemployed" {{ old('employment_status', $response->employment_status) == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                                </select>
                            </div>

                            <div id="employed_fields" class="{{ old('employment_status', $response->employment_status) !== 'Employed' ? 'hidden' : '' }}">
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
                                        <select name="organization_type" id="organization_type" onchange="toggleOrgTypeOther()"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select Organization Type</option>
                                            @foreach($organizationTypes as $type)
                                                <option value="{{ $type }}" {{ old('organization_type', $response->organization_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="org_type_other_container" class="sm:col-span-6 {{ old('organization_type', $response->organization_type) !== 'Other' ? 'hidden' : '' }}">
                                        <label for="organization_type_other" class="block text-sm font-medium text-gray-700">Specify Organization Type</label>
                                        <input type="text" name="organization_type_other" id="organization_type_other" value="{{ old('organization_type_other') }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label for="occupational_classification" class="block text-sm font-medium text-gray-700">Occupational Classification</label>
                                        <select name="occupational_classification" id="occupational_classification" onchange="toggleOccClassOther()"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select Classification</option>
                                            @foreach($occupationClassifications as $group => $options)
                                                @if(is_array($options))
                                                    <optgroup label="{{ $group }}">
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ old('occupational_classification', $response->occupational_classification) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @else
                                                    <option value="{{ $options }}" {{ old('occupational_classification', $response->occupational_classification) == $options ? 'selected' : '' }}>{{ $options }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="occ_class_other_container" class="sm:col-span-6 {{ old('occupational_classification', $response->occupational_classification) !== 'Other' ? 'hidden' : '' }}">
                                        <label for="occupational_classification_other" class="block text-sm font-medium text-gray-700">Specify Occupational Classification</label>
                                        <input type="text" name="occupational_classification_other" id="occupational_classification_other" value="{{ old('occupational_classification_other', $response->occupational_classification_other) }}"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="job_situation" class="block text-sm font-medium text-gray-700">Employment Type</label>
                                        <select name="job_situation" id="job_situation"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select Employment Type</option>
                                            <option value="Permanent" {{ old('job_situation', $response->job_situation) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                            <option value="Contractual" {{ old('job_situation', $response->job_situation) == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                            <option value="Casual" {{ old('job_situation', $response->job_situation) == 'Casual' ? 'selected' : '' }}>Casual</option>
                                            <option value="Others" {{ old('job_situation', $response->job_situation) == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="years_in_company" class="block text-sm font-medium text-gray-700">Years in Company</label>
                                        <select name="years_in_company" id="years_in_company"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select Years</option>
                                            <option value="0-5" {{ old('years_in_company', $response->years_in_company) == '0-5' ? 'selected' : '' }}>0-5 years</option>
                                            <option value="6-10" {{ old('years_in_company', $response->years_in_company) == '6-10' ? 'selected' : '' }}>6-10 years</option>
                                            <option value="10-15" {{ old('years_in_company', $response->years_in_company) == '10-15' ? 'selected' : '' }}>10-15 years</option>
                                            <option value="16-20" {{ old('years_in_company', $response->years_in_company) == '16-20' ? 'selected' : '' }}>16-20 years</option>
                                            <option value="20-25" {{ old('years_in_company', $response->years_in_company) == '20-25' ? 'selected' : '' }}>20-25 years</option>
                                            <option value="25 above" {{ old('years_in_company', $response->years_in_company) == '25 above' ? 'selected' : '' }}>25+ years</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="unemployed_fields" class="{{ old('employment_status', $response->employment_status) !== 'Unemployed' ? 'hidden' : '' }}">
                                <div>
                                    <label for="unemployment_reason" class="block text-sm font-medium text-gray-700">Reasons for Unemployment</label>
                                    <textarea name="unemployment_reason" id="unemployment_reason" rows="4"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('unemployment_reason', $response->unemployment_reason) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('tracer-responses.index', ['type' => 'jhs']) }}" 
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

@section('scripts')
<script>
    function toggleEmploymentFields() {
        const status = document.getElementById('employment_status').value;
        const employedFields = document.getElementById('employed_fields');
        const unemployedFields = document.getElementById('unemployed_fields');
        
        if (status === 'Employed') {
            employedFields.classList.remove('hidden');
            unemployedFields.classList.add('hidden');
        } else if (status === 'Unemployed') {
            employedFields.classList.add('hidden');
            unemployedFields.classList.remove('hidden');
        }
    }

    function toggleOrgTypeOther() {
        const orgTypeSelect = document.getElementById('organization_type');
        const otherContainer = document.getElementById('org_type_other_container');
        
        if (orgTypeSelect.value === 'Other') {
            otherContainer.classList.remove('hidden');
    } else {
            otherContainer.classList.add('hidden');
        }
    }

    function toggleOccClassOther() {
        const occClassSelect = document.getElementById('occupational_classification');
        const otherContainer = document.getElementById('occ_class_other_container');
        
        if (occClassSelect.value === 'Other') {
            otherContainer.classList.remove('hidden');
        } else {
            otherContainer.classList.add('hidden');
        }
    }

    // Address dropdown functionality
    async function loadProvinces() {
        const region = document.getElementById('region').value;
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');
        
        // Reset dependent fields
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        citySelect.innerHTML = '<option value="">Select Municipality/City</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        if (!region) return;

        try {
            showLoader(provinceSelect);
            const response = await fetch(`/api/provinces?region=${encodeURIComponent(region)}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            
            data.forEach(province => {
                const option = document.createElement('option');
                option.value = province.code;
                option.textContent = province.name;
                if (province.code === "{{ $response->province }}") {
                    option.selected = true;
                }
                provinceSelect.appendChild(option);
            });
            
            // If we have a saved province, load its cities
            if ("{{ $response->province }}" && provinceSelect.value) {
                await loadCities();
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
            provinceSelect.innerHTML = '<option value="">Error loading provinces</option>';
        }
    }

    async function loadCities() {
        const province = document.getElementById('province').value;
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');
        
        // Reset dependent fields
        citySelect.innerHTML = '<option value="">Select Municipality/City</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        if (!province) return;

        try {
            showLoader(citySelect);
            const response = await fetch(`/api/cities?province=${encodeURIComponent(province)}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            
            data.forEach(city => {
                const option = document.createElement('option');
                option.value = city.code;
                option.textContent = city.name;
                if (city.code === "{{ $response->municipality }}") {
                    option.selected = true;
                }
                citySelect.appendChild(option);
            });
            
            // If we have a saved municipality, load its barangays
            if ("{{ $response->municipality }}" && citySelect.value) {
                await loadBarangays();
            }
        } catch (error) {
            console.error('Error loading cities:', error);
            citySelect.innerHTML = '<option value="">Error loading cities</option>';
        }
    }

    async function loadBarangays() {
        const city = document.getElementById('city').value;
        const barangaySelect = document.getElementById('barangay');
        
        // Reset dependent field
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        if (!city) return;

        try {
            showLoader(barangaySelect);
            const response = await fetch(`/api/barangays?city=${encodeURIComponent(city)}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            
            data.forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay.code;
                option.textContent = barangay.name;
                if (barangay.code === "{{ $response->barangay }}") {
                    option.selected = true;
                }
                barangaySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading barangays:', error);
            barangaySelect.innerHTML = '<option value="">Error loading barangays</option>';
        }
    }

    function showLoader(selectElement) {
        selectElement.innerHTML = '<option value="">Loading...</option>';
    }

    // Initialize address dropdowns on page load
    document.addEventListener('DOMContentLoaded', async function() {
        toggleEmploymentFields();
        toggleOrgTypeOther();
        toggleOccClassOther();
        
        // Debug: Log the saved values
        console.log('Saved values:', {
            region: "{{ $response->region }}",
            province: "{{ $response->province }}",
            municipality: "{{ $response->municipality }}",
            barangay: "{{ $response->barangay }}"
        });
        
        // If we have a saved region, trigger the cascade
        if ("{{ $response->region }}") {
            const regionSelect = document.getElementById('region');
            regionSelect.value = "{{ $response->region }}";
            await loadProvinces();
        }
    });
</script>
@endsection

@endsection