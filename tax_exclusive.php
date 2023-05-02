<!DOCTYPE html>
<html>
<head>
	<title>Tax Calculator</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-6 mx-auto mt-5">
			<h2 class="text-center">Tax Calculator</h2>
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
				$taxComponents = calculateTaxComponents($value);
				echo '<h4 class="mt-4">Tax Components for ' . $value . ':</h4>';
				echo '<table class="table table-striped">';
				echo '<thead><tr><th>Tax Component</th><th>Amount</th></tr></thead>';
				echo '<tbody>';
				echo '<tr><td>NHIL 2.5%</td><td>' . $taxComponents['tax2Point5Percent'] . '</td></tr>';
				echo '<tr><td>GETFL 2.5% (2)</td><td>' . $taxComponents['tax2Point5Percent2'] . '</td></tr>';
                echo '<tr><td>CHRL 1%</td><td>' . $taxComponents['tax1Percent'] . '</td></tr>';
				echo '<tr><td>Value Added Tax</td><td>' . $taxComponents['valueAddedTax'] . '</td></tr>';
				echo '<tr><td>Withholding Tax</td><td>' . $taxComponents['withholdingTax'] . '</td></tr>';
                echo '<tr><td>Total Tax</td><td>' . $taxComponents['totalTax'] . '</td></tr>';
                echo '<tr><td>Total Invoice</td><td>' . $taxComponents['totalInvoice'] . '</td></tr>';
				echo '</tbody></table>';
			}

			function calculateTaxComponents($value) {
                $tax1Percent = $value * 0.01;
                $tax2Point5Percent = $value * 0.025;
                $tax2Point5Percent2 = $value * 0.025;
                $valueAddedTax = ($value + $tax1Percent + $tax2Point5Percent + $tax2Point5Percent2) * 0.15;
                $withholdingTax = $value * 0.075;
                $totalTax = $tax1Percent + $tax2Point5Percent + $tax2Point5Percent2 + $valueAddedTax;
                $totalInvoice = $value + $totalTax;

                return [
                    'tax1Percent' => $tax1Percent,
                    'tax2Point5Percent' => $tax2Point5Percent,
                    'tax2Point5Percent2' => $tax2Point5Percent2,
                    'valueAddedTax' => $valueAddedTax,
                    'withholdingTax' => $withholdingTax,
                    'totalTax' => $totalTax,
                    'totalInvoice' => $totalInvoice
                ];
            }

			?>
		</div>
	</div>
</div>

</body>
</html>
