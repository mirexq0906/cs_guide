<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategory\StoreRequest;
use App\Http\Requests\SUbCategory\UpdateRequest;
use App\Http\Requests\DataRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessCollection;
use App\Http\Resources\SuccessResource;
use App\Models\Action;

class ActionController extends Controller
{
    public function index(DataRequest $request)
    {
        try {
            $data = $request->all();
            $query = Action::query()->with(['subCategory', 'category', 'place_start', 'place_end']);
            $actions['items'] = $this->dataProcessor->processData($data, $query);
            $actions['total'] = Action::get()->count();
            return new SuccessCollection($actions);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $action = Action::find($id);
            $action['sub_category'] = $action->subCategory;
            $action['category'] = $action->category;
            $action['place_start'] = $action->place_start;
            $action['place_end'] = $action->place_end;
            return new SuccessResource($action);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('img_start')) {
                $data['img_start'] = $this->imageLoader->oneLoadImage($request->file('img_start'));
            }
            if ($request->hasFile('img_end')) {
                $data['img_end'] = $this->imageLoader->oneLoadImage($request->file('img_end'));
            }
            if ($request->hasFile('img_middle')) {
                $data['img_middle'] = $this->imageLoader->oneLoadImage($request->file('img_middle'));
            }
            $action = Action::create($data);
            return new SuccessResource($action);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function update($id, UpdateRequest $request)
    {
        try {
            $data = $request->all();
            $action = Action::find($id);
            if ($request->hasFile('img_start')) {
                $data['img_start'] = $this->imageLoader->oneLoadImage($request->file('img_start'));
            }
            if ($request->hasFile('img_end')) {
                $data['img_end'] = $this->imageLoader->oneLoadImage($request->file('img_end'));
            }
            if ($request->hasFile('img_middle')) {
                $data['img_middle'] = $this->imageLoader->oneLoadImage($request->file('img_middle'));
            }
            $action->update($data);
            return new SuccessResource($action);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $action = Action::find($id);
            $action->delete();
            return new SuccessResource($action);
        } catch (\Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
