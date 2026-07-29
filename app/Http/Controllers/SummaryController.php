<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Institution;

class SummaryController extends Controller
{
    public function index()
    {
        return view("summary", [
            "institutions_internal" => Institution::whereRaw("country_id = 9 and bmkg <> 1")
                ->with('documents:id,title')
                ->withCount("documents")
                ->get(),
            "institutions_foreign" => Institution::where("country_id", "<>", "9")
                ->with(['documents:id,title', "country:id,name"])
                ->withCount("documents")
                ->get()
        ]);
    }
}
