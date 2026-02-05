<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotLog extends Model
{
    use HasFactory;

    protected $table='chatbot_logs';

    protected $fillable = ['resume_id','skills','responses',];

    protected $casts = ['skills'=>'array','responses'=> 'array',];

    //Each Chatlog belongs -> Resume
    public function resume()
    {
        return $this->belongsToMany(Resume::class);
    }
}
