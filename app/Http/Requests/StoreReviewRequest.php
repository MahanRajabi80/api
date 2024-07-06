<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ReviewType;
use App\Enums\ReviewStatus;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|numeric',
            'review_type' => [new Enum(ReviewType::class)],
            'title' => 'required|string|max:250',
            'description' => 'required|string|min:200|max:20000',
            'salary' => 'numeric',
            'rate' => 'integer|between:1,5',
            'start_date' => 'date',
            'review_status' => ['required', new Enum(ReviewStatus::class)],
        ];
    }
}
