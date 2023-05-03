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
        'principal' => $principal,
        'nhil' => $nhil,
        'getfl' => $getfl,
        'chrl' => $chrl,
        'vatable_amt' => $vatable_amt,
        'vat' => $vat,
        'total_tax' => $total_tax,
        'withholding_goods' => $withholding_goods,
        'withholding_services' => $withholding_services,
    );
}

//php -S localhost:8000
?>
