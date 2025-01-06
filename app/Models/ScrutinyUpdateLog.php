<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ScrutinyUpdateLog extends Model
{
    use HasFactory;
    protected $table = 'scrutiny_update_logs';
    // Allow all attributes to be mass-assignable
    protected $guarded = [];
}
