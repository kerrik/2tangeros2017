<?php


/**
 * Class to format text
 *
 */
class CTextFilter {
    
    public function do_filter($data, $filters){
        $filters = explode(',', $filters) ;
        foreach ($filters as $filter){
            switch ($filter){
                case 'nl2br':
                    $data = $this->nl2br($data);
                    break;
                case 'bbcode':
                     $data =  $this->BBCode2html($data);
                    break;
                case 'markdown':
                     $data =  $this->markdown($data);
                    break;
                case 'link':
                     $data =  $this->clickable_links($data);
                    break;
            }
        }
        return $data;
        
    }
    
    
    private function BBCode2html( $data){
        $find = array(
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
                '/\[u\](.*?)\[\/u]/ix',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
        '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        );
       $switch = array(
            '<strong>$1</strong>',
        '<em>$1</em>',
        '<u>$1</u>',
        '<img src="$1" />',
        '<a href="$1">$1</a>',
        '<a href="$1">$2</a>'
            );
        return preg_replace($find, $switch, $data);
    } // end BBCode2html
    
    private function clickable_links($data){
        $pattern =  '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';
        $return = '<a href=\'{$matches[0]}\'>{$matches[0]}</a>';
        return preg_replace_callback($pattern, create_function(
        '$matches',
        'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
        ), $data);
    } // end clickable_links()
    
   private function nl2br($data) {
       return nl2br($data);
        
    } // end nl2br()
    
    public function markdown($data) {
    require_once(__DIR__ . '/php-markdown/Michelf/Markdown.inc.php');
  require_once(__DIR__ . '/php-markdown/Michelf/MarkdownExtra.inc.php');
  return \Michelf\MarkdownExtra::defaultTransform($data);
} 
} //end CTextFilter
 
     
