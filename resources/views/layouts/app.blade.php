<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillly - AI Resume Analyzer</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --secondary-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(255, 255, 255, 0.6);
            --accent-color: #4f46e5;
            --text-dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* --- Animated Background --- */
        .bg-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background: 
                radial-gradient(circle at 15% 50%, rgba(79, 70, 229, 0.08), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(124, 58, 237, 0.08), transparent 25%);
        }

        /* --- Navbar --- */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }
        .navbar-brand span { color: var(--accent-color); }

        .nav-link {
            font-weight: 600;
            color: #64748b !important;
            margin: 0 10px;
            transition: color 0.2s;
        }
        .nav-link:hover { color: var(--accent-color) !important; }

        /* --- Hero Section --- */
        .hero-section {
            padding: 6rem 0 4rem;
            text-align: center;
        }

        .hero-title {
            font-weight: 800;
            font-size: 3.5rem;
            background: var(--secondary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto 3rem;
        }

        /* --- Upload Zone --- */
        .upload-container {
            max-width: 800px;
            margin: 0 auto 4rem;
            position: relative;
        }

        .upload-zone {
            background: var(--glass-bg);
            border: 2px dashed #cbd5e1;
            border-radius: 24px;
            padding: 4rem 2rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
        }

        .upload-zone:hover, .upload-zone.dragover {
            border-color: var(--accent-color);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(79, 70, 229, 0.2);
        }

        .upload-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--accent-color);
            font-size: 2rem;
        }

        .upload-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 1.5rem;
            transition: transform 0.2s;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }
        .upload-btn:hover { transform: scale(1.05); }

        /* --- Features Grid --- */
        .feature-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 2.5rem;
            height: 100%;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            border-color: var(--accent-color);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
        }

        .icon-blue { background: #eff6ff; color: #3b82f6; }
        .icon-purple { background: #f5f3ff; color: #8b5cf6; }
        .icon-teal { background: #f0fdfa; color: #14b8a6; }

        /* --- Analysis Dashboard (Hidden by default) --- */
        #dashboardSection {
            display: none;
            max-width: 1000px;
            margin: 0 auto;
            animation: slideUp 0.6s ease-out;
        }

        .score-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        .circular-score {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(var(--accent-color) 0% 85%, #e2e8f0 85% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
        }

        .circular-score::before {
            content: '';
            position: absolute;
            width: 130px;
            height: 130px;
            background: white;
            border-radius: 50%;
        }

        .score-number {
            position: relative;
            z-index: 1;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent-color);
        }

        .issue-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .issue-item:last-child { border-bottom: none; }
        .issue-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        /* --- Loader --- */
        .loader-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255,255,255,0.95);
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 24px;
        }
        .spinner-grow {
            width: 3rem; height: 3rem;
            color: var(--accent-color);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer */
        footer {
            margin-top: 5rem;
            padding: 3rem 0;
            background: #fff;
            border-top: 1px solid #f1f5f9;
        }

    </style>
</head>
<body>

    <div class="bg-mesh"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-layer-group me-2"></i>Skillly<span>.</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Templates</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="#" class="btn btn-dark rounded-pill px-4">Get Started</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        
        <!-- Hero & Upload Section -->
        <section class="hero-section container" id="uploadSection">
            <h1 class="hero-title">Get Past the Bots.<br>Land the Interview.</h1>
            <p class="hero-subtitle">Upload your resume and get an instant ATS score, keyword analysis, and improvement suggestions.</p>

            <div class="upload-container">
                <div class="upload-zone" id="dropZone">
                    <!-- Loading Overlay (Hidden) -->
                    <div class="loader-overlay" id="loader">
                        <div class="spinner-grow mb-3" role="status"></div>
                        <h5 class="fw-bold">Analyzing Resume...</h5>
                        <p class="text-muted small">Checking against 50+ job criteria</p>
                    </div>

                    <!-- Normal State -->
                    <div class="upload-content">
                        <div class="upload-icon-wrapper">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h3 class="fw-bold">Drag & Drop your Resume</h3>
                        <p class="text-muted">Supported formats: PDF, DOCX (Max 5MB)</p>
                        <input type="file" id="fileInput" hidden accept=".pdf,.docx">
                        <button class="upload-btn" onclick="document.getElementById('fileInput').click()">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Upload Resume
                        </button>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="row g-4 mt-5">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-blue"><i class="fa-solid fa-crosshairs"></i></div>
                        <h4>ATS Score</h4>
                        <p class="text-muted">We check how well your resume ranks against Applicant Tracking Systems used by 99% of Fortune 500s.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-purple"><i class="fa-solid fa-magnifying-glass"></i></div>
                        <h4>Keyword Gap</h4>
                        <p class="text-muted">Identify missing hard skills and action verbs that recruiters are searching for in your industry.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-teal"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <h4>Instant Fix</h4>
                        <p class="text-muted">Get actionable suggestions to rephrase bullet points and improve readability immediately.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dashboard / Result Section (Hidden initially) -->
        <section class="container mb-5" id="dashboardSection">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Analysis Report</h2>
                    <p class="text-muted mb-0">Results for: <strong>John_Doe_Resume.pdf</strong></p>
                </div>
                <div>
                    <button class="btn btn-outline-secondary me-2" onclick="resetUI()">Upload New</button>
                    <button class="btn btn-primary"><i class="fa-solid fa-download me-2"></i>Download PDF</button>
                </div>
            </div>

            <div class="row g-4">
                <!-- Score Card -->
                <div class="col-lg-4">
                    <div class="score-card h-100">
                        <h5 class="fw-bold mb-4">ATS Compatibility Score</h5>
                        <div class="circular-score">
                            <span class="score-number">85</span>
                        </div>
                        <h4 class="text-success mb-2">Good Job!</h4>
                        <p class="text-muted small">Your resume is well formatted, but needs more keywords for specific roles.</p>
                        <hr>
                        <div class="d-flex justify-content-between text-start small mb-2">
                            <span><i class="fa-solid fa-check text-success me-2"></i>Format</span>
                            <span class="fw-bold">100%</span>
                        </div>
                        <div class="d-flex justify-content-between text-start small">
                            <span><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>Keywords</span>
                            <span class="fw-bold">65%</span>
                        </div>
                    </div>
                </div>

                <!-- Issues / Suggestions -->
                <div class="col-lg-8">
                    <div class="feature-card h-100 p-0 overflow-hidden">
                        <div class="p-4 border-bottom bg-light">
                            <h5 class="fw-bold mb-0">Optimization Suggestions</h5>
                        </div>
                        <div class="p-4">
                            
                            <!-- Suggestion 1 -->
                            <div class="issue-item">
                                <div class="issue-icon bg-danger bg-opacity-10 text-danger">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Missing "Project Management"</h6>
                                    <p class="text-muted small mb-0">The job description for "Product Manager" requires this term 3 times. It appears 0 times in your resume.</p>
                                </div>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3">Fix</button>
                            </div>

                            <!-- Suggestion 2 -->
                            <div class="issue-item">
                                <div class="issue-icon bg-warning bg-opacity-10 text-warning">
                                    <i class="fa-solid fa-font"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Section Order</h6>
                                    <p class="text-muted small mb-0">Your "Education" section is placed above "Experience". Move Experience up.</p>
                                </div>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3">Fix</button>
                            </div>

                            <!-- Suggestion 3 -->
                            <div class="issue-item">
                                <div class="issue-icon bg-info bg-opacity-10 text-info">
                                    <i class="fa-solid fa-bolt"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Weak Action Verbs</h6>
                                    <p class="text-muted small mb-0">Found "Responsible for". Consider using "Spearheaded", "Orchestrated", or "Directed".</p>
                                </div>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3">Fix</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <h4 class="fw-bold mb-3"><i class="fa-solid fa-layer-group me-2"></i>Skillly</h4>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="text-decoration-none text-secondary">About</a>
                <a href="#" class="text-decoration-none text-secondary">Privacy</a>
                <a href="#" class="text-decoration-none text-secondary">Terms</a>
                <a href="#" class="text-decoration-none text-secondary">Contact</a>
            </div>
            <p class="text-muted small mb-0">&copy; 2026 Skillly. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Logic -->
    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const loader = document.getElementById('loader');
        const uploadSection = document.getElementById('uploadSection');
        const dashboardSection = document.getElementById('dashboardSection');

        // --- Drag & Drop Effects ---
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });

        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if(files.length) handleFile(files[0]);
        });

        fileInput.addEventListener('change', (e) => {
            if(fileInput.files.length) handleFile(fileInput.files[0]);
        });

        function handleFile(file) {
            // Show Loader
            loader.style.display = 'flex';
            
            // Simulate Processing Time (2 seconds)
            setTimeout(() => {
                // Hide Upload Section Elements
                uploadSection.style.display = 'none';
                
                // Show Dashboard
                dashboardSection.style.display = 'block';
                
                // Scroll to top
                window.scrollTo(0, 0);
            }, 2000);
        }

        function resetUI() {
            dashboardSection.style.display = 'none';
            uploadSection.style.display = 'block';
            loader.style.display = 'none';
            fileInput.value = ''; // Reset input
        }
    </script>
</body>
</html>