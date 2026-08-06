<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Document;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Fetch grouped year counts cleanly using Laravel Collection helpers
        $expiries = Document::selectRaw("
                CASE WHEN expiry IS NULL THEN 'Format tanggal tidak valid' ELSE YEAR(expiry) END as expiry_year, 
                COUNT(*) as expiry_count
            ")
            ->groupByRaw("CASE WHEN expiry IS NULL THEN 'Format tanggal tidak valid' ELSE YEAR(expiry) END")
            ->orderBy("expiry_year")
            ->get();

        $query = Document::with(["institutions", "status"]);

        // Direct text fields
        if ($request->filled('title'))  $query->where('title', 'like', '%' . $request->title . '%');
        if ($request->filled('signing'))   $query->where('signing', 'like', '%' . $request->signing . '%');
        if ($request->filled('expiry'))   $query->where('expiry', 'like', '%' . $request->expiry . '%');
        if ($request->filled('status')) {
            $query->whereHas('status', fn($q) => $q->where('name', 'like', '%' . $request->status . '%'));
        }
        if ($request->filled('mitra')) {
            $query->whereHas('institutions', fn($q) => $q->where('name', 'like', '%' . $request->mitra . '%'));
        }

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
            "expiry_count" => $expiries->pluck('expiry_count'),

            "documents" => $query->orderBy("expiry", "DESC")
                ->paginate(12)
                ->withQueryString()
        ]);
    }
    public function downloadPdf()
    {
        // Fetch your table data
        $items = Document::with(["institutions", "status"])->get();

        // Pass data to the Blade view
        $pdf = Pdf::loadView('pdf', compact('items'))
                  ->setPaper('a4', 'landscape'); // Optional configuration
        
        // Alternatively, use stream() to view it in the browser:
        return $pdf->stream();
    }
}
