<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePembayaranRequest extends FormRequest
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
            'id_transaksi' => ['required', 'exists:transaksis,id'],
            'metode_pembayaran' => ['required', 'in:cash,qris'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
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
            'id_transaksi.required' => 'ID Transaksi harus diisi',
            'id_transaksi.exists' => 'Transaksi tidak ditemukan',
            'metode_pembayaran.required' => 'Metode pembayaran harus dipilih',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid',
            'jumlah_bayar.required' => 'Jumlah bayar harus diisi',
            'jumlah_bayar.numeric' => 'Jumlah bayar harus berupa angka',
            'jumlah_bayar.min' => 'Jumlah bayar tidak boleh kurang dari 0',
        ];
    }
}
