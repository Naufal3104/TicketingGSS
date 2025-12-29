<?php

namespace App\Http\Requests\Operational;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,customer_id',
            'issue_category' => 'required|string|max:50',
            'issue_description' => 'required|string',
            'visit_address' => 'required|string',
            'priority_level' => 'required|in:LOW,MEDIUM,HIGH,URGENT',
            'ts_quota_needed' => 'required|integer|min:1',
            'status' => 'nullable|in:OPEN,ASSIGNED,IN_PROGRESS,COMPLETED,CANCELLED,ARCHIVED', // Allow status update
        ];
    }
}
