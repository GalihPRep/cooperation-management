<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\CreateSectorJob;
use App\Models\Sector;
class SectorsController extends Controller {
    private $validator = [
        "name" => "required|max:256",
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/sectors/index.blade.php`.
     */
    public function index() {
        return view("sectors.index", [
            "title" => "Sectors",
            "items" => Sector::orderBy("name")
                ->paginate(12),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/sectors/create.blade.php`.
     */
    public function create() {
        return view("sectors.create");
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreateSectorJob::handle`.
     */
    public function store(Request $request) {
        CreateSectorJob::dispatch($request->validate($this->validator));
        return redirect("sectors")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/sectors/edit.blade.php`.
     */
    public function edit(string $id) {
        return view("sectors.edit", [
            "item" => Sector::find($id),
        ]); 
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id) {
        Sector::where("id", $id)
            ->update($request->validate($this->validator));
        return redirect("sectors")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id) {
        Sector::destroy($id);
        return redirect("sectors")->with("success", "We did it!");
    }
}