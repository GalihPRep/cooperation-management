<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Document;
use App\Models\Sector;

class Institution extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "sector_id",
        "country_id",
        "bmkg"
    ];
    public function sector()
    {
        return $this->belongsTo(Sector::class, "sector_id");
    }
    public function country()
    {
        return $this->belongsTo(Country::class, "country_id");
    }

        public function documents()
    {
        return $this->belongsToMany(
            Document::class,
            "document_institution",
            "institution_id",
            "document_id"
        );
    }
}
