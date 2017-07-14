<?php


class CContentUpdatePost {
       public $html = '';
    
    public function __construct () {    
        mb_internal_encoding("UTF-8");
        $this->show_update();
    }
    
    private function show_update(){
        $post=new CContentForm('post');
        
        $this->html =  "<div class='text'>\n
                        <h1>Redigera post</h1>\n
                        {$post->form()}\n
                        <div class='right bottom_links'>\n   
                            {$post->link_all()}
                        </div>"; // end this->html
        
       
    } //end show_new 
} // end CContentUpdate