<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\CreateCategoryJob;
use App\Models\Category;
class CategoriesController extends Controller {
    private $validator = [
        "name" => "required|max:256",
    ];

    /**
     * Display a listing of the resource.
     * View used: `./resource/views/categories/index.blade.php`.
     */
    public function index(Request $request) {
        $query = Category::query();
        if ($request->filled('name')) $query->where('name', 'like', '%' . $request->name . '%');
        return view("categories.index", [
            "title" => "Categories",
            "items" => $query->orderBy("name")
                ->paginate(12),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     * View used: `./resource/views/categories/create.blade.php`.
     */
    public function create() {
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     * The entire process is inside `CreateCategoryJob::handle`.
     */
    public function store(Request $request) {
        CreateCategoryJob::dispatch($request->validate($this->validator));
        return redirect("categories")->with("success", "We did it!");
    }

    /**
     * Show the form for editing a new resource.
     * Not used yet. We include this only because it's in the default setting.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing a new resource.
     * View used: `./resource/views/categories/edit.blade.php`.
     */
    public function edit(string $id) {
        return view("categories.edit", [
            "item" => Category::find($id),
        ]); 
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, string $id) {
        Category::where("id", $id)->update($request->validate($this->validator));
        return redirect("categories")->with("success", "We did it!");
    }

    /** Remove the specified resource from storage. */
    public function destroy(string $id) {
        Category::destroy($id);
        return redirect("categories")->with("success", "We did it!");
    }
}