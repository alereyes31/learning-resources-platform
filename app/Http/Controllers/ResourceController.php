<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\Resource;
use App\Models\Category; 
use App\Models\Voter;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Resources', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resources' => Resource::with('category','votes')->latest()->get(),
            'categories' => Category::all(),
            'voterId' => Voter::getOrCreateVoter($request)->code,
        ]);
    }

    public function store(Request $request)
    {
        Resource::create([
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'creator_id' => $request->user()->id,
        ]);
        return Inertia::location('/');
        return response()->json(['message' => 'Recurso creado con éxito']);
    }
    public function search(Request $request)
    {
        return Resource::query()
            ->when(!empty($request->search), function ($query) use ($request) {
                return $query->where('title', 'like', "%$request->search%");
            })
            ->when(!empty($request->category), function ($query) use ($request) {
                return $query->where('category_id', $request->category);
            })
            ->with('category','votes')
            ->get();
    }
    
}
