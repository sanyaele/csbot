<?php
if (!empty($_GET['ch'])){
    $ch = $_GET['ch'];
    if ($ch == "b"){
        $amount = 55000;
        $maintenance = 10000;
        $for = "Basic Chatbot";
    } elseif ($ch == "s"){
        $amount = 95000;
        $maintenance = 21000;
        $for = "Standard Chatbot";
    }

    if (!empty($_GET['discount'])){ // Current discount is 25% for online payment
        $discounted = $amount * 0.75;
    }
} else {
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pay for Chatbot</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/new-age.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    

  </head>

  <body>
    <!-- Page Content -->
    <div class="container">

          <h1> <?php echo $for; ?> </h1>
          <h3 class="text-success"> Setup: <?php if (!empty($discounted)){ echo "N".number_format($discounted)." <del class=\"text-muted\">N".number_format($amount)."</del>"; } else { echo "N".number_format($amount); }?> </h3>
      <!-- Intro Content -->
      <div class="row">
        <form action="pay.php" method="POST">
                <div class="col-12 mt-2">
                    <input name="firstname" placeholder="Firstname" <?php if (!empty($_GET['fn'])){ echo "value=\"$_GET[fn]\""; } ?> onblur="this.placeholder = 'Firstname'" class="form-control" required="" type="text" required>
                </div>
                <div class="col-12 mt-2">
                    <input name="lastname" placeholder="Lastname" <?php if (!empty($_GET['ln'])){ echo "value=\"$_GET[ln]\""; } ?> onblur="this.placeholder = 'Lastname'" class="form-control" required="" type="text" required>
                </div>
                <div class="col-12 mt-2">
                    <input name="email" placeholder="Email"<?php if (!empty($_GET['em'])){ echo "value=\"$_GET[em]\""; } ?> onblur="this.placeholder = 'Email'" class="form-control" required="" type="email" required>
                </div>
                <div class="col-12 mt-2">
                    <input name="mobile" placeholder="Telephone" <?php if (!empty($_GET['ph'])){ echo "value=\"$_GET[ph]\""; } ?> onblur="this.placeholder = 'Telephone'" class="form-control" required="" type="text" required>
                </div>
                <div class="col-12 mt-2">
                    <button class="btn btn-primary col-12" type="submit" data-toggle="collapse">Pay For Chatbot <i class="fa fa-paper-plane-o ml-1"></i></button>
                </div>
                <div>
                    <input type="hidden" name="for" value="<?php echo $for; ?>">
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="pg" value="pg">
                </div>
            </form>
        </div>
      <!-- /.form -->

    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
