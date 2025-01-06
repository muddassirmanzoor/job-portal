<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $primaryKey = 'applicant_id';
    // Allow all attributes to be mass-assignable
    protected $guarded = [];

    public function qualification(): HasMany
    {
        return $this->hasMany(Qualification::class, 'applicant_id', 'applicant_id');
    }
    public function experience(): HasMany
    {
        return $this->hasMany(EmploymentHistory::class, 'applicant_id', 'applicant_id');
    }

    public function post(): HasOne
    {
        return $this->hasOne(Job::class, 'post_id', 'post_id');
    }
    public function latestQualification()
    {
        return $this->hasOne(Qualification::class,'applicant_id', 'applicant_id')->latest('qualification_id');
    }

    public function latestQualifications(): HasMany
    {
        return $this->hasMany(Qualification::class, 'applicant_id', 'applicant_id')
            ->orderBy('qualification_id', 'desc'); // Adjust the column as necessary
    }
}
