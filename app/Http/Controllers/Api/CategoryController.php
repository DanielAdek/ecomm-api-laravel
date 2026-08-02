<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\ApiResponse;

class CategoryController extends Controller
{
	use ApiResponse;
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

		return $this->successResponse(
			$data,
			'Categories retrieved successfully'
		);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreCategoryRequest $request)
	{
		$category = $this->service->create(
				$request->validated()
		);

		return $this->successResponse(
			new CategoryResource($category),
			'Category created successfully',
			201
    );
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Category $category)
	{
		$category = new CategoryResource(
				$this->service->getById($category)
		);

		return $this->successResponse(
			new CategoryResource($category),
			'Category retrieved successfully'
    );
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

		return $this->successResponse(
			new CategoryResource($updatedCategory),
			'Updated Successfully!'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Category $category)
	{
		$this->service->delete($category);

		return $this->successResponse(
      null,
      'Category deleted successfully'
    );
	}
}
