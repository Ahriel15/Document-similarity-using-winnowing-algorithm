<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $target_dir = "uploads/";
  $target_file1 = $target_dir . basename($_FILES["file1"]["name"]);
  $target_file2 = $target_dir . basename($_FILES["file2"]["name"]);
  $fileType1 = strtolower(pathinfo($target_file1, PATHINFO_EXTENSION));
  $fileType2 = strtolower(pathinfo($target_file2, PATHINFO_EXTENSION));

  if (isset($_FILES["file1"]) && isset($_FILES["file2"])) {
    if ($fileType1 == "pdf" && $fileType2 == "pdf") {
      $file1Name = str_replace(" ", "_", $_FILES["file1"]["name"]);
      $file2Name = str_replace(" ", "_", $_FILES["file2"]["name"]);
      $target_file1 = "uploads/" . $file1Name;
      $target_file2 = "uploads/" . $file2Name;
      move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file1);
      move_uploaded_file($_FILES["file2"]["tmp_name"], $target_file2);
      $output1 = shell_exec("pdftotext " . $target_file1 . " -");
      $output2 = shell_exec("pdftotext " . $target_file2 . " -");
    } else {
      $error = "Error: Please upload two PDF files.";
    }
  }
}


$output1 = isset($output1) ? str_replace(array("\r", "\n", "\f"), " ", $output1) : "";
$output2 = isset($output2) ? str_replace(array("\r", "\n", "\f"), " ", $output2) : "";
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
     .header {
      background-color: #262625;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .footer {
      background-color: #343a40;
      color: white;
      padding: 20px;
      margin-top: auto;
      text-align: center;
    }
    .sidebar {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px;
}
  </style>
  <title>Aplikasi Pendeteksi Plagiarisme</title>
</head>
<body>
<header class="header text-white text-center py-4">
  <h1>Pengecek Kemiripan Dokumen PDF</h1>
</header>
<div class="sidebar">
  <div class="row">
    <div class="col-md-3 bg cornered p-4">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="home.php">Beranda</a>
        </li>
      </ul>
      <br>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Pengecekan Judul</a>
        </li>
      </ul>
      <br>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="untitled-1.php">Pengecekan Kemiripan Dokumen PDF</a>
        </li>
      </ul>
    </div>

    <div class="col-md-9">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <label for="file1">Pilih PDF ke-1:</label>
        <input type="file" name="file1" id="file1" class="form-control"><br>
        <label for="file2">Pilih PDF ke-2:</label>
        <input type="file" name="file2" id="file2" class="form-control"><br>
        <input type="submit" value="Convert" class="btn btn-primary">
      </form>

      <?php if (isset($output1) && isset($output2) && isset($_FILES["file1"]) && isset($_FILES["file2"])):
        session_start();
        $_SESSION['file1'] = $file1Name;
        $_SESSION['file2'] = $file2Name;
         ?>
        <form method="post" enctype="multipart/form-data" action="winnowing.php?file1=<?php echo $file1Name; ?>&file2=<?php echo $file2Name; ?>" class="mt-4">
        
          <h2>Hasil Convert:</h2>
          <div class="row">
            <div class="col-md-6">
              <h3><?php echo $_FILES["file1"]["name"]; ?></h3>
              <textarea name="output1" rows="10" cols="50" class="form-control"><?php echo $output1; ?></textarea>
            </div>
            <div class="col-md-6">
              <h3><?php echo $_FILES["file2"]["name"]; ?></h3>
              <textarea name="output2" rows="10" cols="50" class="form-control"><?php echo $output2; ?></textarea>
            </div>
          </div>
          <div class="mt-4">
            <p>Masukkan N Gram : <input type="text" name="n" value="" class="form-control"></p>
            <p>Masukkan Window : <input type="text" name="window" value="" class="form-control"></p>
            <p>Bilangan Prima :
              <select name="prima" class="form-control">
                <option>Pilih Salah Satu</option>
                <?php
                for ($i = 2; $i < 1000; $i++) {
                  $hitung = 0;
                  for ($j = 1; $j <= $i; $j++) {
                    if (($i % $j) == 0) $hitung++;
                  }
                  if ($hitung == 2) {
                    $selected = '';
                    if ($prima == $i) $selected = ' selected';
                    echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
                  }
                }
                ?>
              </select>
            </p>
            <p><input type="submit" value="Proses" class="btn btn-primary"></p>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
<footer class="footer">
  &copy; <?php echo date("Y"); ?> Aplikasi Pendeteksi Plagiarisme
</footer>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
