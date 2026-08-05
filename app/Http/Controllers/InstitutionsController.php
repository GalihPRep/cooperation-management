<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CreateInstitutionJob;
use App\Models\Country;
use App\Models\Institution;
use App\Models\Sector;

class InstitutionsController extends Controller
{
    private $validator = [
        "name" => "required|max:256",
        "sector_id" => "nullable|exists:sectors,id",
        "country_id" => "nullable|exists:countries,id",
        "bmkg" => "nullable",
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/institutions/index.blade.php`.
     */
    public function index(Request $request)
    {
        $query = Institution::with(["sector", "country"]);
        if ($request->filled('name'))  $query->where('name', 'like', '%' . $request->name . '%');
        if ($request->filled('bmkg'))  $query->where('bmkg', $request->bmkg);
        if ($request->filled('sector'))  $query->whereHas('sector', fn($q) => $q->where('name', 'like', '%' . $request->sector . '%'));
        if ($request->filled('country'))  $query->whereHas('country', fn($q) => $q->where('name', 'like', '%' . $request->country . '%'));
        return view("institutions.index", [
            "title" => "Institutions",
            "items" => $query->orderBy("name", "ASC")
                ->paginate(12)
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/institutions/create.blade.php`.
     */
    public function create()
    {
        return view("institutions.create", [
            "sectors" => Sector::orderBy("name")->get(),
            "countries" => Country::orderBy("name")->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreateInstitutionJob::handle`.
     */
    public function store(Request $request)
    {
        // 1. Run your standard validation
        $validatedData = $request->validate($this->validator);

        // 2. Fallback to false/0 if the checkbox was omitted from the request
        // Replace 'is_active' with your actual checkbox input name
        $validatedData['bmkg'] = $request->boolean('bmkg');

        // 3. Pass the modified array to your background job
        CreateInstitutionJob::dispatch($validatedData);

        return redirect("institutions")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/institutions/edit.blade.php`.
     */
    public function edit(string $id)
    {
        return view("institutions.edit", [
            "item" => Institution::find($id),
            "sectors" => Sector::orderBy("name")->get(),
            "countries" => Country::orderBy("name")->get(),
        ]);
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id)
    {
        // 1. Run your standard validation
        $validatedData = $request->validate($this->validator);

        // 2. Fallback to false/0 if the checkbox was omitted from the request
        // Replace 'is_active' with your actual checkbox input name
        $validatedData['bmkg'] = $request->boolean('bmkg');

        Institution::where("id", $id)->update($validatedData);
        return redirect("institutions")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id)
    {
        Institution::destroy($id);
        return redirect("institutions")->with("success", "We did it!");
    }
}
