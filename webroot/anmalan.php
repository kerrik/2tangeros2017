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

$tango->set_property('title', "Anmälan Svinnock");
$tango->set_property('title_append', "matathon 2017");

$tango->set_property('style', array('css', 'webroot/js/jquery/include/jquery-ui-1.12.1.custom/jquery-ui.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/driver.js');

$tango->set_property('main', driverinfo());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function driverinfo() {
//fyller $tango med lite data att skriva ut...
    global $user;
    $current_driver = new CAnmalan;
    $selected_driver = $current_driver->id();
//#####################################################################
//    $content = "<div id='form-driver'>\n";
//    $content .= "<form id='select-driver' action='' method='post'>\n";
//    $content .= "<fieldset>\n";
//    $content .= "<legend>\nFörare\n</legend>\n";
//    $content .= "<p>\n";
//    if ($selected_driver < 0) {
//        $content .= "<input type='hidden' name='use_driver' value= -2>\n";
//    } else {
//// Här börjar rutinen för inloggad förare        
//        $content .= "<div class='driver-form-row'>\n";
//        $content .= "<select id='use-driver'  name='use_driver'>";
//// Om inloggad är admin val för ny förare
//        if ($user->role() == 1 AND $selected_driver != -1) {
//            $content .= "<option value='-1'>Ny förare</option>\n";
//        }
//// Förarna läggs in i select-kontrollen. Inloggad markeras som vald
//        foreach ($user->users() as $user_data_id => $driver_data) {
//            $mark_selected = ($user_data_id == $selected_driver) ? 'SELECTED' : '';
//            $content .= "<option value='{$user_data_id}' {$mark_selected}>{$driver_data['name']}</option>\n";
//        }
//        $content .= "</select>\n";
//        $content .= "</div>\n";
////        $content .= "<div class='driver-form-label'>\n<input id='visa' type='submit' value='Visa'>\n";
////        $content .= "</div>\n";
//        $content .= "</fieldset>\n";
//        $content.="</form>";
//        
//    }
    $content = "<div id='form-driverinfo'>\n";
    $content .= "<form action='' method='post'>\n";
    $content .= "<fieldset>\n";
    $content .= "<legend>Anmälan</legend>\n";
    $content .= "<input type='hidden' name='use_driver' value={$current_driver->id()}>\n";
    $content .= "<div class='driver-form-row'>\n";
    if ($selected_driver > 0) {

        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>\nDu är anmäld till Svinnock tangomaraton med följande val  \n</label>\n</div>\n";
        $content .= "</div>\n";
    }
    $content .= "<div class='driver-form-label'>\n<label>\nFörnamn  \n</label>\n</div>\n";
    $content .= "<div class='driver-form-input'>\n<input id='name' type='text' name='name' value='{$current_driver->name()}' autocomplete='off'>\n";
    $content .= "</div>\n";
    $content .= "<div class='driver-form-row'>\n";
    $content .= "<div class='driver-form-label'>\n<label>\nEfternamn \n</label>\n</div>\n";
    $content .= "<div class='driver-form-input'>\n<input id='display_name' type='text' name='display_name' value='{$current_driver->display_name()}'>\n\n";
    $content .= "</div>\n";

    if ($selected_driver < 0) {
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>\nEmail  \n</label>\n</div>\n";
        $content .= "<div class='driver-form-input'>\n<input id='acronym' type='text' name='acronym' value='{$current_driver->acronym()}' autocomplete='off'>\n</div>\n\n";
        $content .= "</div>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>Password  </label>\n</div>";
        $content .= "<div class='driver-form-input'>\n<input id='password' type='text' name='password' value='' autocomplete='off'>\n</div>\n\n";
        $content .= "</div>\n";
        $content .= "<div class='driver-form-row'>\n";
        $content .= "<div class='driver-form-label'>\n<label>\nRepetera  \n</label>\n</div>\n";
        $content .= "<div class='driver-form-input'>\n<input id='password_check' type='text' name='password_check' value='' autocomplete='off'>\n</div>\n\n";
        $content .= "</div>\n";
    }
    $counter = -1;
//här kommer fälten från user-posten
    foreach ($current_driver->driver_data($selected_driver) as $driver_data) {
        $counter = ($driver_data->type <2)?$counter +1 : $counter;
        if ($driver_data->type >= 0) {
            $content .= "<div class='driver-form-row'>\n";
            $content .= "<div class='driver-form-label'>\n<label>\n{$driver_data->user_data_descr}  \n</label>\n</div>";
            $content .= "<div class='driver-form-label'>\n";
            if ($driver_data->type == 0) {
                $content .= "<input type='text' name='value[{$counter}]' value='{$driver_data->value}' autocomplete='off'>\n";
            } elseif ($driver_data->type == 1) {
                $checked = isset($driver_data->value) ? 'checked' : '';
                $content .= "<input type='checkbox' name='value[{$counter}]'  $checked >\n";
            }elseif ($driver_data->type ==2) {  
                $content .= "<input type='radio' name='value[{$counter}]'  $checked >\n";
            }
            $content .= "<input type='hidden' name='key[{$counter}]' value='{$driver_data->user_data_key}'>\n";
            $content .= "<input type='hidden' name='user_data_id[{$counter}]' value='{$driver_data->user_data_id}'>\n";
            $content .= "<input type='hidden' name='post_id[{$counter}]' value='{$driver_data->id}'>\n";
            $content .= "</div>\n";
        }
    }

    $content .= "<div class='driver-form-row'>\n";
    $content .= "<button id='save' type='submit'  name='save' value='{$selected_driver}'>Spara</button>\n";
    $content .= "</div>\n";
    $content .= "";
    $content .= "</fieldset>";
    $content .= "</form>";
    $content .= "</div>";

    return $content;
}
