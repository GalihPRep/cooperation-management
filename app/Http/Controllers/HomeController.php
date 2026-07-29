<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Fetch grouped year counts cleanly using Laravel Collection helpers
        $expiries = Document::selectRaw("
                CASE WHEN expiry IS NULL THEN 'Format tanggal tidak valid' ELSE YEAR(expiry) END as expiry_year, 
                COUNT(*) as expiry_count
            ")
            ->groupByRaw("CASE WHEN expiry IS NULL THEN 'Format tanggal tidak valid' ELSE YEAR(expiry) END")
            ->orderBy("expiry_year")
            ->get();

        return view("home", [
            "country" => [
                // National (Only ID 9)
                Document::whereHas('institutions', function ($query) {
                    $query->where('country_id', 9);
                })->whereDoesntHave('institutions', function ($query) {
                    $query->where('country_id', '!=', 9);
                })->count(),

                // International (Has at least one non-9)
                Document::whereHas('institutions', function ($query) {
                    $query->where('country_id', '!=', 9);
                })->count()
            ],

            // Collection method ->pluck() replaces the array_map entirely!
            "expiry_year"  => $expiries->pluck('expiry_year'),
            "expiry_count" => $expiries->pluck('expiry_count')
        ]);
    }
}