<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Jobs\CreateDocumentJob;
use App\Models\Category;
use App\Models\Document;
use App\Models\Institution;
use App\Models\Pic;
use App\Models\Status;
use App\Models\Format;

class DocumentsController extends Controller
{
    private $validator = [
        "partner" => "nullable|string", // Added
        "division" => "nullable|string", // Added
        "pic" => "nullable|string", // Added
        "title" => "required|string",
        "number" => "nullable|string",
        "category_id" => "nullable|exists:categories,id",
        "scope" => "nullable|string",
        "signing" => "nullable",
        "expiry" => "nullable",
        "status_id" => "nullable|exists:statuses,id",
        "format_id" => "nullable|exists:formats,id",
        "note" => "nullable|string",
        "extension" => "nullable"
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/documents/index.blade.php`.
     */
public function index(Request $request)
{
    $query = Document::with(["institutions", "category", "status", "pics", "format"]);

    // Direct text fields
    if ($request->filled('title'))  $query->where('title', 'like', '%' . $request->title . '%');
    if ($request->filled('number')) $query->where('number', 'like', '%' . $request->number . '%');
    if ($request->filled('scope'))  $query->where('scope', 'like', '%' . $request->scope . '%');
    if ($request->filled('note'))   $query->where('note', 'like', '%' . $request->note . '%');

    // Relationships
    if ($request->filled('category')) {
        $query->whereHas('category', fn($q) => $q->where('name', 'like', '%' . $request->category . '%'));
    }
    if ($request->filled('status')) {
        $query->whereHas('status', fn($q) => $q->where('name', 'like', '%' . $request->status . '%'));
    }
    if ($request->filled('format')) {
        $query->whereHas('format', fn($q) => $q->where('name', 'like', '%' . $request->format . '%'));
    }
    if ($request->filled('mitra')) {
        $query->whereHas('institutions', fn($q) => $q->where('name', 'like', '%' . $request->mitra . '%'));
    }
    if ($request->filled('pic')) {
        $query->whereHas('pics', fn($q) => $q->where('name', 'like', '%' . $request->pic . '%'));
    }

    $items = $query->orderBy("created_at", "DESC")
                   ->paginate(12)
                   ->withQueryString();

    return view("documents.index", compact("items"));
}

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/documents/create.blade.php`.
     */
    public function create()
    {
        return view("documents.create", [
            "partners" => Institution::where("bmkg", "<>", "1")->orderBy("name")->get(),
            "divisions" => Institution::where("bmkg", "1")->orderBy("name")->get(),
            "categories" => Category::orderBy("name")->get(),
            "statuses" => Status::orderBy("name")->get(),
            "pics" => Pic::orderBy("name")->get(),
            "formats" => Format::orderBy("name")->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreateDocumentJob::handle`.
     */
    public function store(Request $request)
    {
        CreateDocumentJob::dispatch($request->validate($this->validator));
        return redirect("documents")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/documents/edit.blade.php`.
     */
    public function edit(string $id)
    {
        $obj = Document::with(["institutions", "pics"])->findOrFail($id);
        $ids_partner = $obj->institutions->filter(fn($x) => !$x->bmkg)->pluck('id')->implode(',');
        $ids_division = $obj->institutions->filter(fn($x) => $x->bmkg)->pluck('id')->implode(',');
        $ids_pic = $obj->pics->pluck('id')->implode(',');
        return view("documents.edit", [
            "item" => $obj,
            "item_partners" => $ids_partner,
            "item_divisions" => $ids_division,
            "item_pics" => $ids_pic,
            "partners" => Institution::where("bmkg", "<>", "1")->orderBy("name")->get(),
            "divisions" => Institution::where("bmkg", "1")->orderBy("name")->get(),
            "categories" => Category::orderBy("name")->get(),
            "statuses" => Status::orderBy("name")->get(),
            "pics" => Pic::orderBy("name")->get(),
            "formats" => Format::orderBy("name")->get(),
        ]);
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id)
    {
        $req = $request->validate($this->validator);
        $obj = Document::findOrFail($id);
        $str_partner = Arr::pull($req, 'partner');
        $str_division = Arr::pull($req, 'division');
        $str_pic = Arr::pull($req, 'pic');
        $obj->update($req);
        $str_institution = [];
        if (!empty($str_partner)) {
            $ids_partner = array_map("intval", explode(',', $str_partner));
            $str_institution = array_merge($str_institution, $ids_partner);
        }
        if (!empty($str_division)) {
            $ids_division = array_map("intval", explode(',', $str_division));
            $str_institution = array_merge($str_institution, $ids_division);
        }
        // Run sync ONCE for the shared relation table
        if (!empty($str_institution)) $obj->institutions()->sync($str_institution);
        else $obj->institutions()->detach();
        if (!empty($str_pic)) {
            $ids_pic = array_map("intval", explode(',', $str_pic));
            $obj->pics()->sync($ids_pic);
        } else $obj->pics()->detach();
        return redirect("documents")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id)
    {
        Document::destroy($id);
        return redirect("documents")->with("success", "We did it!");
    }
}
