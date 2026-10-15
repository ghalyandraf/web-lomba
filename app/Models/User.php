<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'major_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function reportCards()
    {
        return $this->hasMany(ReportCard::class);
    }

    public function analysisResults()
    {
        return $this->hasMany(AnalysisResult::class);
    }

    public function careerPlans()
    {
        return $this->hasMany(CareerPlan::class);
    }
}