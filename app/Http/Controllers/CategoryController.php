<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return inertia('Categories/Index',[
            'categories'=>Category::all()->map(function($category){
                return [
                    'id'=>$category->id,
                    'name'=>$category->name,
                    'photo'=>asset('storage/'.$category->photo),
                    'status'=>$category->status
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required', // Assuming 'public' is a boolean field in your database
        ]);

        $image=$request->file('photo')->store('categories','public');
        Category::create([
            'name'=>$request->name,
            'photo'=>$image,
            'status'=>$request->status
        ]);

        // $data = $request->all();

        // if ($request->hasFile('photo')) {
        //     $imagePath = $request->file('photo')->store('category_images', 'public');
        //     $data['photo'] = $imagePath;
        // }

        // Category::create($data);

        return redirect()->route('categories.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category=Category::find($id);
        return inertia('Categories/Edit',[
            'category'=>$category,
            'photo'=>asset('storage/'.$category->photo)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data=$request->validate([
            'name'=>'required',
            'photo'=>'nullable',
        ]);

        $category=Category::find($id);

        if($request->file('photo')){
            Storage::delete('public/'.$category->photo);
            $imagePath=$request->file('photo')->store('categores','public');
            $data['photo']=$imagePath;
        }

        $category->update($data);


        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        Storage::delete('public/'.$category->photo);
        $category->delete();

        return redirect()->route('categories.index');
    }
}
