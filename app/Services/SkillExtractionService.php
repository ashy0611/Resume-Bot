<?php

namespace App\Services;

use App\Models\Skill;

class SkillExtractionService
{
        /**
     * Normalize text for matching
     */
    protected function normalize(string $value): string
    {
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9\s]/', ' ', $value);
        return preg_replace('/\s+/', ' ', trim($value));
    }

public function extractSkills(string $text): array
{
    $text = $this->normalize($text);
    $found = [];

    $skills = Skill::pluck('name')->toArray();

    foreach ($skills as $skill) {
        $normalizedSkill = $this->normalize($skill);

        if ($normalizedSkill !== '' && str_contains($text, $normalizedSkill)) {
            $found[] = $skill;
        }
    }

    return array_values(array_unique($found));
}

}
