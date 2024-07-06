<?php

namespace App\Http\Requests;

use App\Enums\ReviewStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateReviewRequest extends FormRequest
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
            'key' => 'required|string|max:250',
            'title' => 'required|string|max:250',
            'description' => 'required|string|max:20000',
            'salary' => 'numeric',
            'rate' => 'integer|between:1,5',
            'start_date' => 'date',
            'review_status' => [new Enum(ReviewStatus::class)],
        ];
    }
}
