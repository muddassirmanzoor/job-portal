<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceDocument extends Model
{
    use HasFactory;
    protected $table = 'experience_documents';
// Allow all attributes to be mass-assignable
    protected $guarded = [];
}
