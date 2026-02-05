<?php

namespace App\Services;

use App\Models\Skill;

class SkillExtractionService
{
    public function extractSkills(string $text): array
    {
        $text = strtolower($text);
        $found = [];

        $skills = Skill::pluck('name')->toArray(); 

        foreach ($skills as $skill) {
            if (str_contains($text, strtolower($skill))) {
                $found[] = $skill;
            }
        }

        return array_values(array_unique($found));
    }
}
