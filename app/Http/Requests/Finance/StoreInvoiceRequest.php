<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'visit_ticket_id' => 'required|exists:visit_tickets,visit_ticket_id',
            'amount_base' => 'required|numeric|min:0',
            'amount_discount' => 'nullable|numeric|min:0',
            // 'sales_id' => 'required|exists:users,user_id', // Optional if we auto-assign
        ];
    }
}
