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
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);
        //store file
        $path = $request->file('resume')->store('resumes');
        //Parse resume-> returns the array 
        $parsedData = $this->parser->extractText(
            storage_path('app/' . $path)
        );
        //store resume record 
        $resume= Resume::create(['file_path'=>$path,'extracted_text'=>$parsedData['text']??'',]);
        //skill extraction from raw text 
        $skills = $this->skillService->extractSkills($parsedData['text']??'');
        $parsedData['skills']=$skills;
        $skillIds = Skill::whereIn('name', $skills)->pluck('id')->toArray();
        $resume->skills()->sync($skillIds);
        //chatbot generates reccomendations
        /** @var array $parsedData */
        $botResponse = $this->chatBot->generateRecommendations($parsedData);
        //stores chatbot logs 
        ChatbotLog::create(['resume_id'=>$resume,'skills'=>$skills,'responses'=>$botResponse,]);
        //PDF report generation
        $pdfPath = $this->reportService->generateOverallReport([
            'skills' => $skills,
            'bot_response' => $botResponse
        ]);

        return response()->json([
            'message' => 'Resume processed successfully',
            'skills' => $skills,
            'recommendations' => $botResponse,
            'pdf_link' => url('download-report/' . basename($pdfPath)),
        ]);

    }
}
