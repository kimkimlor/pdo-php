<?php
require 'connection.php';

// Menangani pengalihan jika tombol "Cancel" ditekan
if (isset($_POST["cancel"])) {
  // Pengalihan langsung ke index.php
  echo "
    <script>
      let konfirmasi = confirm('yakin ingin keluar ?');
      if (konfirmasi) {
        window.location.href='index.php';
      }
    </script>
  ";
  header("Location: index.php");
  exit();
}

try {
  if (isset($_POST["submit"])) {
    // Pastikan mengambil nilai yang benar untuk username dan email
    $name = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);

    $pdo = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Menyiapkan query untuk menyimpan data ke database
    $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
    $stmt = $pdo->prepare($sql);

    // Eksekusi query
    $stmt->execute([
      ":name" => $name,
      ":email" => $email
    ]);
    echo "
          <script>window.location.href = 'index.php';</script>
        ";
  }
} catch (PDOException $e) {
  echo "Koneksi gagal: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create a New User</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <form action="" method="POST">
    <label for="username">Username</label><br />
    <input type="text" name="username" id="username"><br />

    <label for="email">Email</label><br />
    <input type="email" name="email" id="email"><br />

    <button type="submit" name="submit">Kirim</button>
    <!-- Tombol Cancel dengan type="button" agar tidak submit form -->
    <button type="button" name="cancel">Cancel</button>
  </form>
</body>

</html>