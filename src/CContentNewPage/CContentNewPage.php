<?php


class CContentNewPage {
       public $html = '';
               
    
    public function __construct() {    
        mb_internal_encoding("UTF-8");
        $this->show_new();
    }
    
    private function show_new(){
        $post=new CContentForm("page");
        
        $this->html =  "<div class='text'>\n
                        <h1>Skapa ny sida</h1>\n
                        {$post->form()}\n
                        <div class='right bottom_links'>\n   
                            {$post->link_all()}
                        </div>"; // 
        
       
    } //end show_new 

}



      