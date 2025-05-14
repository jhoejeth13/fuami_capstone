<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUAMI SHS Tracer System</title>
    <!-- Font Awesome (Local) -->
    @include('includes.fontawesome')
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1d4ed8;
            --primary-light: #3b82f6;
            --primary-dark: #1e40af;
            --accent: #079cff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
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
            background-color: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }

        /* Introduction Section */
        .intro-section {
            text-align: center;
            padding: 6rem 1.5rem;
            color: white;
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, rgba(29, 78, 216, 0.8) 0%, rgba(7, 156, 255, 0.8) 100%);
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            margin-bottom: 3rem;
        }

        .intro-section h1 {
            font-size: 2.75rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .intro-section p {
            font-size: 1.15rem;
            max-width: 800px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
            opacity: 0.9;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--accent);
            color: white;
            border: 2px solid var(--accent);
        }

        .btn-primary:hover {
            background-color: rgba(7, 156, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-outline {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Content Section */
        .content-section {
            padding: 3rem 1.5rem;
            max-width: 1200px;
            margin: 0 auto 4rem;
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2.5rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--accent);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .card h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--accent);
        }

        .card p, .card ul, .card ol {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #4b5563;
        }

        .card ul, .card ol {
            padding-left: 1.25rem;
        }

        .card ul li, .card ol li {
            margin-bottom: 0.5rem;
            position: relative;
        }

        .card ul li:before {
            content: '•';
            color: var(--accent);
            font-weight: bold;
            display: inline-block; 
            width: 1em;
            margin-left: -1em;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem 1rem;
            background-color: var(--primary);
            color: white;
            position: relative;
            z-index: 1;
            font-size: 0.95rem;
            clip-path: polygon(0 10%, 100% 0, 100% 100%, 0 100%);
            margin-top: 4rem;
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
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .form-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .form-title {
            font-size: 1.75rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-note {
            background: #f0f8ff;
            border-left: 4px solid var(--accent);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0.25rem;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .form-section {
            margin: 1.5rem 0;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            background-color: #f8fafc;
        }

        .form-section h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .form-section h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent);
        }

        label {
            display: block;
            margin: 1rem 0 0.5rem;
            font-weight: 500;
            color: #334155;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            margin: 0.25rem 0 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.375rem;
            font-size: 1rem;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(7, 156, 255, 0.2);
        }

        .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            transition: color 0.2s ease;
            background: none;
            border: none;
            padding: 0.25rem;
        }

        .close-btn:hover {
            color: var(--danger);
        }

        .hidden {
            display: none;
        }

        .error {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: -0.75rem;
            margin-bottom: 0.5rem;
            display: none;
        }

        .error.active {
            display: block;
        }

        .input-error {
            border-color: var(--danger) !important;
        }

        .success-message {
            color: var(--success);
            padding: 1rem;
            border: 1px solid var(--success);
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
            background-color: rgba(16, 185, 129, 0.1);
        }

        .error-message {
            color: var(--danger);
            padding: 1rem;
            border: 1px solid var(--danger);
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
            background-color: rgba(239, 68, 68, 0.1);
        }

        .error-message ul {
            margin: 0.5rem 0 0;
            padding-left: 1.25rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .intro-section {
                padding: 4rem 1rem;
                clip-path: polygon(0 0, 100% 0, 100% 95%, 0 100%);
            }
            
            .intro-section h1 {
                font-size: 2rem;
            }

            .intro-section p {
                font-size: 1rem;
            }

            .content-section {
                padding: 2rem 1rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .card-container {
                grid-template-columns: 1fr;
            }

            .form-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .intro-section {
                padding: 3rem 1rem;
            }
            
            .intro-section h1 {
                font-size: 1.75rem;
            }

            .btn {
                padding: 0.7rem 1.5rem;
                font-size: 0.95rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade {
            animation: fadeIn 0.6s ease forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }
    </style>
</head>
<body>
    <!-- Introduction Section -->
    <div class="intro-section animate-fade">
        <div class="animate-fade delay-100">
            <h1>FUAMI Senior High School Graduates Tracker</h1>
            <p>
                The Fr. Urios Academy Of Magallanes, Inc. Senior High School Graduates Tracker is an essential tool for tracking the post-graduation pathways of FUAMI's Senior High School alumni. Through this comprehensive system, FUAMI can monitor the progress and outcomes of its graduates as they transition into higher education, employment, or other endeavors.
            </p>
            <button class="btn btn-primary" onclick="openForm()">
                <i class="fas fa-edit mr-2"></i> Fill Out SHS Tracer Form
            </button>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section animate-fade delay-200">
        <h2 class="section-title">Fr. Urios Academy Of Magallanes, Inc.</h2>

        <!-- Card Container -->
        <div class="card-container">
            <!-- Philosophy Card -->
            <div class="card animate-fade delay-300">
                <h2><i class="fas fa-lightbulb mr-2 text-accent"></i> PHILOSOPHY</h2>
                <p>
                    The manifold of the students are recognized and honed. The students become SALUTAY to their family, society and the church. As such the students are watchful (vigilant) servant. Teachers who are committed servants of God. (MASAWA).
                </p>
            </div>

            <!-- Core Values Card -->
            <div class="card animate-fade delay-300">
                <h2><i class="fas fa-star mr-2 text-accent"></i> CORE VALUES</h2>
                <ul>
                    <li>CARITAS (Care for Others)</li>
                    <li>STEWARDSHIP</li>
                    <li>COMPASSION</li>
                    <li>TEAMWORK</li>
                </ul>
            </div>

            <!-- Vision Card -->
            <div class="card animate-fade delay-300">
                <h2><i class="fas fa-eye mr-2 text-accent"></i> VISION</h2>
                <p>
                    Christ-centered persons who care for the earth and fellow human beings.
                </p>
            </div>

            <!-- Mission Card -->
            <div class="card animate-fade delay-300">
                <h2><i class="fas fa-bullseye mr-2 text-accent"></i> MISSION</h2>
                <ol>
                    <li><strong>CATHECHISM</strong> - to know Christ better and the teachings of the church.</li>
                    <li><strong>STEWARDSHIP</strong> - to become humble and obedient servants of God.</li>
                    <li><strong>STUDENT-CENTERED</strong> - the students (individually and as a group) as the center of the school's mission.</li>
                    <li><strong>COLLABORATIVE LEARNING</strong> - a collaborative relationship between students and teachers; students and students.</li>
                </ol>
            </div>

            <!-- Hallmark Card -->
            <div class="card animate-fade delay-300">
                <h2><i class="fas fa-award mr-2 text-accent"></i> HALL MARK</h2>
                <p>
                    MAGDADASIG (BERNABE)
                </p>
            </div>

            <!-- FUAMINIAN Prayer Card -->
            <div class="card animate-fade delay-300">
                <h2><i class="fas fa-pray mr-2 text-accent"></i> THE FUAMINIAN PRAYER</h2>
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
            <button class="close-btn" onclick="closeForm()">&times;</button>
            <h1 class="form-title">FUAMI Senior High School Graduate Tracer Form</h1>
            
            <div class="form-note">
                <p>
                    <strong>Dear SHS graduates of FUAMI,</strong><br><br>
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

            @if($errors->any()))
                <div class="error-message">
                    <h3><i class="fas fa-exclamation-circle mr-2"></i> Errors:</h3>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tracer.submit-shs') }}" method="POST" id="tracerForm" novalidate>
                @csrf
                <input type="hidden" name="graduate_type" value="SHS">
                <input type="hidden" name="employment_status" id="employment_status_hidden" value="Did not respond">

                <!-- Personal Information -->
                <div class="form-section">
                    <h2><i class="fas fa-user mr-2"></i> Personal Information</h2>
                    <label>First Name:
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                        <span class="error" id="first_name_error">First name is required</span>
                    </label>                    
                    <label>Middle Name:
                        <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}">
                    </label>
                    <label>Last Name:
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                        <span class="error" id="last_name_error">Last name is required</span>
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
                            <input type="text" name="suffix_other" id="suffix_other" value="{{ old('suffix_other') }}" maxlength="10">
                            <span class="error" id="suffix_other_error">Please specify your suffix</span>
                        </label>
                    </div>
                    <label>Date of Birth:
                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required onchange="calculateAge()" pattern="\d{2}/\d{2}/\d{2}">
                        <span class="error" id="birthdate_error">Date of birth is required</span>
                    </label>
                    <label>Age:
                        <input type="number" name="age" id="age" value="{{ old('age') }}" required readonly>
                        <span class="error" id="age_error">Age is required</span>
                    </label>
                    <label>Sex:
                        <select name="gender" id="gender" required>
                            <option value="">Select Sex</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        <span class="error" id="gender_error">Please select your sex</span>
                    </label>
                    <label>Civil Status:
                        <select name="civil_status" id="civil_status" required>
                            <option value="">Select Civil Status</option>
                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                        <span class="error" id="civil_status_error">Please select your civil status</span>
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
                        <span class="error" id="religion_error">Please select your religion</span>
                        <input type="text" name="religion_other" id="religion_other" 
                              value="{{ old('religion_other') }}" 
                              style="display: none; margin-top: 0.5rem;"
                              placeholder="Please specify religion">
                        <span class="error" id="religion_other_error" style="display: none;">Please specify your religion</span>
                    </label>
                    <h2><i class="fas fa-map-marker-alt mr-2"></i>Present Address</h2>
                    
                    <div class="location-fields">
                        <div class="form-group">
                            <label for="region">Region:</label>
                            <select name="region" id="region" class="form-control" required onchange="loadProvinces()">
                                <option value="">Select Region</option>
                                @foreach(App\Helpers\LocationHelper::getRegions() as $region)
                                    <option value="{{ $region['region_code'] }}" {{ old('region') == $region['region_code'] ? 'selected' : '' }}>
                                        {{ $region['region_name'] }} ({{ $region['region_code'] }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="error" id="region_error">Please select your region</span>
                        </div>

                        <div class="form-group">
                            <label for="province">Province:</label>
                            <select name="province" id="province" class="form-control" required onchange="loadCities()" disabled>
                                <option value="">Select Province</option>
                                @if(old('province'))
                                    <option value="{{ old('province') }}" selected>{{ old('province_name') }}</option>
                                @endif
                            </select>
                            <span class="error" id="province_error">Please select your province</span>
                        </div>

                        <div class="form-group">
                            <label for="municipality">City/Municipality:</label>
                            <select name="municipality" id="city" class="form-control" required onchange="loadBarangays()" disabled>
                                <option value="">Select City/Municipality</option>
                                @if(old('city'))
                                    <option value="{{ old('city') }}" selected>{{ old('city_name') }}</option>
                                @endif
                            </select>
                            <span class="error" id="city_error">Please select your city/municipality</span>
                        </div>

                        <div class="form-group">
                            <label for="barangay">Barangay:</label>
                            <select name="barangay" id="barangay" class="form-control" required disabled>
                                <option value="">Select Barangay</option>
                                @if(old('barangay'))
                                    <option value="{{ old('barangay') }}" selected>{{ old('brgy_name') }}</option>
                                @endif
                            </select>
                            <span class="error" id="barangay_error">Please select your barangay</span>
                            <input type="hidden" name="postal_code" value="0000">
                            <input type="hidden" name="country" value="{{ old('country', 'Philippines') }}">
                            <label>Purok/Street:
                                <input type="text" name="address" id="address" value="{{ old('address') }}">
                            </label>
                            <div class="form-group">
                                <label for="country">Country:</label>
                                <input type="text" name="country" id="country" class="form-control" value="{{ old('country', 'Philippines') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Education Information (SHS specific) -->
                <div class="form-section">
                    <h2><i class="fas fa-graduation-cap mr-2"></i> Education Information</h2>
                    <label>SHS Track/Strand Completed:
                        <select name="shs_track" id="shs_track" required>
                            <option value="" disabled selected hidden>Select Program</option>
                            <optgroup label="Academic Strand">
                                <option value="STEM" {{ old('shs_track') == 'STEM' ? 'selected' : '' }}>STEM - Science, Technology, Engineering, and Mathematics</option>
                                <option value="ABM" {{ old('shs_track') == 'ABM' ? 'selected' : '' }}>ABM - Accountancy, Business, and Management</option>
                                <option value="HUMSS" {{ old('shs_track') == 'HUMSS' ? 'selected' : '' }}>HUMSS - Humanities and Social Sciences</option>
                                <option value="GAS" {{ old('shs_track') == 'GAS' ? 'selected' : '' }}>GAS - General Academic Strand</option>
                            </optgroup>
                            <optgroup label="TVL Strand">
                                <option value="ICT" {{ old('shs_track') == 'ICT' ? 'selected' : '' }}>ICT - Information and Communications Technology</option>
                                <option value="HE" {{ old('shs_track') == 'HE' ? 'selected' : '' }}>HE - Home Economics</option>
                                <option value="IA" {{ old('shs_track') == 'IA' ? 'selected' : '' }}>IA - Industrial Arts</option>
                            </optgroup>
                        </select>
                        <span class="error" id="shs_track_error">Please select your SHS track/strand</span>
                    </label>
                    <label>Year Graduated:
                        <select name="year_graduated" id="year_graduated" required>
                            <option value="">Select Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ old('year_graduated') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <span class="error" id="year_graduated_error">Please select your year of graduation</span>
                    </label>
                    <label>Educational Attainment:
                        <input type="text" name="educational_attainment" id="educational_attainment" value="{{ old('educational_attainment') }}" required>
                        <span class="error" id="educational_attainment_error">Educational attainment is required</span>
                    </label>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <h2><i class="fas fa-address-book mr-2"></i> Contact Information (Optional)</h2>
                    <label>Phone Number:
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" pattern="[0-9]{10,15}">
                        <span class="error" id="phone_error">Please enter a valid phone number (10-15 digits)</span>
                    </label>
                    <label>Email Address:
                        <input type="email" name="email" id="email" value="{{ old('email') }}">
                        <span class="error" id="email_error">Please enter a valid email address</span>
                    </label>
                </div>

                <!-- Employment Information -->
                <div class="form-section">
                    <h2><i class="fas fa-briefcase mr-2"></i> Employment Information</h2>
                    <label>Employment Status:
                        <select name="employment_status_display" id="employment_status_display" onchange="toggleEmploymentFields()">
                            <option value="">Select Status</option>
                            <option value="Employed" {{ old('employment_status') == 'Employed' ? 'selected' : '' }}>Employed</option>
                            <option value="Unemployed" {{ old('employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                        </select>
                        <span class="error" id="employment_status_error">Please select your employment status</span>
                    </label>

                    <!-- Employed Fields -->
                    <div id="employed_fields" class="hidden">
                        <h3><i class="fas fa-building mr-2"></i> Employment Details</h3>
                        
                        <!-- Organization Type -->
                        <label>Organization Type:
                            <select name="organization_type" id="organization_type" onchange="toggleOrgTypeOther()">
                                <option value="">Select Organization Type</option>
                                @foreach($organizationTypes as $type)
                                    <option value="{{ $type }}" {{ old('organization_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="error" id="organization_type_error">Please select organization type</span>
                        </label>
                        <div id="org_type_other_container" style="display: none; margin-top: 0.5rem;">
                            <label>Please specify organization type:
                                <input type="text" name="organization_type_other" id="organization_type_other" 
                                    value="{{ old('organization_type_other') }}"
                                    placeholder="Enter organization type">
                                <span class="error" id="organization_type_other_error">Please specify organization type</span>
                            </label>
                        </div>

                        <!-- Occupational Classification -->
                        <label>Occupational Classification:
                            <select name="occupational_classification" id="occupational_classification" onchange="toggleOccClassOther()">
                                <option value="">Select Classification</option>
                                @foreach($occupationClassifications as $group => $options)
                                    @if(is_array($options))
                                        <optgroup label="{{ $group }}">
                                            @foreach($options as $option)
                                                <option value="{{ $option }}" {{ old('occupational_classification') == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{ $options }}" {{ old('occupational_classification') == $options ? 'selected' : '' }}>
                                            {{ $options }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="error" id="occupational_classification_error">Please select occupational classification</span>
                        </label>
                        <div id="occ_class_other_container" style="display: none;">
                            <label>Specify Occupational Classification:
                                <input type="text" name="occupational_classification_other" id="occupational_classification_other" value="{{ old('occupational_classification_other') }}" maxlength="255">
                                <span class="error" id="occupational_classification_other_error">Please specify occupational classification</span>
                            </label>
                        </div>
                        
                        <label>Employer Name:
                            <input type="text" name="employer_name" id="employer_name" value="{{ old('employer_name') }}">
                            <span class="error" id="employer_name_error">Employer name is required</span>
                        </label>
                        <label>Employer Address:
                            <input type="text" name="employer_address" id="employer_address" value="{{ old('employer_address') }}">
                            <span class="error" id="employer_address_error">Employer address is required</span>
                        </label>
                        <label>Employment Type:
                            <select name="job_situation" id="job_situation">
                                <option value="">Select Situation</option>
                                <option value="Permanent" {{ old('job_situation') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                <option value="Contractual" {{ old('job_situation') == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                <option value="Casual" {{ old('job_situation') == 'Casual' ? 'selected' : '' }}>Not Permanent</option>
                                <option value="Others" {{ old('job_situation') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            <span class="error" id="job_situation_error">Please select employment type</span>
                        </label>
                        <label>Years in Company:
                            <select name="years_in_company" id="years_in_company">
                                <option value="">Select Years</option>
                                <option value="0-5" {{ old('years_in_company') == '0-5' ? 'selected' : '' }}>0-5 years</option>
                                <option value="6-10" {{ old('years_in_company') == '6-10' ? 'selected' : '' }}>6-10 years</option>
                                <option value="10-15" {{ old('years_in_company') == '10-15' ? 'selected' : '' }}>10-15 years</option>
                                <option value="16-20" {{ old('years_in_company') == '16-20' ? 'selected' : '' }}>16-20 years</option>
                                <option value="20-25" {{ old('years_in_company') == '20-25' ? 'selected' : '' }}>20-25 years</option>
                                <option value="25 above" {{ old('years_in_company') == '25 above' ? 'selected' : '' }}>25+ years</option>
                            </select>
                            <span class="error" id="years_in_company_error">Please select years in company</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" class="btn border border-gray-300 text-gray-800 hover:bg-gray-100" onclick="closeForm()">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-paper-plane mr-2"></i> Submit SHS Form
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show complimentary message after form submission
        function showSuccessMessage() {
            Swal.fire({
                title: 'Thank You!',
                text: 'Your response has been successfully recorded.',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#1d4ed8'
            });
        }
        
        // Execute the success message if we returned with a success status
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showSuccessMessage();
            @endif
            
            // Initialize form elements
            toggleEmploymentFields();
            document.getElementById('currentYear').textContent = new Date().getFullYear();
            
            // Initialize address fields if values exist
            const region = document.getElementById('region');
            if (region && region.value) {
                loadProvinces();
            }
            
            // Initialize religion fields
            handleReligionChange();
            
            // Set date format for date inputs
            const birthdateInput = document.getElementById('birthdate');
            if (birthdateInput) {
                birthdateInput.addEventListener('focus', function() {
                    this.type = 'date';
                });
                birthdateInput.addEventListener('blur', function() {
                    if (!this.value) {
                        this.type = 'text';
                    }
                });
            }

            // Set employment status before form submission
            document.getElementById('tracerForm').addEventListener('submit', function(e) {
                // First validate the form
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                const statusDisplay = document.getElementById('employment_status_display').value;
                const hiddenStatusField = document.getElementById('employment_status_hidden');
                
                if (statusDisplay === 'Employed') {
                    hiddenStatusField.value = 'Employed';
                } else if (statusDisplay === 'Unemployed') {
                    hiddenStatusField.value = 'Unemployed';
                } else {
                    hiddenStatusField.value = 'Did not respond';
                }
            });

            // Add real-time validation for all fields
            setupRealTimeValidation();
        });

        // Address dropdown functions
        function loadProvinces() {
            const region = document.getElementById('region').value;
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const barangaySelect = document.getElementById('barangay');
            
            // Reset dependent fields
            provinceSelect.innerHTML = '<option value="">Select Province</option>';
            provinceSelect.disabled = !region;
            
            citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
            citySelect.disabled = true;
            
            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
            barangaySelect.disabled = true;

            if (!region) return;

            showLoader(provinceSelect);
            
            fetch(`/api/provinces?region=${encodeURIComponent(region)}`)
                .then(handleResponse)
                .then(data => {
                    provinceSelect.innerHTML = '<option value="">Select Province</option>';
                    data.forEach(province => {
                        const option = new Option(province.name, province.code);
                        provinceSelect.add(option);
                    });
                    
                    // Restore old value if exists
                    const oldProvince = "{{ old('province') }}";
                    if (oldProvince) {
                        provinceSelect.value = oldProvince;
                        loadCities();
                    }
                })
                .catch(handleError.bind(null, provinceSelect));
        }

        function loadCities() {
            const province = document.getElementById('province').value;
            const citySelect = document.getElementById('city');
            const barangaySelect = document.getElementById('barangay');
            
            // Reset dependent field
            citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
            citySelect.disabled = !province;
            
            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
            barangaySelect.disabled = true;

            if (!province) return;

            showLoader(citySelect);
            
            fetch(`/api/cities?province=${encodeURIComponent(province)}`)
                .then(handleResponse)
                .then(data => {
                    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                    data.forEach(city => {
                        const option = new Option(city.name, city.code);
                        citySelect.add(option);
                    });
                    
                    // Restore old value if exists
                    const oldCity = "{{ old('city') }}";
                    if (oldCity) {
                        citySelect.value = oldCity;
                        loadBarangays();
                    }
                })
                .catch(handleError.bind(null, citySelect));
        }

        function loadBarangays() {
            const city = document.getElementById('city').value;
            const barangaySelect = document.getElementById('barangay');
            
            barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
            barangaySelect.disabled = !city;

            if (!city) return;

            showLoader(barangaySelect);
            
            fetch(`/api/barangays?city=${encodeURIComponent(city)}`)
                .then(handleResponse)
                .then(data => {
                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                    data.forEach(barangay => {
                        const option = new Option(barangay.name, barangay.code);
                        barangaySelect.add(option);
                    });
                    
                    // Restore old value if exists
                    const oldBarangay = "{{ old('barangay') }}";
                    if (oldBarangay) {
                        barangaySelect.value = oldBarangay;
                    }
                })
                .catch(handleError.bind(null, barangaySelect));
        }

        // Helper functions for address dropdowns
        function handleResponse(response) {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        }

        function handleError(selectElement, error) {
            console.error('Error:', error);
            selectElement.innerHTML = `<option value="">Error loading data</option>`;
        }

        function showLoader(selectElement) {
            const loaderOption = document.createElement('option');
            loaderOption.value = '';
            loaderOption.textContent = 'Loading...';
            loaderOption.disabled = true;
            selectElement.innerHTML = '';
            selectElement.appendChild(loaderOption);
        }

        function toggleEmploymentFields() {
            const status = document.getElementById('employment_status_display').value;
            const employedFields = document.getElementById('employed_fields');
            
            // List of all employed-related fields
            const employedFieldsToToggle = [
                'organization_type',
                'occupational_classification',
                'employer_name',
                'employer_address',
                'job_situation',
                'years_in_company'
            ];
            
            if (status === 'Employed') {
                employedFields.style.display = 'block';
                
                // Add required attributes
                employedFieldsToToggle.forEach(field => {
                    const fieldElement = document.getElementsByName(field)[0];
                    if (fieldElement) fieldElement.required = true;
                });
            } else {
                employedFields.style.display = 'none';
                
                // Remove required attributes
                employedFieldsToToggle.forEach(field => {
                    const fieldElement = document.getElementsByName(field)[0];
                    if (fieldElement) fieldElement.required = false;
                });
            }
        }

        function openForm() {
            document.getElementById('formModal').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when form is open
        }

        function closeForm() {
            document.getElementById('formModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
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

        function handleReligionChange() {
            const religionSelect = document.getElementById('religion');
            const religionOtherInput = document.getElementById('religion_other');
            const religionOtherError = document.getElementById('religion_other_error');
            
            if (religionSelect.value === 'Others') {
                religionOtherInput.style.display = 'block';
                religionOtherInput.setAttribute('required', 'required');
                religionOtherError.style.display = 'block';
            } else {
                religionOtherInput.style.display = 'none';
                religionOtherInput.removeAttribute('required');
                religionOtherError.style.display = 'none';
            }
        }

        function toggleOrgTypeOther() {
            const orgTypeSelect = document.getElementById('organization_type');
            const otherContainer = document.getElementById('org_type_other_container');
            const otherError = document.getElementById('organization_type_other_error');
            
            if (orgTypeSelect.value === 'Other') {
                otherContainer.style.display = 'block';
                document.getElementById('organization_type_other').setAttribute('required', 'required');
                otherError.style.display = 'block';
            } else {
                otherContainer.style.display = 'none';
                document.getElementById('organization_type_other').removeAttribute('required');
                otherError.style.display = 'none';
            }
        }

        function toggleOccClassOther() {
            const occClassSelect = document.getElementById('occupational_classification');
            const otherContainer = document.getElementById('occ_class_other_container');
            const otherError = document.getElementById('occupational_classification_other_error');
            
            if (occClassSelect.value === 'Other') {
                otherContainer.style.display = 'block';
                otherError.style.display = 'block';
            } else {
                otherContainer.style.display = 'none';
                otherError.style.display = 'none';
            }
        }

        function toggleOtherSuffix() {
            const suffixSelect = document.getElementById('suffix');
            const otherSuffixContainer = document.getElementById('otherSuffixContainer');
            const otherError = document.getElementById('suffix_other_error');
            
            if (suffixSelect.value === 'Other') {
                otherSuffixContainer.style.display = 'block';
                document.getElementById('suffix_other').setAttribute('required', 'required');
                otherError.style.display = 'block';
            } else {
                otherSuffixContainer.style.display = 'none';
                document.getElementById('suffix_other').removeAttribute('required');
                otherError.style.display = 'none';
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('formModal');
            if (event.target == modal) {
                closeForm();
            }
        }

        // Setup real-time validation for all fields
        function setupRealTimeValidation() {
            // Personal Information
            document.getElementById('first_name').addEventListener('input', validateFirstName);
            document.getElementById('last_name').addEventListener('input', validateLastName);
            document.getElementById('birthdate').addEventListener('change', validateBirthdate);
            document.getElementById('gender').addEventListener('change', validateGender);
            document.getElementById('civil_status').addEventListener('change', validateCivilStatus);
            document.getElementById('religion').addEventListener('change', validateReligion);
            document.getElementById('religion_other').addEventListener('input', validateReligionOther);
            document.getElementById('region').addEventListener('change', validateRegion);
            document.getElementById('province').addEventListener('change', validateProvince);
            document.getElementById('city').addEventListener('change', validateCity);
            document.getElementById('barangay').addEventListener('change', validateBarangay);
            
            // Education Information
            document.getElementById('shs_track').addEventListener('change', validateShsTrack);
            document.getElementById('year_graduated').addEventListener('change', validateYearGraduated);
            document.getElementById('educational_attainment').addEventListener('input', validateEducationalAttainment);
            
            // Contact Information
            document.getElementById('phone').addEventListener('input', validatePhone);
            document.getElementById('email').addEventListener('input', validateEmail);
            
            // Employment Information
            document.getElementById('employment_status_display').addEventListener('change', validateEmploymentStatus);
            document.getElementById('organization_type').addEventListener('change', validateOrganizationType);
            document.getElementById('organization_type_other').addEventListener('input', validateOrganizationTypeOther);
            document.getElementById('occupational_classification').addEventListener('change', validateOccupationalClassification);
            document.getElementById('occupational_classification_other').addEventListener('input', validateOccupationalClassificationOther);
            document.getElementById('employer_name').addEventListener('input', validateEmployerName);
            document.getElementById('employer_address').addEventListener('input', validateEmployerAddress);
            document.getElementById('job_situation').addEventListener('change', validateJobSituation);
            document.getElementById('years_in_company').addEventListener('change', validateYearsInCompany);
        }

        // Validation functions
        function validateFirstName() {
            const firstName = document.getElementById('first_name');
            const error = document.getElementById('first_name_error');
            if (!firstName.value.trim()) {
                showError(firstName, error, 'First name is required');
                return false;
            }
            hideError(firstName, error);
            return true;
        }

        function validateLastName() {
            const lastName = document.getElementById('last_name');
            const error = document.getElementById('last_name_error');
            if (!lastName.value.trim()) {
                showError(lastName, error, 'Last name is required');
                return false;
            }
            hideError(lastName, error);
            return true;
        }

        function validateBirthdate() {
            const birthdate = document.getElementById('birthdate');
            const error = document.getElementById('birthdate_error');
            if (!birthdate.value) {
                showError(birthdate, error, 'Date of birth is required');
                return false;
            }
            
            // Validate age range (5-100 years old)
            const today = new Date();
            const birthDate = new Date(birthdate.value);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age < 5 || age > 100) {
                showError(birthdate, error, 'Please enter a valid date of birth (age)');
                return false;
            }
            
            hideError(birthdate, error);
            return true;
        }

        function validateGender() {
            const gender = document.getElementById('gender');
            const error = document.getElementById('gender_error');
            if (!gender.value) {
                showError(gender, error, 'Please select your sex');
                return false;
            }
            hideError(gender, error);
            return true;
        }

        function validateCivilStatus() {
            const civilStatus = document.getElementById('civil_status');
            const error = document.getElementById('civil_status_error');
            if (!civilStatus.value) {
                showError(civilStatus, error, 'Please select your civil status');
                return false;
            }
            hideError(civilStatus, error);
            return true;
        }

        function validateReligion() {
            const religion = document.getElementById('religion');
            const error = document.getElementById('religion_error');
            if (!religion.value) {
                showError(religion, error, 'Please select your religion');
                return false;
            }
            hideError(religion, error);
            return true;
        }

        function validateReligionOther() {
            const religionOther = document.getElementById('religion_other');
            const error = document.getElementById('religion_other_error');
            if (document.getElementById('religion').value === 'Others' && !religionOther.value.trim()) {
                showError(religionOther, error, 'Please specify your religion');
                return false;
            }
            hideError(religionOther, error);
            return true;
        }

        function validateRegion() {
            const region = document.getElementById('region');
            const error = document.getElementById('region_error');
            if (!region.value) {
                showError(region, error, 'Please select your region');
                return false;
            }
            hideError(region, error);
            return true;
        }

        function validateProvince() {
            const province = document.getElementById('province');
            const error = document.getElementById('province_error');
            if (!province.value) {
                showError(province, error, 'Please select your province');
                return false;
            }
            hideError(province, error);
            return true;
        }

        function validateCity() {
            const city = document.getElementById('city');
            const error = document.getElementById('city_error');
            if (!city.value) {
                showError(city, error, 'Please select your city/municipality');
                return false;
            }
            hideError(city, error);
            return true;
        }

        function validateBarangay() {
            const barangay = document.getElementById('barangay');
            const error = document.getElementById('barangay_error');
            if (!barangay.value) {
                showError(barangay, error, 'Please select your barangay');
                return false;
            }
            hideError(barangay, error);
            return true;
        }

        function validateShsTrack() {
            const shsTrack = document.getElementById('shs_track');
            const error = document.getElementById('shs_track_error');
            if (!shsTrack.value) {
                showError(shsTrack, error, 'Please select your SHS track/strand');
                return false;
            }
            hideError(shsTrack, error);
            return true;
        }

        function validateYearGraduated() {
            const yearGraduated = document.getElementById('year_graduated');
            const error = document.getElementById('year_graduated_error');
            if (!yearGraduated.value) {
                showError(yearGraduated, error, 'Please select your year of graduation');
                return false;
            }
            hideError(yearGraduated, error);
            return true;
        }

        function validateEducationalAttainment() {
            const educationalAttainment = document.getElementById('educational_attainment');
            const error = document.getElementById('educational_attainment_error');
            if (!educationalAttainment.value.trim()) {
                showError(educationalAttainment, error, 'Educational attainment is required');
                return false;
            }
            hideError(educationalAttainment, error);
            return true;
        }

        function validatePhone() {
            const phone = document.getElementById('phone');
            const error = document.getElementById('phone_error');
            
            if (phone.value && !/^[0-9]{10,15}$/.test(phone.value)) {
                showError(phone, error, 'Please enter a valid phone number (10-15 digits)');
                return false;
            }
            hideError(phone, error);
            return true;
        }

        function validateEmail() {
            const email = document.getElementById('email');
            const error = document.getElementById('email_error');
            
            if (email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                showError(email, error, 'Please enter a valid email address');
                return false;
            }
            hideError(email, error);
            return true;
        }

        function validateEmploymentStatus() {
            const employmentStatus = document.getElementById('employment_status_display');
            const error = document.getElementById('employment_status_error');
            if (!employmentStatus.value) {
                showError(employmentStatus, error, 'Please select your employment status');
                return false;
            }
            hideError(employmentStatus, error);
            return true;
        }

        function validateOrganizationType() {
            const organizationType = document.getElementById('organization_type');
            const error = document.getElementById('organization_type_error');
            
            // Only validate if employment status is Employed
            if (document.getElementById('employment_status_display').value === 'Employed' && !organizationType.value) {
                showError(organizationType, error, 'Please select organization type');
                return false;
            }
            hideError(organizationType, error);
            return true;
        }

        function validateOrganizationTypeOther() {
            const organizationTypeOther = document.getElementById('organization_type_other');
            const error = document.getElementById('organization_type_other_error');
            
            if (document.getElementById('organization_type').value === 'Other' && !organizationTypeOther.value.trim()) {
                showError(organizationTypeOther, error, 'Please specify organization type');
                return false;
            }
            hideError(organizationTypeOther, error);
            return true;
        }

        function validateOccupationalClassification() {
            const occupationalClassification = document.getElementById('occupational_classification');
            const error = document.getElementById('occupational_classification_error');
            
            // Only validate if employment status is Employed
            if (document.getElementById('employment_status_display').value === 'Employed' && !occupationalClassification.value) {
                showError(occupationalClassification, error, 'Please select occupational classification');
                return false;
            }
            hideError(occupationalClassification, error);
            return true;
        }

        function validateOccupationalClassificationOther() {
            const occupationalClassificationOther = document.getElementById('occupational_classification_other');
            const error = document.getElementById('occupational_classification_other_error');
            
            if (document.getElementById('occupational_classification').value === 'Other' && !occupationalClassificationOther.value.trim()) {
                showError(occupationalClassificationOther, error, 'Please specify occupational classification');
                return false;
            }
            hideError(occupationalClassificationOther, error);
            return true;
        }

        function validateEmployerName() {
            const employerName = document.getElementById('employer_name');
            const error = document.getElementById('employer_name_error');
            
            // Only validate if employment status is Employed
            if (document.getElementById('employment_status_display').value === 'Employed' && !employerName.value.trim()) {
                showError(employerName, error, 'Employer name is required');
                return false;
            }
            hideError(employerName, error);
            return true;
        }

        function validateEmployerAddress() {
            const employerAddress = document.getElementById('employer_address');
            const error = document.getElementById('employer_address_error');
            
            // Only validate if employment status is Employed
            if (document.getElementById('employment_status_display').value === 'Employed' && !employerAddress.value.trim()) {
                showError(employerAddress, error, 'Employer address is required');
                return false;
            }
            hideError(employerAddress, error);
            return true;
        }

        function validateJobSituation() {
            const jobSituation = document.getElementById('job_situation');
            const error = document.getElementById('job_situation_error');
            
            // Only validate if employment status is Employed
            if (document.getElementById('employment_status_display').value === 'Employed' && !jobSituation.value) {
                showError(jobSituation, error, 'Please select employment type');
                return false;
            }
            hideError(jobSituation, error);
            return true;
        }

        function validateYearsInCompany() {
            const yearsInCompany = document.getElementById('years_in_company');
            const error = document.getElementById('years_in_company_error');
            
            // Only validate if employment status is Employed
            if (document.getElementById('employment_status_display').value === 'Employed' && !yearsInCompany.value) {
                showError(yearsInCompany, error, 'Please select years in company');
                return false;
            }
            hideError(yearsInCompany, error);
            return true;
        }

        // Helper functions for validation
        function showError(inputElement, errorElement, message) {
            inputElement.classList.add('input-error');
            errorElement.textContent = message;
            errorElement.classList.add('active');
        }

        function hideError(inputElement, errorElement) {
            inputElement.classList.remove('input-error');
            errorElement.classList.remove('active');
        }

        // Main form validation function
        function validateForm() {
            let isValid = true;
            
            // Personal Information
            isValid = validateFirstName() && isValid;
            isValid = validateLastName() && isValid;
            isValid = validateBirthdate() && isValid;
            isValid = validateGender() && isValid;
            isValid = validateCivilStatus() && isValid;
            isValid = validateReligion() && isValid;
            isValid = validateReligionOther() && isValid;
            isValid = validateRegion() && isValid;
            isValid = validateProvince() && isValid;
            isValid = validateCity() && isValid;
            isValid = validateBarangay() && isValid;
            
            // Education Information
            isValid = validateShsTrack() && isValid;
            isValid = validateYearGraduated() && isValid;
            isValid = validateEducationalAttainment() && isValid;
            
            // Contact Information
            isValid = validatePhone() && isValid;
            isValid = validateEmail() && isValid;
            
            // Employment Information
            isValid = validateEmploymentStatus() && isValid;
            
            // Only validate employment details if employed
            if (document.getElementById('employment_status_display').value === 'Employed') {
                isValid = validateOrganizationType() && isValid;
                isValid = validateOrganizationTypeOther() && isValid;
                isValid = validateOccupationalClassification() && isValid;
                isValid = validateOccupationalClassificationOther() && isValid;
                isValid = validateEmployerName() && isValid;
                isValid = validateEmployerAddress() && isValid;
                isValid = validateJobSituation() && isValid;
                isValid = validateYearsInCompany() && isValid;
            }
            
            // Scroll to first error if form is invalid
            if (!isValid) {
                const firstError = document.querySelector('.error.active');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                Swal.fire({
                    title: 'Form Validation Error',
                    text: 'Please correct the highlighted fields before submitting.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ef4444'
                });
            }
            
            return isValid;
        }
    </script>
    
    <!-- SweetAlert2 for better alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>