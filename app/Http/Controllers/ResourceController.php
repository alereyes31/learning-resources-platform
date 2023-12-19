<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\Resource;
use App\Models\Category; 

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Resources', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resources' => Resource::with('category')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Resource::create([
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'description' => $request->input('description'),
            'category_id' => $request->category_id,
            'creator_id' => $request->user()->id,
        ]);

        return response()->json(['message' => 'Recurso creado con éxito']);
    }
    public function search(Request $request)
    {
        return Resource::where('title', 'LIKE', "%$request->search%")
            ->with('category')
            ->get();

    }
}
