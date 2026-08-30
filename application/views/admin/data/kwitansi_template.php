<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #fff; /* Mengubah background menjadi putih */
            color: #000; /* Mengubah warna teks menjadi hitam */
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff; /* Bagian utama tetap putih */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            font-size: 34px;
            color: #000; /* Mengubah warna teks menjadi hitam */
            font-weight: bold;
        }
        .header p {
            font-size: 20px;
            color: #000; /* Mengubah warna teks menjadi hitam */
        }
        .details {
            margin-bottom: 30px;
            font-size: 16px;
            color: #000; /* Mengubah warna teks menjadi hitam */
        }
        .details p {
            margin: 12px 0;
        }
        .details .info {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }
        .details .info p {
            width: 45%;
        }
        .amount-section {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            font-size: 22px;
            font-weight: bold;
            color: #000; /* Mengubah warna teks menjadi hitam */
        }
        .signature-section {
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 20px 0;
        }
        .signature-space {
            border-bottom: 2px solid #000; /* Mengubah warna garis menjadi hitam */
            height: 50px;
            margin-bottom: 10px;
        }
        .signature p {
            margin-top: 10px;
            font-size: 16px;
            color: #000; /* Mengubah warna teks menjadi hitam */
        }
        .footer {
            text-align: center;
            font-size: 16px;
            margin-top: 30px;
            color: #000; /* Mengubah warna teks menjadi hitam */
        }
        .footer p {
            margin: 0;
        }
        .amount-section p {
            font-size: 26px;
            font-weight: bold;
            color: #000; /* Mengubah warna teks menjadi hitam */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>KWITANSI PEMBAYARAN</h2>
            <p>Universitas Jenderal Achmad Yani</p>
        </div>
        <div class="details">
            <div class="info">
                <p><strong>No:</strong> <?php echo $pengajuan->id_ka; ?></p>
                <p><strong>Tanggal:</strong> <?php echo date('d F Y', strtotime($pengajuan->tanggal_pengajuan)); ?></p>
            </div>
            <p><strong>ID User:</strong> <?php echo $pengajuan->id_user; ?></p>
            <p><strong>Terima Dari:</strong> <?php echo $pengajuan->nama_lengkap; ?></p>
            <p><strong>Terbilang:</strong> <?php 
                $amount = ($pengajuan->keterangan == 'mahasiswa') ? 40000 : 0;
                echo ucwords(terbilang($amount)) . ' Rupiah';
            ?></p>
            <p><strong>Untuk Pembayaran:</strong> Pembayaran Kartu Akses</p>
        </div>
        <div class="amount-section">
            <p>Rp <?php echo number_format($amount, 0, ',', '.'); ?></p>
        </div>
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="signature-space"></div>
                        <p>Tanda tangan Penerima</p>
                    </td>
                    <td>
                        <div class="signature-space"></div>
                        <p>Tanda tangan Penyetor</p>
                        <br>
                        <p><?php echo $pengajuan->nama_lengkap; ?></p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Universitas Jenderal Achmad Yani | Aji & Bella</p>
        </div>
    </div>
</body>
</html>

<?php
// Fungsi pembantu untuk mengubah angka ke dalam bentuk kata (dalam Bahasa Indonesia)
function terbilang($number) {
    $words = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($number < 12)
        return " " . $words[$number];
    elseif ($number < 20)
        return terbilang($number - 10) . " belas";
    elseif ($number < 100)
        return terbilang($number / 10) . " puluh" . terbilang($number % 10);
    elseif ($number < 200)
        return " seratus" . terbilang($number - 100);
    elseif ($number < 1000)
        return terbilang($number / 100) . " ratus" . terbilang($number % 100);
    elseif ($number < 2000)
        return " seribu" . terbilang($number - 1000);
    elseif ($number < 1000000)
        return terbilang($number / 1000) . " ribu" . terbilang($number % 1000);
    elseif ($number < 1000000000)
        return terbilang($number / 1000000) . " juta" . terbilang($number % 1000000);
}
?>
