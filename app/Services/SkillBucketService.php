<?php

namespace App\Services;

class SkillBucketService
{
    public function bucketize(array $skills): array
    {
        $buckets = [
            'frontend' => [],
            'backend' => [],
            'data' => []
        ];

        foreach ($skills as $skill) {
            if (in_array($skill, ['html', 'css', 'javascript', 'react'])) {
                $buckets['frontend'][] = $skill;
            }

            if (in_array($skill, ['php', 'laravel', 'java', 'node', 'sql'])) {
                $buckets['backend'][] = $skill;
            }

            if (in_array($skill, ['python', 'sql', 'excel'])) {
                $buckets['data'][] = $skill;
            }
        }

        return $buckets;
    }
}
