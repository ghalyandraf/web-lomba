<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = ['analysis_result_id', 'title', 'learning_tips', 'resources', 'is_completed'];

    public function analysisResult()
    {
        return $this->belongsTo(AnalysisResult::class);
    }
}