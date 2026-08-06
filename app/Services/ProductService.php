<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll(?int $categoryId = null)
    {
        return Product::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(10);
    }
}