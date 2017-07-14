<?php


$to = "spam@kerrik.se";
$from = 'boka@utveckling.2tangeros.se';
$subject = 'Bokningsbekräftelse';
$message = "<html><body>\r\n";
$message .= "Hej. Bokningsbekräftelse hittar du på\r\n";
$message .=  "http://2tangeros.se/anmalan\r\n";
$message .= "Logga in med din emaladress och lösenordet du angav vid registreringen\r\n" ;

$message .= '</body></html>';
$message = wordwrap($message, 70);;

########################################################################
// HEADERS för innehållstyp och textkodning
$headers = '';//"Content-Type: text/plain; charset=utf-8 \r\n"; 
$headers .= "From:" . $from ."\r\n" .
'Reply-To: boka@2tangeros.se' . "\r\n" ;
$headers = "From: " . strip_tags($from) . "\r\n";
$headers .= "Reply-To: boka@2tangeros.se \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
//'X-Mailer: PHP/' . phpversion();
########################################################################
if (mail($to, $subject, $message, $headers))
echo nl2br("<h2>Ditt meddelande har skickats!</h2>
<b>mottagare:</b> $to
<b>meddelande:</b>
$message
");

echo $to;
echo $subject;
echo $message;
echo $headers;



    
//else
//echo "Det gick inte att skicka ditt meddelande";
//} 
