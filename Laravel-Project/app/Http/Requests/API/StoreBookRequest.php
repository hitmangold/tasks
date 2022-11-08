<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
            'qty' => 'required|numeric|not_in:0',
            'authors' => 'sometimes|required',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Գրքի անվանումը խնդրում ենք մուտքագրել',
            'price.required'  => 'Խնդրում ենք նշել գինը',
            'qty.required' => 'Խնդրում ենք նշել քանակը',
            'authors.required' => 'Խնդրում ենք նշել հեղինակներին'
        ];
    }
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'status'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ], 400));

    }
}
