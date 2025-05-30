<?php
require_once "catur.php";
$ctr = new catur();
$table = "persentase_catur";

// Notifikasi
$message = '';
if (isset($_GET['sukses'])) {
    if ($_GET['sukses'] == 'hapus') {
        $message = "Data berhasil dihapus!";
    } elseif ($_GET['sukses'] == 'edit') {
        $message = "Data berhasil diperbarui!";
    } elseif ($_GET['sukses'] == 'tambah') {
        $message = "Data berhasil ditambahkan!";
    }
} elseif (isset($_GET['gagal'])) {
    $message = "Terjadi kesalahan. Silakan coba lagi.";
}

// Tambah data
if (isset($_POST['tambah'])) {
    $nama = $_POST['Nama'];
    $notasi = $_POST['Notasi'];
    $persen = $_POST['Persentase'];

    $sql = "INSERT INTO $table (Nama, Notasi, Persentase) VALUES ('$nama', '$notasi', '$persen')";
    if ($ctr->db->mysqli->query($sql)) {
        header("Location: main.php?sukses=tambah");
        exit;
    } else {
        header("Location: main.php?gagal=1");
        exit;
    }
}

// Proses edit (dengan URL ?edit=id)
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $ctr->db->mysqli->query("SELECT * FROM $table WHERE id = $id");
    $editData = $result->fetch_assoc();
}

// Update data
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['Nama'];
    $notasi = $_POST['Notasi'];
    $persen = $_POST['Persentase'];

    $sql = "UPDATE $table SET Nama='$nama', Notasi='$notasi', Persentase='$persen' WHERE id=$id";
    if ($ctr->db->mysqli->query($sql)) {
        header("Location: main.php?sukses=edit");
        exit;
    } else {
        header("Location: main.php?gagal=1");
        exit;
    }
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($ctr->db->mysqli->query("DELETE FROM $table WHERE id = $id")) {
        header("Location: main.php?sukses=hapus");
    } else {
        header("Location: main.php?gagal=1");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PERSENTASE KEMENANGAN OPENING CATUR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* --- CSS Tabel dan Formulir --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f8;
            margin: 30px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .message {
            background-color: #d4edda;
            padding: 12px;
            border: 1px solid #c3e6cb;
            color: #155724;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2980b9;
            color: white;
            text-transform: uppercase;
        }
        tr:hover {
            background-color: #f1f9ff;
        }
        form {
            max-width: 500px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
        }
        button:hover {
            background-color: #1f6391;
        }
        .action-buttons a {
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 3px;
            color: white;
        }
        .edit-btn {
            background: #f39c12;
        }
        .delete-btn {
            background: #e74c3c;
        }
    </style>
    <script>
        function confirmDelete(nama, id) {
            if (confirm(`Yakin ingin menghapus opening "${nama}"?`)) {
                window.location.href = `main.php?hapus=${id}`;
            }
        }
    </script>
</head>
<body>

<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<h1>Persentase Kemenangan Opening Catur</h1>

<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
    <input type="text" name="Nama" placeholder="Nama Opening" value="<?= $editData['Nama'] ?? '' ?>" required>
    <input type="text" name="Notasi" placeholder="Notasi" value="<?= $editData['Notasi'] ?? '' ?>" required>
    <input type="number" name="Persentase" placeholder="Persentase Kemenangan" min="0" max="100" value="<?= $editData['Persentase'] ?? '' ?>" required>
    <button type="submit" name="<?= $editData ? 'edit' : 'tambah' ?>">
        <?= $editData ? 'Perbarui Data' : 'Tambah Data' ?>
    </button>
</form>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Notasi</th>
        <th>Persentase</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $datas = $ctr->show($table);
    foreach ($datas as $data):
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $data['Nama'] ?></td>
            <td><?= $data['Notasi'] ?></td>
            <td><?= $data['Persentase'] ?>%</td>
            <td class="action-buttons">
                <a href="main.php?edit=<?= $data['id'] ?>" class="edit-btn">Edit</a>
                <a href="#" class="delete-btn" onclick="confirmDelete('<?= $data['Nama'] ?>', <?= $data['id'] ?>)">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
