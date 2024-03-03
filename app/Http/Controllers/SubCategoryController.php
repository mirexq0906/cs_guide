<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategory\StoreRequest;
use App\Http\Requests\SUbCategory\UpdateRequest;
use App\Http\Requests\DataRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessCollection;
use App\Http\Resources\SuccessResource;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(DataRequest $request)
    {
        try {
            $data = $request->all();
            $query = SubCategory::query()->with(['category']);
            $subCategories['items'] = $this->dataProcessor->processData($data, $query);
            $subCategories['total'] = SubCategory::get()->count();
            return new SuccessCollection($subCategories);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $subCategory = SubCategory::find($id);
            $subCategory['category'] = $subCategory->category;
            return new SuccessResource($subCategory);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->all();
            $subCategory = SubCategory::create($data);
            return new SuccessResource($subCategory);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function update($id, UpdateRequest $request)
    {
        try {
            $data = $request->all();
            $subCategory = SubCategory::find($id);
            $subCategory->update($data);
            return new SuccessResource($subCategory);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $subCategory = SubCategory::find($id);
            $subCategory->delete();
            return new SuccessResource($subCategory);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
