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

  public function getById(Category $category)
  {
    return $category;
  }

  public function update(Category $category, array $data)
  {
    $data['slug'] = Str::slug($data['name']);

    $category->update($data);

    return $category->fresh();
  }
} 