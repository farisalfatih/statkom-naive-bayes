<?php

$conn = mysqli_connect("localhost", "root", "", "statkom");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $rows = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data)
{
    global $conn;
    $DJSebelumO = htmlspecialchars($data["DJSebelumO"]);
    $STSebelumO = htmlspecialchars($data["STSebelumO"]);
    $Usia = htmlspecialchars($data["Usia"]);
    $Intensitas = htmlspecialchars($data["Intensitas"]);
    $DJSetelahO = htmlspecialchars($data["DJSetelahO"]);
    $STSetelahO = htmlspecialchars($data["STSetelahO"]);
    $Kelas = htmlspecialchars($data["Kelas"]);

    $query = "INSERT INTO data_training (DJSebelumO, STSebelumO, Usia, Intensitas, DJSetelahO, STSetelahO, Kelas)
                VALUES ('$DJSebelumO', '$STSebelumO', '$Usia', '$Intensitas', '$DJSetelahO', '$STSetelahO', '$Kelas')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM data_training WHERE id = $id");

    return mysqli_affected_rows($conn);
}


function cari($keyword)
{
    $query = "SELECT * FROM data_training 
                    WHERE
                    DJSebelumO LIKE '%$keyword%' OR
                    STSebelumO LIKE '%$keyword%' OR
                    Usia LIKE '%$keyword%' OR
                    Intensitas LIKE '%$keyword%' OR
                    DJSetelahO LIKE '%$keyword%' OR
                    STSetelahO LIKE '%$keyword%' OR
                    Kelas LIKE '%$keyword%'
    ";
    return query($query);
}

function probabilitas($DJSebelumO, $STSebelumO, $Usia, $Intensitas, $DJSetelahO, $STSetelahO)
{
    $alpha = 1;
    // Mengambil niali unik dari masung-masing kolom
    $uniqueDJSebelumO = query("SELECT DISTINCT DJSebelumO FROM data_training");
    $uniqueSTSebelumO = query("SELECT DISTINCT STSebelumO FROM data_training");
    $uniqueUsia = query("SELECT DISTINCT Usia FROM data_training");
    $uniqueIntensitas = query("SELECT DISTINCT Intensitas FROM data_training");
    $uniqueDJSetelahO = query("SELECT DISTINCT DJSetelahO FROM data_training");
    $uniqueSTSetelahO = query("SELECT DISTINCT STSetelahO FROM data_training");
 
    
    // Mendapatkan jumlah data latihan untuk setiap kelas
    $KelasTidakOlahraga = count(query("SELECT * FROM data_training WHERE Kelas = 'Tidak Olahraga'"));
    $KelasOlahraga = count(query("SELECT * FROM data_training WHERE Kelas = 'Olahraga'"));
    $KelasLanjut = count(query("SELECT * FROM data_training WHERE Kelas = 'Lanjut'"));
    $KelasIstirahat = count(query("SELECT * FROM data_training WHERE Kelas = 'Istirahat'"));
    $KelasCukup = count(query("SELECT * FROM data_training WHERE Kelas = 'Cukup'"));

    $totalData = count(query("SELECT * FROM data_training"));
    
    // Menghitung probabilitas prior untuk setiap kelas
    $probabilitasTidakOlahraga = $KelasTidakOlahraga / $totalData;
    $probabilitasOlahraga = $KelasOlahraga / $totalData;
    $probabilitasLanjut = $KelasLanjut / $totalData;
    $probabilitasIstirahat = $KelasIstirahat / $totalData;
    $probabilitasCukup = $KelasCukup / $totalData;

    // Mendapatkan jumlah data latihan untuk setiap atribut dan nilai
    $DJSebelumOTidakOlahraga = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Tidak Olahraga'"));
    $STSebelumOTidakOlahraga = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Tidak Olahraga'"));
    $UsiaTidakOlahraga = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Tidak Olahraga'"));
    $IntensitasTidakOlahraga = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Tidak Olahraga'"));
    $DJSetelahOTidakOlahraga = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Tidak Olahraga'"));
    $STSetelahOTidakOlahraga = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Tidak Olahraga'"));
    
    $DJSebelumOOlahraga = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Olahraga'"));
    $STSebelumOOlahraga = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Olahraga'"));
    $UsiaOlahraga = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Olahraga'"));
    $IntensitasOlahraga = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Olahraga'"));
    $DJSetelahOOlahraga = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Olahraga'"));
    $STSetelahOOlahraga = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Olahraga'"));

    $DJSebelumOLanjut = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Lanjut'"));
    $STSebelumOLanjut = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Lanjut'"));
    $UsiaLanjut = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Lanjut'"));
    $IntensitasLanjut = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Lanjut'"));
    $DJSetelahOLanjut = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Lanjut'"));
    $STSetelahOLanjut = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Lanjut'"));

    $DJSebelumOIstirahat = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Istirahat'"));
    $STSebelumOIstirahat = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Istirahat'"));
    $UsiaIstirahat = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Istirahat'"));
    $IntensitasIstirahat = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Istirahat'"));
    $DJSetelahOIstirahat = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Istirahat'"));
    $STSetelahOIstirahat = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Istirahat'"));

    $DJSebelumOCukup = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Cukup'"));
    $STSebelumOCukup = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Cukup'"));
    $UsiaCukup = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Cukup'"));
    $IntensitasCukup = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Cukup'"));
    $DJSetelahOCukup = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Cukup'"));
    $STSetelahOCukup = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Cukup'"));
    
    // Menghitung probabilitas likelihood untuk setiap atribut dan nilai dengan Laplacian correction
    $probabilitasDJSebelumOTidakOlahraga = ($DJSebelumOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOTidakOlahraga = ($STSebelumOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueSTSebelumO));
    $probabilitasUsiaTidakOlahraga = ($UsiaTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueUsia));
    $probabilitasIntensitasTidakOlahraga = ($IntensitasTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueIntensitas));
    $probabilitasDJSetelahOTidakOlahraga = ($DJSetelahOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueDJSetelahO));
    $probabilitasSTSetelahOTidakOlahraga = ($STSetelahOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueSTSetelahO));

    $probabilitasDJSebelumOOlahraga = ($DJSebelumOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOOlahraga = ($STSebelumOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaOlahraga = ($UsiaOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasOlahraga = ($IntensitasOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOOlahraga = ($DJSetelahOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOOlahraga = ($STSetelahOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));

    $probabilitasDJSebelumOLanjut = ($DJSebelumOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOLanjut = ($STSebelumOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaLanjut = ($UsiaLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasLanjut = ($IntensitasLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOLanjut = ($DJSetelahOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOLanjut = ($STSetelahOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));

    $probabilitasDJSebelumOIstirahat = ($DJSebelumOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOIstirahat = ($STSebelumOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaIstirahat = ($UsiaIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasIstirahat = ($IntensitasIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOIstirahat = ($DJSetelahOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOIstirahat = ($STSetelahOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));

    $probabilitasDJSebelumOCukup = ($DJSebelumOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOCukup = ($STSebelumOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaCukup = ($UsiaCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasCukup = ($IntensitasCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOCukup = ($DJSetelahOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOCukup = ($STSetelahOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));

    // Menghitung probabilitas posterior untuk setiap kelas
    $probabilitasPosteriorTidakOlahraga = $probabilitasTidakOlahraga * $probabilitasDJSebelumOTidakOlahraga * $probabilitasSTSebelumOTidakOlahraga * $probabilitasUsiaTidakOlahraga * $probabilitasIntensitasTidakOlahraga * $probabilitasDJSetelahOTidakOlahraga * $probabilitasSTSetelahOTidakOlahraga;

    $probabilitasPosteriorOlahraga = $probabilitasOlahraga * $probabilitasDJSebelumOOlahraga * $probabilitasSTSebelumOOlahraga * $probabilitasUsiaOlahraga * $probabilitasIntensitasOlahraga * $probabilitasDJSetelahOOlahraga * $probabilitasSTSetelahOOlahraga;

    $probabilitasPosteriorLanjut = $probabilitasLanjut * $probabilitasDJSebelumOLanjut * $probabilitasSTSebelumOLanjut * $probabilitasUsiaLanjut * $probabilitasIntensitasLanjut * $probabilitasDJSetelahOLanjut * $probabilitasSTSetelahOLanjut;

    $probabilitasPosteriorIstirahat = $probabilitasIstirahat * $probabilitasDJSebelumOIstirahat * $probabilitasSTSebelumOIstirahat * $probabilitasUsiaIstirahat * $probabilitasIntensitasIstirahat * $probabilitasDJSetelahOIstirahat * $probabilitasSTSetelahOIstirahat;

    $probabilitasPosteriorCukup = $probabilitasCukup * $probabilitasDJSebelumOCukup * $probabilitasSTSebelumOCukup * $probabilitasUsiaCukup * $probabilitasIntensitasCukup * $probabilitasDJSetelahOCukup * $probabilitasSTSetelahOCukup;


    // Klasifikasi berdasarkan probabilitas posterior tertinggi
    $probabilitasPosterior = [
        'Tidak Olahraga' => $probabilitasPosteriorTidakOlahraga,
        'Olahraga' => $probabilitasPosteriorOlahraga,
        'Lanjut' => $probabilitasPosteriorLanjut,
        'Istirahat' => $probabilitasPosteriorIstirahat,
        'Cukup' => $probabilitasPosteriorCukup,
    ];

    $kelasTertinggi = array_keys($probabilitasPosterior, max($probabilitasPosterior))[0];
    // Menyusun hasil perhitungan probabilitas ke dalam array
    $result = [
        'probabilitasPrior' => [
            'Tidak Olahraga' => $probabilitasTidakOlahraga,
            'Olahraga' => $probabilitasOlahraga,
            'Lanjut' => $probabilitasLanjut,
            'Istirahat' => $probabilitasIstirahat,
            'Cukup' => $probabilitasCukup,
        ],
        'probabilitasDJSebelumO' => [
            'Tidak Olahraga' => $probabilitasDJSebelumOTidakOlahraga,
            'Olahraga' => $probabilitasDJSebelumOOlahraga,
            'Lanjut' => $probabilitasDJSebelumOLanjut,
            'Istirahat' => $probabilitasDJSebelumOIstirahat,
            'Cukup' => $probabilitasDJSebelumOCukup,
        ],
        'probabilitasSTSebelumO' => [
            'Tidak Olahraga' => $probabilitasSTSebelumOTidakOlahraga,
            'Olahraga' => $probabilitasSTSebelumOOlahraga,
            'Lanjut' => $probabilitasSTSebelumOLanjut,
            'Istirahat' => $probabilitasSTSebelumOIstirahat,
            'Cukup' => $probabilitasSTSebelumOCukup,
        ],
        'probabilitasUsia' => [
            'Tidak Olahraga' => $probabilitasUsiaTidakOlahraga,
            'Olahraga' => $probabilitasUsiaOlahraga,
            'Lanjut' => $probabilitasUsiaLanjut,
            'Istirahat' => $probabilitasUsiaIstirahat,
            'Cukup' => $probabilitasUsiaCukup,
        ],
        'probabilitasIntensitas' => [
            'Tidak Olahraga' => $probabilitasIntensitasTidakOlahraga,
            'Olahraga' => $probabilitasIntensitasOlahraga,
            'Lanjut' => $probabilitasIntensitasLanjut,
            'Istirahat' => $probabilitasIntensitasIstirahat,
            'Cukup' => $probabilitasIntensitasCukup,
        ],
        'probabilitasDJSetelahO' => [
            'Tidak Olahraga' => $probabilitasDJSetelahOTidakOlahraga,
            'Olahraga' => $probabilitasDJSetelahOOlahraga,
            'Lanjut' => $probabilitasDJSetelahOLanjut,
            'Istirahat' => $probabilitasDJSetelahOIstirahat,
            'Cukup' => $probabilitasDJSetelahOCukup,
        ],
        'probabilitasSTSetelahO' => [
            'Tidak Olahraga' => $probabilitasSTSetelahOTidakOlahraga,
            'Olahraga' => $probabilitasSTSetelahOOlahraga,
            'Lanjut' => $probabilitasSTSetelahOLanjut,
            'Istirahat' => $probabilitasSTSetelahOIstirahat,
            'Cukup' => $probabilitasSTSetelahOCukup,
        ],
        'probabilitasPosterior' => [
            'Tidak Olahraga' => $probabilitasPosteriorTidakOlahraga,
            'Olahraga' => $probabilitasPosteriorOlahraga,
            'Lanjut' => $probabilitasPosteriorLanjut,
            'Istirahat' => $probabilitasPosteriorIstirahat,
            'Cukup' => $probabilitasPosteriorCukup,
        ],
        'kelasTertinggi' => $kelasTertinggi,
    ];

    return $result;
}

function probabilitasTes($DJSebelumO, $STSebelumO, $Usia, $Intensitas, $DJSetelahO, $STSetelahO)
{
    $alpha = 1;
    // Mengambil niali unik dari masung-masing kolom
    $uniqueDJSebelumO = query("SELECT DISTINCT DJSebelumO FROM data_training");
    $uniqueSTSebelumO = query("SELECT DISTINCT STSebelumO FROM data_training");
    $uniqueUsia = query("SELECT DISTINCT Usia FROM data_training");
    $uniqueIntensitas = query("SELECT DISTINCT Intensitas FROM data_training");
    $uniqueDJSetelahO = query("SELECT DISTINCT DJSetelahO FROM data_training");
    $uniqueSTSetelahO = query("SELECT DISTINCT STSetelahO FROM data_training");

    // Menghitung jumlah nilai unik
    $countUniqueDJSebelumO = count($uniqueDJSebelumO);
    $countUniqueSTSebelumO = count($uniqueSTSebelumO);
    $countUniqueUsia = count($uniqueUsia);
    $countUniqueIntensitas = count($uniqueIntensitas);
    $countUniqueDJSetelahO = count($uniqueDJSetelahO);
    $countUniqueSTSetelahO = count($uniqueSTSetelahO);

    // Mendapatkan total jumlah data latihan untuk setiap kelas
    $totalData = count(query("SELECT * FROM data_training"));
    
    // Mendapatkan jumlah data latihan untuk setiap kelas
    $KelasTidakOlahraga = count(query("SELECT * FROM data_training WHERE Kelas = 'Tidak Olahraga'"));
    $KelasOlahraga = count(query("SELECT * FROM data_training WHERE Kelas = 'Olahraga'"));
    $KelasLanjut = count(query("SELECT * FROM data_training WHERE Kelas = 'Lanjut'"));
    $KelasIstirahat = count(query("SELECT * FROM data_training WHERE Kelas = 'Istirahat'"));
    $KelasCukup = count(query("SELECT * FROM data_training WHERE Kelas = 'Cukup'"));
    
    // Menghitung probabilitas prior untuk setiap kelas
    $probabilitasTidakOlahraga = $KelasTidakOlahraga / $totalData;
    $probabilitasOlahraga = $KelasOlahraga / $totalData;
    $probabilitasLanjut = $KelasLanjut / $totalData;
    $probabilitasIstirahat = $KelasIstirahat / $totalData;
    $probabilitasCukup = $KelasCukup / $totalData;

    // Mendapatkan jumlah data latihan untuk setiap atribut dan nilai
    $DJSebelumOTidakOlahraga = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Tidak Olahraga'"));
    $STSebelumOTidakOlahraga = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Tidak Olahraga'"));
    $UsiaTidakOlahraga = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Tidak Olahraga'"));
    $IntensitasTidakOlahraga = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Tidak Olahraga'"));
    $DJSetelahOTidakOlahraga = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Tidak Olahraga'"));
    $STSetelahOTidakOlahraga = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Tidak Olahraga'"));
    
    $DJSebelumOOlahraga = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Olahraga'"));
    $STSebelumOOlahraga = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Olahraga'"));
    $UsiaOlahraga = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Olahraga'"));
    $IntensitasOlahraga = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Olahraga'"));
    $DJSetelahOOlahraga = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Olahraga'"));
    $STSetelahOOlahraga = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Olahraga'"));

    $DJSebelumOLanjut = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Lanjut'"));
    $STSebelumOLanjut = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Lanjut'"));
    $UsiaLanjut = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Lanjut'"));
    $IntensitasLanjut = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Lanjut'"));
    $DJSetelahOLanjut = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Lanjut'"));
    $STSetelahOLanjut = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Lanjut'"));

    $DJSebelumOIstirahat = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Istirahat'"));
    $STSebelumOIstirahat = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Istirahat'"));
    $UsiaIstirahat = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Istirahat'"));
    $IntensitasIstirahat = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Istirahat'"));
    $DJSetelahOIstirahat = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Istirahat'"));
    $STSetelahOIstirahat = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Istirahat'"));

    $DJSebelumOCukup = count(query("SELECT * FROM data_training WHERE DJSebelumO = '$DJSebelumO' AND Kelas = 'Cukup'"));
    $STSebelumOCukup = count(query("SELECT * FROM data_training WHERE STSebelumO = '$STSebelumO' AND Kelas = 'Cukup'"));
    $UsiaCukup = count(query("SELECT * FROM data_training WHERE Usia = '$Usia' AND Kelas = 'Cukup'"));
    $IntensitasCukup = count(query("SELECT * FROM data_training WHERE Intensitas = '$Intensitas' AND Kelas = 'Cukup'"));
    $DJSetelahOCukup = count(query("SELECT * FROM data_training WHERE DJSetelahO = '$DJSetelahO' AND Kelas = 'Cukup'"));
    $STSetelahOCukup = count(query("SELECT * FROM data_training WHERE STSetelahO = '$STSetelahO' AND Kelas = 'Cukup'"));
    
    // Menghitung probabilitas likelihood untuk setiap atribut dan nilai dengan Laplacian correction
    $probabilitasDJSebelumOTidakOlahraga = ($DJSebelumOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOTidakOlahraga = ($STSebelumOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueSTSebelumO));
    $probabilitasUsiaTidakOlahraga = ($UsiaTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueUsia));
    $probabilitasIntensitasTidakOlahraga = ($IntensitasTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueIntensitas));
    $probabilitasDJSetelahOTidakOlahraga = ($DJSetelahOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueDJSetelahO));
    $probabilitasSTSetelahOTidakOlahraga = ($STSetelahOTidakOlahraga + $alpha) / ($KelasTidakOlahraga + $alpha * count($uniqueSTSetelahO));

    $probabilitasDJSebelumOOlahraga = ($DJSebelumOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOOlahraga = ($STSebelumOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaOlahraga = ($UsiaOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasOlahraga = ($IntensitasOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOOlahraga = ($DJSetelahOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOOlahraga = ($STSetelahOOlahraga + $alpha) / ($KelasOlahraga+ $alpha * count($uniqueDJSebelumO));

    $probabilitasDJSebelumOLanjut = ($DJSebelumOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOLanjut = ($STSebelumOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaLanjut = ($UsiaLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasLanjut = ($IntensitasLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOLanjut = ($DJSetelahOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOLanjut = ($STSetelahOLanjut + $alpha) / ($KelasLanjut+ $alpha * count($uniqueDJSebelumO));

    $probabilitasDJSebelumOIstirahat = ($DJSebelumOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOIstirahat = ($STSebelumOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaIstirahat = ($UsiaIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasIstirahat = ($IntensitasIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOIstirahat = ($DJSetelahOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOIstirahat = ($STSetelahOIstirahat + $alpha) / ($KelasIstirahat+ $alpha * count($uniqueDJSebelumO));

    $probabilitasDJSebelumOCukup = ($DJSebelumOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSebelumOCukup = ($STSebelumOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasUsiaCukup = ($UsiaCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasIntensitasCukup = ($IntensitasCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasDJSetelahOCukup = ($DJSetelahOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));
    $probabilitasSTSetelahOCukup = ($STSetelahOCukup + $alpha) / ($KelasCukup+ $alpha * count($uniqueDJSebelumO));

    // Menghitung probabilitas posterior untuk setiap kelas
    $probabilitasPosteriorTidakOlahraga = $probabilitasTidakOlahraga * $probabilitasDJSebelumOTidakOlahraga * $probabilitasSTSebelumOTidakOlahraga * $probabilitasUsiaTidakOlahraga * $probabilitasIntensitasTidakOlahraga * $probabilitasDJSetelahOTidakOlahraga * $probabilitasSTSetelahOTidakOlahraga;

    $probabilitasPosteriorOlahraga = $probabilitasOlahraga * $probabilitasDJSebelumOOlahraga * $probabilitasSTSebelumOOlahraga * $probabilitasUsiaOlahraga * $probabilitasIntensitasOlahraga * $probabilitasDJSetelahOOlahraga * $probabilitasSTSetelahOOlahraga;

    $probabilitasPosteriorLanjut = $probabilitasLanjut * $probabilitasDJSebelumOLanjut * $probabilitasSTSebelumOLanjut * $probabilitasUsiaLanjut * $probabilitasIntensitasLanjut * $probabilitasDJSetelahOLanjut * $probabilitasSTSetelahOLanjut;

    $probabilitasPosteriorIstirahat = $probabilitasIstirahat * $probabilitasDJSebelumOIstirahat * $probabilitasSTSebelumOIstirahat * $probabilitasUsiaIstirahat * $probabilitasIntensitasIstirahat * $probabilitasDJSetelahOIstirahat * $probabilitasSTSetelahOIstirahat;

    $probabilitasPosteriorCukup = $probabilitasCukup * $probabilitasDJSebelumOCukup * $probabilitasSTSebelumOCukup * $probabilitasUsiaCukup * $probabilitasIntensitasCukup * $probabilitasDJSetelahOCukup * $probabilitasSTSetelahOCukup;


    // Klasifikasi berdasarkan probabilitas posterior tertinggi
    $probabilitasPosterior = [
        'Tidak Olahraga' => $probabilitasPosteriorTidakOlahraga,
        'Olahraga' => $probabilitasPosteriorOlahraga,
        'Lanjut' => $probabilitasPosteriorLanjut,
        'Istirahat' => $probabilitasPosteriorIstirahat,
        'Cukup' => $probabilitasPosteriorCukup,
    ];

    $kelasTertinggi = array_keys($probabilitasPosterior, max($probabilitasPosterior))[0];
    return $kelasTertinggi;
}
?>