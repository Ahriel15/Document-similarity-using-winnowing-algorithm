<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Pendeteksi Plagiarisme Dokumen PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .col-md-9 {
            display: flex;
            flex-direction: column;
             min-height: 100vh;
        }

        .header {
            background-color: #262625;
            color: #fff;
            padding: 20px;
        }

        .title {
            margin-bottom: 30px;
        }

        .sidebar {
            background-color: #f8f9fa;
            color: #ffffff
            padding: 20px;
        }

        .content {
            background-color: #fff;
            padding: 20px;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header class="header text-center">
        <h1 class="title">Aplikasi Pendeteksi Plagiarisme Dokumen PDF</h1>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 bg p-4">
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
                <li class="nav-item">
                    <a class="nav-link" href="untitled-1.php">Pengecekan Kemiripan Dokumen PDF</a>
                </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="content">
                    <h2>Apa Itu Plagiarisme?</h2>
                    <p>
                            Plagiarisme merupakan mengambil atau menjiplak ide atau karya orang lain tanpa mencantumkan nama pemilik karya atau tanpa seizin pemiliknya. Secara istilah, plagiarisme dapat disebut sebagai mencuri.
                    </p>
                    <p>
                            Dalam Undang-Undang Hak Cipta, pengertian plagiarisme dijelaskan dalam beberapa istilah seperti mengumumkan, mempublikasikan, atau menjual hasil karya orang lain tanpa seizin pemilik karya tersebut. Karya yang dimaksud tergolong dalam hak kekayaan intelektual yang dapat berupa karya seni, sastra, dan ilmu pengetahuan.
                    </p>
                    <p>
                            Makanya perbuatan itu tergolong sebagai tindakan yang tidak etis dan dapat berujung pada sanksi pidana plagiarisme. Misalnya jika seorang lulusan perguruan tinggi terbukti melakukan plagiarisme terhadap skripsinya, sanksinya dapat berupa pencabutan gelar hingga ancaman pidana penjara. Sanksi ini sudah diatur dalam Pasal 12 ayat 1 huruf g Permendiknas 17/2010.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer text-center">
        &copy; <?php echo date("Y"); ?> Aplikasi Pendeteksi Plagiarisme
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
