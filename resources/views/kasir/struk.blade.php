@extends('layouts.kasir')
@section('title', 'Struk Pembayaran')

@section('content')

<div class="struk-container">
    <h2>Struk Pembayaran</h2>
    <div class="info">
        <div>No. Order: <b><?= $pembayaran['id'] ?></b></div>
        <div>Tanggal: <?= date('d M Y H:i', strtotime($pembayaran['order_date'])) ?></div>
        <div>Customer: <?= htmlspecialchars($pembayaran['customer_name'] ?: '-') ?></div>
        <div>Jenis Order: <?= htmlspecialchars($pembayaran['order_type_name']) ?></div> <div>Metode: <?= htmlspecialchars($pembayaran['payment_method_name']) ?></div> <div>Status: <?= ucfirst(htmlspecialchars($pembayaran['order_status_name'])) ?></div> </div>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        
            <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>Rp<?= number_format($row['price_per_item'], 0, ',', '.') ?></td>
                <td>Rp<?= number_format($row['subtotal_calculated'], 0, ',', '.') ?></td>
            </tr>
            
            <tr>
                <td colspan="4" style="font-size:12px;color:#888;">Catatan: <?= htmlspecialchars($row['item_notes']) ?></td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>Rp<?= number_format($total_amount_calculated, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="center">
        <button class="btn-cetak" onclick="window.print()">Cetak Struk</button>
        <button class="btn-kembali" onclick="window.location.href="kasir.php"">Kembali</button>
    </div>
</div>

@endsection

