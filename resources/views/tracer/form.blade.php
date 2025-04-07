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
            <h1>FUAMI Alumni Tracer System</h1>
            <p>
                The Fr. Urios Academy Of Magallanes, Inc. Alumni Tracer System is an essential tool for tracking the progress and outcomes of FUAMI graduates. This system helps monitor the pathways of our alumni, providing valuable insights for curriculum enhancement and institutional development.
            </p>
        </div>
    </div>

    <!-- Content Section -->
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

    <!-- Footer -->
    <div class="footer">
        <p>© <span id="currentYear"></span> Fr. Urios Academy Of Magallanes, Inc. All Rights Reserved.</p>
    </div>

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