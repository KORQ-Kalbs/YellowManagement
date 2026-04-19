<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - {{ $selectedDate->format('d/m/Y') }}</title>
    <style>{!! file_get_contents(resource_path('css/laporan-pdf.css')) !!}</style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>LAPORAN TRANSAKSI</h1>
        <p>Yellow Drink &mdash; Jl. Kasir Yellow No. 1 &mdash; Telp: 0812-3456-7890</p>
    </div>

    <!-- Meta -->
    <div class="meta">
        <div>
            <span><strong>Periode:</strong>
                @if($period === 'day') Harian &mdash; {{ $selectedDate->format('d F Y') }}
                @elseif($period === 'week') Mingguan &mdash; {{ $selectedDate->copy()->startOfWeek()->format('d M') }} s/d {{ $selectedDate->copy()->endOfWeek()->format('d M Y') }}
                @else Bulanan &mdash; {{ $selectedDate->format('F Y') }}
                @endif
            </span>
            @if($isKasir)
                <span><strong>Kasir:</strong> {{ auth()->user()->name }}</span>
            @endif
        </div>
        <div style="text-align:right;">
            <span><strong>Dicetak:</strong> {{ now()->format('d/m/Y H:i') }}</span>
            <span><strong>Total Transaksi:</strong> {{ $transaksis->count() }}</span>
        </div>
    </div>

    <!-- Summary -->
    @php
        $grandSubtotal  = $transaksis->sum(fn($t) => $t->details->sum('subtotal'));
        $grandDiscount  = $transaksis->sum(fn($t) => $t->details->sum('subtotal') - floatval($t->total_harga));
        $grandTotal     = $transaksis->sum(fn($t) => floatval($t->total_harga));
    @endphp
    <div class="summary">
        <div class="summary-box">
            <div class="label">Subtotal Asli</div>
            <div class="value">Rp {{ number_format($grandSubtotal, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box red">
            <div class="label">Total Potongan</div>
            <div class="value">- Rp {{ number_format($grandDiscount, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box green">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box blue">
            <div class="label">Jml Transaksi</div>
            <div class="value">{{ $transaksis->count() }}</div>
        </div>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Metode</th>
                <th>Event Diskon</th>
                <th class="text-right">Subtotal Asli</th>
                <th class="text-right">Potongan</th>
                <th class="text-right">Total Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $t)
                @php
                    $subtotalAsli = $t->details->sum('subtotal');
                    $potongan     = $subtotalAsli - floatval($t->total_harga);
                    $discountPct  = $t->discountEvent ? floatval($t->discountEvent->discount_percentage) : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $t->no_invoice }}</td>
                    <td>{{ $t->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td class="text-center">{{ strtoupper($t->pembayaran->metode_pembayaran ?? '-') }}</td>
                    <td>
                        @if($t->discountEvent)
                            {{ $t->discountEvent->name }} ({{ number_format($discountPct, 0) }}%)
                        @else
                            <span style="color:#9ca3af;">-</span>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($subtotalAsli, 0, ',', '.') }}</td>
                    <td class="text-right discount-row">
                        @if($potongan > 0)- {{ number_format($potongan, 0, ',', '.') }}@else -@endif
                    </td>
                    <td class="text-right" style="font-weight:600;">{{ number_format($t->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:20px; color:#9ca3af;">
                        Tidak ada data transaksi pada periode ini.
                    </td>
                </tr>
            @endforelse

            @if($transaksis->count() > 0)
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($grandSubtotal, 0, ',', '.') }}</td>
                <td class="text-right discount-row">- Rp {{ number_format($grandDiscount, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <span>Laporan ini digenerate otomatis oleh sistem kasir Yellow Drink.</span>
        <span>Halaman 1</span>
    </div>

</body>
</html>
