<?php
/** 
 * 
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');


//fyller $tango med lite data att skriva ut...

$tango->set_property('title', "Tango, webbsidor som en dans");
$tango->set_property('title_append', "En webmall skapad på kursen ooophp på BTH");


/**
 * Du är inte nöjd med det sidhuvud som automatiskt skapas av CTango?
 * Fritt fram att göra vad du vill. Mallen här nedan är precis vad som
 * skrivs ut av systemet automatiskt baserat på inlagda värden
 */
//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);


$style =<<<EOD
        #header {
            background-image: url('img/blogg.jpg');
        }
         .siteslogan {
          color: #515b5c;
        }
EOD
;


$tango->set_property('embed_style', $style);

$content = new CContent;
$tango->main_content($content->html());

$tango->main_content( "</div>' <!-- end div text -->" );
include_once 'footer.php';
include_once (TANGO_THEME_PATH);
        
