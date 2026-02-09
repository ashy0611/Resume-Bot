@extends('layouts.app')


@section('content')
<div class="row">
<div class="col-md-12">
<h3 class="mb-4">Resume Analysis Result</h3>


<!-- Extracted Skills -->
<div class="card mb-3">
<div class="card-header bg-secondary text-white">Extracted Skills</div>
<div class="card-body">
<strong>Technical Skills:</strong>
<p>{{ implode(', ', $technicalSkills ?? []) }}</p>


<strong>Soft Skills:</strong>
<p>{{ implode(', ', $softSkills ?? []) }}</p>
</div>
</div>


<!-- Career Recommendations -->
<div class="card mb-3">
<div class="card-header bg-success text-white">Career Recommendations</div>
<div class="card-body">
@forelse ($recommendations ?? [] as $rec)
<p>
<strong>{{ $rec['domain'] }}</strong> – Match: {{ $rec['match'] }}%
</p>
@empty
<p>No suitable career domain found.</p>
@endforelse
</div>
</div>


<!-- Skill Gap Analysis -->
<div class="card mb-3">
<div class="card-header bg-warning">Skill Gap Analysis</div>
<div class="card-body">
@foreach ($skillGaps ?? [] as $domain => $gaps)
<strong>{{ $domain }}:</strong>
<p>Missing Skills: {{ implode(', ', $gaps) }}</p>
@endforeach
</div>
</div>


<div class="d-flex gap-2">
<a href="{{ route('report.download') }}" class="btn btn-outline-primary">Download PDF Report</a>
<a href="{{ url('/') }}" class="btn btn-outline-secondary">Upload Another Resume</a>
</div>
</div>
</div>
@endsection