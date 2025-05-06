<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .kuitansi {
            width: 500px;
            border: 1px solid #000;
            padding: 20px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        .nomor {
            text-align: right;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .item {
            margin-bottom: 10px;
        }
        .label {
            display: inline-block;
            width: 150px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #000;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .detail-items {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="kuitansi">
        <div class="header">KUITANSI PEMBAYARAN</div>
        
        <div class="nomor">Nomor: 10</div>
        
        <div class="content">
            <div class="item">
                <span class="label">Tanggal:</span>
                <span>20 Januari 2023</span>
            </div>
            <div class="item">
                <span class="label">Telah terima dari:</span>
                <span>{{ $data->name }}</span>
            </div>
            <div class="item">
                <span class="label">Uang sejumlah:</span>
                <span>Rp{{ $data->total_biaya}}</span>
            </div>
            <div class="item">
                <span class="label">Untuk pembayaran:</span>
                <span>Pembayaran sewa fasilitas</span>
            </div>
            <div class="item">
                <span class="label">Periode:</span>
                <span>Februari sampai dengan Juli 2023</span>
            </div>
        </div>
        
        <div class="detail-items">
            <table class="table">
                <thead>
                    <tr>
                        <th width="40%">Item</th>
                        <th width="10%">Harga</th>
                        <th width="50%">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->rentalDetails as $val)
                    <tr>
                        <td>{{ $val->facility->name }}</td>
                        <td>{{ $val->facility->hourly_rate }}</td>
                        <td>{{ $val->catatan_tambahan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <table class="table" style="margin-top: 30px;">
            <tr>
                <td>Penerima<br><br><br><br>({{ $data->name }})</td>
                <td>Penyetor<br><br><br><br>({{ $data->kasir->name }})</td>
            </tr>
        </table>
    </div>
</body>
</html>