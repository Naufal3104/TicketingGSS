<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas - {{ $ticket->visit_ticket_id }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; }
        .content { margin-bottom: 50px; }
        .row { display: flex; margin-bottom: 10px; }
        .label { width: 200px; font-weight: bold; }
        .value { flex: 1; }
        .footer { display: flex; justify-content: space-between; margin-top: 50px; text-align: center; }
        .signature { width: 200px; }
        .signature-line { margin-top: 80px; border-bottom: 1px solid #000; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Global Service Solusi</h1>
        <p>Jl. Contoh Jalan No. 123, Jakarta Selatan</p>
        <p>Telp: (021) 1234-5678 | Email: admin@gss.co.id</p>
    </div>

    <div class="content">
        <h2 style="text-align: center; text-decoration: underline;">SURAT TUGAS</h2>
        <p style="text-align: center;">Nomor: ST/{{ date('Y/m') }}/{{ substr($ticket->visit_ticket_id, -4) }}</p>

        <p>Yang bertanda tangan di bawah ini memberikan tugas kepada:</p>

        <div class="row">
            <div class="label">Nama Teknisi</div>
            <div class="value">: {{ $ticket->assignment->ts->name ?? 'Belum Ditentukan' }}</div>
        </div>
        <div class="row">
            <div class="label">ID Teknisi</div>
            <div class="value">: {{ $ticket->assignment->ts->user_id ?? '-' }}</div>
        </div>

        <p>Untuk melaksankan pekerjaan kunjungan teknis (Visit) dengan detail sebagai berikut:</p>

        <div class="row">
            <div class="label">ID Tiket</div>
            <div class="value">: {{ $ticket->visit_ticket_id }}</div>
        </div>
        <div class="row">
            <div class="label">Nama Pelanggan</div>
            <div class="value">: {{ $ticket->customer->customer_name ?? 'Guest' }}</div>
        </div>
        <div class="row">
            <div class="label">Alamat</div>
            <div class="value">: {{ $ticket->visit_address }}</div>
        </div>
        <div class="row">
            <div class="label">Kategori Masalah</div>
            <div class="value">: {{ $ticket->issue_category }}</div>
        </div>
        <div class="row">
            <div class="label">Deskripsi Masalah</div>
            <div class="value">: {{ $ticket->issue_description }}</div>
        </div>
        <div class="row">
            <div class="label">Jadwal Kunjungan</div>
            <div class="value">: {{ $ticket->visit_date }} {{ $ticket->visit_time }}</div>
        </div>

        <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>
        <p>Jakarta, {{ date('d F Y') }}</p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Penerima Tugas</p>
            <div class="signature-line"></div>
            <p>{{ $ticket->assignment->ts->name ?? 'Teknisi' }}</p>
        </div>
        <div class="signature">
            <p>Pemeberi Tugas</p>
            <div class="signature-line"></div>
            <p>Operational Manager</p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Surat Tugas</button>
    </div>
</body>
</html>
