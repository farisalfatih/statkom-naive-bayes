<?php
require 'functions.php';

if (isset($_POST["submit"])) {

    if (tambah($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TAMBAH DATA</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <div class="container">
        <h1>TAMBAH DATA</h1>

        <!-- Form untuk menambahkan data -->
        <form action="" method="post">
            <ul>
                <li>
                    <label for="DJSebelumO">DJ SebelumO : </label>
                    <select name="DJSebelumO" required>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="59">59</option>
                        <option value="60">60</option>
                        <option value="80">80</option>
                        <option value="100">100</option>
                        <option value="101">101</option>
                        <option value="110">110</option>
                        <option value="120">120</option>
                    </select>
                </li>
                <li>
                    <label for="STSebelumO">ST SebelumO : </label>
                    <select name="STSebelumO" required>
                    <option value="31">31</option>
                        <option value="33">33</option>
                        <option value="35">35</option>
                        <option value="35.5">35.5</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38">38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                        <option value="42">42</option>
                    </select>
                </li>
                <li>
                    <label for="Usia">Usia : </label>
                    <select name="Usia" required>
                    <option value="39">39</option>
                        <option value="18">18</option>
                        <option value="41">41</option>
                        <option value="65">65</option>
                    </select>
                </li>
                <li>
                    <label for="Intensitas">Intensitas : </label>
                    <select name="Intensitas" required>
                        <option value="50">50</option>
                        <option value="55">55</option>
                        <option value="60">60</option>
                        <option value="65">65</option>
                        <option value="70">70</option>
                        <option value="75">75</option>
                        <option value="80">80</option>
                        <option value="85">85</option>
                        <option value="90">90</option>
                        <option value="95">95</option>
                        <option value="100">100</option>
                    </select>
                </li>
                <li>
                    <label for="DJSetelahO">DJ SetelahO : </label>
                    <select name="DJSetelahO" required>
                    <option value="50">50</option>
                        <option value="0">0</option>
                        <option value="60">60</option>
                        <option value="84">84</option>
                        <option value="88">88</option>
                        <option value="93">93</option>
                        <option value="98">98</option>
                        <option value="103">103</option>
                        <option value="108">108</option>
                        <option value="117">117</option>
                        <option value="127">127</option>
                        <option value="135">135</option>
                        <option value="136">136</option>
                        <option value="144">144</option>
                        <option value="146">146</option>
                        <option value="154">154</option>
                        <option value="161">161</option>
                        <option value="164">164</option>
                        <option value="171">171</option>
                        <option value="174">174</option>
                        <option value="182">182</option>
                        <option value="202">202</option>
                    </select>
                </li>
                <li>
                    <label for="STSetelahO">ST SetelahO : </label>
                    <select name="STSetelahO" required>
                    <option value="0">0</option>
                        <option value="0">0</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                        <option value="42">42</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38">38</option>
                    </select>
                </li>
                <li>
                    <label for="Kelas">Kelas : </label>
                    <select name="Kelas" required>
                        <option value="TidakOlahraga">Tidak Olahraga</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Istirahat">Istirahat</option>
                        <option value="Lanjut">Lanjut</option>
                        <option value="Cukup">Cukup</option>
                    </select>
                </li>
                <li>
                    <button type="submit" name="submit">Tambah Data!</button>
                </li>
            </ul>
        </form>
    </div>
</body>
</html>
