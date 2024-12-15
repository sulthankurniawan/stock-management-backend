<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return Item::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code' => 'required|unique:items',
            'name' => 'required',
            'uom' => 'required',
        ]);

        Item::create($validated);

        return response()->json(['message' => 'Item added successfully']);
    }
}
