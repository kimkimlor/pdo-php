<form action="" method="GET">
  <input type="text" placeholder="search your name" name="name">
  <a href="create.php">Create a New User</a>
</form>
<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'belajar_pdo';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql: host=$host; dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Ambil parameter `name` dari URL dan sanitasi
  $name = isset($_GET["name"]) ? trim($_GET["name"]) : "";

  if (!empty($name)) {
    // Query berdasarkan `name` jika parameter disediakan
    $sql = "SELECT * FROM users WHERE name LIKE :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ":name" => '%' . $name . '%'
    ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    // Query semua data jika `name` kosong
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Tampilkan hasil query
  if ($results) {
    foreach ($results as $row) {
      echo "ID    : " . $row["id"] . "<br />";
      echo "Name  : " . $row["name"] . "<br />";
      echo "Email : " . $row["email"] . "<br />";
      echo "<hr>";
    }
  } else {
    echo "Data tidak ditemukan.";
  }
} catch (PDOException $e) {
  echo "Koneksi gagal: " . $e->getMessage();
}
?>