<?php
require "bill-splitter-ctl.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="Bill Splitter PHP App">
    <meta name="author" content="Chutian Gao">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Bill Splitter</title>
    <!-- Bootstrap -->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' type='text/css'>
</head>
<body>
<div class="container">
    <h2 class="text-center">Bill Splitter</h2>
    <div class="row">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-3 col-xs-12 col-sm-8 col-md-8 col-lg-6">
            <?php foreach ($error_msg as $msg): ?>
                <div class="alert alert-danger">
                    <?= $msg ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <form action="" method="POST">
        <div class="row">
            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-3 col-xs-12 col-sm-8 col-md-8 col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                    <input type="number"
                           name="total_charged"
                           class="form-control"
                           placeholder="Total"
                           value="<?= $total_charged ?>"
                           step="0.01">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="number"
                           name="number_people"
                           class="form-control"
                           placeholder="Numer of People"
                           value="<?= $number_people ?>">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-scale"></i></span>
                    <select name="tips_rate" class="form-control" value="<?= $tips_rate ?>">
                        <option value="0" <?= $selected_0 ?> >Satisfaction</option>
                        <option value="15" <?= $selected_15 ?> >Normal Lunch - 15%</option>
                        <option value="18" <?= $selected_18 ?> >Normal Dinner - 18%</option>
                        <option value="20" <?= $selected_20 ?> >Amazing - 20%</option>
                        <option value="10" <?= $selected_10 ?> >Not Satisfied - 10%</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <p class="text-center">
                <br><label class="checkbox-inline"><input type="checkbox"
                                                          name="round_up"
                                                          value="yes" <?= $round_up_checked ?> >Round Up</label>
                <br><br><input type="submit" class="btn btn-primary" name="submit" value="Calculate">
            </p>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-3 col-xs-12 col-sm-8 col-md-8 col-lg-6">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="well">
                        <p>
                        <h4>All Together</h4>
                        <label>Charged:</label> $<?= $total_charged ?><br>
                        <label>Tips:</label> $<?= $tips ?><br>
                        <label>Total:</label> $<?= $total ?>
                        </p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="well">
                        <p>
                        <h4>Per Person</h4>
                        <label>Charged:</label> $<?= $charged_per_person ?><br>
                        <label>Tips:</label> $<?= $tips_per_person ?><br>
                        <label>Owns:</label> $<u><?= $total_per_person ?></u>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /.container -->
</body>
</html>