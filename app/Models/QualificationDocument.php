<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationDocument extends Model
{
    use HasFactory;
    protected $table = 'qualification_documents';
// Allow all attributes to be mass-assignable
    protected $guarded = [];
}
