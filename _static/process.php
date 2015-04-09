<?php

// if the url field is empty 

if(isset($_POST['blocker']) && $_POST['blocker'] == ''){
    // Your code here to handle a successful verification
    $to = "info@scspartners.net, mike.nizinski@gmail.com";

    # assemble header
    $header = "Reply-To: ".$_POST['email']."\nFrom: ".$_POST['email'];

    # fix subject
    $subject = "Contact from SCS Partners";

    # assemble body
    $body = "New Contact:
    -----------------------------------------------------

    ";

    $body .= "Name: ".stripslashes($_POST['name'])."\n";
    $body .= "Company: ".$_POST['company']."\n";
    $body .= "Email: ".$_POST['email']."\n";
    $body .= "Message: ".stripslashes($_POST['message'])."\n";

    # send mail
    mail($to,$subject,$body,$header); 
}
?>