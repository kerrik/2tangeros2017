<?php

function mailform(){
    $retur = "<div class='halva'>\n";
    global $user;
    
    $mottagare = $user->show_user($_GET['mail']);
    $bokning = $user->user_data($_GET['mail']);
    $mailtext = "Hej {$mottagare->name} {$mottagare->display_name}<br>\n";
    $mailtext .= "<p>Tack för din anmälan till Svinnock tango marathon<br>\n";
    $mailtext .= "<p>Du kan kolla din bokning om du loggar in på <a src='http://2tangeros.se/anmalan'>http://2tangeros.se/anmalan</a>\n<br>\n</p>\n";
    $mailtext .= "<p>Kostnaden för för dig är {$_GET['att_betala']}:- som du kan swischa till 0708714141 (Vilhelm Herlin)<br></p>\n";
    $mailtext .= "<p>Betala på annat sätt? Kontakta Vilhelm på samma tel.<br></p>\n";
    $mailtext .= "<p>Om du bokat inkvartering\n";
    $mailtext .= "återkommer vi om den senare</p>\n";
    $mailtext .= "<p>Ses snart på Svinnock<br>\n";
    $mailtext .= "Vilhelm Och Peder</p>\n";
    
    $retur .= " <form action = '' method='post'>\n";
    $retur .= "<input type='text' name='mailto' value='{$mottagare->acronym}'<br>\n";
    $retur .= "<textarea name='message' rows='20' cols='70'>\n";
    $retur .= htmlentities($mailtext);
    $retur .= "</textarea>\n";
    
    $retur .= "<input type='submit' name='maila' value='Maila'>\n";
    $retur .= "</form>\n"; 
    $retur .= "</div>\n";
    return $retur;
}

