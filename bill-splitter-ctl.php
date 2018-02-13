<?php

$total_charged = 0;
$tips_rate = 0;
$total = 0;
$tips = 0;

$number_people = 1;
$charged_per_person = 0;
$tips_per_person = 0;
$total_per_person = 0;

$round_up = false;
$round_up_checked = '';

$selected_0 = '';
$selected_10 = '';
$selected_15 = '';
$selected_18 = '';
$selected_20 = '';

$error_msg = [];

// Assign Vars
if (isset($_POST['submit']) && isset($_POST['submit']) == 'Calculate') {
    foreach ($_POST as $key => $value) {
        // Total Charged
        if ($key == "total_charged") {
            if (is_numeric($value)) {
                $total_charged = floatval($value);
            }
        }
        // Tips Rate
        if ($key == "tips_rate") {
            if (is_numeric($value)) {
                $tips_rate = floatval($value) / 100;
            }
        }
        // Number of People
        if ($key == "number_people") {
            if (is_numeric($value)) {
                $number_people = intval($value);
            }
        }
    }

    // Round Up
    if (isset($_POST['round_up'])) {
        $round_up_checked = 'checked';
        $round_up = true;
    } else {
        $round_up_checked = '';
        $round_up = false;
    }

    // Validation
    if ($total_charged < 0) {
        $error_msg[] = 'Bill Total must be an positive integer.';
    }

    if ($tips_rate == 0) {
        $error_msg[] = 'Please rate your satisfaction.';
    }

    if ($number_people <= 0) {
        $error_msg[] = 'Number of People be an positive integer.';
    }
}

// Config Display
switch ($tips_rate) {
    case 0.1:
        $selected_10 = 'selected';
        break;
    case 0.15:
        $selected_15 = 'selected';
        break;
    case 0.18:
        $selected_18 = 'selected';
        break;
    case 0.2:
        $selected_20 = 'selected';
        break;
    default:
        $selected_0 = 'selected';
        break;
}

if (sizeof($error_msg) == 0) {
    // Calculate
    $tips = $total_charged * $tips_rate;
    $tips_per_person = $tips / $number_people;
    $total = $total_charged + $tips;
    $charged_per_person = $total_charged / $number_people;
    $total_per_person = $total / $number_people;
    // Format Numbers
    $total_charged = number_format($total_charged, 2, '.', '');
    $tips = number_format($tips, 2, '.', '');
    $tips_per_person = number_format($tips_per_person, 2, '.', '');
    $total = number_format($total, 2, '.', '');
    $charged_per_person = number_format($charged_per_person, 2, '.', '');
    $total_per_person = number_format($total_per_person, 2, '.', '');

    if ($round_up) {
        $total_per_person = round($total_per_person);
    }
}
