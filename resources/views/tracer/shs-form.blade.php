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
            <h1 class="form-title">FUAMI Senior Highschool Graduate Tracer Form</h1>
            
            <div class="form-note">
                <p>
                    <strong>Dear graduates of FUAMI,</strong><br><br>
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

            <form action="{{ route('tracer.submit-shs') }}" method="POST">
                @csrf
                <input type="hidden" name="graduate_type" value="SHS">

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
    </div>

    <div class="form-group">
        <label for="province">Province:</label>
        <select name="province" id="province" class="form-control" required onchange="loadCities()" disabled>
            <option value="">Select Province</option>
            @if(old('province'))
                <option value="{{ old('province') }}" selected>{{ old('province_name') }}</option>
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="municipality">City/Municipality:</label>
        <select name="municipality" id="city" class="form-control" required onchange="loadBarangays()" disabled>
            <option value="">Select City/Municipality</option>
            @if(old('city'))
                <option value="{{ old('city') }}" selected>{{ old('city_name') }}</option>
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="barangay">Barangay:</label>
        <select name="barangay" id="barangay" class="form-control" required disabled>
            <option value="">Select Barangay</option>
            @if(old('barangay'))
                <option value="{{ old('barangay') }}" selected>{{ old('brgy_name') }}</option>
            @endif
        </select>
        <input type="hidden" name="postal_code" value="0000">
        <input type="hidden" name="country" value="{{ old('country', 'Philippines') }}">
        <label>Purok/Street:
            <input type="text" name="address" value="{{ old('address') }}">
        </label>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', 'Philippines') }}" readonly>
        </div>
    </div>
</div>
        </div>

                    <!-- Education Information (only for SHS) -->
                    <div class="form-section" id="education-section" style="display: none;">
                    <h2><i class="fas fa-graduation-cap mr-2"></i> Education Information</h2>
                    <label>SHS Track/Strand Completed:
                            <select name="shs_track" id="shs_track">
                            <option disabled selected hidden value="">Select Program</option>
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
                    </label>
                    <label>Year Graduated:
                        <select name="year_graduated" required>
                            <option value="">Select Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ old('year_graduated') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <h2><i class="fas fa-address-book mr-2"></i> Contact Information (Optional)</h2>
                    <label>Phone Number:
                        <input type="text" name="phone" value="{{ old('phone') }}">
                    </label>
                    <label>Email Address:
                        <input type="email" name="email" value="{{ old('email') }}">
                    </label>
                </div>

                <!-- Employment Information -->
                <div class="form-section">
                    <h2><i class="fas fa-briefcase mr-2"></i> Employment Information</h2>
                    <label>Employment Status:
                        <select name="employment_status" id="employment_status" required onchange="toggleEmploymentFields()">
                            <option value="">Select Status</option>
                            <option value="Employed" {{ old('employment_status') == 'Employed' ? 'selected' : '' }}>Employed</option>
                            <option value="Unemployed" {{ old('employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                        </select>
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
    </label>
    <div id="org_type_other_container" style="display: none; margin-top: 0.5rem;">
        <label>Please specify organization type:
            <input type="text" name="organization_type_other" id="organization_type_other" 
                   value="{{ old('organization_type_other') }}"
                   placeholder="Enter organization type">
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
    </label>
    <div id="occ_class_other_container" style="display: none;">
        <label>Specify Occupational Classification:
            <input type="text" name="occupational_classification_other" value="{{ old('occupational_classification_other') }}" maxlength="255">
        </label>
    </div>
                            
            <label>Employer Name:
           <input type="text" name="employer_name" value="{{ old('employer_name') }}">
             </label>
            <label>Employer Address:
                <input type="text" name="employer_address" value="{{ old('employer_address') }}">
            </label>
            <label>Employment Type:
                <select name="job_situation">
                    <option value="">Select Situation</option>
                    <option value="Permanent" {{ old('job_situation') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                    <option value="Contractual" {{ old('job_situation') == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                    <option value="Casual" {{ old('job_situation') == 'Casual' ? 'selected' : '' }}>Not Permanent</option>
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
        </div>

        <!-- Unemployed Fields -->
        <div id="unemployed_fields" class="hidden">
            <h3><i class="fas fa-user-clock mr-2"></i> Unemployment Details</h3>
            <label>Reasons for Unemployment:
                <textarea name="unemployment_reason" rows="4">{{ old('unemployment_reason') }}</textarea>
            </label>
        </div>
    </div>

    <div class="flex justify-between mt-6">
    <button type="button" class="btn border border-gray-300 text-gray-800 hover:bg-gray-100" onclick="closeForm()">
<i class="fas fa-times mr-2"></i> Cancel
</button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane mr-2"></i> Submit Form
        </button>
        </div>
    </div>
</form>
        </div>
    </div>

    <script>
        // Show complimentary message after form submission - now done separately after success
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
            
            toggleEmploymentFields();
            document.getElementById('currentYear').textContent = new Date().getFullYear();
            
            // Initialize education section for SHS form
            const educationSection = document.getElementById('education-section');
            if (educationSection) {
                educationSection.style.display = 'block';
            }
            
            const shsTrackField = document.getElementById('shs_track');
            if (shsTrackField) {
                shsTrackField.setAttribute('required', 'required');
            }
            
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
    const status = document.getElementById('employment_status').value;
    const employedFields = document.getElementById('employed_fields');
    const unemployedFields = document.getElementById('unemployed_fields');
    
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
        unemployedFields.style.display = 'none';
        
        // Add required attributes
        employedFieldsToToggle.forEach(field => {
            const fieldElement = document.getElementsByName(field)[0];
            if (fieldElement) fieldElement.required = true;
        });
            } else if (status === 'Unemployed') {
        employedFields.style.display = 'none';
        unemployedFields.style.display = 'block';
        
        // Remove required attributes
        employedFieldsToToggle.forEach(field => {
            const fieldElement = document.getElementsByName(field)[0];
            if (fieldElement) fieldElement.required = false;
        });
                
                // Ensure unemployment_reason is not required
                const unemploymentReasonField = document.getElementsByName('unemployment_reason')[0];
                if (unemploymentReasonField) unemploymentReasonField.removeAttribute('required');
            } else {
                employedFields.style.display = 'none';
                unemployedFields.style.display = 'none';
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
            
            if (religionSelect.value === 'Others') {
                religionOtherInput.style.display = 'block';
                religionOtherInput.setAttribute('required', 'required');
            } else {
                religionOtherInput.style.display = 'none';
                religionOtherInput.removeAttribute('required');
            }
        }

        function toggleOrgTypeOther() {
            const orgTypeSelect = document.getElementById('organization_type');
            const otherContainer = document.getElementById('org_type_other_container');
            
            if (orgTypeSelect.value === 'Other') {
                otherContainer.style.display = 'block';
                document.getElementById('organization_type_other').setAttribute('required', 'required');
            } else {
                otherContainer.style.display = 'none';
                document.getElementById('organization_type_other').removeAttribute('required');
            }
        }

        function toggleOccClassOther() {
            const occClassSelect = document.getElementById('occupational_classification');
            const otherContainer = document.getElementById('occ_class_other_container');
            
            if (occClassSelect.value === 'Others (please specify)') {
                otherContainer.style.display = 'block';
            } else {
                otherContainer.style.display = 'none';
            }
        }

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

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('formModal');
            if (event.target == modal) {
                closeForm();
            }
        }

        // Add these functions for address auto-fill
        function autoFillPostalCode() {
            const city = document.getElementById('city').value;
            const postalCodeMap = {
                'MAGALLANES': '8604',
                // Add more city-postal code mappings as needed
            };
            
            if (city && postalCodeMap[city]) {
                document.getElementById('postal_code').value = postalCodeMap[city];
            }
        }

        // Add event listener for city change
        document.getElementById('city').addEventListener('change', function() {
            autoFillPostalCode();
        });

        // Initialize postal code if city is already selected
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('city').value) {
                autoFillPostalCode();
            }
        });
    </script>
    
    <!-- SweetAlert2 for better alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>