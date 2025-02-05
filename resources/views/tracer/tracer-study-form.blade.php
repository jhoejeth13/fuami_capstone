<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study Form</title>
    <style>
        .form-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        .hidden { display: none; }
        .error { color: red; }
        label { display: block; margin: 10px 0; }
        input, select, textarea { width: 100%; padding: 8px; margin: 5px 0; }
    </style>
    <script>
        function toggleEmploymentFields() {
            const status = document.getElementById('employment_status').value;
            document.getElementById('employed_fields').style.display = status === 'Employed' ? 'block' : 'none';
            document.getElementById('self_employed_fields').style.display = status === 'Self-employed' ? 'block' : 'none';
            document.getElementById('unemployed_fields').style.display = status === 'Unemployed' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h1>Fuami SHS Graduate Tracer Form</h1>
    <div style="background: #f0f8ff; border: 1px solid #007bff; padding: 20px; margin: 20px 0; border-radius: 5px;">
    <p style="margin: 0; line-height: 1.6; color: #004085;">
        <strong>Dear graduates of FUAMI SHS,</strong><br><br>
        Please take the time to complete the Tracer Study Form accurately and honestly. 
        Your participation is crucial for research purposes, as it will help evaluate your 
        employability status and contribute to the enhancement of the curriculum offered 
        at Senior High of FR. URIOS ACADEMY OF MAGALLANES INCORPORATED. 
        Rest assured that your responses will be kept confidential.<br><br>
        Thank you for your cooperation.
    </p>
</div>
    @if(session('success'))
        <div style="color: green; padding: 10px; border: 1px solid green;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red; padding: 10px; border: 1px solid red;">
            <h3>Errors:</h3>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tracer.submit') }}" method="POST">
        @csrf

        <!-- Personal Information -->
        <div class="form-section">
            <h2>Personal Information</h2>
            
            <label>Full Name:
                <input type="text" name="fullname" value="{{ old('fullname') }}" required>
            </label>

            <label>Age:
                <input type="number" name="age" value="{{ old('age') }}" required>
            </label>

            <label>Gender:
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </label>

            <label>Date of Birth:
                <input type="date" name="birthdate" value="{{ old('birthdate') }}" required>
            </label>

            <label>Civil Status:
                <input type="text" name="civil_status" value="{{ old('civil_status') }}" required>
            </label>

            <label>Religion:
                <input type="text" name="religion" value="{{ old('religion') }}" required>
            </label>

            <label>Permanent Address:
                <input type="text" name="address" value="{{ old('address') }}" required>
            </label>

            <label>Municipality:
                <input type="text" name="municipality" value="{{ old('municipality') }}" required>
            </label>

            <label>Province:
                <input type="text" name="province" value="{{ old('province') }}" required>
            </label>

            <label>Region:
                <input type="text" name="region" value="{{ old('region') }}" required>
            </label>

            <label>Postal Code:
                <input type="text" name="postal_code" value="{{ old('postal_code') }}" required>
            </label>

            <label>Country:
                <input type="text" name="country" value="{{ old('country') }}" required>
            </label>
        </div>

        <!-- Education Information -->
        <div class="form-section">
            <h2>Education Information</h2>

            <label>SHS Track/Strand Completed:
    <select name="shs_track" required>
        <option disabled selected hidden value="">--Select Program--</option>
        <optgroup label="--Academic Strand--">
            <option value="STEM" {{ old('shs_track') == 'STEM' ? 'selected' : '' }}>Science, Technology, Engineering, Mathematics (STEM)</option>
            <option value="ABM" {{ old('shs_track') == 'ABM' ? 'selected' : '' }}>Accountancy, Business, and Management (ABM)</option>
            <option value="HUMSS" {{ old('shs_track') == 'HUMSS' ? 'selected' : '' }}>Humanities and Social Sciences (HUMSS)</option>
            <option value="GA" {{ old('shs_track') == 'GA' ? 'selected' : '' }}>General Academic (GA)</option>
        </optgroup>
        <optgroup label="--Technical, Vocational, and Livelihood (TVL) Strand--">
            <option value="ICT" {{ old('shs_track') == 'ICT' ? 'selected' : '' }}>ICT: Computer System Servicing</option>
            <option value="HE" {{ old('shs_track') == 'HE' ? 'selected' : '' }}>HE: Food and Beverages Services, Bread and Pastry Production</option>
            <option value="IA" {{ old('shs_track') == 'IA' ? 'selected' : '' }}>IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance</option>
        </optgroup>
    </select>
</label>
            <label>Year Graduated:
                <input type="text" name="year_graduated" value="{{ old('year_graduated') }}" required>
            </label>
        </div>

        <!-- Contact Information -->
        <div class="form-section">
            <h2>Contact Information</h2>

            <label>Facebook:
                <input type="text" name="facebook" value="{{ old('facebook') }}">
            </label>

            <label>Twitter/X:
                <input type="text" name="twitter" value="{{ old('twitter') }}">
            </label>

            <label>Phone Number:
                <input type="text" name="phone" value="{{ old('phone') }}" required>
            </label>

            <label>Email Address:
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
        </div>

        <!-- Employment Information -->
        <div class="form-section">
            <h2>Employment Information</h2>

            <label>Employment Status:
                <select name="employment_status" id="employment_status" required onchange="toggleEmploymentFields()">
                    <option value="">Select Status</option>
                    <option value="Employed" {{ old('employment_status') == 'Employed' ? 'selected' : '' }}>Employed</option>
                    <option value="Self-employed" {{ old('employment_status') == 'Self-employed' ? 'selected' : '' }}>Self-employed</option>
                    <option value="Unemployed" {{ old('employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                </select>
            </label>

            <!-- Employed Fields -->
            <div id="employed_fields" class="hidden">
                <h3>Employment Details</h3>

                <label>Organization Type:
                    <input type="text" name="organization_type" value="{{ old('organization_type') }}">
                </label>

                <label>Occupational Classification:
                    <input type="text" name="occupational_classification" value="{{ old('occupational_classification') }}">
                </label>

                <label>Employment Type:
                    <select name="employment_type">
                        <option value="">Select Type</option>
                        <option value="Working Full-time" {{ old('employment_type') == 'Working Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Working Part-time" {{ old('employment_type') == 'Working Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Others" {{ old('employment_type') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                </label>

                <label>Work Location:
                    <select name="work_location">
                        <option value="">Select Location</option>
                        <option value="Local" {{ old('work_location') == 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Abroad" {{ old('work_location') == 'Abroad' ? 'selected' : '' }}>Abroad</option>
                    </select>
                </label>

                <label>Job Situation:
                    <select name="job_situation">
                        <option value="">Select Situation</option>
                        <option value="Permanent" {{ old('job_situation') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                        <option value="Contractual" {{ old('job_situation') == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                        <option value="Casual" {{ old('job_situation') == 'Casual' ? 'selected' : '' }}>Casual</option>
                        <option value="Others" {{ old('job_situation') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                </label>

                <label>Years in Company:
                    <select name="years_in_company">
                        <option value="">Select Years</option>
                        <option value="1-5" {{ old('years_in_company') == '1-5' ? 'selected' : '' }}>1-5 years</option>
                        <option value="6-10" {{ old('years_in_company') == '6-10' ? 'selected' : '' }}>6-10 years</option>
                        <option value="10-15" {{ old('years_in_company') == '10-15' ? 'selected' : '' }}>10-15 years</option>
                        <option value="16-20" {{ old('years_in_company') == '16-20' ? 'selected' : '' }}>16-20 years</option>
                        <option value="20-25" {{ old('years_in_company') == '20-25' ? 'selected' : '' }}>20-25 years</option>
                        <option value="25 above" {{ old('years_in_company') == '25 above' ? 'selected' : '' }}>25+ years</option>
                    </select>
                </label>

                <label>Monthly Income (PHP):
                    <input type="number" name="monthly_income" value="{{ old('monthly_income') }}">
                </label>

                <label>Job Related to SHS Track?
                    <select name="job_related_to_shs">
                        <option value="Yes" {{ old('job_related_to_shs') == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ old('job_related_to_shs') == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </label>

                <label>Reasons for Staying:
                    <textarea name="reason_staying_job">{{ old('reason_staying_job') }}</textarea>
                </label>
            </div>

            <!-- Self-Employed Fields -->
            <div id="self_employed_fields" class="hidden">
                <h3>Self-Employment Details</h3>

                <label>Nature of Employment:
                    <input type="text" name="nature_of_employment" value="{{ old('nature_of_employment') }}">
                </label>

                <label>Company Name:
                    <input type="text" name="company_name" value="{{ old('company_name') }}">
                </label>

                <label>Years in Business:
                    <select name="years_in_business">
                        <option value="">Select Years</option>
                        <option value="0-5" {{ old('years_in_business') == '0-5' ? 'selected' : '' }}>0-5 years</option>
                        <option value="6-10" {{ old('years_in_business') == '6-10' ? 'selected' : '' }}>6-10 years</option>
                        <option value="10-15" {{ old('years_in_business') == '10-15' ? 'selected' : '' }}>10-15 years</option>
                        <option value="16 Above" {{ old('years_in_business') == '16 Above' ? 'selected' : '' }}>16+ years</option>
                    </select>
                </label>

                <label>Monthly Income (PHP):
                    <input type="number" name="self_employed_income" value="{{ old('self_employed_income') }}">
                </label>
            </div>

            <!-- Unemployed Fields -->
            <div id="unemployed_fields" class="hidden">
                <h3>Unemployment Details</h3>

                <label>Reasons for Unemployment:
                    <textarea name="unemployment_reason">{{ old('unemployment_reason') }}</textarea>
                </label>

                <label>Is FUAMI a Factor?
                    <select name="fuami_factor">
                        <option value="Yes" {{ old('fuami_factor') == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ old('fuami_factor') == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </label>
            </div>
        </div>

        <button type="submit" style="padding: 10px 20px; background: #4CAF50; color: white; border: none;">Submit Form</button>
    </form>

    <script>
        // Initialize visibility on page load
        toggleEmploymentFields();
    </script>
</body>
</html>