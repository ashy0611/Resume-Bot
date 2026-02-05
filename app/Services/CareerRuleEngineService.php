<?php

namespace App\Services;

class CareerRuleEngineService
{
    public function recommend(array $buckets): string
    {
        if (
            count($buckets['frontend']) >= 1 &&
            count($buckets['backend']) >= 1
        ) {
            return 'Full Stack Developer';
        }

        if (count($buckets['backend']) >= 2) {
            return 'Backend Developer';
        }

        if (count($buckets['frontend']) >= 2) {
            return 'Frontend Developer';
        }

        if (count($buckets['data']) >= 2) {
            return 'Data Analyst';
        }

        return 'General Career Guidance Required';
    }
}
