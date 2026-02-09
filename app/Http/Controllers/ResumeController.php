<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResumeParserService;
use App\Services\SkillExtractionService;
use App\Services\ChatBotService;
use App\Services\ReportService;
use App\Models\ChatbotLog;
use App\Models\Resume;
use App\Models\Skill;

class ResumeController extends Controller
{
    protected $parser;
    protected $skillService;
    protected $chatBot;
    protected $reportService;

    public function __construct(
        ResumeParserService $parser,
        SkillExtractionService $skillService,
        ChatBotService $chatBot,
        ReportService $reportService
    ) {
        $this->parser = $parser;
        $this->skillService = $skillService;
        $this->chatBot = $chatBot;
        $this->reportService = $reportService;
    }

public function upload(Request $request)
{
    // Validate uploaded file
    $request->validate([
        'resume' => 'required|mimes:pdf,doc,docx|max:5120', // 5MB max
    ]);

    // Store file
    $file = $request->file('resume');
    $path = $file->store('resumes');

    // Parse resume → returns raw text
    $rawText = $this->parser->extractText(storage_path('app/' . $path));

    // Wrap parsed data in array to avoid string offset errors
    $parsedData = [
        'text' => $rawText,
        'skills' => [],
    ];

    // Store resume record in DB
    $resume = Resume::create([
        'file_path' => $path,
        'file_name' => $file->getClientOriginalName(), // store original file name
        'extracted_text' => $parsedData['text'] ?? '',
    ]);

    // Extract skills from resume text
    $skills = $this->skillService->extractSkills($parsedData['text'] ?? '');
    $parsedData['skills'] = $skills;

    // Sync skills with pivot table
    $skillIds = Skill::whereIn('name', $skills)->pluck('id')->toArray();
    $resume->skills()->sync($skillIds);

    // Generate chatbot recommendations
    $botResponse = $this->chatBot->generateRecommendations($parsedData);

    // Store chatbot logs
    ChatbotLog::create([
        'resume_id' => $resume->id,
        'skills' => $skills,
        'responses' => $botResponse,
    ]);

    // Normalize skills to array of arrays with 'name' key for ReportService
    $skillsForReport = [];
    foreach ($skills as $skill) {
        if (is_array($skill) && isset($skill['name'])) {
            $skillsForReport[] = $skill;
        } elseif (is_object($skill) && isset($skill->name)) {
            $skillsForReport[] = ['name' => $skill->name];
        } else {
            $skillsForReport[] = ['name' => (string)$skill];
        }
    }

    // Generate PDF report
   $pdfPath = $this->reportService->generateOverallReport([
    'name' => $resume->file_name ?? '',
    'email' => '', // or parse from resume if available
    'phone' => '',
    'education' => [],
    'skills' => $skills, // already an array of strings
    'projects' => [],
    'internships' => [],
    'recommendations' => $botResponse,
]);

    // Return JSON response
    return response()->json([
        'message' => 'Resume processed successfully',
        'skills' => $skills,
        'recommendations' => $botResponse,
        'pdf_link' => url('download-report/' . basename($pdfPath)),
    ]);
}




    // Show upload form
    public function showUploadForm()
    {
        return view('resume.upload');
    }
}
