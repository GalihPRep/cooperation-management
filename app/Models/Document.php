<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Format;
use App\Models\Institution;
use App\Models\Pic;
use App\Models\Status;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "number",
        "category_id",
        "scope",
        "signing",
        "expiry",
        "status_id",
        "format_id",
        "note",
        "extension"
    ];

    /** Multiple `document` rows have single `category` row. */
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    /** Multiple `document` rows have single `status` row. */
    public function status()
    {
        return $this->belongsTo(Status::class, "status_id");
    }

    /** Multiple `document` rows have single `format` row. */
    public function format()
    {
        return $this->belongsTo(Format::class, "format_id");
    }

    /** Multiple `document` rows have multiple `institution` row. */
    public function institutions()
    {
        return $this->belongsToMany(
            Institution::class,
            "document_institution",
            "document_id",
            "institution_id"
        );
    }

    /** Multiple `document` rows have multiple `pic` row. */
    public function pics()
    {
        return $this->belongsToMany(
            Pic::class,
            "document_pic",
            "document_id",
            "pic_id"
        );
    }
}
