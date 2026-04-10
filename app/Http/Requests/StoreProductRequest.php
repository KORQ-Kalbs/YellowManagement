<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:255', 'unique:products,nama_produk'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'harga' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'stok' => ['required', 'integer', 'min:0'],
            'status' => ['nullable', 'in:active,inactive'],
            'variants' => ['nullable', 'array'],
            'variants.*.id' => ['nullable', 'integer'],
            'variants.*.kode_variant' => ['required_with:variants', 'string', 'max:10'],
            'variants.*.nama_variant' => ['required_with:variants', 'string', 'max:255'],
            'variants.*.harga_tambahan' => ['nullable', 'numeric', 'min:0'],
            'variants.*.is_active' => ['nullable'],
        ];
    }

    /**
     * Dapatkan pesan validasi kustom untuk penentu kesalahan.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah terdaftar',
            'kategori_id.required' => 'Kategori harus dipilih',
            'kategori_id.exists' => 'Kategori tidak ditemukan',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh kurang dari 0',
            'stok.required' => 'Stok harus diisi',
            'stok.integer' => 'Stok harus berupa angka bulat',
            'stok.min' => 'Stok tidak boleh kurang dari 0',
        ];
    }
}
