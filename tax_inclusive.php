<!DOCTYPE html>
<html>
<head>
    <title>Tax Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Tax Calculator</h1>
    <form method="POST">
        <div class="form-group">
            <label for="amount">Enter the amount:</label>
            <input type="text" class="form-control" id="amount" name="amount">
        </div>
        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    if (is_numeric($amount)) {
        include 'tax_include.php';
        $result = calculateTaxes($amount);
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
            <td>NHIL</td>
            <td><?php echo $result["nhil"]; ?></td>
        </tr>
        <tr>
            <td>GETFL</td>
            <td><?php echo $result["getfl"]; ?></td>
        </tr>
        <tr>
            <td>CHRL</td>
            <td><?php echo $result["chrl"]; ?></td>
        </tr>
        <tr>
            <td>VAT-able Amount</td>
            <td><?php echo $result["vatable_amt"]; ?></td>
        </tr>
        <tr>
            <td>VAT</td>
            <td><?php echo $result["vat"]; ?></td>
        </tr>
        <tr>
            <td>Withholding Goods</td>
            <td><?php echo $result["withholding_goods"]; ?></td>
        </tr>
        <tr>
            <td>Withholding Services</td>
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
</body>
</html>