<?php
session_start(); // Tetap memulai session, meskipun belum digunakan

// --- Pengaturan ---
$key = 3;
$modulus = 256; // Kita menggunakan 256 untuk semua karakter ASCII

// --- Inisialisasi Variabel ---
$plaintext = '';
$ciphertext = '';

// --- Logika Proses ---

// 1. Cek jika tombol 'Enkripsi' ditekan
if (isset($_POST['enkripsi'])) {
    $plaintext = $_POST['plaintext'];
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $kode = ord($plaintext[$i]); // Ambil kode ASCII
        $b = ($kode + $key) % $modulus; // Rumus Enkripsi: (ASCII + 3) % 256
        $ciphertext .= chr($b); // Ubah kembali ke karakter
    }
}

// 2. Cek jika tombol 'Dekripsi' ditekan
if (isset($_POST['dekripsi'])) {
    $ciphertext = $_POST['ciphertext'];
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $kode = ord($ciphertext[$i]); // Ambil kode ASCII
        // Rumus Dekripsi: (ASCII - 3 + 256) % 256
        // Kita tambah 256 untuk menghindari hasil negatif dari modulo
        $b = ($kode - $key + $modulus) % $modulus; 
        $plaintext .= chr($b); // Ubah kembali ke karakter
    }
}

// 3. Menjaga perilaku script asli (jika ada parameter GET 'kata')
// Ini akan dieksekusi hanya jika tidak ada form yang disubmit
else if (isset($_GET['kata']) && !isset($_POST['enkripsi']) && !isset($_POST['dekripsi'])) {
    $plaintext = $_GET['kata'];
    for ($i = 0; $i < strlen($plaintext); $i++) {
        $kode = ord($plaintext[$i]);
        $b = ($kode + $key) % $modulus;
        $ciphertext .= chr($b);
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kriptografi Caesar Shift +3</title>
    <style>
        body { font-family: arial; color: #333; background-color: #f4f4f4; }
        center { margin-top: 30px; }
        p { font-size: 1.2em; font-weight: bold; }
        table {
            border: 1px solid #aaa;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        td { padding: 12px; }
        textarea {
            width: 350px;
            height: 80px;
            padding: 8px;
            font-family: monospace;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            color: white;
            margin: 5px;
        }
        input[name="enkripsi"] { background-color: #28a745; /* Hijau */ }
        input[name="dekripsi"] { background-color: #dc3545; /* Merah */ }
        a { text-decoration: none; color: #007bff; margin-top: 15px; display: inline-block; }
    </style>
</head>
<body>

    <center>
        <p>ALAT ENKRIPSI & DEKRIPSI (Caesar Cipher +3)</p>

        <form method="POST" action="">
            <table border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <td>DEKSRIPSI (PLAINTEXT)</td>
                    <td width="5" align="center">:</td>
                    <td><textarea name="plaintext" placeholder="Ketik plaintext di sini..."><?php echo htmlspecialchars($plaintext); ?></textarea></td>
                </tr>
                <tr>
                    <td>HASIL ENKRIPSI (CIPHERTEXT)</td>
                    <td align="center">:</td>
                    <td><textarea name="ciphertext" placeholder="Ketik ciphertext di sini..."><?php echo htmlspecialchars($ciphertext); ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <input type="submit" name="enkripsi" value="Enkripsi (Plaintext -> Ciphertext)">
                        <input type="submit" name="dekripsi" value="Dekripsi (Ciphertext -> Plaintext)">
                    </td>
                </tr>
            </table>
        </form>
        <br>
        <a href='index.php'> Kembali </a>
    </center>

</body>
</html>