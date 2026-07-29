<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\CreateFormatJob;
use App\Models\Format;
class FormatsController extends Controller {
    private $validator = [
        "name" => "required|max:256",
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/formats/index.blade.php`.
     */
    public function index() {
        return view("formats.index", [
            "title" => "Formats",
            "items" => Format::orderBy("name")
                ->paginate(12),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/formats/create.blade.php`.
     */
    public function create() {
        return view("formats.create");
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreateFormatJob::handle`.
     */
    public function store(Request $request) {
        CreateFormatJob::dispatch($request->validate($this->validator));
        return redirect("formats")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/formats/edit.blade.php`.
     */
    public function edit(string $id) {
        return view("formats.edit", [
            "item" => Format::find($id),
        ]); 
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id) {
        Format::where("id", $id)
            ->update($request->validate($this->validator));
        return redirect("formats")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id) {
        Format::destroy($id);
        return redirect("formats")->with("success", "We did it!");
    }
}