<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\CreatePicJob;
use App\Models\Institution;
use App\Models\Pic;
class PicsController extends Controller {
    private $validator = [
        "name" => "required|max:256",
        "role" => "nullable",
        "institution_id" => "nullable|exists:institutions,id",
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/pics/index.blade.php`.
     */
    public function index() {
        return view("pics.index", [
            "title" => "Pics",
            "items" => Pic::orderBy("name")
                ->paginate(12),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/pics/create.blade.php`.
     */
    public function create() {
        return view("pics.create", ["institutions" => Institution::all()]);
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreatePicJob::handle`.
     */
    public function store(Request $request) {
        CreatePicJob::dispatch($request->validate($this->validator));
        return redirect("pics")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/pics/edit.blade.php`.
     */
    public function edit(string $id) {
        return view("pics.edit", [
            "item" => Pic::find($id),
            "institutions" => Institution::all()
        ]); 
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id) {
        Pic::where("id", $id)
            ->update($request->validate($this->validator));
        return redirect("pics")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id) {
        Pic::destroy($id);
        return redirect("pics")->with("success", "We did it!");
    }
}