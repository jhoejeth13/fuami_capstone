<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUAMI SHS Tracer System</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
            background-image: url('{{ asset("images/_n.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        /* Dark overlay for background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        h1, h2, h3 {
            color: #007bff;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Introduction Section */
        .intro-section {
            text-align: center;
            padding: 80px 20px;
            color: white;
            position: relative;
            z-index: 1;
        }

        .intro-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .intro-section p {
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.8;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .intro-section button {
            padding: 12px 24px;
            font-size: 1rem;
            background-color: #079cffb8;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .intro-section button:hover {
            background-color: #079cffb8;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3);
        }

        /* Content Section */
        .content-section {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .content-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            color: #007bff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: auto; /* Adjusted to fit content */
            overflow-y: auto;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #007bff;
        }

        .card p, .card ul, .card ol {
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        .card ul, .card ol {
            padding-left: 20px;
        }

        .card ul li, .card ol li {
            margin-bottom: 8px;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 123, 255, 0.9);
            color: white;
            margin-top: 40px;
            position: relative;
            z-index: 1;
            font-size: 0.95rem;
        }

        .footer p {
            margin: 0;
            font-weight: 500;
        }

        /* Form Modal */
        .form-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .form-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .form-section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-section h2 {
            font-size: 1.25rem;
            margin-bottom: 15px;
            color: #007bff;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 500;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .close-btn {
            float: right;
            font-size: 1.5rem;
            cursor: pointer;
            color: #333;
        }

        .close-btn:hover {
            color: #007bff;
        }

        .hidden {
            display: none;
        }

        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .intro-section h1 {
                font-size: 2rem;
            }

            .intro-section p {
                font-size: 1rem;
            }

            .form-content {
                padding: 20px;
            }

            .card-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script>
        function toggleEmploymentFields() {
            const status = document.getElementById('employment_status').value;
            document.getElementById('employed_fields').style.display = status === 'Employed' ? 'block' : 'none';
            document.getElementById('self_employed_fields').style.display = status === 'Self-employed' ? 'block' : 'none';
            document.getElementById('unemployed_fields').style.display = status === 'Unemployed' ? 'block' : 'none';
        }

        function openForm() {
            document.getElementById('formModal').style.display = 'flex';
        }

        function closeForm() {
            document.getElementById('formModal').style.display = 'none';
        }

        // Calculate age based on date of birth
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

        // Dynamically update the year in the footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();

        // Show complimentary message after form submission
        function showComplimentaryMessage() {
            alert("Thank you for filling out the form! Your response has been recorded.");
        }
    </script>
</head>
<body>
    <!-- Introduction Section -->
    <div class="intro-section">
        <h1>FUAMI Senior High Graduates Tracer System</h1>
        <p>
            The Fr. Urios Academy Of Magallanes, Inc. Senior High Graduates Tracer System is an essential tool for tracking the post-graduation pathways of FUAMI's Senior High School alumni. Through this comprehensive software platform, FUAMI can monitor the progress and outcomes of its graduates as they transition into higher education, employment, or other endeavors.
        </p>
        <button onclick="openForm()">Fill-In the Form as SHS Graduate</button>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <h2>Fr. Urios Academy Of Magallanes, Inc.</h2>

        <!-- Card Container -->
        <div class="card-container">
            <!-- Philosophy Card -->
            <div class="card">
                <h2>PHILOSOPHY</h2>
                <p>
                    The manifold of the students are recognized and honed. The students become SALUTAY to their family, society and the church. As such the students are watchful (vigilant) servant. Teachers who are committed servants of God. (MASAWA).
                </p>
            </div>

            <!-- Core Values Card -->
            <div class="card">
                <h2>CORE VALUES</h2>
                <ul>
                    <li>CARITAS (Care for Others)</li>
                    <li>STEWARDSHIP</li>
                    <li>COMPASSION</li>
                    <li>TEAMWORK</li>
                </ul>
            </div>

            <!-- Vision Card -->
            <div class="card">
                <h2>VISION</h2>
                <p>
                    Christ-centered persons who care for the earth and fellow human beings.
                </p>
            </div>

            <!-- Mission Card -->
            <div class="card">
                <h2>MISSION</h2>
                <ol>
                    <li><strong>CATHECHISM</strong> - to know Christ better and the teachings of the church.</li>
                    <li><strong>STEWARDSHIP</strong> - to become humble and obedient servants of God.</li>
                    <li><strong>STUDENT-CENTERED</strong> - the students (individually and as a group) as the center of the school's mission.</li>
                    <li><strong>COLLABORATIVE LEARNING</strong> - a collaborative relationship between students and teachers; students and students.</li>
                </ol>
            </div>

            <!-- Hallmark Card -->
            <div class="card">
                <h2>HALL MARK</h2>
                <p>
                    MAGDADASIG (BERNABE)
                </p>
            </div>

            <!-- FUAMINIAN Prayer Card -->
            <div class="card">
                <h2>THE FUAMINIAN PRAYER</h2>
                <p>
                    Oh light and life, our Risen Christ,<br>
                    May your children shine so bright<br>
                    Lesson learned at home and school,<br>
                    Make us friendly and respectful.<br>
                    In sports and studies, may we become,<br>
                    CARING STEWARDS OF EARTH with FUN.<br>
                    You provide us with WATER, AIR, and SUN,<br>
                    Make us grateful by working hand in hand.<br>
                    Today make us true Christians,<br>
                    By following your STEPS<br>
                    with Faith, Hope and Love.<br>
                    With Mary, our Mother, who is at our side,<br>
                    May we glorify the Father, the Son, and the Holy Spirit;<br>
                    One God, forever and ever.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© <span id="currentYear"></span> Fr. Urios Academy Of Magallanes, Inc. All Rights Reserved.</p>
    </div>

    <!-- Form Modal -->
    <div id="formModal" class="form-modal">
        <div class="form-content">
            <span class="close-btn" onclick="closeForm()">&times;</span>
            <h1>FUAMI SHS Graduate Tracer Form</h1>
            <div style="background: #f0f8ff; border: 1px solid #007bff; padding: 20px; margin: 20px 0; border-radius: 5px;">
                <p style="margin: 0; line-height: 1.6; color: #004085;">
                    <strong>Dear graduates of FUAMI SHS,</strong><br><br>
                    Please take time to complete the Tracer Study Form accurately and honestly. 
                    Your participation is crucial for research purposes, as it will help evaluate your 
                    employability status and contribute to the enhancement of the curriculum offered 
                    at Senior High of FR. URIOS ACADEMY OF MAGALLANES, INC. 
                    Rest assured that your responses will be kept confidential.<br><br>
                    Thank you for your cooperation.
                </p>
            </div>

            @if(session('success'))
                <div style="color: green; padding: 10px; border: 1px solid green;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any()))
                <div style="color: red; padding: 10px; border: 1px solid red;">
                    <h3>Errors:</h3>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tracer.submit') }}" method="POST" onsubmit="showComplimentaryMessage()">
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h2>Personal Information</h2>
                    <label>Full Name:
                        <input type="text" name="fullname" value="{{ old('fullname') }}" required>
                    </label>
                    <label>Age:
                        <input type="number" name="age" id="age" value="{{ old('age') }}" required readonly>
                    </label>
                    <label>Gender:
                        <select name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </label>
                    <label>Date of Birth:
                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required onchange="calculateAge()">
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
                        <input type="text" name="religion" value="{{ old('religion') }}" required>
                    </label>
                    <h2>Address</h2>
                    <label>Purok/Barangay/Street:
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
                            <option disabled selected hidden value="">Select Program</option>
                            <optgroup label="--Academic Strand--">
                                <option value="STEM" {{ old('shs_track') == 'STEM' ? 'selected' : '' }}>STEM</option>
                                <option value="ABM" {{ old('shs_track') == 'ABM' ? 'selected' : '' }}>ABM</option>
                                <option value="HUMSS" {{ old('shs_track') == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                                <option value="GAS" {{ old('shs_track') == 'GAS' ? 'selected' : '' }}>GAS</option>
                            </optgroup>
                            <optgroup label="--TVL Strand--">
                                <option value="ICT" {{ old('shs_track') == 'ICT' ? 'selected' : '' }}>ICT</option>
                                <option value="HE" {{ old('shs_track') == 'HE' ? 'selected' : '' }}>HE</option>
                                <option value="IA" {{ old('shs_track') == 'IA' ? 'selected' : '' }}>IA</option>
                            </optgroup>
                        </select>
                    </label>
                    <select name="year_graduated">
                        <option value="">Select Year</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ old('year_graduated') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
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
                                <option value="0-5" {{ old('years_in_company') == '0-5' ? 'selected' : '' }}>0-5 years</option>
                                <option value="6-10" {{ old('years_in_company') == '6-10' ? 'selected' : '' }}>6-10 years</option>
                                <option value="10-15" {{ old('years_in_company') == '10-15' ? 'selected' : '' }}>10-15 years</option>
                                <option value="16-20" {{ old('years_in_company') == '16-20' ? 'selected' : '' }}>16-20 years</option>
                                <option value="20-25" {{ old('years_in_company') == '20-25' ? 'selected' : '' }}>20-25 years</option>
                                <option value="25 above" {{ old('years_in_company') == '25 above' ? 'selected' : '' }}>25+ years</option>
                            </select>
                        </label>
                        <label>Job Related to SHS Track?
                            <select name="job_related_to_shs">
                                <option value="Yes" {{ old('job_related_to_shs') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('job_related_to_shs') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
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
                    </div>

                    <!-- Unemployed Fields -->
                    <div id="unemployed_fields" class="hidden">
                        <h3>Unemployment Details</h3>
                        <label>Reasons for Unemployment:
                            <textarea name="unemployment_reason">{{ old('unemployment_reason') }}</textarea>
                        </label>
                    </div>
                </div>

                <button type="submit" style="padding: 12px 24px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
                    Submit Form
                </button>
            </form>
        </div>
    </div>

    <script>
        // Initialize visibility on page load
        toggleEmploymentFields();
    </script>
</body>
</html>