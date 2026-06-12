<!--2572024 - Audrick Estrello-->
<?php 
include_once "connect.php";
    $firstname = FILTER_INPUT(INPUT_POST, 'usagi');
    $city = FILTER_INPUT(INPUT_POST, 'city');
    $komen = FILTER_INPUT(INPUT_POST, 'komen');
    $sub = FILTER_INPUT(INPUT_POST, 'btnsub');
    if ($sub){
        try {
            $sql = "INSERT INTO buku_tamu (nama, asal, komentar) VALUES (:fname, :asal, :komen)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
            'fname' => $firstname,
            'asal' => $city,
            'komen' => $komen
            ]);
            //$msg = "New record created successfully";
        } catch(PDOException $e) {
            $msg = $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
        header("location:Tugas3_2572024.php?msg=".$msg);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BukuTamu-2572024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" /> 
</head>
<body>
    <div class="container card">
        <h2 class="text-center">Buku Tamu</h2>
        <form action="Tugas3_2572024.php" method="POST">
            <p>Nama</p>
            <input type="text" name="usagi" placeholder="Nama lengkap kamu">
            <p>Asal kota</p>
            <input type="text" name="city" placeholder="Contoh: Bandung">
            <p>Komentar</p>
            <textarea class="w-100" cols="50" name="komen" placeholder="Tulis komentar atau kesanmu..."></textarea>
            <br>
            <input class="btn btn-primary" type="submit" name="btnsub" value="Kirim Komentar">
        </form>

    </div>
    <br>
    <div class="container">
        <h2>Komentar Tamu <?php 
            $sql = "SELECT * FROM buku_tamu";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            echo "(".$stmt->rowCount()." Komentar)";
            ?></h2>
        <?php 
        try {
            $sql = "SELECT * FROM buku_tamu ORDER BY waktu DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                  
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='card mb-4 p-3'>"; 
                    echo "<div class='d-flex flex-row justify-content-between'>";
                    echo "<h3>". $row['nama'] ."</h3>";
                    echo "<p class='text-secondary'>".$row['asal']." | ".$row['waktu']."</p>";
                    echo "</div>";
                    echo "<p>". $row['komentar'] ."</p>";
                    echo "</div>";
                }
                unset($result);
            } else {
                echo "No records found.";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>