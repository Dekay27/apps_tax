<!DOCTYPE html>
<html>
<head>
    <title>Calculate Square and Cube</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Calculate Square and Cube</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="number">Enter a Number:</label>
                            <input type="text" class="form-control" id="number" name="number" required>
                        </div>
                        <button type="submit" name="save" class="btn btn-primary mt-3">Calculate</button>
                    </form>
<?php
    if (isset($_POST['save'])) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $number = $_POST['number'];
                $square = $number * $number;
                $cube = $number * $number * $number;
                $current_month = date('F');
                $data = array($number, $square, $cube, $current_month);
                $db = new SQLite3('calc.db');
                $stmt = $db->prepare('INSERT INTO calc (number, square, cube, month) VALUES (?, ?, ?, ?)');
                $stmt->bindParam(1, $number);
                $stmt->bindParam(2, $square);
                $stmt->bindParam(3, $cube);
                $stmt->bindParam(4, $current_month);
                $stmt->execute();
                echo '<div class="mt-4">';
                echo '<h5>Results:</h5>';
                echo '<ul>';
                echo '<li>Number: ' . $number . '</li>';
                echo '<li>Square of number: ' . $square . '</li>';
                echo '<li>Cube  of number: ' . $cube . '</li>';
                echo '<li>Current date: ' . $current_month . '</li>';
            }
        } catch (PDOException $e) {
            echo '<p class="mt-3 text-danger">Error: ' . $e->getMessage() . '</p>';
        }
    }

?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


