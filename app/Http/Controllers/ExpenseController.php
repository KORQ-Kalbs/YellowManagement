<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    /**
     * Daftar pengeluaran dengan date-range filter.
     */
    public function index(Request $request): View
    {
        $query = Expense::with(['category', 'user'])->latest('date');

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $expenses   = $query->paginate(15)->withQueryString();
        $categories = ExpenseCategory::orderBy('name')->get();

        // Summary stats for filtered period
        $totalFiltered = (clone $query)->getQuery()->sum('amount');

        return view('admin.pengeluaran.index', compact('expenses', 'categories', 'totalFiltered'));
    }

    /**
     * Form input pengeluaran baru.
     */
    public function create(): View
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('admin.pengeluaran.create', compact('categories'));
    }

    /**
     * Simpan pengeluaran baru + upload attachment.
     */
    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();

            // Handle file upload
            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment')
                    ->store('expenses/attachments', 'public');
            }

            Expense::create($data);

            return redirect()
                ->route('admin.expenses.index')
                ->with('success', 'Pengeluaran berhasil dicatat.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menyimpan pengeluaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Form edit pengeluaran.
     */
    public function edit(Expense $expense): View
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('admin.pengeluaran.edit', compact('expense', 'categories'));
    }

    /**
     * Update pengeluaran.
     */
    public function update(StoreExpenseRequest $request, Expense $expense): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Handle file upload (replace old if new uploaded)
            if ($request->hasFile('attachment')) {
                // Delete old attachment
                if ($expense->attachment) {
                    Storage::disk('public')->delete($expense->attachment);
                }
                $data['attachment'] = $request->file('attachment')
                    ->store('expenses/attachments', 'public');
            }

            $expense->update($data);

            return redirect()
                ->route('admin.expenses.index')
                ->with('success', 'Pengeluaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui pengeluaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus pengeluaran.
     */
    public function destroy(Expense $expense): RedirectResponse
    {
        try {
            if ($expense->attachment) {
                Storage::disk('public')->delete($expense->attachment);
            }
            $expense->delete();

            return redirect()
                ->route('admin.expenses.index')
                ->with('success', 'Pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus pengeluaran: ' . $e->getMessage());
        }
    }

    /**
     * CRUD Kategori Pengeluaran (inline via modal).
     */
    public function storeCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:expense_categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        ExpenseCategory::create($request->only('name', 'description'));

        return back()->with('success', 'Kategori pengeluaran berhasil ditambahkan.');
    }

    public function destroyCategory(ExpenseCategory $category): RedirectResponse
    {
        if ($category->expenses()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki data pengeluaran.');
        }

        $category->delete();
        return back()->with('success', 'Kategori pengeluaran berhasil dihapus.');
    }
}
