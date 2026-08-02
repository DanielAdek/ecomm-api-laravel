<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(
       private CategoryService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CategoryResource::collection(
            Category::latest()->get()
        );

        return [
            'message' => 'Successful!',
            'data' => $data
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->service->create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Category created successfully',
            'date' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = new CategoryResource(
            $this->service->getById($category)
        );

        return response()->json([
            'message' => "Success",
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $updatedCategory = $this->service->update(
          $category,
          $request->validated()
        );

        return response()->json([
          'message' => 'Category updated successfully',
          'data' => new CategoryResource($updatedCategory),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
      $this->service->delete($category);

			return response()->json([
					'message' => 'Category deleted successfully',
			]);
    }
}
