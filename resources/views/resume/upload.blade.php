@extends('layouts.app')

@section('title', 'Upload Resume')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">
                Upload Your Resume
            </div>

            <div class="card-body">
                <p class="text-muted mb-4">
                    Upload your resume in PDF, DOC, or DOCX format to receive skill analysis
                    and career recommendations.
                </p>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('resume.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="resume" class="form-label fw-semibold">
                            Choose Resume File
                        </label>
                        <input type="file"
                               name="resume"
                               id="resume"
                               class="form-control"
                               accept=".pdf,.doc,.docx"
                               required>
                        <div class="form-text">
                            Allowed formats: PDF, DOC, DOCX • Maximum size: 5 MB
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Upload & Analyze
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection