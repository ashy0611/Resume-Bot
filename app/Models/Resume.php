<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    protected $fillable = ['file_name','file_path','extracted_text' ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class,'resume_skills');
    }

    public function chatbotLogs(){
        return $this->hasMany(ChatbotLog::class);
    }
}
