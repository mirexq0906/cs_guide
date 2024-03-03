<?php

namespace App\Http\Requests\SubCategory;

use App\Http\Resources\ErrorResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ErrorResource('Ошибка валидации полей'))->response()->getData(true);
        throw new HttpResponseException(response()->json($errors));
    }

    public function rules(): array
    {
        return [ ];
    }
}
