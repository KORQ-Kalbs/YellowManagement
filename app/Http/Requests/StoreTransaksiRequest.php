<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
            'metode_pembayaran' => ['required', 'in:cash,qris'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Minimal harus ada 1 produk',
            'items.min' => 'Minimal harus ada 1 produk',
            'items.*.product_id.required' => 'Produk wajib dipilih',
            'items.*.product_id.exists' => 'Produk tidak valid',
            'items.*.jumlah.required' => 'Jumlah wajib diisi',
            'items.*.jumlah.min' => 'Jumlah minimal 1',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid',
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi',
            'jumlah_bayar.min' => 'Jumlah bayar tidak valid',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert jumlah_bayar to numeric if it's a string
        if ($this->has('jumlah_bayar')) {
            $this->merge([
                'jumlah_bayar' => (float) str_replace(',', '', $this->jumlah_bayar)
            ]);
        }
    }
}