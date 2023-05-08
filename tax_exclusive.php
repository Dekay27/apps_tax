<!DOCTYPE html>
<html>
<head>
    <title>Exclusive Tax Calculator</title>
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
            <h2 class="text-center">Tax Calculator - Exclusive</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="value">Enter a value:</label>
                    <input type="number" class="form-control" id="value" name="value" required>
                </div>
                <button type="submit" class="btn btn-primary">Calculate</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $value = $_POST['value'];
                include 'tax_include.php';
                $taxComponents = calculateTaxComponents($value);
                echo '<h4 class="mt-4">Tax Components for ' . $value . ':</h4>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>Tax Component</th><th>Amount</th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td>NHIL 2.5%</td><td>' . $taxComponents['tax2Point5Percent'] . '</td></tr>';
                echo '<tr><td>GETFL 2.5%</td><td>' . $taxComponents['tax2Point5Percent2'] . '</td></tr>';
                echo '<tr><td>CHRL 1%</td><td>' . $taxComponents['tax1Percent'] . '</td></tr>';
                echo '<tr><td>Value Added Tax</td><td>' . $taxComponents['valueAddedTax'] . '</td></tr>';
                echo '<tr><td>Withholding Tax (Goods)</td><td>' . $taxComponents['withholdingTaxGoods'] . '</td></tr>';
                echo '<tr><td>Withholding Tax (Services)</td><td>' . $taxComponents['withholdingTaxServices'] . '</td></tr>';
                echo '<tr><td>Total Tax</td><td>' . $taxComponents['totalTax'] . '</td></tr>';
                echo '<tr><td>Total Invoice</td><td>' . $taxComponents['totalInvoice'] . '</td></tr>';
                echo '</tbody><tfoot><tr><th>Total Tax</th><th>' . $taxComponents['totalTax'] . '</th></tr></tfoot></table>';

                echo '<button type="submit" name="save" class="btn btn-primary mt-3">Save</button>';

                if (isset($_POST['save'])) {
                    try {

                        $db = new PDO('sqlite:tax_data.sqlite');
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $db->prepare('INSERT INTO tax_components_exclusive (value, principal, nhil, getfl, chrl, vatable_amt, vat, total_tax, withholdingTaxGoods, withholdingTaxServices, totalInvoice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                        $stmt->bindValue(1, $value, SQLITE3_FLOAT);
                        $stmt->bindValue(2, $taxComponents['totalInvoice'], SQLITE3_FLOAT);
                        $stmt->bindValue(3, $taxComponents['nhil'], SQLITE3_FLOAT);
                        $stmt->bindValue(4, $taxComponents['getfl'], SQLITE3_FLOAT);
                        $stmt->bindValue(5, $taxComponents['chrl'], SQLITE3_FLOAT);
                        $stmt->bindValue(6, $taxComponents['vatableAmt'], SQLITE3_FLOAT);
                        $stmt->bindValue(7, $taxComponents['vat'], SQLITE3_FLOAT);
                        $stmt->bindValue(8, $taxComponents['totalTax'], SQLITE3_FLOAT);
                        $stmt->bindValue(9, $taxComponents['withholdingGoods'], SQLITE3_FLOAT);
                        $stmt->bindValue(10, $taxComponents['withholdingServices'], SQLITE3_FLOAT);
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
