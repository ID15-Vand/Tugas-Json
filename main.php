<?php
require_once "catur.php";
$ctr = new catur();
$table = "persentase_catur";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERSENTASE KEMENANGAN OPENING CATUR</title>
</head>
<body>
    <h1>Tabel Persentase Kemenangan</h1>
    <table border = "1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Notasi</th>
            <th>Persentase Kemenangan</th>
        </tr>
        <?php
        $no = 1;
        $datas = $ctr->show($table);
        foreach($datas as $data){
            echo "<tr>";
            echo "<td>" .$no++ . "</td>";
            echo "<td>" .$data['Nama'] . "</td>";
            echo "<td>" .$data['Notasi']. "</td>";
            echo "<td>" .$data['Persentase']. "%</td>";
            echo "</tr>";
        }
            ?>
    </table>
</body>
</html>
