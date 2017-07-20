<?php
/** Det här är en sida för in och utloggning.
 * 
 * Möjlighet för utloggning ligger också i sidforen
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');

//fyller $tango med lite data att skriva ut...


$tango->main_content(<<<EOD
    <p></p>
    <form method=post>
        <fieldset>
        <legend>Login</legend>
EOD
); //end main_content

if( $user->logged_in()){  
    $url= 'anmalan';
    header("location:$url");
    $tango->main_content("<p>Du &auml;r inloggad som " . $user->name() . " </p>");    
    $tango->main_content("<p><input type='submit' name='logout' value='Logout'/></p>");
    }elseif (isset($_POST['nyanmalan'])){
        $_SESSION['nyanmalan'] = TRUE;
        $url='anmalan';
        header("location:$url");

    }else{
    $tango->main_content( <<<EOD
        <p><input type='submit' name='nyanmalan' value='Skapa ny anmälan'/></p>
         
        <p><label>Redan anmäld? Kolla din anmälan genom att logga in</label></p>
        <p><label>Email:<br/><input type='text' name='acronym' value='' autocomplete='off'/></label></p>
        <p><label>Lösenord:<br/><input type='password' name='password' value=''/></label></p>
        <p><input type='submit' name='login' value='Login'/>
        </p>
        </fieldset>
    </form>

EOD
    );// end main content
    
    }


include_once 'footer.php';
include_once (TANGO_THEME_PATH);
        
