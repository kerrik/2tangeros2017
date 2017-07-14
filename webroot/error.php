<?php
include( __DIR__ . '/config.php');

if($user->logged_in()){
    $logged_in = <<<EOF
        <form method=post>
            <input type="submit" value="Logout" name= "logout" id='logout' />
        </form>
EOF
    ; // end first if
}else { 
    $logged_in = "<a  href='login'>Login</a>";
}

//fyller $tango med lite data att skriva ut...



$tango->content ("","<article class='main-content'>");
$tango->content ( <<<EOD
                 
        <h1>Något blev fel</h1>
        <p>
		hör av dig till itdrift@kerrik.se eller direkt till Peder Nordenstad om felet kvarstår
		<p>
		
EOD
);

$tango->content ("","</article>");



$tango->set_property('footer', <<<EOD
        <div class='sitefooter left'>
            &copy;Peder Nordenstad <a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>
        </div>
         <div class='right sitefooter'>
            $logged_in
        </div>
EOD
);


include_once (TANGO_THEME_PATH);
        
