<?php
    require 'functions.php';

    // Ubah query menjadi data_training
    $data_training = query('SELECT * FROM data_training');

    // Tombol cari ditekan
    if (isset($_POST["cari"])) {
        $data_training = cari($_POST["keyword"]);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/table.css">
    <title>MONITORING KESEHATAN</title>
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
        
        <a href="tambah.php" class="tombol">TAMBAH DATA TRAINING</a>

        <table>
            <tr>
                <th>No</th>
                <th>Aksi</th>
                <th>DJSebelumO</th>
                <th>STSebelumO</th>
                <th>Usia</th>
                <th>Intensitas</th>
                <th>DJSetelahO</th>
                <th>STSetelahO</th>
                <th>Kelas</th>
            </tr>

            <?php $i = 1 ?>
            <?php foreach ($data_training as $row) : ?>
                <tr>
                    <td class="spesial"><?php echo $i ?></td>
                    <td>
                        <a href="hapus.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Apakah Anda Yakin?')" class="tombolhapus">Hapus</a>
                    </td>
                    <td><?php echo $row["DJSebelumO"] ?></td>
                    <td><?php echo $row["STSebelumO"] ?></td>
                    <td><?php echo $row["Usia"] ?></td>
                    <td><?php echo $row["Intensitas"] ?></td>
                    <td><?php echo $row["DJSetelahO"] ?></td>
                    <td><?php echo $row["STSetelahO"] ?></td>
                    <td><?php echo $row["Kelas"] ?></td>
                </tr>
            <?php $i++ ?>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
