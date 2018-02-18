<?php
require "Form.php";

use DWA\Form;

// Default Values
$charged  = 0;
$tipsRate = 0;
$tips     = 0;
$total    = 0;

$numberPeople     = 1;
$tipsRateFloat    = 0;
$chargedPerPerson = 0;
$tipsPerPerson    = 0;
$totalPerPerson   = 0;

$roundUp        = false;
$roundUpChecked = false;

// Define Field Title
$fieldTitles = array(
    'charged'      => 'Total Charged',
    'numberPeople' => 'Number of People',
    'tipsRate'     => 'Satisfaction',
);

// Build Form
$formUtil = new Form($_POST);

$errors = $formUtil->validate(
    [
        'charged'      => 'required|numeric',
        'numberPeople' => 'required|numeric',
        'tipsRate'     => 'required|numeric|min:0|max:100',
    ], $fieldTitles
);

// Assign Values
$charged      = $formUtil->sanitize($formUtil->get('charged'));
$tipsRate     = $formUtil->sanitize($formUtil->get('tipsRate'));
$numberPeople = $formUtil->sanitize($formUtil->get('numberPeople'));

if ($formUtil->has('roundUp')) {
    $roundUp = $formUtil->get('roundUp');
    if ($roundUp == 'yes') {
        $roundUpChecked = true;
    }
}

// Calculate
if ($formUtil->isSubmitted() && !$formUtil->hasErrors) {

    $tipsRateFloat    = floatval($tipsRate) / 100;
    $tips             = $charged * $tipsRateFloat;
    $tipsPerPerson    = $tips / $numberPeople;
    $total            = $charged + $tips;
    $chargedPerPerson = $charged / $numberPeople;
    $totalPerPerson   = $total / $numberPeople;

    // Format Numbers
    $charged          = number_format($charged, 2, '.', '');
    $tips             = number_format($tips, 2, '.', '');
    $tipsPerPerson    = number_format($tipsPerPerson, 2, '.', '');
    $total            = number_format($total, 2, '.', '');
    $chargedPerPerson = number_format($chargedPerPerson, 2, '.', '');
    $totalPerPerson   = number_format($totalPerPerson, 2, '.', '');

    if ($roundUpChecked) {
        $totalPerPerson = round($totalPerPerson);
    }
}
