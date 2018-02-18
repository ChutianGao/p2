<?php
require "bill-splitter-logic.php";
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
    <!-- Display Errors -->
    <div class="row">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-3 col-xs-12 col-sm-8 col-md-8 col-lg-6">
             <?php if ($formUtil->isSubmitted() && $formUtil->hasErrors): ?>
                 <div class='alert alert-danger'>
                     <ul>
                         <?php foreach ($errors as $error): ?>
                             <li><?= $error ?></li>
                         <?php endforeach;?>
                     </ul>
                 </div>
             <?php endif;?>
        </div>
    </div>

    <!-- Calculator Form -->
    <form action="" method="POST">
        <div class="row">
            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-3 col-xs-12 col-sm-8 col-md-8 col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                    <input type="number"
                           name="charged"
                           class="form-control"
                           placeholder="Total"
                           value='<?= $formUtil->prefill("charged", "") ?>'
                           step="0.01">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="number"
                           name="numberPeople"
                           class="form-control"
                           placeholder="Numer of People"
                           value='<?= $formUtil->prefill("numberPeople", "") ?>'>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-scale"></i></span>
                    <select name="tipsRate" class="form-control" value='<?= $formUtil->prefill("tipsRate", "") ?>'>
                        <option value=""   <?php if ($tipsRate == '') echo 'selected'?> >Satisfaction</option>
                        <option value="15" <?php if ($tipsRate == '15') echo 'selected'?> >Normal Lunch - 15%</option>
                        <option value="18" <?php if ($tipsRate == '18') echo 'selected'?> >Normal Dinner - 18%</option>
                        <option value="20" <?php if ($tipsRate == '20') echo 'selected'?> >Amazing - 20%</option>
                        <option value="10" <?php if ($tipsRate == '10') echo 'selected'?> >Not Satisfied - 10%</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <p class="text-center">
                <br><label class="checkbox-inline"><input type="checkbox"
                                                          name="roundUp"
                                                          value="yes" 
                                                          <?php if ($roundUpChecked) echo 'checked'?> >Round Up</label>
                <br><br><input type="submit" class="btn btn-primary" name="submit" value="Calculate">
            </p>
        </div>
    </form>

    <!-- Display Result -->
    <div class="row">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-3 col-xs-12 col-sm-8 col-md-8 col-lg-6">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="well">                        
                        <h4>All Together</h4>
                        <p>
                            <label>Charged:</label> $<?= $charged ?><br>
                            <label>Tips:</label> $<?= $tips ?><br>
                            <label>Total:</label> $<?= $total ?>
                        </p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="well">                        
                        <h4>Per Person</h4>
                        <p>
                            <label>Charged:</label> $<?= $chargedPerPerson ?><br>
                            <label>Tips:</label> $<?= $tipsPerPerson ?><br>
                            <label>Owns:</label> $<?= $totalPerPerson ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /.container -->
</body>
</html>