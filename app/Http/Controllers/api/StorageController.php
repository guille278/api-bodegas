<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index()
    {
        return Storage::with("images","services")->get();
    }

    public function find($categoryId)
    {
        return Storage::with("images","services")->where('category_id', $categoryId)->get();
    }
}
