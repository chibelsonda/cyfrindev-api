<?php

namespace App\Trait;

use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationTrait
{
    /**
     * @param Validator $validator
     * 
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'message' => array_values($validator->errors()->toArray())
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
