<?php

/*
  Copyright (C) 2016 peder

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY;
  without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.

  #########################################################################
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');

$tango->set_property('title', "Bekräftelsemail");
$tango->set_property('title_append', "");

$tango->set_property('style', array('css', 'webroot/js/jquery/include/jquery-ui-1.12.1.custom/jquery-ui.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/driver.js');

$tango->set_property('main', maila());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function maila() {
//fyller $tango med lite data att skriva ut...
    $content = '';
    global $user;
    $mottagare = $user->show_user($_GET['mail']);
    $bokning = $user->user_data($_GET['mail']);
    dump($mottagare);
    dump($bokning);
    $mailtext = "Hej {$mottagare->name} {$mottagare->display_name}<br>";
    $mailtext .= "<p>Tack för din anmälan till Svinnock tango marathon<br>";
    $mailtext .= "Vi håller på att jobbar med fördelning av inkvartering mm<br>";
    $mailtext .= "och återkommer med hur vi tänkt oss senare</p>";
    $mailtext .= "<p>Du kan kolla din bokning om du loggar in på <a src='http://2tangeros.se/anmalan'>http://2tangeros.se/anmalan</a><br>";
    $mailtext .= "Kostnaden för marathonet är för dig kr som du kan swischa till 0708714141 (Vilhelm Herlin)</p>>";
    $mailtext .= "<p>Ses snart på Svinnock<br>";
    $mailtext .= "Vilhelm Och Peder</p>";
    
    $content .= " <form action = 'mailpphp'>";
    $content .= "<textarea rows='20' cols='70'>";
    $content .= $mailtext;
    $content .= "</textarea>";
    
    $content .= "</form>"; 
    dump($content);
    return $content;
}
