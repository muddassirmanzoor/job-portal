<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmploymentHistory extends Model
{
    use HasFactory;
    protected $table = 'employment_history';
// Allow all attributes to be mass-assignable
    protected $guarded = [];


    public function experienceImages(): HasOne
    {
        return $this->hasOne(ExperienceDocument::class, 'employment_id', 'employment_id');
    }
}
