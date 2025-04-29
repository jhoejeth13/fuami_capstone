<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUAMI Alumni Tracer System</title>
    <!-- Font Awesome (Local) -->
    @include('includes.fontawesome')
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Glide.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.5.0/css/glide.core.min.css">
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
            --text-accent: #079cff;
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

        /* Announcements Section */
        .announcements-section {
            max-width: 1200px;
            margin: 0 auto 2rem;
            position: relative;
            z-index: 1;
        }

        .announcements-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .announcements-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 0.75rem;
        }

        .announcements-header h2 {
            color: var(--primary);
            font-size: 1.5rem;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .announcements-header h2 i {
            margin-right: 0.75rem;
            color: var(--accent);
        }

        .announcement-item {
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .announcement-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .announcement-item.urgent {
            border-left-color: var(--danger);
            background-color: rgba(239, 68, 68, 0.05);
        }

        .announcement-item.important {
            border-left-color: var(--warning);
            background-color: rgba(245, 158, 11, 0.05);
        }

        .announcement-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .announcement-title .badge {
            margin-left: 0.75rem;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        .announcement-content {
            color: var(--dark);
            margin-bottom: 1rem;
            line-height: 1.7;
        }

        .announcement-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .announcement-date {
            display: flex;
            align-items: center;
        }

        .announcement-date i {
            margin-right: 0.4rem;
        }

        /* FUAMI Information Section */
        .section-title {
            text-align: center;
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--accent);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            color: var(--primary-dark);
            font-size: 1.3rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .card p, .card ul, .card ol {
            color: #4b5563;
            line-height: 1.7;
        }

        .card ul, .card ol {
            padding-left: 1.5rem;
        }

        .card li {
            margin-bottom: 0.5rem;
        }

        .text-accent {
            color: var(--text-accent);
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

        .selection-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .selection-container h2 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }

        .selection-container p {
            color: #4b5563;
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            width: 100%;
            margin-top: 1rem;
        }

        .selection-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            width: 300px;
            text-decoration: none;
            color: inherit;
        }

        .selection-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .button-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background-color: #e7f1ff;
            border-radius: 50%;
            margin-bottom: 1.5rem;
        }

        .button-icon i {
            font-size: 2rem;
            color: var(--primary);
        }

        .selection-button h3 {
            font-size: 1.4rem;
            margin-bottom: 0.75rem;
            color: var(--primary-dark);
        }

        .selection-button p {
            font-size: 0.95rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .start-button {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .start-button:hover {
            background-color: var(--primary-dark);
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

            .buttons-container {
                gap: 1.5rem;
            }

            .selection-button {
                width: 100%;
                padding: 1.5rem;
            }
            
            .announcements-container {
                padding: 1.5rem;
            }
            
            .announcement-title {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .announcement-title .badge {
                margin-left: 0;
                margin-top: 0.5rem;
            }
            
            .announcement-meta {
                flex-direction: column;
            }
            
            .announcement-date {
                margin-bottom: 0.5rem;
            }

            .card-container {
                grid-template-columns: 1fr;
            }
        }

        .announcement-image-container {
            margin: 1rem 0;
            border-radius: 0.5rem;
            overflow: hidden;
            max-width: 100%;
        }

        .announcement-image {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .announcement-image:hover {
            transform: scale(1.02);
        }

        .announcement-image-caption {
            font-size: 0.85rem;
            color: #6b7280;
            text-align: center;
            margin-top: 0.5rem;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .announcement-image {
                max-height: 250px;
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
        
        /* Badge styles */
        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }
        
        .badge-primary {
            color: #fff;
            background-color: var(--primary);
        }
        
        .badge-warning {
            color: #212529;
            background-color: var(--warning);
        }
        
        .badge-danger {
            color: #fff;
            background-color: var(--danger);
        }

        /* Carousel Styles */
        .announcements-carousel {
            position: relative;
            width: 100%;
            margin: 0 auto;
        }

        .glide__track {
            overflow: hidden;
        }

        .glide__slides {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            will-change: transform;
        }

        .glide__slide {
            flex-shrink: 0;
            width: 100%;
            padding: 0 15px;
        }

        .glide__arrows {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 2;
        }

        .glide__arrow {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .glide__arrow:hover {
            background: var(--primary);
            color: white;
        }

        .glide__arrow--left {
            left: 10px;
        }

        .glide__arrow--right {
            right: 10px;
        }

        .glide__bullets {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .glide__bullet {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ddd;
            margin: 0 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .glide__bullet--active {
            background: var(--primary);
        }

        /* Adjust announcement item for carousel */
        .announcement-item {
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .glide__arrow {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
            
            .announcement-item {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Introduction Section -->
    <div class="intro-section animate-fade">
        <div class="animate-fade delay-100">
            <h1>FUAMI Alumni Tracer System</h1>
            <p>
                The Fr. Urios Academy Of Magallanes, Inc. Alumni Tracer System is an essential tool for tracking the progress and outcomes of FUAMI graduates. This system helps monitor the pathways of our alumni, providing valuable insights for curriculum enhancement and institutional development.
            </p>
        </div>
    </div>

   <!-- Form Selection Section -->
   <div class="content-section animate-fade delay-200">
        <div class="selection-container">
            <h2>Choose Your Graduate Type</h2>
            <p>Please select your graduate type to proceed to the appropriate tracer form. Your participation helps us improve our educational programs and better serve future students.</p>
            
            <form id="graduateTypeForm" class="animate-fade delay-300" style="max-width: 600px; margin: 0 auto;">
                @csrf

                <!-- Graduate Type Section -->
                <div class="form-section" style="background-color: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: left; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.4rem; margin-bottom: 1.5rem; color: var(--primary-dark); text-align: center;">Graduate Type</h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="graduate_type" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Please select your graduate type:</label>
                        <select name="graduate_type" id="graduate_type" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #f9fafb;">
                            <option value="" selected>-- Select Graduate Type --</option>
                            <option value="JHS" {{ old('graduate_type') == 'JHS' ? 'selected' : '' }}>Junior High School (JHS) Graduate</option>
                            <option value="SHS" {{ old('graduate_type') == 'SHS' ? 'selected' : '' }}>Senior High School (SHS) Graduate</option>
                        </select>
                    </div>
                    
                    <div style="text-align: center;">
                        <button type="button" id="startButton" class="start-button" onclick="redirectToForm()">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Fill Out Tracer Form</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Announcements Section -->
    @if($activeAnnouncements->count() > 0)
    <div class="announcements-section animate-fade delay-150">
        <div class="announcements-container">
            <div class="announcements-header">
                <h2><i class="fas fa-bullhorn"></i> Announcements</h2>
                <div class="announcement-date">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ now()->format('F j, Y') }}</span>
                </div>
            </div>
            
            <div class="announcements-carousel glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach($activeAnnouncements as $announcement)
                        <li class="glide__slide">
                            <div class="announcement-item">
                                <h3 class="announcement-title">
                                    {{ $announcement->title }}
                                </h3>
                                
                                @if($announcement->image_path)
                                <div class="announcement-image-container">
                                    <img src="{{ asset('storage/' . $announcement->image_path) }}" 
                                         alt="Announcement Image" 
                                         class="announcement-image">
                                    <div class="announcement-image-caption"></div>
                                </div>
                                @endif
                                
                                <div class="announcement-content">
                                    {!! nl2br(e($announcement->content)) !!}
                                </div>
                                <div class="announcement-meta">
                                    <div class="announcement-date">
                                        <i class="far fa-calendar-times"></i>
                                        <span>Expires: {{ $announcement->expiry_date->format('M j, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <div class="glide__bullets" data-glide-el="controls[nav]">
                    @foreach($activeAnnouncements as $index => $announcement)
                    <button class="glide__bullet" data-glide-dir="={{ $index }}"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif


    <!-- FUAMI Information Section -->
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

    <!-- Glide.js and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('currentYear').textContent = new Date().getFullYear();
            
            // Add event listener for Enter key
            document.getElementById('graduate_type').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    redirectToForm();
                }
            });
            
            // Initialize Glide carousel if announcements exist
            @if($activeAnnouncements->count() > 0)
            new Glide('.glide', {
                type: 'carousel',
                startAt: 0,
                perView: 1,
                focusAt: 'center',
                gap: 20,
                autoplay: 5000,
                hoverpause: true,
                animationDuration: 600,
                breakpoints: {
                    768: {
                        perView: 1
                    }
                }
            }).mount();
            @endif
            
            // Auto-hide announcements after 10 seconds (optional)
            setTimeout(function() {
                const announcements = document.querySelector('.announcements-section');
                if (announcements) {
                    announcements.style.opacity = '0.8';
                    announcements.style.transition = 'opacity 1s ease';
                }
            }, 10000);
        });

        function redirectToForm() {
            const graduateType = document.getElementById('graduate_type').value;
            
            if (!graduateType) {
                alert('Please select your graduate type first.');
                return;
            }
            
            if (graduateType === 'JHS') {
                window.location.href = "{{ route('tracer.jhs-form') }}";
            } else if (graduateType === 'SHS') {
                window.location.href = "{{ route('tracer.shs-form') }}";
            }
        }
    </script>
</body>
</html>