<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Resmi - {{ $order->invoice_number }}</title>
    <style>
        @page { margin: 40px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            font-size: 13px;
            line-height: 1.4;
            margin: 0; padding: 0;
        }
        table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        .logo-text { font-size: 26px; font-weight: bold; color: #2563eb; letter-spacing: -0.5px; }
        .logo-sub { font-size: 11px; color: #64748b; margin-top: 2px; }
        .invoice-title { font-size: 20px; font-weight: bold; color: #1e293b; text-align: right; text-transform: uppercase; }
        .invoice-meta { text-align: right; font-size: 12px; color: #475569; margin-top: 5px; }
        .divider { border-bottom: 2px solid #e2e8f0; margin: 20px 0; }
        .info-section { margin-bottom: 25px; }
        .info-box { width: 48%; vertical-align: top; }
        .info-title { font-size: 11px; text-transform: uppercase; font-weight: bold; color: #94a3b8; margin-bottom: 6px; letter-spacing: 0.5px; }
        .info-content { font-size: 12px; color: #334155; }
        .items-table th { background-color: #f8fafc; border-bottom: 2px solid #cbd5e1; color: #475569; font-weight: bold; text-align: left; padding: 10px 12px; font-size: 11px; text-transform: uppercase; }
        .items-table td { padding: 12px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        .item-category { font-weight: bold; color: #1e293b; font-size: 13px; }
        .totals-table { margin-top: 20px; width: 40%; float: right; }
        .totals-table td { padding: 6px 12px; font-size: 12px; }
        .totals-table .grand-total { border-top: 2px solid #e2e8f0; font-size: 15px; font-weight: bold; color: #2563eb; padding-top: 10px; }
        .paid-stamp { border: 3px double #10b981; color: #10b981; font-size: 18px; font-weight: bold; text-transform: uppercase; padding: 8px 15px; display: inline-block; margin-top: 15px; transform: rotate(-5deg); }
        .footer { margin-top: 60px; font-size: 10px; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 15px; }
        .participant-card { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; margin-top: 12px; }
        .participant-title { font-size: 11px; font-weight: bold; color: #475569; text-transform: uppercase; margin-bottom: 6px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 4px; }
        .participant-table td { padding: 3px 0; font-size: 11px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="logo-text">StrideTix</div>
                <div class="logo-sub">Sistem Manajemen Tiket Lomba Lari Otomatis</div>
            </td>
            <td>
                <div class="invoice-title">Bukti Pembayaran</div>
                <div class="invoice-meta">
                    <strong>No. Invoice:</strong> {{ $order->invoice_number }}<br>
                    <strong>Waktu Cetak:</strong> {{ date('d F Y, H:i') }} WIB
                </div>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="info-section">
        <tr>
            <td class="info-box">
                <div class="info-title">Penerima Tagihan (Bill To)</div>
                <div class="info-content">
                    <strong>{{ $order->customer_name }}</strong><br>
                    Email: {{ $order->customer_email }}<br>
                    WhatsApp: {{ $order->customer_phone }}
                </div>
            </td>
            <td class="info-box" style="padding-left: 4%;">
                <div class="info-title">Detail Acara Lari (Event Info)</div>
                <div class="info-content">
                    <strong>{{ $event->title ?? 'Event Lomba Lari' }}</strong><br>
                    Lokasi: {{ $event->location ?? 'Lintasan Lomba Terpilih' }}
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50%;">Kategori & Kelas Tiket</th>
                <th style="width: 15%; text-align: center;">Kuantitas</th>
                <th style="width: 15%; text-align: right;">Harga Satuan</th>
                <th style="width: 20%; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="item-category">
                            {{ $item->ticketTier->raceCategory->category_name }}
                            <span style="color: #2563eb;">({{ $item->ticketTier->raceCategory->distance_km }}KM)</span>
                        </div>
                        <div style="font-size: 10px; color: #64748b;">Fase: {{ $item->ticketTier->tier_name }}</div>
                    </td>
                    <td style="text-align: center; font-weight: bold;">{{ $item->quantity }}x</td>
                    <td style="text-align: right;">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align: right; font-weight: bold;">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr>
            <td>
                <div class="paid-stamp">LUNAS / PAID</div>
            </td>
            <td>
                <table class="totals-table">
                    <tr>
                        <td style="color: #64748b;">Subtotal Tiket:</td>
                        <td style="text-align: right;">Rp{{ number_format($order->total_original_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="grand-total">Total Bayar:</td>
                        <td style="text-align: right;" class="grand-total">Rp{{ number_format($order->gross_amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top: 30px;">
        <div class="info-title">Manifest Data Pelari Terdaftar (BIB Registrant)</div>
        @php $pNum = 1; @endphp
        @foreach($order->items as $item)
            @foreach($item->participants as $participant)
                <div class="participant-card">
                    <div class="participant-title">Pelari #{{ $pNum }} - Kategori {{ $item->ticketTier->raceCategory->category_name }}</div>
                    <table class="participant-table">
                        <tr>
                            <td style="width: 15%; color: #64748b;">Nama Lengkap:</td>
                            <td style="width: 35%; font-weight: bold;">{{ $participant->full_name }}</td>
                            <td style="width: 15%; color: #64748b;">Ukuran Jersey:</td>
                            <td style="width: 35%; font-weight: bold;">{{ $participant->jersey_size }}</td>
                        </tr>
                        <tr>
                            <td style="color: #64748b;">Jenis Kelamin:</td>
                            <td>{{ $participant->gender->label() }}</td>
                            <td style="color: #64748b;">Gol. Darah:</td>
                            <td>{{ $participant->blood_type }}</td>
                        </tr>
                        <tr>
                            <td style="color: #64748b;">No. Identitas:</td>
                            <td colspan="3">{{ $participant->identity_number }} ({{ $participant->identity_type->label() }})</td>
                        </tr>
                    </table>
                </div>
                @php $pNum++; @endphp
            @endforeach
        @endforeach
    </div>

    <div class="footer">
        Invoice ini merupakan dokumen bukti pendaftaran sah yang diterbitkan secara elektronik oleh StrideTix. Silakan bawa berkas digital atau cetak saat pengambilan BIB & Jersey penukaran race pack.
    </div>

</body>
</html>