<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Storage;

class StorageController extends Controller
{
    public function index()
    {
        return Storage::with("images","services")->get();
    }

    public function find($id)
    {
        return Storage::with("images","services")->find($id);
    }

    public function findByCategory($categoryId)
    {
        return Storage::with("images","services")->where('category_id', $categoryId)->get();
    }
}
