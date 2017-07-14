<?php
/** Det här är mitt första försök till em me-sida med tango
 * 
 * Tango är en struktur för websidor skapad på kursen ooophp av mig
 * Peder Nordenstad.
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');


//fyller $tango med lite data att skriva ut...

$tango->set_property('title', "Två tangeros ");
$tango->set_property('title_append', "En tangoupplevelse utöver det vanliga");


/**
 * Du är inte nöjd med det sidhuvud som automatiskt skapas av CTango?
 * Fritt fram att göra vad du vill. Mallen här nedan är precis vad som
 * skrivs ut av systemet automatiskt baserat på inlagda värden
 */
//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);

$tango->content ("","<article class='main-content'>");
$tango->content ( <<<EOD
        <h1>Sovplatser</h1>
        
   <p>
   Vi har sovplatser i hus enligt nedan:<br>
   <br>Torpets bottenvåning
   <a href='baddar?img=torpet_botten.jpg&hus=Torpet%20botten'>Bild</a><br>
    Dubbelsäng, bäddsoffa för två, en möjlig golvplats
   <br>Torpets vind
   <a href='baddar?img=torpet_vind.jpg&hus=Torpet%20vind'>Bild</a><br>
    Dubbelsäng, två enkelsängar
   <br>Backstugan
    <a href='baddar?img=backstugan.jpg&hus=Backstugan'>Bild</a><br>
    Fyra enkelsängar, en möjlig golvplats
   <br>Magasinets bottenvåning
    <a href='baddar?img=magasinet_botten.jpg&hus=Magasinet%20botten'>Bild</a><br>
    Två enkelsängar
   <br>Magasinets vind
    <a href='baddar?img=magasinet_vind.jpg&hus=Magasinet%20vind'>Bild</a><br>
    En dubbelsäng, fyra enkelsängar
   <br>Gärdesstugan
    <a href='baddar?img=gardesstugan.jpg&hus=Gardesstugan'>Bild</a><br>
   En våningssäng med dubbel nere, enkel uppe, en möjlig golvplats
   <br>Fiskareboden
   <a href='baddar?img=fiskareboden.jpg&hus=Fiskereboden'>Bild</a>&hus=torpet%20botten
   <br>Fiskebodens vind
   <a href='baddar?img=fiskareboden_vind.jpg&hus=Fiskareboden%20botten'>Bild</a><br>
   Två sängplatser
   <br>Sjöbod
   <a href='baddar?img=sjoboden.jpg&hus=Sjoboden'>Bild</a><br>
   Två golvplatser
   
   </p>
   <p></p>
   
        

        
EOD
);
$if_image = isset($_GET['img'])?"<p>{$_GET['hus']}</p><img  src='webroot/img/{$_GET['img']}'>":'';
$tango->content($if_image);

$tango->set_property('footer', <<<EOD
        <div class='sitefooter left'>
            &copy;Peder Nordenstad <a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>
        </div>
EOD
);

include_once (TANGO_THEME_PATH);
        
