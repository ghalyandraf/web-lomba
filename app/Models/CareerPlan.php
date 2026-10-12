<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_career',
        'education_path',
        'short_term_goals',
        'medium_term_goals',
        'long_term_goals',
        'progress_percentage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}