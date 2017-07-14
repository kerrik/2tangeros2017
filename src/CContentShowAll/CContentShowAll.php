<?php

class CContentShowAll extends CContentPost{
    public $html = '';
    
    
    public function __construct(){    
        mb_internal_encoding("UTF-8");
        $action = null;
        parent::__construct( 'post' );
        
        $this->show_all();        
    }
    
    private function show_all(){
        global $content;
       
        $this->html = <<<HTML
                "<div class='text'>\n
                    <div id='blogg_sidrubrik' class='left center'>\n
                        <h1>Blogg</h1>\n
                    </div>\n 
                    <div id='blog_menu'>\n
                        <div class='right'>\n
                            <div class='page_value_title'>\n
                                Visa antal poster per sida:
                            </div>
                            {$this->show_posts_per_page()}\n
                        </div>\n
                        <div class='left'>
                            <div class='page_value_title'>\n
                                 Sida: 
                            </div>\n
                            {$this->show_paging()}\n
                        </div>\n
                    </div>        
                    <div id='blog_contents'>
                        {$this->show_posts()}
                    </div> <!-- blogg_contents --> 
                    {$this->link_new()}       
                
HTML
                ;
    } // end show_all
        
}// end CContentShowAll