<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReportService
{
    /**
     * Generate an overall PDF report for a resume
     *
     * @param array $resumeData
     *   Expected structure:
     *   [
     *      'name' => '',
     *      'email' => '',
     *      'phone' => '',
     *      'education' => [...],
     *      'skills' => [...],
     *      'projects' => [...],
     *      'internships' => [...],
     *      'recommendations' => [...]
     *   ]
     * @return string File path of generated PDF
     */
    public function generateOverallReport(array $resumeData): string
    {
        $html = $this->buildHtml($resumeData);

        $filename = 'reports/resume_report_' . time() . '.pdf';

        $pdf = Pdf::loadHTML($html);
        $pdf->save(storage_path('app/' . $filename));

        return $filename;
    }

    /**
     * Build the HTML content for the PDF
     */
    protected function buildHtml(array $data): string
    {
        $html = "<h1 style='text-align:center;'>Resume Report</h1>";
        $html .= "<h2>Personal Info</h2>";
        $html .= "<p><strong>Name:</strong> {$data['name']}</p>";
        $html .= "<p><strong>Email:</strong> {$data['email']}</p>";
        $html .= "<p><strong>Phone:</strong> {$data['phone']}</p>";

        // Education
        if (!empty($data['education'])) {
            $html .= "<h2>Education</h2><ul>";
            foreach ($data['education'] as $edu) {
                $html .= "<li>{$edu['degree']} - {$edu['institution']} ({$edu['year']})</li>";
            }
            $html .= "</ul>";
        }

        // Skills
        if (!empty($data['skills'])) {
            $html .= "<h2>Skills</h2><ul>";
            foreach ($data['skills'] as $skill) {
                $html .= "<li>{$skill}</li>";
            }
            $html .= "</ul>";
        }

        // Projects
        if (!empty($data['projects'])) {
            $html .= "<h2>Projects</h2><ul>";
            foreach ($data['projects'] as $project) {
                $html .= "<li><strong>{$project['title']}</strong>: {$project['description']}</li>";
            }
            $html .= "</ul>";
        }

        // Internships/Training
        if (!empty($data['internships'])) {
            $html .= "<h2>Internships / Training</h2><ul>";
            foreach ($data['internships'] as $internship) {
                $html .= "<li>{$internship['role']} at {$internship['company']} ({$internship['duration']})</li>";
            }
            $html .= "</ul>";
        }

        // Recommendations / Suggestions
        if (!empty($data['recommendations'])) {
            $html .= "<h2>Recommendations</h2><ul>";
            foreach ($data['recommendations'] as $rec) {
                $html .= "<li>{$rec}</li>";
            }
            $html .= "</ul>";
        }

        return $html;
    }
}
