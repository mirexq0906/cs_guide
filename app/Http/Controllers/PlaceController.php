<?php

namespace App\Http\Controllers;

use App\Http\Requests\Place\StoreRequest;
use App\Http\Requests\Place\UpdateRequest;
use App\Http\Requests\DataRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessCollection;
use App\Http\Resources\SuccessResource;
use App\Models\Category;
use App\Models\Place;
use App\Models\SubCategory;
use Illuminate\Support\Arr;

class PlaceController extends Controller
{
    public function index(DataRequest $request)
    {
        try {
            $data = $request->all();
            $query = Place::query()->with(['subCategory', 'category']);
            $place['items'] = $this->dataProcessor->processData($data, $query);
            $place['total'] = Place::get()->count();
            return new SuccessCollection($place);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $place = Place::find($id);
            $place['sub_category'] = $place->subCategory;
            $place['category'] = $place->category;
            return new SuccessResource($place);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->all();
            $place = Place::create($data);
            return new SuccessResource($place);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function update($id, UpdateRequest $request)
    {
        try {
            $data = $request->all();
            $allowedColumns = ['name', 'sub_category_id', 'category_id'];
            $filteredData = Arr::only($data, $allowedColumns);

            $place = Place::find($id);
            $place->update($filteredData);
            return new SuccessResource($place);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $place = Place::find($id);
            $place->delete();
            return new SuccessResource($place);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
