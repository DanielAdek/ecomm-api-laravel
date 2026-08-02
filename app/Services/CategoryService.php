<?php

namespace App\Services;

use Illuminate\Support\Str;

use App\Models\Category;

class CategoryService
{
  public function getAll()
  {
    return Category::latest()->get();
  }

  public function create(array $data): Category
  {
    $data['slug'] = Str::slug($data['name']);
    
    return Category::create($data);
  }
} 