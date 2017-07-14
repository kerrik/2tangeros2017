<?php


class CContentShowPage {
    public $html = '';
    
    public function __construct() {    
        mb_internal_encoding("UTF-8");
        $action = null;
        $this->show_one(); 
    }
    
  private function show_one(){
    $post=new CContentPost("page");
      $this->html =  "<div class='text'>\n  
                        <div id='blog_show_one'>
                            <h1>{$post->title()}</h1>\n
                            <div class='info_plot left'>
                              {$post->filtered_text()}\n
                            </div>\n
                            <div class='info_text left'>\n
                              {$post->author()}\n
                            </div>\n
                        </div>\n
                        <div class='right bottom_links'>\n  
                        <div class='left'>
                            {$post->link_all()}
                        </div>\n
                        <div class='right'>
                            <div class='left'>\n
                                {$post->link_update($post->id())}\n
                            </div>\n 
                            <div class='left'>\n
                                {$post->link_delete($post->id())}\n
                            </div>\n 
                        </div>\n 
                    </div>";
                        ;
    } // end show_one
}
