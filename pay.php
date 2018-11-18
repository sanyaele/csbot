<?php
session_start();

function clean_for_payment(){
    $_SESSION['firstname'] = strip_tags(htmlspecialchars($_POST['firstname'],ENT_QUOTES));
    $_SESSION['lastname'] = strip_tags(htmlspecialchars($_POST['lastname'],ENT_QUOTES));
    $_SESSION['email'] = strip_tags(htmlspecialchars ($_POST['email'],ENT_QUOTES));
    $_SESSION['mobile'] = strip_tags(htmlspecialchars ($_POST['mobile'],ENT_QUOTES));
    $_SESSION['for'] = strip_tags(htmlspecialchars($_POST['for']));

    $_SESSION['amount'] = strip_tags(htmlspecialchars($_POST['amount']));
    
    // Create Transaction Reference
    $_SESSION['txref'] = "Chatbot-".rand(1000,9999);
    
    return TRUE;   
}


function send_email (){
    // Create the email and send the message
    $full_script = "";
    foreach ($_POST as $key=>$value){
        $full_script .= "$key: $value\n\n ";
    }

    $to = 'contact@seonigeria.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
    $email_subject = "Payment for  ".$_SESSION['for'];
    $email_body = "Someone just sent payment for ".$_SESSION['for']."\n\n".
    "Here are the details:\n\n 
    Name: $_SESSION[firstname] $_SESSION[lastname] \n\n 
    Email: $_SESSION[email]\n\n 
    Phone: $_SESSION[mobile]\n\n 
    Amount: $_SESSION[amount]\n\n 
    Full POST: \n
        $full_script\n\n
    Transaction Reference: $_SESSION[txref]\n\n 
    Kindly reach out to the client to discuss further";
    $headers = "From: noreply@seonigeria.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
    $headers .= "Reply-To: $_SESSION[email]";   
    
    if (mail($to,$email_subject,$email_body,$headers)){
        $cont['head'] = "Application Received";
        $cont['body'] = "We have received your application, and someone from the team will be reviewing it. We will get back to you as soon as possible on $_SESSION[email] or $_SESSION[mobile]. <br>
        Thank you";
    } else {
        $cont['head'] = "Error Processing Request";
        $cont['body'] = "There was an error sending this request. Kindly email or call us to notify of this error. <br>
        Thank you.";
    }
}


if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['for']) && !empty($_POST['amount'])){
    clean_for_payment();

    send_email ();
    // 
} else {
    if (!empty($_POST['pg'])){
        print_r($_POST);
        // header ("Location: ".$_POST['pg'].".html");
    } else {
        exit();
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay for  <?php echo $_SESSION['for']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
</head>

<body>
<h2>Amount: <strong><?php echo number_format($_SESSION['amount'],2); ?></strong> </h2>    
<form target="">
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <button type="button" onclick="payWithPaystack()" class="btn btn-danger pr-4 pl-4"> Pay Now </button> 
</form>
<div class="container">
    <div class="row">    
        <div class="col-lg-8 mt-4">
            Payment for <strong> <?php echo $_SESSION['for']; ?> </strong> 
        </div>
    </div>
    <div class="row">    
        <div class="col-lg-8 mt-4">
            Call +2348033954301 for further enquiries. <br>
            Thank you.
        </div>
    </div>
</div>
    <script>
        <?php
        /*//////////
        key: 'pk_test_e2456fe6ca7c3d76e62efde7714b99203f61c5fc'
        //////////*/
        ?>
    function payWithPaystack(){
        var handler = PaystackPop.setup({
        key: 'pk_live_04692d71b041f8bed88dfcda78b59c0ea74f1904',
        email: '<?php echo $_SESSION['email']; ?>',
        amount: <?php echo $_SESSION['amount']; ?>00,
        //ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
        firstname: '<?php echo $_SESSION['firstname']; ?>',
        lastname: '<?php echo $_SESSION['lastname']; ?>',
        // label: "Optional string that replaces customer email"
        metadata: {
            custom_fields: [
                {
                    display_name: "Mobile Number",
                    variable_name: "mobile_number",
                    value: "<?php echo $_SESSION['mobile']; ?>"
                }
            ]
        },
        callback: function(response){
            alert('success. transaction ref is ' + response.reference);
        },
        onClose: function(){
            alert('window closed');
        }
        });
        handler.openIframe();
    }
    </script>
</body>
</html>
