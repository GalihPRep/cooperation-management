<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institution;

class Pic extends Model
{
    use HasFactory;
        protected $fillable = [
        "name", "role", "institution_id"
    ];
    public function institution()
    {
        return $this->belongsTo(Institution::class, "institution_id");
    }
}
