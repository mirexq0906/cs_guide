<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Requests\DataRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessCollection;
use App\Http\Resources\SuccessResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(DataRequest $request)
    {
        try {
            $data = $request->all();
            $categories['items'] = $this->dataProcessor->processData($data, Category::query()->with(['subCategory']));
            $categories['total'] = Category::get()->count();
            return new SuccessCollection($categories);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $category = Category::find($id);
            return new SuccessResource($category);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('img')) {
                $data['img'] = $this->imageLoader->oneLoadImage($request->file('img'));
            }
            $category = Category::create($data);
            return new SuccessResource($category);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function update($id, UpdateRequest $request)
    {
        try {
            $data = $request->all();
            $category = Category::find($id);
            if ($request->hasFile('img')) {
                $data['img'] = $this->imageLoader->oneLoadImage($request->file('img'), $category->img);
            }
            $category->update($data);
            return new SuccessResource($category);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            return new SuccessResource($category);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
