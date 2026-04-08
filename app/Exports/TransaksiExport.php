<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected string $period;
    protected Carbon $selectedDate;
    protected bool $isKasir;
    protected int $userId;

    public function __construct(string $period, Carbon $selectedDate, bool $isKasir, int $userId)
    {
        $this->period      = $period;
        $this->selectedDate = $selectedDate;
        $this->isKasir     = $isKasir;
        $this->userId      = $userId;
    }

    public function collection()
    {
        [$startDate, $endDate] = $this->dateRange();

        return Transaksi::with(['details.product', 'user', 'pembayaran', 'discountEvent'])
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'completed')
            ->when($this->isKasir, fn($q) => $q->where('user_id', $this->userId))
            ->orderBy('tanggal_transaksi')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Tanggal',
            'Kasir',
            'Metode Bayar',
            'Event Diskon',
            'Subtotal Asli (Rp)',
            'Potongan Diskon (Rp)',
            'Total Akhir (Rp)',
            'Jumlah Bayar (Rp)',
            'Kembalian (Rp)',
        ];
    }

    public function map($transaksi): array
    {
        $subtotalAsli   = $transaksi->details->sum('subtotal');
        $discountPct    = $transaksi->discountEvent
            ? floatval($transaksi->discountEvent->discount_percentage)
            : 0;
        $potongan       = $subtotalAsli - floatval($transaksi->total_harga);
        $jumlahBayar    = $transaksi->pembayaran ? floatval($transaksi->pembayaran->jumlah_pembayaran) : 0;
        $kembalian      = max(0, $jumlahBayar - floatval($transaksi->total_harga));

        return [
            $transaksi->no_invoice,
            $transaksi->tanggal_transaksi->format('d/m/Y H:i'),
            $transaksi->user->name ?? '-',
            strtoupper($transaksi->pembayaran->metode_pembayaran ?? '-'),
            $transaksi->discountEvent
                ? $transaksi->discountEvent->name . ' (' . number_format($discountPct, 0) . '%)'
                : '-',
            $subtotalAsli,
            $potongan,
            floatval($transaksi->total_harga),
            $jumlahBayar,
            $kembalian,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }

    private function dateRange(): array
    {
        return match ($this->period) {
            'week'  => [$this->selectedDate->copy()->startOfWeek(), $this->selectedDate->copy()->endOfWeek()],
            'month' => [$this->selectedDate->copy()->startOfMonth(), $this->selectedDate->copy()->endOfMonth()],
            default => [$this->selectedDate->copy()->startOfDay(), $this->selectedDate->copy()->endOfDay()],
        };
    }
}
