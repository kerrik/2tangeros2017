<?php
/**
 * This example shows sending a message using PHP's mail() function.
 */
$message = <<<EOD
 <!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
</head>

<body>
{$_POST['message']}
</body>

</html> 

EOD;


require TANGO_INSTALL_PATH . '/src/PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

$mail->CharSet = 'utf-8';
//Set who the message is to be sent from
$mail->setFrom('boka@2tangeros.se', 'Bokning Svinnock');
//Set who the message is to be sent to
$mail->addAddress($_POST['mailto']);
//Set the subject line
$mail->Subject = 'Bekräftelse anmälan Svinnock tangomarathon';

$mail->msgHTML($message);

$mail->AltBody = strip_tags($message);


//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
function replcSpecChar($string){
    echo 'hej och hå';
	$string = preg_replace("/å/", "&aring;", $string);
	$string = preg_replace("/ä/", "&auml;", $string);
	$string = preg_replace("/ö/", "&ouml;", $string);
	$string = preg_replace("/Å/", "&Aring;", $string);
	$string = preg_replace("/Ä/", "&Auml;", $string);
	$string = preg_replace("/Ö/", "&Ouml;", $string);
	
	return $string;
}