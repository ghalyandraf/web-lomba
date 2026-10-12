<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'major_id', 'match_percentage', 'category', 'matched_aspects', 'improvement_aspects'
    ];

    protected $casts = [
        'matched_aspects' => 'array',
        'improvement_aspects' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}