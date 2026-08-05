<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\CreateCountryJob;
use App\Models\Institution;
use App\Models\Country;
class CountriesController extends Controller {
    private $validator = [
        "name" => "required|max:256",
        "role" => "nullable",
        "institution_id" => "nullable|exists:institutions,id",
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/countries/index.blade.php`.
     */
    public function index(Request $request) {
        $query = Country::orderBy("name");
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        return view("countries.index", [
            "title" => "Countries",
            "items" => $query->paginate(12),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/countries/create.blade.php`.
     */
    public function create() {
        return view("countries.create", ["institutions" => Institution::all()]);
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreateCountryJob::handle`.
     */
    public function store(Request $request) {
        CreateCountryJob::dispatch($request->validate($this->validator));
        return redirect("countries")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/countries/edit.blade.php`.
     */
    public function edit(string $id) {
        return view("countries.edit", [
            "item" => Country::find($id),
            "institutions" => Institution::all()
        ]); 
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id) {
        Country::where("id", $id)
            ->update($request->validate($this->validator));
        return redirect("countries")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id) {
        Country::destroy($id);
        return redirect("countries")->with("success", "We did it!");
    }
}