<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\CreateStatusJob;
use App\Models\Status;
class StatusesController extends Controller {
    private $validator = [
        "name" => "required|max:256",
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/statuses/index.blade.php`.
     */
    public function index() {
        return view("statuses.index", [
            "title" => "Statuses",
            "items" => Status::orderBy("name")
                ->paginate(12),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/statuses/create.blade.php`.
     */
    public function create() {
        return view("statuses.create");
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreatePicJob::handle`.
     */
    public function store(Request $request) {
        CreateStatusJob::dispatch($request->validate($this->validator));
        return redirect("statuses")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/statuses/edit.blade.php`.
     */
    public function edit(string $id) {
        return view("statuses.edit", [
            "item" => Status::find($id),
        ]); 
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id) {
        Status::where("id", $id)
            ->update($request->validate($this->validator));
        return redirect("statuses")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id) {
        Status::destroy($id);
        return redirect("statuses")->with("success", "We did it!");
    }
}