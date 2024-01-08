<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{

    return inertia('Items/Index', [
        'items' => Item::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'category_id' => $item->category_id,
                'price' => $item->price,
                'description' => $item->description,
                'item_condition' => $item->item_condition,
                'item_type' => $item->item_type,
                'status' => $item->status,
                'photo' => asset('storage/'.$item->photo),
                'owner_name' => $item->owner_name,
                'owner_contact_number' => $item->owner_contact_number,
                'owner_address' => $item->owner_address,
            ];
        }),
        'categories' => Category::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        }),
    ]);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia('Items/Create',[
            'categories' => Category::all()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }),
        ]

        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{


    $image = $request->file('photo')->store('items', 'public');

    Item::create([
        'name' => $request->name,
        'category_id' => $request->category_id, // Change to the actual category ID
        'price' => $request->price,
        'description' => $request->description,
        'item_condition' => $request->item_condition,
        'item_type' => $request->item_type,
        'status' => $request->status, // Change based on your requirements
        'photo' => $image,
        'owner_name' => $request->owner_name,
        'owner_contact_number' => $request->owner_contact_number,
        'owner_address' => $request->owner_address,
    ]);

    return redirect()->route('items.index');
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
    $item = Item::find($id);

    if (!$item) {
        // Handle the case when the item is not found.
        return redirect()->route('items.index')->with('errorMsg', 'Item not found.');
    }

    $photo = asset('storage/'.$item->photo);

    return inertia('Items/Edit', [
        'item' => $item,
        'photo' => $photo,
        'categories' => Category::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        }),
    ]);
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $data = $request->validate([
        'name' => 'required',
        'category_id' => 'required', // Change to the actual validation rule for category_id
        'price' => 'required',
        'description' => 'required',
        'item_condition' => 'required',
        'item_type' => 'required',
        'status' => 'required', // Change based on your requirements
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'owner_name' => 'required',
        'owner_contact_number' => 'required',
        'owner_address' => 'required',
    ]);

    $item = Item::find($id);

    if (!$item) {
        // Handle the case when the item is not found.
        return redirect()->route('items.index')->with('errorMsg', 'Item not found.');
    }

    if ($request->file('photo')) {
        Storage::delete('public/'.$item->photo);
        $imagePath = $request->file('photo')->store('items', 'public');
        $data['photo'] = $imagePath;
    }

    $item->update($data);

    return redirect()->route('items.index')->with('successMsg', 'Item updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item=Item::find($id);
        Storage::delete('public/'.$item->photo);
        $item->delete();

        return redirect()->route('items.index');
    }
}
