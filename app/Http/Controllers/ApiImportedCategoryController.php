<?php

namespace App\Http\Controllers;

use App\Models\ImportedCategory;

class ApiImportedCategoryController extends Controller
{
    public function index()
    {
        return response()->json(
            ImportedCategory::withCount('questions')->get()
        );
    }
}
