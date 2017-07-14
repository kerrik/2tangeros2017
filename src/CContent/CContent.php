<?php

/*
 * 
 */

class CContent extends CDatabase{
    private $html = '';
    private $filtrera= false;
    public $search = array();
    
    
    public function __construct($type = 'post') {        
        mb_internal_encoding("UTF-8");
        $this->create_db( TANGO_SOURCE_PATH . 'CContent/dbcreate.php');
        $this->search_criteria($type);
        if ( isset($_POST['new_post'])){
            $this->search['id'] = $this->new_post();
            $this->search['view'] = 'show';
        }
        if ( isset($_POST['new_page'])){
            $this->search['id'] = $this->new_post();
            $this->search['view'] = 'show';
            
            $this->search['slug'] = $_POST['slug'];
        }
        if ( isset($_POST['update_post']) || isset($_POST['update_page']) ){            
            $this->search['id'] = $_POST['id'];
            $this->update_post();
        }
        if( isset( $_POST['delete_post']) || isset($_GET['delete']) ){            
            $parameter = array($this->search['id']);
            $this->delete_post( $parameter );
            $this->search['view'] = $type == 'post' ? 'alla' : 'new' ;            
            $this->search['id'] = 0;
            if( isset($this->search['delete'])){ unset($this->search['delete']);}
         }
    } // end __construct
    
     public function search_criteria( $type = 'post' ){
    // Skapas en array med värden för att generera GET-strängen
        $search['type'] =  $type;
        $search['start_page'] =  1;
        $search['sort'] =  'titleasc';
        $search['title'] =  '';
        $search['year1'] =  '';
        $search['year2'] =  '';
        $search['posts_per_page'] =  4;
        $search['view'] = 'alla';
        $search['start_page'] = ($search['start_page']-1) * $search['posts_per_page'];
        $search['limit'] = true;
//        $search['id'] = 0;
        if( isset( $_GET )){
            parse_str($_SERVER['QUERY_STRING'], $this->search);
            $this->search = array_merge( $search, $this->search );
        }else{
            $this->search = $search;
        }
    } // end search_criteria
    
   
    
    /**
     * 
     * Här händer till synes inte så mycket. Bollen skickas vidare ...
     */
    
    public function html(){
        $this->check_for_include();
        return $this->html;
    } // end html    
    
    /**
     * .. hit.
     * Nu börjar det hända saker. 
     * check_for_include startar renderingsprocessen genom att kontrollera vad 
     * du vill göra och skicka dig vidare till den class som hanterar det.
     * Resten av CContent har bara hand om gränssnittet mot databasen. Övrig
     * renderinglogik ligger i nästa anropade class, som är specifik för vad den
     *  ska göra.
     */
     private function check_for_include(){
        global $tango;
        global $main_menu;
        if($this->search['type'] == 'post'){
            switch ($this->search['view']){
                case 'update':
                    $tango->set_property('title', "Uppdatera bloggpost");
                    $CContentUpdate = new CContentUpdatePost;
                    $this->html= $CContentUpdate->html; 
                    return true;
                case 'show':
                    $tango->set_property('title', "Visa enskild post");
                   $CContentShowOne = new CContentShowBlogpost;
                    $this->html= $CContentShowOne->html; 
                    return true;
                case 'new':
                    $tango->set_property('title', "Ny bloggpost");
                    $CContentNew = new CContentNewPost;
                    $this->html= $CContentNew->html; 
                    return true;
                default:              
                    $tango->set_property('title', "Visa bloggen");
                    $CContentShowAll = new CContentShowAll;
                    $this->html= $CContentShowAll->html; 
                    return true;
            } // end switch
        }else{ 
            switch ($this->search['view']){
                case 'update':
                    $tango->set_property('title', "Uppdatera bloggpost");
                    $CContentUpdate = new CContentUpdatePage;
                    $this->html= $CContentUpdate->html; 
                    return true;
                case 'show':
                    $tango->set_property('title', "Sida");
                    $CContentShowAll = new CContentShowPage;
                    $this->html= $CContentShowAll->html; 
                    return true;
                case 'new':
                    $tango->set_property('title', "Ny bloggpost");
                    $CContentNew = new CContentNewPage;
                    $this->html= $CContentNew->html; 
                    return true; 
            }
            
        }
        return false;
    } // end include_file
    
    
    public function filter_search($search){
        $limit = null;
        $filter = null ;
        $sort = null;
        
        $filter .= " AND Content.type LIKE '{$search['type']}' ";
           
        if( !empty($search['year1'])){
            $filter .= isset ($filter)? ' AND ' : '';
            $filter .= "Content.publisshed>=?";
            $parameter[] = $search['publisshed1'];
        } 
        if( !empty($search['published'])){
            $filter .= isset ($filter)? ' AND ' : '';
            $filter .= "Content.published<=?";
            $parameter[] = $search['published2'];
        } 
        if( !empty($search['title'])){
            $filter .= isset ($filter)? ' AND ' : '';
            $filter .= "Content.title LIKE ?";
            $parameter[] = $search['title'];
        } 
        if( !empty($search['title'])){
            $filter .= isset ($filter)? ' AND ' : '';
            $filter .= "Content.title LIKE ?";
            $parameter[] = $search['title'];
        } 
        if( !empty($search['id'])){
            $filter .= isset ($filter)? ' AND ' : '';
            $filter .= "Content.id LIKE ?";
            $parameter[] = $search['id'];
        } 
        if( !empty($search['sort'])){
            
            $sort = $this->create_sortstring();
        } 
        if( isset($search['limit'])){
            $limit .= " LIMIT {$search['start_page']} , {$search['posts_per_page']} ";
        } 
        $today = date( 'Y-m-d');
        $filter =  " WHERE Content.published <= '{$today} 23:59' $filter";
        $return = array( 'sql' => $filter,
                         'limit' => $limit, 
                         'parameter' => $parameter,
                         'sort' => $sort );
        return $return;
    } // end search
    
    public function get_posts($search){
        $filter = $this->filter_search($search);
        $sql = "SELECT *
                  FROM Content
        {$filter['sql']} 
        {$filter['limit']};";
        $return = $this->query_DB($sql, $filter['parameter']);
        return $return;
    }// end get_posts()
    
    public function get_page($search){
        $filter = array();
        $sql = "SELECT *
                  FROM Content
                  WHERE slug = '{$search['slug']}';";
        $return = $this->query_DB($sql, array());
        return $return;
    }// end get_posts()
     
    public function paginering($search){
        $filter = $this->filter_search($search);
        $sql = <<<EOD
                SELECT 
                    COUNT(DISTINCT Content.id ) AS posts
                  FROM Content
                   {$filter['sql']};
EOD
                ;
        $return = $this->query_DB($sql, $filter['parameter']);
        return (int)$return[0]->posts;
        
        
    } //end paginering
    
    public function update_post(){
        $parameter = $this->make_parameter_var();
        $sql = <<<EOD
               UPDATE Content SET
                created = ?,
                updated = ?,
                published = ?,
                deleted = ?,
                author = ?,
                title = ?,
                slug = ?,
                url = ?,
                filter = ?,
                text = ?,
                type = ?
              {$parameter['sql']}
EOD
       ;
        $return = $this->query_DB($sql, $parameter['value']);
        return $return;
    } // end update_post()
    
    
     public function new_post(){
        $parameter = $this->make_parameter_var();
        $sql = <<<EOD
            INSERT INTO Content(
                created,
                updated,
                published,
                deleted,
                author,
                title,
                slug,
                url,
                filter,
                text,
                type)
            VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
EOD
       ;
        $return = $this->query_DB($sql, $parameter['value']);
        $return = $this->id_new_post();
        return $return;
    } // end new_post()

    public function delete_post($parameter){
        $sql = "DELETE FROM Content WHERE id = ?;";
        $return = $this->query_DB($sql, $parameter);
        return $return;
    } //end delete_post()

    
    private function create_sortstring(){
        switch ($this->search['sort']){
            case 'titleasc':
                $return = " ORDER BY Content.title ASC ";
            break;
            case 'titledec':
                $return = " ORDER BY Content.title DESC ";
            break;
            case 'yearasc':
                $return = " ORDER BY Content.published ASC ";
            break;
            case 'yeardec':
                $return = " ORDER BY Content.published DESC ";
            break;             
        }
        
        return $return;
    } // end crete_sortstring
    
   public function make_parameter_var(){
       
        $parameter['value'][] = isset($_POST['new_post']) || isset($_POST['new_page']) ? date('Y-m-d H:i') : $_POST['created'];
        $parameter['value'][] = isset($_POST['update']) ? date('Y-m-d H:i') : $_POST['updated'];
        $parameter['value'][] =isset($_POST['publish']) ? date('Y-m-d H:i') : $_POST['created'];
        $parameter['value'][] = $_POST['deleted'];
        $parameter['value'][] = trim( $_POST['author'] );
        $parameter['value'][] = trim( $_POST['title'] );
        $parameter['value'][] = trim( $_POST['slug'] );
        $parameter['value'][] = empty($_POST['url']) ? null : trim( $_POST['url'] );
        $parameter['value'][] = isset( $_POST['filter']) ? implode( ',', $_POST['filter']) : '' ;
        $parameter['value'][] = trim( $_POST['text'] );
        $parameter['value'][] =trim( $_POST['type'] );
        if (isset( $_POST['update_post']) || isset( $_POST['update_page'])){
            $parameter['sql'] = " WHERE id = {$_POST['id']}";
        }
        return $parameter;
   } // end make_parameter_var()
        
} // end CContent