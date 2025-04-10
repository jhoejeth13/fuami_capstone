@php
// Check if required variables are set
$organizationTypes = $organizationTypes ?? [];
$occupationClassifications = $occupationClassifications ?? [];
$suffixOptions = $suffixOptions ?? [];
$regions = $regions ?? [];
$years = $years ?? [];

// Log missing variables for debugging
if (empty($organizationTypes)) \Log::warning('organizationTypes is empty in jhs-form-modal');
if (empty($occupationClassifications)) \Log::warning('occupationClassifications is empty in jhs-form-modal');
if (empty($suffixOptions)) \Log::warning('suffixOptions is empty in jhs-form-modal');
if (empty($regions)) \Log::warning('regions is empty in jhs-form-modal');
if (empty($years)) \Log::warning('years is empty in jhs-form-modal');
@endphp

<div id="jhsFormModal" class="form-modal">
    <div class="form-content">
        <button class="close-btn" onclick="closeForm()">&times;</button>
        <h1 class="form-title">FUAMI Junior High School Graduate Tracer Form</h1>
        
        <div class="form-note">
            <p>
                <strong>Dear JHS graduates of FUAMI,</strong><br><br>
                Please take time to complete the Tracer Study Form accurately and honestly. 
                Your participation is crucial for research purposes, as it will help evaluate your 
                employability status and contribute to the enhancement of the curriculum offered 
                at FR. URIOS ACADEMY OF MAGALLANES, INC. 
                Rest assured that your responses will be kept confidential.<br><br>
                Thank you for your cooperation.
            </p>
        </div>

        @if(session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                <h3><i class="fas fa-exclamation-circle mr-2"></i> Errors:</h3>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="jhsForm" action="{{ route('submit-jhs-form') }}" method="POST" onsubmit="submitJHSForm(event)">
            @csrf
            <input type="hidden" name="graduate_type" value="JHS">

            <!-- Personal Information -->
            <div class="form-section">
                <h2><i class="fas fa-user mr-2"></i> Personal Information</h2>
                <label>First Name:
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                </label>                    
                <label>Middle Name:
                    <input type="text" name="middle_name" value="{{ old('middle_name') }}">
                </label>
                <label>Last Name:
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                </label>         
                <label>Suffix:
                    <select name="suffix" id="suffix" onchange="toggleOtherSuffix()">
                        @foreach($suffixOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('suffix') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <div id="otherSuffixContainer" style="display: none;">
                    <label>Specify Suffix:
                        <input type="text" name="suffix_other" value="{{ old('suffix_other') }}" maxlength="10">
                    </label>
                </div>
                <label>Date of Birth:
                    <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required onchange="calculateAge()" pattern="\d{2}/\d{2}/\d{2}">
                    <small>Format: MM/DD/YY</small>
                </label>
                <label>Age:
                    <input type="number" name="age" id="age" value="{{ old('age') }}" required readonly>
                </label>
                <label>Sex:
                    <select name="gender" required>
                        <option value="">Select Sex</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </label>
                <label>Civil Status:
                    <select name="civil_status" required>
                        <option value="">Select Civil Status</option>
                        <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                    </select>
                </label>
                <label>Religion:
                    <select name="religion" id="religion" required onchange="handleReligionChange()">
                        <option value="">Select Religion</option>
                        <option value="Roman Catholic" {{ old('religion') == 'Roman Catholic' ? 'selected' : '' }}>Roman Catholic</option>
                        <option value="Christian" {{ old('religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                        <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Iglesia ni Cristo" {{ old('religion') == 'Iglesia ni Cristo' ? 'selected' : '' }}>Iglesia ni Cristo</option>
                        <option value="Seventh-day Adventist" {{ old('religion') == 'Seventh-day Adventist' ? 'selected' : '' }}>Seventh-day Adventist</option>
                        <option value="Baptist" {{ old('religion') == 'Baptist' ? 'selected' : '' }}>Baptist</option>
                        <option value="Born Again" {{ old('religion') == 'Born Again' ? 'selected' : '' }}>Born Again</option>
                        <option value="Jehovah's Witness" {{ old('religion') == 'Jehovah\'s Witness' ? 'selected' : '' }}>Jehovah's Witness</option>
                        <option value="Others">Others (please specify)</option>
                    </select>
                    <input type="text" name="religion_other" id="religion_other" 
                          value="{{ old('religion_other') }}" 
                          style="display: none; margin-top: 0.5rem;"
                          placeholder="Please specify religion">
                </label>
            </div>

            <!-- Present Address -->
            <div class="form-section">
                <h2><i class="fas fa-map-marker-alt mr-2"></i> Present Address</h2>
                <label>Region:
                    <select name="region" required>
                        <option value="">Select Region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region['region_code'] }}" {{ old('region') == $region['region_code'] ? 'selected' : '' }}>
                                {{ $region['region_name'] }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>Province:
                    <input type="text" name="province" value="{{ old('province') }}" required>
                </label>
                <label>City/Municipality:
                    <input type="text" name="municipality" value="{{ old('municipality') }}" required>
                </label>
                <label>Barangay:
                    <input type="text" name="barangay" value="{{ old('barangay') }}" required>
                </label>
                <label>Purok/Street:
                    <input type="text" name="address" value="{{ old('address') }}">
                </label>
                <label>Country:
                    <input type="text" name="country" value="Philippines" readonly>
                </label>
            </div>

            <!-- Education Information -->
            <div class="form-section">
                <h2><i class="fas fa-graduation-cap mr-2"></i> Education Information</h2>
                <label>Year Graduated:
                    <select name="year_graduated" required>
                        <option value="">Select Year</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ old('year_graduated') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <!-- Contact Information -->
            <div class="form-section">
                <h2><i class="fas fa-phone mr-2"></i> Contact Information (Optional)</h2>
                <label>Phone Number:
                    <input type="tel" name="phone" value="{{ old('phone') }}">
                </label>
                <label>Email Address:
                    <input type="email" name="email" value="{{ old('email') }}">
                </label>
            </div>

            <!-- Employment Information -->
            <div class="form-section">
                <h2><i class="fas fa-briefcase mr-2"></i> Employment Information</h2>
                <label>Employment Status:
                    <select name="employment_status" required onchange="toggleEmploymentDetails()">
                        <option value="">Select Status</option>
                        <option value="Employed" {{ old('employment_status') == 'Employed' ? 'selected' : '' }}>Employed</option>
                        <option value="Unemployed" {{ old('employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                        <option value="Student" {{ old('employment_status') == 'Student' ? 'selected' : '' }}>Student</option>
                    </select>
                </label>

                <!-- Employment Details (shown if employed) -->
                <div id="employmentDetails" style="display: none;">
                    <label>Organization Type:
                        <select name="organization_type" onchange="toggleOtherOrgType()">
                            <option value="">Select Type</option>
                            @foreach($organizationTypes as $type)
                                <option value="{{ $type }}" {{ old('organization_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <div id="otherOrgTypeContainer" style="display: none;">
                        <label>Specify Organization Type:
                            <input type="text" name="organization_type_other" value="{{ old('organization_type_other') }}">
                        </label>
                    </div>
                    <label>Occupational Classification:
                        <select name="occupational_classification" onchange="toggleOtherOccupation()">
                            <option value="">Select Classification</option>
                            @foreach($occupationClassifications as $category => $occupations)
                                <optgroup label="{{ $category }}">
                                    @foreach($occupations as $occupation)
                                        <option value="{{ $occupation }}" {{ old('occupational_classification') == $occupation ? 'selected' : '' }}>
                                            {{ $occupation }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </label>
                    <div id="otherOccupationContainer" style="display: none;">
                        <label>Specify Occupation:
                            <input type="text" name="occupational_classification_other" value="{{ old('occupational_classification_other') }}">
                        </label>
                    </div>
                    <label>Employer Name:
                        <input type="text" name="employer_name" value="{{ old('employer_name') }}">
                    </label>
                    <label>Years in Company:
                        <input type="text" name="years_in_company" value="{{ old('years_in_company') }}">
                    </label>
                </div>

                <!-- Unemployment Details (shown if unemployed) -->
                <div id="unemploymentDetails" style="display: none;">
                    <label>Reason for Unemployment:
                        <textarea name="unemployment_reason" rows="3">{{ old('unemployment_reason') }}</textarea>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Submit Tracer Form</button>
                <button type="button" class="btn btn-secondary" onclick="closeForm()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleOtherSuffix() {
        const suffixSelect = document.getElementById('suffix');
        const otherSuffixContainer = document.getElementById('otherSuffixContainer');
        
        if (suffixSelect.value === 'Other') {
            otherSuffixContainer.style.display = 'block';
            document.getElementById('suffix_other').setAttribute('required', 'required');
        } else {
            otherSuffixContainer.style.display = 'none';
            document.getElementById('suffix_other').removeAttribute('required');
        }
    }

    function calculateAge() {
        const dob = document.getElementById('birthdate').value;
        if (dob) {
            const today = new Date();
            const birthDate = new Date(dob);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            document.getElementById('age').value = age;
        }
    }

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

    function toggleEmploymentDetails() {
        const status = document.getElementById('employment_status').value;
        const employmentDetails = document.getElementById('employmentDetails');
        const unemploymentDetails = document.getElementById('unemploymentDetails');
        
        if (status === 'Employed') {
            employmentDetails.style.display = 'block';
            unemploymentDetails.style.display = 'none';
            setEmploymentFieldsRequired(true);
            document.getElementById('unemployment_reason').removeAttribute('required');
        } else if (status === 'Unemployed') {
            employmentDetails.style.display = 'none';
            unemploymentDetails.style.display = 'block';
            setEmploymentFieldsRequired(false);
            document.getElementById('unemployment_reason').setAttribute('required', 'required');
        } else {
            employmentDetails.style.display = 'none';
            unemploymentDetails.style.display = 'none';
            setEmploymentFieldsRequired(false);
            document.getElementById('unemployment_reason').removeAttribute('required');
        }
    }

    function setEmploymentFieldsRequired(required) {
        const fields = ['organization_type', 'occupational_classification', 'employer_name', 'years_in_company'];
        fields.forEach(field => {
            const element = document.getElementById(field);
            if (required) {
                element.setAttribute('required', 'required');
            } else {
                element.removeAttribute('required');
            }
        });
    }

    function toggleOtherOrgType() {
        const orgTypeSelect = document.getElementById('organization_type');
        const otherOrgTypeContainer = document.getElementById('otherOrgTypeContainer');
        
        if (orgTypeSelect.value === 'Other') {
            otherOrgTypeContainer.style.display = 'block';
            document.getElementById('organization_type_other').setAttribute('required', 'required');
        } else {
            otherOrgTypeContainer.style.display = 'none';
            document.getElementById('organization_type_other').removeAttribute('required');
        }
    }

    function toggleOtherOccupation() {
        const occupationSelect = document.getElementById('occupational_classification');
        const otherOccupationContainer = document.getElementById('otherOccupationContainer');
        
        if (occupationSelect.value === 'Other') {
            otherOccupationContainer.style.display = 'block';
            document.getElementById('occupational_classification_other').setAttribute('required', 'required');
        } else {
            otherOccupationContainer.style.display = 'none';
            document.getElementById('occupational_classification_other').removeAttribute('required');
        }
    }

    function submitJHSForm(event) {
        event.preventDefault();
        
        const form = document.getElementById('jhsForm');
        const formData = new FormData(form);
        
        fetch('{{ route("submit-jhs-form") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Thank You!',
                    text: 'Your response has been successfully submitted. Thank you for participating in our graduate tracer study.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1d4ed8'
                }).then((result) => {
                    if (result.isConfirmed) {
                        closeForm();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.error || 'An error occurred while submitting the form.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1d4ed8'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while submitting the form. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#1d4ed8'
            });
        });
    }

    function closeForm() {
        document.getElementById('jhsFormModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
