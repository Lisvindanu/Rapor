{{-- Default mock transactions when no data from controller --}}
<tr class="transaction-row" data-transaction-id="TRX20250715001">
    <td>15/07/2025</td>
    <td>TRX20250715001</td>
    <td><span class="badge bg-success">Pembayaran TA</span></td>
    <td>Rizky Hidayah Aminullah</td>
    <td class="text-success">+Rp 300.000</td>
    <td><span class="badge bg-success">Paid</span></td>
    <td>
        <button class="btn btn-sm btn-outline-primary"
                onclick="handleTransactionAction('view', 'TRX20250715001')"
                data-action="view">
            <i class="fas fa-eye"></i>
        </button>
    </td>
</tr>
<tr class="transaction-row" data-transaction-id="TRX20250714001">
    <td>14/07/2025</td>
    <td>TRX20250714001</td>
    <td><span class="badge bg-warning">Honor Koreksi</span></td>
    <td>Dr. Ahmad Sutisna</td>
    <td class="text-danger">-Rp 2.500.000</td>
    <td><span class="badge bg-warning">Pending</span></td>
    <td>
        <button class="btn btn-sm btn-outline-success"
                onclick="handleTransactionAction('approve', 'TRX20250714001')"
                data-action="approve">
            <i class="fas fa-check"></i>
        </button>
    </td>
</tr>
<tr class="transaction-row" data-transaction-id="TRX20250713001">
    <td>13/07/2025</td>
    <td>TRX20250713001</td>
    <td><span class="badge bg-info">Pengeluaran</span></td>
    <td>Administrasi Umum</td>
    <td class="text-danger">-Rp 850.000</td>
    <td><span class="badge bg-success">Paid</span></td>
    <td>
        <button class="btn btn-sm btn-outline-secondary"
                onclick="handleTransactionAction('download', 'TRX20250713001')"
                data-action="download">
            <i class="fas fa-download"></i>
        </button>
    </td>
</tr>
