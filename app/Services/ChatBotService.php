<?php

namespace App\Services;

class ChatBotService
{
    /**
     * Generate rule-based recommendations
     */
    public function generateRecommendations(array $data): array
    {
        $skills = array_map('strtolower', $data['skills'] ?? []);
        $text   = strtolower($data['text'] ?? '');

        $responses = [];

        // 🔴 Weak skills
        if (count($skills) < 2) {
            $responses[] = 'Skills section is too weak. Consider adding more relevant technical skills.';
        }

        // 📌 Missing sections (keyword-based)
        if (!str_contains($text, 'project')) {
            $responses[] = 'Consider adding a Projects section to showcase your work.';
        }

        if (!str_contains($text, 'internship') && !str_contains($text, 'training')) {
            $responses[] = 'Including internships or training can strengthen your resume.';
        }

        if (!str_contains($text, 'education') && !str_contains($text, 'degree')) {
            $responses[] = 'Add education details to make your resume complete.';
        }

        // 🎯 Career suggestions
        if (in_array('java', $skills) && in_array('sql', $skills)) {
            $responses[] = 'You may be suitable for Backend Developer roles.';
        }

        if (in_array('javascript', $skills) && in_array('react', $skills)) {
            $responses[] = 'You may be suitable for Frontend Developer roles.';
        }

        if (in_array('php', $skills) && in_array('laravel', $skills)) {
            $responses[] = 'You may be suitable for PHP/Laravel Developer roles.';
        }

        // 🟢 Fallback
        if (empty($responses)) {
            $responses[] = 'Your resume looks good. Keep improving your skills and experience.';
        }

        return $responses;
    }
}
