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
    echo '</tbody><tfoot><tr><th>Total Tax</th><th>' . $taxComponents['totalTax'] . '</th></tr></tfoot></table>';

    // Save button form
    echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">';
    echo '<input type="hidden" name="value" value="' . $value . '">';
    echo '<input type="hidden" name="nhil" value="' . $taxComponents['tax2Point5Percent'] . '">';
    echo '<input type="hidden" name="getfl" value="' . $taxComponents['tax2Point5Percent2'] . '">';
    echo '<input type="hidden" name="totalTax" value="' . $taxComponents['totalTax'] . '">';
    echo '<button type="submit" name="save" class="btn btn-primary mt-3">Save</button>';
    echo '</form>';
}

if (isset($_POST['save'])) {
    try {
        $db = new PDO('sqlite:tax_data.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare('INSERT INTO tax_components (value, principal, nhil, getfl, chrl, vatable_amt, vat, total_tax, withholding_goods, withholding_services) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bindValue(1, $value, SQLITE3_FLOAT);
        $stmt->bindValue(2, $taxComponents['principal'], SQLITE3_FLOAT);
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
?>
