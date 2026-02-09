@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white rounded-3 p-5 mb-5 text-center">
    <h1 class="display-6 fw-semibold">Welcome to Skillly</h1>
    <p class="lead mt-3">
        Upload your resume and let Skillly analyze your skills, suggest career paths,
        and provide personalized improvement tips.
    </p>
    <a href="{{ route('resume.upload.form') }}" class="btn btn-light btn-lg mt-3">
        Upload Your Resume
    </a>
</section>


<!-- Features Section -->
<section>
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Skill Extraction</h5>
                    <p class="card-text">
                        Automatically extracts technical and soft skills from uploaded resumes
                        using predefined rules.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Career Recommendations</h5>
                    <p class="card-text">
                        Matches your skills against predefined career domains to suggest
                        suitable career paths.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">PDF Report</h5>
                    <p class="card-text">
                        Download a detailed PDF report summarizing your resume analysis,
                        skill gaps, and recommendations.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection