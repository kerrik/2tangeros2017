<?php

// This is a menu item
$menu_item['home'] = array(
    'text' => 'Hem',
    'url' => 'start',
    'title' => 'Hem',
    'slug' => null,
    'view' => null);
     

$menu_item['svinnock']  = array(
      'text'  =>'Svinåker',   
      'url'   =>'svinnock',  
      'title' => 'Svinåker', 
      'slug' => null,
      'view' => null  
    );

$menu_item['baddar']  = array(
      'text'  =>'Fördelning sovplatser',   
      'url'   =>'baddar',  
      'title' => 'Fördelning sovplatser', 
      'slug' => null,
      'view' => null  
    );
   
$menu_item['map']  = array(
      'text'  =>'Karta',   
      'url'   =>'map',  
      'title' => 'Karta', 
      'slug' => null,
      'view' => null  
    );

$menu_item['anmalan'] = array(
        'text' => 'Anmälan',
        'url' => 'anmalan',
        'title' => 'Anmälan',
        'slug' => null,
        'view' => null);


    $menu_item['login'] = array(
        'text' => 'Login',
        'url' => 'login',
        'title' => 'Login',
        'slug' => null,
        'view' => null);


    $menu_item['login'] = array(
        'text' => 'Login',
        'url' => 'login',
        'title' => 'Login',
        'slug' => null,
        'view' => null);

    
if ($user->logged_in() && $user->role() == 1) {
    
    
  
}
$main_menu['class'] = 'pagemenu';
$main_menu['items'] = $menu_item;


// This is the callback tracing the current selected menu item base on scriptname
$main_menu['callback'] = function($url, $view) {
    if (basename($_SERVER['SCRIPT_FILENAME']) == $url) {
        if (isset($_GET['view']) && isset($view) && $view !== $_GET['view']) {
            return false;
        }
        return true;
    }
};
