<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Calculator</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="number">Enter a number:</label>
            <input type="number" class="form-control" id="number" name="number" required>
        </div>
        <button type="submit" name="save" class="btn btn-primary mt-3">Calculate</button>
    </form>
</div>
</body>
</html>

<?php

if (isset($_POST['save'])) {
    // Connect to the database
    $db = new SQLite3('calc.db');

    // Get the input number from the form
    $input_number = $_POST['number'];

    // Calculate the square and cube
    $square = $input_number * $input_number;
    $cube = $input_number * $input_number * $input_number;

    // Create an array of the results
    $results = array(
        'number' => $input_number,
        'square' => $square,
        'cube' => $cube
    );

    // Insert the results into the database
    $stmt = $db->prepare('INSERT INTO calc (number, square, cube) VALUES (:number, :square, :cube)');
    $stmt->bindValue(':number', $results['number'], SQLITE3_INTEGER);
    $stmt->bindValue(':square', $results['square'], SQLITE3_INTEGER);
    $stmt->bindValue(':cube', $results['cube'], SQLITE3_INTEGER);
    $stmt->execute();

    // Close the database connection
    $db->close();
}

?>
