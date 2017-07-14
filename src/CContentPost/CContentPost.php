<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CContentPost
 *
 * @author peder
 */
class CContentPost{
       private $search = array();
      private  $logged_in = false;
      public $post_type = 'post';

      public function __construct( $action = 'post' ) {
        mb_internal_encoding("UTF-8");
        global $content;
        global $user;
        $content->search['type'] = $action; 
        $this->logged_in = $user->logged_in();
        if ( $content->search['view']  == 'new'){ 
            $this->build_class_array($action);           
        }else{
            if ( $content->search['type'] == 'post'){
                $this->blog_post = $content->get_posts($content->search);
            }else{
                $this->blog_post = $content->get_page(array('slug' => $content->search['slug'])); 
            }
        }
        if ( $content->search['view']  == 'update' || $content->search['view']  == 'show' ){
            $this->blog_post = $this->blog_post[0];
        }

//        if ( $content->search['view']  == 'page' || $content->search['view']  == 'show' ){
//        $text_filter = new CTextFilter;
//        }   
    }
    
    private function build_class_array($action){
        global $user;
        $post['id'] = null;
        $post['title'] = null;
        $post['author'] = $user->name();
        $post['slug'] = null;
        $post['url'] = null;
        $post['type'] = $action;
        $post['text'] = null;
        $post['filter'] = null;
        $post['published'] = null;
        $post['created'] = null;
        $post['updated'] = null;
        $post['deleted'] = null;
        
        $this->blog_post = (object) $post;
    }
    
    
    public function text_filter(){
        $filters = array('bbcode' => 'BBCode2HTML', 'markdown' => 'Markdown', 'nl2br' => 'nl2br', 'link' => 'Clickable links');
        $filters_choosen = explode(',', $this->blog_post->filter);
        $return = "";
        
        foreach($filters as $name => $filter){
            $checked = array_key_exists($name, $filters_choosen) ? ' checked' : '';
            $return .= "<input type='checkbox' name='filter[]' value='{$name}'{$checked}>{$filter}\n";            
        }// end foreach
        
        return $return;
        
    } // end show_radiobutton_gengre()
    public function id(){
        return $this->blog_post->id;
    }
    public function title(){
        $title = htmlentities($this->blog_post->title);
        return $title;
    }
    public function author(){
        return $this->blog_post->author;
    }
    public function slug(){
        return $this->blog_post->slug;
    }
    public function url(){
        return $this->blog_post->url;
    }
    public function type(){
        return $this->blog_post->type;
    }
    public function text(){
        return $this->blog_post->text;
    }
    public function filtered_text(){
        $text_filter = new CTextFilter;
        $text =  $text_filter->do_filter(htmlentities($this->blog_post->text), $this->blog_post->filter);
        return $text;
    }
    public function filter(){
        return $this->blog_post->filter;
    }
    public function published(){
        return $this->blog_post->published;
    }
    public function created(){
        return $this->blog_post->created;
    }
    public function updated(){
        return $this->blog_post->updated;
    }
    public function deleted(){
        return $this->blog_post->deleted;
    }
    public function action(){
        global $content;
        $submit_name= "{$content->search['view']}_{$this->blog_post->type}";
        return $submit_name;
    }
    public function dates(){
        $dates = $this->format_date( $this->blog_post->created ) ? "<div class='form_date'>Skapad: " . date('ymd H:i', strtotime( $this->blog_post->created )) . "</div>\n"  :''; 
        $dates .= $this->format_date( $this->blog_post->updated ) ? "<div class='form_date'>Uppdaterad : " . date('ymd H:i', strtotime($this->blog_post->updated)) . "</div>\n" :''; 
        $dates .= $this->format_date( $this->blog_post->published ) ? "<div class='form_date'>Publicerad : " . date('ymd H:i', strtotime($this->blog_post->published)) . "</div>\n" :''; 
        $dates .= $this->format_date( $this->blog_post->deleted ) ? "<div class='form_date'>Raderad : " . date('ymd H:i', strtotime($this->blog_post->deleted)) . "</div>\n" : ''; 
        return $dates;
    }
    public function link_show_post( $id ){
        global $content;
        global $user;
        $search = $content->search;
        $search['view'] = "show";
        $search['id'] = $id;
        $get = http_build_query($search, null, '&amp;');
        $return = "<a class='right' href='blog.php?{$get}'><img src='img/zoom_in.png' alt='show post'></a>\n"; 
        return $return;
    }
    public function link_update( $id ){
        global $content;
        global $user;
        $search = $content->search;
        $search['view'] = "update";
        $search['id'] = $id;
        $get = http_build_query($search, null, '&amp;');
        $return = $this->logged_in ? "<a class='right' href='blog.php?{$get}'>\n
                                      <img src='img/edit.png' alt='edit'>\n</a>\n" : "" ;    
        return $return;
    }
    public function link_new(){
        global $content;
        global $user;
        $search = $content->search;
        $search['view'] = "new";
        $get = http_build_query($search, null, '&amp;');
        $return = $this->logged_in ? "<a class='right' href='blog.php?{$get}'>
                                      <img src='img/new-blog-post.png' alt='edit'></a>" : "" ;     
        return $return;
    }
    public function link_all(){
        global $content;
        global $user;
        $search = $content->search;
        $search['view'] = "alla";   
        $search['id'] = "";
        $get = http_build_query($search, null, '&amp;');
        $return =  "<a class='left' href='blog.php?{$get}'><img src='img/home.png' alt='home'></a>";
        return $return;
    }
    
     public function link_delete(){
        global $content;
        global $user;
        $search = $content->search;
        $search['view'] = "alla";   
        $get = http_build_query($search, null, '&amp;');
        $return =  "<a class='left' href='blog.php?{$get}&amp;delete'><img src='img/delete.png' alt='home'></a>";
        return $return;
    }
    
    private function format_date($date){
        if ( strtotime($date)>0 ){
            return true;                    
        }
        return false;
    }
    
    public function show_posts(){        
        global $content;
        $text_filter = new CTextFilter;
        $html = '';
        $search = $content->search;
        $search['start_page'] = ($search['start_page']-1) * $search['posts_per_page'];
        $search['limit'] = true;
        $get_update = $content->search;
        $get_update['view'] = "update";
        $get_show = $content->search;
        $get_show['view'] = "show";
        $get_new['view'] = "new";
        
            
        //Skapar output
        foreach($this->blog_post AS $key => $val) {
            $val->title = $val->title;
            $val->text = $this->excerpt($val->text, 150);
            $val->author = $val->author;
            $get_update['id'] = "";
            $update = http_build_query($get_update);
            $get_new['id'] = "$val->id";
            $new = http_build_query($get_new);
        
            $html .= "<div class='blogpost'>
                                    <div class='blog_title'>\n
                                        {$val->title}\n
                                    </div>\n
                                    <div class='blog_data'>\n
                                        {$val->text}\n
                                    </div>\n
                                <div class='blog_date'>\n
                                    {$val->published}\n
                                </div>\n
                                <div class='blog_author'>\n
                                    $val->author
                                </div>\n
                                <div class='info_pick left'>\n
                                {$this->link_show_post($val->id)}\n
                                {$this->link_update($val->id)}\n                        
                                </div><!-- end pic_info -->\n
                                </div> <!-- end blogpost -->";
        }// end foreach
        return $html;
    }// end show_contents
    
    
    public function show_posts_per_page(){
        global $content;
        $get_string = $content->search;
        $html = '';
        for ($pages = 2; $pages <= 10; $pages += 2 ){
            $get_string['posts_per_page'] = $pages;
            $get = http_build_query($get_string, null, '&amp;');
            $html .= $pages == $content->search['posts_per_page'] ? "<div class='page_value'><b>{$pages}</b></div>" : "<a href='blog.php?{$get}'><div class='page_value left'>{$pages}</div></a>";
        } // end for
        return $html;
    } // end show_posts_per_page
    
    public function show_paging(){
        global $content;
        $html = '';
        // Jag börjar med att kolla hur många filmer som ska visas per sida        
        $start_point = $content->search['start_page'] * $content->search['posts_per_page'];
        $contents_to_show = $content->paginering($content->search);
        // Kollar hur många sidor det är totalt, för att kunna styra behovet av forward och backwardslänkarna
        $total_pages = ceil( $contents_to_show /$content->search['posts_per_page'] );
        $get_string = $content->search;
        $get_string['start_page'] = 1;
//        
        $get = http_build_query($get_string);
        $html .= $content->search['start_page'] <= 1 ? "<div class='page_value'>&lt;&lt;</div>" : 
                                                    "<a href='blog.php?{$get}'><div class='page_value'>&lt;&lt;</div></a>";
        
        $get_string['start_page'] = $content->search['start_page'] > 1 ?$content->search['start_page'] -1 : 1;
        $get = http_build_query($get_string, null, '&amp;');
        // snabbspolning bakåt, om ej på första sidan
        $html .= $content->search['start_page'] <= 1 ?
                                    "<div class='page_value'>\n
                                        &lt;\n
                                    </div>" 
                                    ://ternery 
                                    "<a href='blog.php?{$get}'>\n
                                        <div class='page_value'>\n
                                            &lt;\n
                                        </div>\n
                                    </a>";
        
        // Skapar länkar för sidorna
                                           
        for( $page_number = 1; $page_number <= $total_pages; $page_number++){
            
            $get_string['start_page']  = $page_number;
            $get = http_build_query($get_string, null, '&amp;');
            $html .=  $page_number<> (int)$content->search['start_page'] ? 
                                    "<a href='blog.php?{$get}'>\n
                                    <div class='page_value'>\n
                                        {$page_number}\n
                                    </div>\n
                                    </a>\n" 
                                    :   //Ternery  
                                    "<div class='page_value'>\n<b>{$page_number}</b></div>\n"  ;
        } // end for
        
        // och vid behov snabbspolning framår
        $get_string['start_page']  = $content->search['start_page'] + 1;
        $get = http_build_query($get_string, null, '&amp;');
        $html .= $content->search['start_page'] == $total_pages ? 
                                "<div class='page_value'>\n
                                    &gt;\n
                                </div>\n"
                                : //ternery 
                                "<a href='blog.php?{$get}'>\n
                                    <div class='page_value'>\n
                                        &gt;\n
                                    </div>\n
                                </a>\n";
        $get_string['start_page']  = $total_pages;
        $get = http_build_query($get_string, null, '&amp;');
        $html .= $content->search['start_page'] == $total_pages ? "<div class='page_value'>&gt;&gt;</div>" : 
                                                       "<a href='blog.php?{$get}'><div class='page_value'>&gt;&gt;</div></a>";
        return $html;                
    } // end show_paging()
    
    private function create_sortstring($sort){
        global $content;
        $content->search['sort'] = $sort;
        $return = http_build_query($content->search, null, '&amp;');
        return $return;
        
    } // end create_sortstring()
    
     public function excerpt($excerpt, $length=100){
	if (strlen($excerpt) > $length) {
	  $excerpt = mb_substr($excerpt, 0, $length);
	  $excerpt = mb_substr($excerpt,0,mb_strrpos($excerpt, " "));
	  $etc = " ..."; 
	  $excerpt = $excerpt . $etc;
	  }
	return $excerpt; 
    }
}
