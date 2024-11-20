<?php
include "../koneksi.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';
$queryDetail = mysqli_query($koneksi, "SELECT customer.nama_customer, data_transaksi.id, data_transaksi.kode_order, paket.nama_paket, paket.harga, detail_transaksi.* 
FROM detail_transaksi 
LEFT JOIN data_transaksi ON data_transaksi.id = detail_transaksi.id_order
LEFT JOIN customer ON customer.id = data_transaksi.id_customer
LEFT JOIN paket ON paket.id = detail_transaksi.id_paket
WHERE detail_transaksi.id_order = '$id'
");
$row = [];
while ($rowDetail = mysqli_fetch_assoc($queryDetail)) {
    $row[] = $rowDetail;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi : </title>
    <style>
        body {
            margin: 20px;
        }

        .struk {
            width: 80mm;
            max-width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
        }

        .struk-header,
        .struk-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struk-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .struk-body {
            margin-bottom: 10px;
        }

        .struk-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struk-body table th,
        .struk-body table td {
            padding: 5px;
            text-align: left;
        }

        .struk-body table th {
            border-bottom: 1px solid #000;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-evenly;
            /* memberikan space antara dua bagian */
            padding: 5px 0;
            font-weight: bold;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #BFECFF;
            }

            .struk {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struk-header h1,
            .struk-footer {
                font-size: 14px;
            }

            .struk-body table th,
            .struk-body table td {
                padding: 2px;
            }

            .total,
            .payment,
            .change {
                padding: 2px 0;
            }
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="struk-header">
            <h1>Londri Maju Sukacita</h1>
            <p>Jl. Karet Jakarta Pusat</p>
            <p>08213694204</p>
        </div>
        <div class="struk-body">
            <p>Kode Transaksi : <?php echo $row[0]['kode_order'] ?></p>
            <p>Nama Customer : <?php echo $row[0]['nama_customer'] ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row as $key => $rowDetail) : ?>
                        <!-- cara panggilanya juga bisa $row as $rowDetail -->
                        <tr>
                            <td><?php echo $rowDetail['nama_paket'] ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['qty']) ?></td>
                            <td><?php echo $rowDetail['harga'] ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['subtotal']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <!-- <div class="total">
                <span>Total :</span>
                <span><?php echo "Rp." . number_format($row[0]['total_harga']) ?></span>
            </div>
            <div class="payment">
                <span>Dibayar:</span>
                <span><?php echo "Rp." . number_format($row[0]['nominal_bayar']) ?></span>
            </div>
            <div class="change">
                <span>Kembali :</span>
                <span><?php echo "Rp." . number_format($row[0]['kembalian']) ?></span>
            </div> -->
        </div>
        <div class="struk-footer">
            <p>Terima Kasih</p>
            <p>Selamat Berbelanja Kembali</p>
        </div>
    </div>
    <script>
        //untuk print struk 
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>