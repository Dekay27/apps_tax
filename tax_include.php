<?php
// Missing required 'lang' attribute
// Missed locally stored library for HTTP link
function calculateTaxes($value) {
    $principal = $value / 1.219;
    $nhil = 0.025 * $principal;
    $getfl = 0.025 * $principal;
    $chrl = 0.01 * $principal;
    $vatable_amt = $principal + $nhil + $getfl + $chrl;
    $vat = 0.15 * $vatable_amt;
    $total_tax = $nhil + $getfl + $chrl + $vat;
    $withholding_goods = 0.05 * $principal;
    $withholding_services = 0.075 * $principal;
    return array(
        'principal' => round($principal, 2),
        'nhil' => round($nhil, 2),
        'getfl' => round($getfl, 2),
        'chrl' => round($chrl, 2),
        'vatable_amt' => round($vatable_amt, 2),
        'vat' => round($vat, 2),
        'total_tax' => round($total_tax, 2),
        'withholding_goods' => round($withholding_goods, 2),
        'withholding_services' => round($withholding_services, 2),
    );
}

function calculateTaxComponents($value): array
{
    $tax1Percent = $value * 0.01;
    $tax2Point5Percent = $value * 0.025;
    $tax2Point5Percent2 = $value * 0.025;
    $valueAddedTax = ($value + $tax1Percent + $tax2Point5Percent + $tax2Point5Percent2) * 0.15;
    $withholdingTaxGoods = $value * 0.05;
    $withholdingTaxServices = $value * 0.075;
    $totalTax = $tax1Percent + $tax2Point5Percent + $tax2Point5Percent2 + $valueAddedTax;
    $totalInvoice = $value + $totalTax;

    return [
        'tax1Percent' => $tax1Percent,
        'tax2Point5Percent' => $tax2Point5Percent,
        'tax2Point5Percent2' => $tax2Point5Percent2,
        'valueAddedTax' => $valueAddedTax,
        'withholdingTaxGoods' => $withholdingTaxGoods,
        'withholdingTaxServices' => $withholdingTaxServices,
        'totalTax' => $totalTax,
        'totalInvoice' => $totalInvoice
    ];
}

function insertData($data) {
    $db = new SQLite3('data.db');

    foreach ($data as $row) {
        $col1 = $db->escapeString($row['col1']);
        $col2 = $db->escapeString($row['col2']);
        $col3 = $db->escapeString($row['col3']);
        $query = "INSERT INTO my_table (col1, col2, col3) VALUES ('$col1', '$col2', '$col3')";
        $db->exec($query);
    }

    $db->close();
}

function saveToDatabase($dataArray) {
    $db = new SQLite3('tax_data.db');
    foreach ($dataArray as $row) {
        $principal = $row['principal'];
        $nhil = $row['nhil'];
        $getfl = $row['getfl'];
        $chrl = $row['chrl'];
        $vatable_amt = $row['vatable_amt'];
        $vat = $row['vat'];
        $total_tax = $row['total_tax'];
        $withholding_goods = $row['withholding_goods'];
        $withholding_services = $row['withholding_services'];

        $db->query("INSERT INTO tax_inclusive (principal, nhil, getfl, chrl, vatable_amt, vat, total_tax, withholding_goods, withholding_services) 
                    VALUES ('$principal', '$nhil', '$getfl', '$chrl', '$vatable_amt', '$vat', '$total_tax', '$withholding_goods', '$withholding_services')");
    }
}


//php -S localhost:8000
?>
