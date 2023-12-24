<?php

require 'functions.php';

// Mendapatkan data mahasiswa dari database atau sumber data lainnya
$data_testing = query("SELECT * FROM data_testing");

// Fungsi untuk menghitung akurasi prediksi
function hitungAkurasi($prediksi, $kelasSebenarnya) {
    return ($prediksi == $kelasSebenarnya) ? "Benar" : "Salah";
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/table.css">
    <title>AKURASI TESTING</title>
</head>
<body>
    <div class="container">
        <h1>MONITORING KONDISI KESEHATAN SEBELUM DAN SESUDAH OLAHRAGA</h1>
        <form action="" method="post">
            <input type="text" name="keyword" size="70" autofocus placeholder="Apa ang Anda Cari?" autocomplete="off">
            <button type="submit" name="cari" class="tombolcari">Cari!..</button>
        </form>

        <ul>
            <li>
                <a href="index.php" class="tombol">HOME</a>
            </li>
            <li>
                <a href="perhitungan.php" class="tombol">HITUNG PREDIKSI</a>
            </li>
            <li>
                <a href="training.php" class="tombol">AKURASI DATA TRAINING</a>
            </li>
            <li>
                <a href="testing.php" class="tombol">AKURASI DATA TESTING</a>
            </li>
        </ul>
           <?php
                // Menghitung jumlah data yang memiliki nilai "Benar" pada kolom Akurasi
                $jumlahBenar = 0;

                foreach ($data_testing as $row) {
                $prediksiKelas = probabilitasTes($row["DJSebelumO"], $row["STSebelumO"], $row["Usia"], $row["Intensitas"], $row["DJSetelahO"], $row["STSetelahO"]);
                $akurasiPrediksi = hitungAkurasi($prediksiKelas, $row["Kelas"]);

                if ($akurasiPrediksi == "Benar") {
                $jumlahBenar++;
                }
                }
                $totalData = count(query("SELECT * FROM data_testing"));
            ?>
            <table>
                <th>AKURASI PADA DATA TESTING</th>
                <th><?php echo (($jumlahBenar/$totalData) * 100)?> %</th>
            </table>
            <!-- Menampilkan tabel HTML -->
            <table>
                <tr>
                    <th>No</th>
                    <th>DJSebelumO</th>
                    <th>STSebelumO</th>
                    <th>Usia</th>
                    <th>Intensitas</th>
                    <th>DJSetelahO</th>
                    <th>STSetelahO</th>
                    <th>Kelas</th>
                    <th>Prediksi Kelas</th>
                    <th>Akurasi</th>
                </tr>

                <?php $i = 1 ?>
                <?php foreach ($data_testing as $row) : ?>
                    <tr>
                        <td class="spesial"><?php echo $i ?></td>
                        <td><?php echo $row["DJSebelumO"] ?></td>
                        <td><?php echo $row["STSebelumO"] ?></td>
                        <td><?php echo $row["Usia"] ?></td>
                        <td><?php echo $row["Intensitas"] ?></td>
                        <td><?php echo $row["DJSetelahO"] ?></td>
                        <td><?php echo $row["STSetelahO"] ?></td>
                        <td><?php echo $row["Kelas"] ?></td>

                    <!-- Menambah kolom Prediksi Kelas -->
                    <?php
                        $prediksiKelas = probabilitasTes($row["DJSebelumO"], $row["STSebelumO"], $row["Usia"], $row["Intensitas"], $row["DJSetelahO"], $row["STSetelahO"]);
                    ?>
                        <td><?php echo $prediksiKelas ?></td>

                        <!-- Menambah kolom Akurasi -->
                        <?php
                            $akurasiPrediksi = hitungAkurasi($prediksiKelas, $row["Kelas"]);
                        ?>
                        <td><?php echo $akurasiPrediksi ?></td>
                        </tr>
                    <?php $i++ ?>
                <?php endforeach; ?>
        </table>
    </div>
</body>
</html>

