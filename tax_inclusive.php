<!DOCTYPE html>
<html>
<head>
    <title>Tax Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <h1>Tax Calculator - Inclusive</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="amount">Enter the amount:</label>
                    <input type="text" class="form-control" id="amount" name="amount">
                </div>
                <button type="submit" class="btn btn-primary">Calculate</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include 'tax_include.php';

                $amount = $_POST["amount"];
                // Open SQLite database
                $db = new SQLite3('data.sqlite');

                // Loop through data and insert into database
                $result = calculateTaxes($amount);
                saveToDatabase($result);


                // Close database connection
                $db->close();


                // Display values
                if (is_numeric($amount)) {
                    ?>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Tax Type</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Taxable Supply</td>
                            <td><?php echo $result["principal"]; ?></td>
                        </tr>
                        <tr>
                            <td>NHIL (2.5%)</td>
                            <td><?php echo $result["nhil"]; ?></td>
                        </tr>
                        <tr>
                            <td>GETFL (2.5%)</td>
                            <td><?php echo $result["getfl"]; ?></td>
                        </tr>
                        <tr>
                            <td>CHRL (1%)</td>
                            <td><?php echo $result["chrl"]; ?></td>
                        </tr>
                        <tr>
                            <td>VAT-able Amount</td>
                            <td><?php echo $result["vatable_amt"]; ?></td>
                        </tr>
                        <tr>
                            <td>VAT (15%)</td>
                            <td><?php echo $result["vat"]; ?></td>
                        </tr>
                        <tr>
                            <td>Withholding Goods (5%)</td>
                            <td><?php echo $result["withholding_goods"]; ?></td>
                        </tr>
                        <tr>
                            <td>Withholding Services (7.5%)</td>
                            <td><?php echo $result["withholding_services"]; ?></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total Tax</th>
                            <th><?php echo $result["total_tax"]; ?></th>
                        </tr>
                        </tfoot>
                    </table>
                    <?php
                } else {
                    echo "<p>Please enter a valid number.</p>";
                }
            }
            ?>
        </div>
    </div>

    <?php


    // Open SQLite database
    $db = new SQLite3('data.sqlite');

    // Loop through data and insert into database
    foreach ($data as $row) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $db->query("INSERT INTO users (id, name, email) VALUES ('$id', '$name', '$email')");
    }

    // Close database connection
    $db->close();


    ?>


</div>
</body>
</html>