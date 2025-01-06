<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Qualification extends Model
{
    use HasFactory;
    protected $table = 'qualifications';
// Allow all attributes to be mass-assignable
    protected $guarded = [];

    public function qualificationImages(): HasOne
    {
        return $this->hasOne(QualificationDocument::class, 'qualification_id', 'qualification_id');
    }
}
