<?php
require "Form.php";

use DWA\Form;

$charged   = 0;
$tips_rate = 0;
$tips      = 0;
$total     = 0;

$number_people      = 1;
$tips_rate_float    = 0;
$charged_per_person = 0;
$tips_per_person    = 0;
$total_per_person   = 0;

$round_up         = false;
$round_up_checked = false;

// Define Field Title
$field_titles = array (
    'charged'       => 'Total Charged',
    'number_people' => 'Number of People',
    'tips_rate'     => 'Satisfaction'
);


$formUtil = new Form($_POST);

$errors = $formUtil->validate(
    [
        'charged'       => 'required|numeric',
        'number_people' => 'required|numeric',
        'tips_rate'     => 'required|numeric|min:0|max:100',
    ], $field_titles
);


// Assign Values
$charged       = $formUtil->sanitize($formUtil->get('charged'));
$tips_rate     = $formUtil->sanitize($formUtil->get('tips_rate'));
$number_people = $formUtil->sanitize($formUtil->get('number_people'));

if ($formUtil->has('round_up')) {
    $round_up = $formUtil->get('round_up');
    if ($round_up == 'yes') {
        $round_up_checked = true;
    }
}

// Calculate
if ($formUtil->isSubmitted() && !$formUtil->hasErrors) {

    $tips_rate_float    = floatval($tips_rate) / 100;
    $tips               = $charged * $tips_rate_float;
    $tips_per_person    = $tips / $number_people;
    $total              = $charged + $tips;
    $charged_per_person = $charged / $number_people;
    $total_per_person   = $total / $number_people;

    // Format Numbers
    $charged            = number_format($charged, 2, '.', '');
    $tips               = number_format($tips, 2, '.', '');
    $tips_per_person    = number_format($tips_per_person, 2, '.', '');
    $total              = number_format($total, 2, '.', '');
    $charged_per_person = number_format($charged_per_person, 2, '.', '');
    $total_per_person   = number_format($total_per_person, 2, '.', '');

    if ($round_up_checked) {
        $total_per_person = round($total_per_person);
    }
}
