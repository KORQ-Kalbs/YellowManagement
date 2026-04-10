<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'  => ['required', 'exists:expense_categories,id'],
            'amount'       => ['required', 'integer', 'min:1'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'date'         => ['required', 'date'],
            'attachment'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori pengeluaran wajib dipilih.',
            'amount.required'      => 'Jumlah pengeluaran wajib diisi.',
            'amount.min'           => 'Jumlah pengeluaran minimal Rp 1.',
            'date.required'        => 'Tanggal wajib diisi.',
            'attachment.max'       => 'Ukuran file maksimal 2MB.',
            'attachment.mimes'     => 'File harus berformat JPG, PNG, atau PDF.',
        ];
    }
}
