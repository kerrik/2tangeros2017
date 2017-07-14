<?php

/** Det här är mitt första försök till em me-sida med tango
 * 
 * Tango är en struktur för websidor skapad på kursen ooophp av mig
 * Peder Nordenstad.
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
//

if (isset($_POST['maila'])) {
    include 'mail.php';
}

$anmalan = visa_data();

$tango->set_property('main', <<<EOD
<h1>anmälan</h1>
<div class='text'>
<h2>Summering av bokningsläget</h2>
<p>
<div class='deltagarformsumma'>\n 
{$anmalan}
</div>
</div>
EOD
);

$tango->set_property('footer', <<<EOD
        <div class='sitefooter left'>
            &copy;Peder Nordenstad <a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>
        </div>
        <div class='right sitefooter'>
            <a  href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a> | <a href='https://github.com/kerrik/ooophp'>tango på GitHub</a>
        </div>
EOD
);

include_once (TANGO_THEME_PATH);

function visa_data() {
    global $user;

//    dump($user, 'User');
    $bokningar = $user->users();
//    dump($bokningar);
    foreach ($bokningar as $id => $deltagare) {
//        dump($deltagare);
        $data = $user->user_data($id);
        foreach ($data as $item) {
//            dump($item);
            switch ($item->user_data_descr) {
                case 'Milongapass':
                    $description = 'pass';
                    break;
                case 'Mest föra':
                    $description = 'lead';
                    break;
                case 'Mest följa':
                    $description = 'follow';
                    break;
                case 'Bo i stuga':
                    $description = 'sova';
                    break;
                case 'Vegeterian':
                    $description = 'veg';
                    break;
                case 'Önskemål boende':
                    $description = 'infoboende';
                    break;
                case 'Övrig info':
                    $description = 'info';
                    break;
            }

            $deltagare->{$description} = $item->value;
        }
//        dump($deltagare);
    }
//    $summering = $summering[0];
//    $total = array();
//    $counter = 0;
    $retur = "<div class='halva'>\n";
    $retur .= "<div class='raddeltagaresumma'>\n"
            . "<div class='radiodeltagare'><label>Namn</label></div>\n"
            . "<div class='radiodeltagaresumma'><label>M-pass</label></div>\n"
            . "<div class='radiodeltagaresumma'><label>Följ</label></div>\n"
            . "<div class='radiodeltagaresumma'><label>För</label></div>\n"
            . "<div class='radiodeltagaresumma'><label>Säng</label></div></div>\n";

//    $retur .= "<div class='raddeltagaresumma'>" 
//            . "<div class='radiodeltagare'><label></label>Antal tot</div>\n"
//            . "<div class='radiodeltagaresumma'><label>{$summering->pass}</label></div>\n"
//            . "<div class='radiodeltagaresumma'><label>{$summering->follow}</label></div>\n"
//            . "<div class='radiodeltagaresumma'><label>{$summering->lead}</label></div>\n"
//            . "<div class='radiodeltagaresumma'><label>{$summering->sova}</label></div></div>\n";
//     
    $att_betala = 0;  
    foreach ($bokningar as $id => $bokning) {
        $retur .= "<div class='raddeltagaresumma'>\n";
        $retur .= "<form action='' method='get'>\n";

        $retur .= "<input type='hidden' name='id' value='{$id}'>\n";

        $retur .= "<div class='radiodeltagare'>"
                . "<label>{$bokning->name} {$bokning->display_name}</label>\n";

//        if($id !== $bokning->id ){
//            $retur .= "<label> {$bokning->inbetalt}</label>";  
//        }

        $retur .= "</div>";

        $option_vald = ikryssad($bokning->pass);
        $retur .= "<div class='radiodeltagaresumma'><input type=radio name='pass' value='pass' {$option_vald}></div>\n"
                . "<div class='radpris'><label ></label></div>\n";
        $att_betala = (isset($option_vald))?450:0;
//       $option_vald = ikryssad($bokning->middag);
//       
//       $retur .=  "<div class='radiodeltagaresumma'>\n<input type=radio name='middag' value='middag' {$option_vald}></div>\n"
//               . "<div class='radpris'><label ></label></div>\n";
//       $option_vald = ikryssad($bokning->lunch);
//       
//       $retur .= "  <div class='radiodeltagaresumma'><input type=radio name='lunch' value='lunch' {$option_vald}></div> "
//               . "<div class='radpris'><label ></label></div>\n";
        $option_vald = ikryssad($bokning->follow);

        $retur .= "<div class='radiodeltagaresumma'><input type=radio name='follow' value='follow ' {$option_vald}></div>\n";
        $option_vald = ikryssad($bokning->lead);

        $retur .= "<div class='radiodeltagaresumma'><input type=radio name='lead' value='lead' {$option_vald}></div>\n";
        ;

        $option_vald = ikryssad($bokning->sova);

        $retur .= "<div class='radiodeltagaresumma'><input type=radio name='sova' value='sova' {$option_vald}></div>\n";
        ;
        $att_betala = isset($option_vald)?$att_betala+175:$att_betala;
//       $retur .= "<div class='radiodeltagare'><textarea name= 'namn' rows=1>{$bokning->not}</textarea></div>\n";  

        $retur .= "</form>";


        $retur .= "<form action='' method='get'>\n"
                . "<input type='hidden' name='att_betala' value='{$att_betala}'>\n"
                . "<input type='hidden' name='mail' value='{$id}'>\n"
                . "<input type='submit' name='mailit' value='Maila'>\n"
                . "</form>";




//       
//       $id = $bokning->id;
//       ++$counter;

        $retur .= "</div>\n";
    }
    $retur .= "</div>";
    if (isset($_GET['mail'])) {
        include 'mailform.php';
        $retur .= mailform();
    }

    return $retur;
}

function ikryssad($kryss) {
    $result = ( isset($kryss) ) ? 'checked' : FALSE;
    return $result;
}

function fixapriser($old_priser) {
    foreach ($old_priser as $pris) {
        $return[$pris->choise] = $pris->price;
    }
    return $return;
}

function skrivpriset($pris, $option) {
    $result = ($option == 'checked' ? $pris : 0);
    return $result;
}
