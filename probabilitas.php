<?php

require 'functions.php';

    $data = [
        'DJSebelumO' => $_POST['DJSebelumO'],
        'STSebelumO' => $_POST['STSebelumO'],
        'Usia' => $_POST['Usia'],
        'Intensitas' => $_POST['Intensitas'],
        'DJSetelahO' => $_POST['DJSetelahO'],
        'STSetelahO' => $_POST['STSetelahO'],
    ];

    // Hitung probabilitas berdasarkan input formulir
    $result = probabilitas(
        $data['DJSebelumO'],
        $data['STSebelumO'],
        $data['Usia'],
        $data['Intensitas'],
        $data['DJSetelahO'],
        $data['STSetelahO']
    );

    // Akses data dari array hasil
    $probabilitasPriorTidakOlahraga = $result['probabilitasPrior']['Tidak Olahraga'];
    $probabilitasPriorOlahraga = $result['probabilitasPrior']['Olahraga'];
    $probabilitasPriorLanjut = $result['probabilitasPrior']['Lanjut'];
    $probabilitasPriorIstirahat = $result['probabilitasPrior']['Istirahat'];
    $probabilitasPriorCukup = $result['probabilitasPrior']['Cukup'];

    // Akses data probabilitasDJSebelumO
    $probabilitasDJSebelumOTidakOlahraga = $result['probabilitasDJSebelumO']['Tidak Olahraga'];
    $probabilitasDJSebelumOOlahraga = $result['probabilitasDJSebelumO']['Olahraga'];
    $probabilitasDJSebelumOLanjut = $result['probabilitasDJSebelumO']['Lanjut'];
    $probabilitasDJSebelumOIstirahat = $result['probabilitasDJSebelumO']['Istirahat'];
    $probabilitasDJSebelumOCukup = $result['probabilitasDJSebelumO']['Cukup'];

    // Akses data probabilitasSTSebelumO
    $probabilitasSTSebelumOTidakOlahraga = $result['probabilitasSTSebelumO']['Tidak Olahraga'];
    $probabilitasSTSebelumOOlahraga = $result['probabilitasSTSebelumO']['Olahraga'];
    $probabilitasSTSebelumOLanjut = $result['probabilitasSTSebelumO']['Lanjut'];
    $probabilitasSTSebelumOIstirahat = $result['probabilitasSTSebelumO']['Istirahat'];
    $probabilitasSTSebelumOCukup = $result['probabilitasSTSebelumO']['Cukup'];

    // Akses data probabilitasUsia
    $probabilitasUsiaTidakOlahraga = $result['probabilitasUsia']['Tidak Olahraga'];
    $probabilitasUsiaOlahraga = $result['probabilitasUsia']['Olahraga'];
    $probabilitasUsiaLanjut = $result['probabilitasUsia']['Lanjut'];
    $probabilitasUsiaIstirahat = $result['probabilitasUsia']['Istirahat'];
    $probabilitasUsiaCukup = $result['probabilitasUsia']['Cukup'];

    // Akses data probabilitasIntensitas
    $probabilitasIntensitasTidakOlahraga = $result['probabilitasIntensitas']['Tidak Olahraga'];
    $probabilitasIntensitasOlahraga = $result['probabilitasIntensitas']['Olahraga'];
    $probabilitasIntensitasLanjut = $result['probabilitasIntensitas']['Lanjut'];
    $probabilitasIntensitasIstirahat = $result['probabilitasIntensitas']['Istirahat'];
    $probabilitasIntensitasCukup = $result['probabilitasIntensitas']['Cukup'];

    // Akses data probabilitasDJSebelumO
    $probabilitasDJSetelahOTidakOlahraga = $result['probabilitasDJSetelahO']['Tidak Olahraga'];
    $probabilitasDJSetelahOOlahraga = $result['probabilitasDJSetelahO']['Olahraga'];
    $probabilitasDJSetelahOLanjut = $result['probabilitasDJSetelahO']['Lanjut'];
    $probabilitasDJSetelahOIstirahat = $result['probabilitasDJSetelahO']['Istirahat'];
    $probabilitasDJSetelahOCukup = $result['probabilitasDJSetelahO']['Cukup'];

    // Akses data probabilitasSTSetelahO
    $probabilitasSTSetelahOTidakOlahraga = $result['probabilitasSTSetelahO']['Tidak Olahraga'];
    $probabilitasSTSetelahOOlahraga = $result['probabilitasSTSetelahO']['Olahraga'];
    $probabilitasSTSetelahOLanjut = $result['probabilitasSTSetelahO']['Lanjut'];
    $probabilitasSTSetelahOIstirahat = $result['probabilitasSTSetelahO']['Istirahat'];
    $probabilitasSTSetelahOCukup = $result['probabilitasSTSetelahO']['Cukup'];

    // Akses data probabilitasPosterior
    $probabilitasPosteriorTidakOlahraga = $result['probabilitasPosterior']['Tidak Olahraga'];
    $probabilitasPosteriorOlahraga = $result['probabilitasPosterior']['Olahraga'];
    $probabilitasPosteriorLanjut = $result['probabilitasPosterior']['Lanjut'];
    $probabilitasPosteriorIstirahat = $result['probabilitasPosterior']['Istirahat'];
    $probabilitasPosteriorCukup = $result['probabilitasPosterior']['Cukup'];

    // Akses kelas tertinggi
    $kelasTertinggi = $result['kelasTertinggi'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PROSES PERHITUNGAN</title>
    <link rel="stylesheet" href="css/table.css">
</head>
<body>
<div class="container">

  <h1>PROSES PERHITUNGAN</h1>

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

  <h1>Data yang Anda Masukan Masuk pasa Kelas <u><?php echo  $kelasTertinggi ?></u></h1>

    <h2>Probabilitas Prior</h2>
    <table>
      <tr>
        <th>Kelas</th>
        <th>Probabilitas Prior</th>
      </tr>
      <tr>
        <td>Tidak Olahraga</td>
        <td><?php echo $probabilitasPriorTidakOlahraga; ?></td>
      </tr>
      <tr>
        <td>Olahraga</td>
        <td><?php echo $probabilitasPriorOlahraga; ?></td>
      </tr>
      <tr>
        <td>Lanjut</td>
        <td><?php echo $probabilitasPriorLanjut; ?></td>
      </tr>
      <tr>
        <td>Istirahat</td>
        <td><?php echo $probabilitasPriorIstirahat; ?></td>
      </tr>
      <tr>
        <td>Cukup</td>
        <td><?php echo $probabilitasPriorCukup; ?></td>
      </tr>
    </table>

    <h2>Probabilitas Likelihood</h2>
    <table>
      <tr>
          <th>Kelas</th>
          <th>DT Sebelum Olahraga</th>
          <th>ST Sebelum Olahraga</th>
          <th>Usia</th>
          <th>Intensitas</th>
          <th>DT Setelah Olahraga</th>
          <th>ST Setelah Olahraga</th>
      </tr>
      <tr>
          <td>Tidak Olahraga</td>
          <td><?php echo $probabilitasDJSebelumOTidakOlahraga; ?> </td>
          <td><?php echo $probabilitasSTSebelumOTidakOlahraga; ?> </td>
          <td><?php echo $probabilitasUsiaTidakOlahraga; ?> </td>
          <td><?php echo $probabilitasIntensitasTidakOlahraga; ?> </td>
          <td><?php echo $probabilitasDJSetelahOTidakOlahraga; ?> </td>
          <td><?php echo $probabilitasSTSetelahOTidakOlahraga; ?> </td>
      </tr>
      <tr>
          <td>Olahraga</td>
          <td><?php echo $probabilitasDJSebelumOOlahraga; ?> </td>
          <td><?php echo $probabilitasSTSebelumOOlahraga; ?> </td>
          <td><?php echo $probabilitasUsiaOlahraga; ?> </td>
          <td><?php echo $probabilitasIntensitasOlahraga; ?> </td>
          <td><?php echo $probabilitasDJSetelahOOlahraga; ?> </td>
          <td><?php echo $probabilitasSTSetelahOOlahraga; ?> </td>
      </tr>
      <tr>
          <td>Lanjut</td>
          <td><?php echo $probabilitasDJSebelumOLanjut; ?> </td>
          <td><?php echo $probabilitasSTSebelumOLanjut; ?> </td>
          <td><?php echo $probabilitasUsiaLanjut; ?> </td>
          <td><?php echo $probabilitasIntensitasLanjut; ?> </td>
          <td><?php echo $probabilitasDJSetelahOLanjut; ?> </td>
          <td><?php echo $probabilitasSTSetelahOLanjut; ?> </td>
      </tr>
      <tr>
          <td>Istirahat</td>
          <td><?php echo $probabilitasDJSebelumOIstirahat; ?> </td>
          <td><?php echo $probabilitasSTSebelumOIstirahat; ?> </td>
          <td><?php echo $probabilitasUsiaIstirahat; ?> </td>
          <td><?php echo $probabilitasIntensitasIstirahat; ?> </td>
          <td><?php echo $probabilitasDJSetelahOIstirahat; ?> </td>
          <td><?php echo $probabilitasSTSetelahOIstirahat; ?> </td>
      </tr>
      <tr>
          <td>Cukup</td>
          <td><?php echo $probabilitasDJSebelumOCukup; ?> </td>
          <td><?php echo $probabilitasSTSebelumOCukup; ?> </td>
          <td><?php echo $probabilitasUsiaCukup; ?> </td>
          <td><?php echo $probabilitasIntensitasCukup; ?> </td>
          <td><?php echo $probabilitasDJSetelahOCukup; ?> </td>
          <td><?php echo $probabilitasSTSetelahOCukup; ?> </td>
      </tr>
    </table>
    <h2>Probabilitas Posterior</h2>
    <table>
      <tr>
        <th>Kelas</th>
        <th>Probabilitas Posterior</th>
      </tr>
      <tr>
        <td>Tidak Olahraga</td>
        <td><?php echo $probabilitasPosteriorTidakOlahraga; ?></td>
      </tr>
      <tr>
        <td>Olahraga</td>
        <td><?php echo $probabilitasPosteriorOlahraga; ?></td>
      </tr>
      <tr>
        <td>Lanjut</td>
        <td><?php echo $probabilitasPosteriorLanjut; ?></td>
      </tr>
      <tr>
        <td>Istirahat</td>
        <td><?php echo $probabilitasPosteriorIstirahat; ?></td>
      </tr>
      <tr>
        <td>Cukup</td>
        <td><?php echo $probabilitasPosteriorCukup; ?></td>
      </tr>
    </table>
</div>
</body>
</html>
