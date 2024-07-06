<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ContentType;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason_id' => 'required|numeric',
            'review_id' => 'required|numeric',
            'comment_id' => 'numeric',
            'description' => 'string',
            'content_type' => ['required', new Enum(ContentType::class)],
        ];
    }
}
