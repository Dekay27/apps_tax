<!DOCTYPE html>
<html>
<head>
    <title>Inclusive Tax Calculator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
        <img src="images/tax.png" width="30" height="30" alt="">
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    Calculators
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="tax_inclusive.php">Inclusive Tax</a>
                    <a class="dropdown-item" href="tax_exclusive.php">Exclusive Tax</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled">Disabled</a>
            </li>
        </ul>
    </div>
</nav>


<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <h2 class="text-center">Tax Calculator - Inclusive</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="value">Enter a value:</label>
                    <input type="number" class="form-control" id="value" name="value" required>
                </div>
                <button type="submit" name="save" class="btn btn-primary">Calculate</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $value = $_POST['value'];
                include 'tax_include.php';
                $taxComponents = calculateTaxes($value);

                echo '<h4 class="mt-4">Tax Components for ' . $value . ':</h4>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>Tax Component</th><th>Amount</th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td>Principal</td><td>' . $taxComponents['principal'] . '</td></tr>';
                echo '<tr><td>NHIL 2.5%</td><td>' . $taxComponents['nhil'] . '</td></tr>';
                echo '<tr><td>GETFL 2.5%</td><td>' . $taxComponents['getfl'] . '</td></tr>';
                echo '<tr><td>CHRL 1%</td><td>' . $taxComponents['chrl'] . '</td></tr>';
                echo '<tr><td>VAT-able Amount</td><td>' . $taxComponents['vatable_amt'] . '</td></tr>';
                echo '<tr><td>Value Added Tax</td><td>' . $taxComponents['vat'] . '</td></tr>';
                echo '<tr><td>Withholding Tax (Goods)</td><td>' . $taxComponents['withholding_goods'] . '</td></tr>';
                echo '<tr><td>Withholding Tax (Services)</td><td>' . $taxComponents['withholding_services'] . '</td></tr>';
                echo '</tbody><tfoot><tr><th>Total Tax</th><th>' . $taxComponents['total_tax'] . '</th></tr></tfoot></table>';

                echo '<button type="submit" name="save" class="btn btn-primary mt-3">Save</button>';


                if (isset($_POST['save'])) {
                    try {
                        $db = new PDO('sqlite:tax_data.sqlite');
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $db->prepare('INSERT INTO tax_components_inclusive (value, principal, nhil, getfl, chrl, vatable_amt, vat, total_tax, withholding_goods, withholding_services) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                        $stmt->bindValue(1, $value, SQLITE3_FLOAT);
                        $stmt->bindValue(2, $taxComponents['principal'], SQLITE3_FLOAT);
                        $stmt->bindValue(3, $taxComponents['nhil'], SQLITE3_FLOAT);
                        $stmt->bindValue(4, $taxComponents['getfl'], SQLITE3_FLOAT);
                        $stmt->bindValue(5, $taxComponents['chrl'], SQLITE3_FLOAT);
                        $stmt->bindValue(6, $taxComponents['vatable_amt'], SQLITE3_FLOAT);
                        $stmt->bindValue(7, $taxComponents['vat'], SQLITE3_FLOAT);
                        $stmt->bindValue(8, $taxComponents['total_tax'], SQLITE3_FLOAT);
                        $stmt->bindValue(9, $taxComponents['withholding_goods'], SQLITE3_FLOAT);
                        $stmt->bindValue(10, $taxComponents['withholding_services'], SQLITE3_FLOAT);
                        $stmt->execute();
                        echo '<p class="mt-3 text-success">Tax components saved successfully!</p>';
                    } catch (PDOException $e) {
                        echo '<p class="mt-3 text-danger">Error: ' . $e->getMessage() . '</p>';
                    }
                }
            }


            ?>
        </div>
    </div>
</div>

</body>
</html>
