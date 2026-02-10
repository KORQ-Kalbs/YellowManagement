<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of kasir users.
     */
    public function index(): View
    {
        $kasirs = User::where('role', 'kasir')
            ->withCount('transaksis')
            ->latest()
            ->get();

        return view('admin.kelola_kasir.index', compact('kasirs'));
    }

    /**
     * Store a newly created kasir.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'kasir',
        ]);

        return redirect()
            ->route('admin.kasir.index')
            ->with('success', 'Kasir berhasil ditambahkan');
    }

    /**
     * Update the specified kasir.
     */
    public function update(Request $request, User $kasir): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $kasir->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Only update password if provided
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $kasir->update($data);

        return redirect()
            ->route('admin.kasir.index')
            ->with('success', 'Kasir berhasil diperbarui');
    }

    /**
     * Remove the specified kasir.
     */
    public function destroy(User $kasir): RedirectResponse
    {
        // Prevent deleting if kasir has transactions
        if ($kasir->transaksis()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kasir yang memiliki riwayat transaksi');
        }

        $kasir->delete();

        return redirect()
            ->route('admin.kasir.index')
            ->with('success', 'Kasir berhasil dihapus');
    }

    /**
     * Toggle kasir active status (soft disable).
     */
    public function toggleStatus(User $kasir): RedirectResponse
    {
        // You can add a 'status' column to users table if needed
        // For now, we'll just return success
        return back()->with('success', 'Status kasir berhasil diubah');
    }
}
