<?php
// Database connection details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'db_judul';

// Create a database connection
$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input1 = $_POST['input1']; // Assuming the input from the form is submitted via POST

    // Prepare a SELECT query to fetch titles and additional data from the database
    $query = "SELECT title, nama, nim, tahun FROM data_judul";

    // Execute the query and fetch the titles and additional data
    $result = mysqli_query($connection, $query);
    if ($result) {
        // Create an array to store the matching titles, additional data, and similarity percentage
        $matches = array();

        // Loop through each fetched row
        while ($row = mysqli_fetch_assoc($result)) {
            $title2 = $row['title'];
            $nama = $row['nama'];
            $nim = $row['nim'];
            $tahun = $row['tahun'];
            $similarity = calculateTitleSimilarity($input1, $title2);

            if ($similarity >= 80) {
                // Add the matching title, additional data, and similarity to the matches array
                $matches[] = array('title' => $title2, 'nama' => $nama, 'nim' => $nim, 'tahun' => $tahun, 'similarity' => $similarity);
            }
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        echo "Error executing the query: " . mysqli_error($connection);
    }
}

// If there are no matches and the input is not empty, display the form to add the title


// Handle form submission to add the title to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama']) && isset($_POST['nim']) && isset($_POST['tahun'])) {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $tahun = $_POST['tahun'];

    // Prepare an INSERT query to add the title, name, nim, andyear to the database
    $insertQuery = "INSERT INTO data_judul (title, nama, nim, tahun) VALUES ('$input1', '$nama', '$nim', '$tahun')";
    $insertResult = mysqli_query($connection, $insertQuery);
    if ($insertResult) {
        echo "Title, name, nim, and year added to the database.";
    } else {
        echo "Error adding data to the database: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);

// Function to calculate the similarity using the Levenshtein distance (as shown in the previous code example)
function calculateTitleSimilarity($title1, $title2) {
    $distance = levenshtein($title1, $title2);
    $max_length = max(strlen($title1), strlen($title2));
    $similarity_percentage = (($max_length - $distance) / $max_length) * 100;

    return $similarity_percentage;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengecekan Kemiripan Judul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .col-md-9 {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      color: dark;
    }

    .header {
      background-color: #262625;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    .sidebar {
      background-color: #363636;
      color: white;
      padding: 20px;
    }

    .nav-link {
      color: white;
    }

    .content {
      padding: 20px;
    }

    .footer {
  background-color: #343a40;
  color: #fff;
  padding: 20px;
  margin-top: auto;
  text-align: center;
}

  </style>
</head>
<body>
    <header class="header text-white text-center py-4">
        <h1>Pengecekan Kemiripan Judul</h1>
    </header>
    <div class="container fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
            <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Beranda</a>
            </li>
        </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Pengecekan Judul</a>
                    </li>
                </ul>
                <li class="nav flex-column">
                    <a class="nav-link" href="untitled-1.php">Pengecekan Kemiripan Dokumen PDF</a>
                </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="p-4">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="input1">Tulis judul yang ingin di cek:</label>
                            <input type="text" class="form-control" name="input1" id="input1" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Cek">
                        </div>
                    </form>

                    <?php if (isset($matches)) : ?>
                        <?php if (!empty($matches)) : ?>
                            <h2>Judul yang mirip dengan judul yang diinput adalah:</h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Tahun</th>
                                        <th>Kemiripan(%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($matches as $match) : ?>
                                        <tr>
                                            <td><?php echo $match['title']; ?></td>
                                            <td><?php echo $match['nama']; ?></td>
                                            <td><?php echo $match['nim']; ?></td>
                                            <td><?php echo $match['tahun']; ?></td>
                                            <td><?php echo $match['similarity']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else : ?>
                                <h2>Tidak ada judul yang memiliki kemiripan dengan apa yang ada didatabase, tambahkan judul ini?</h2>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                         <form method="POST" action="">
                                            <form id='addTitleForm' method='POST' action='' style='display: none;'>
                                            <input type='hidden' name='input1' value='<?php echo $input1; ?>'>
                                            <div class='form-group'>
                                            <label for='nama'>Nama:</label>
                                            <input type='text' class='form-control' name='nama' id='nama' required>
                                        </div>
                                        <div class='form-group'>
                                        <label for='nim'>NIM:</label>
                                        <input type='text' class='form-control' name='nim' id='nim' required>
                                      </div>
                                      <div class='form-group'>
                                    <label for='tahun'>Tahun:</label>
                                    <input type='text' class='form-control' name='tahun' id='tahun' required>
                                         </div>
                                    <div class='form-group'>
                                    <input type='submit' class='btn btn-primary' value='Tambahkan'>
                                    </div>
                                 </form>
                            </form>
                        </div>
                     </div>

    <script>
        function showForm() {
            var form = document.getElementById('addTitleForm');
            form.style.display = 'block';
        }
    </script>
<?php endif; ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-dark text-white text-center py-4 mt-4">
        &copy; <?php echo date("Y"); ?> Aplikasi Pendeteksi Plagiarisme
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function showForm() {
            document.getElementById("addTitleForm").style.display = "block";
        }
    </script>
</body>
</html>
