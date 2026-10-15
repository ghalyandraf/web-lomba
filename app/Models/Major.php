<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'field',
        'slug',
        'description',
        'min_scores',
        'required_skills',
    ];

    protected $casts = [
        'min_scores' => 'array',
        'required_skills' => 'array',
    ];

    public function analysisResults()
    {
        return $this->hasMany(AnalysisResult::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}