<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CContentForm
 *
 * @author peder
 */
class CContentForm extends CContentPost{
    
    
    public function __construct( $action ) {    
        mb_internal_encoding("UTF-8");
        parent::__construct( $action );
    }
    
    public function form() {
     $html = "";  
     $html = "<form method='post'>\n
                            <fieldset>\n
                                <div class='form_field'>\n
                                    <input type='hidden' name='id' value='{$this->id()}'>\n
                                    <input type='hidden' name='type' value='{$this->type()}'>\n
                                    <input type='hidden' name='published' value='{$this->published()}'>\n
                                    <input type='hidden' name='created' value='{$this->created()}'>\n
                                    <input type='hidden' name='updated' value='{$this->updated()}'>\n
                                    <input type='hidden' name='deleted' value='{$this->deleted()}'>\n
                                    <input type='hidden' name='author' value='{$this->author()}'>\n
                                    <div class='form_elements'>
                                        <p><label class='label left' for='title'>Titel:</label>\n
                                        <input type='text' class='input left' name='title' value=' {$this->title()} '></p>\n
                                    </div>
                                    <div class='form_elements'>
                                        <p><label class='label left' for='slug'>Slug:</label>\n
                                        <input type='text' class='input left' name='slug' value='{$this->slug()}'></p>\n 
                                    </div>
                                    <div class='form_elements'>
                                        <p><label class='label left' for='url'>URL:</label>\n 
                                        <input type='text' class='input left' name='url' value='{$this->url()}'></p>\n
                                    </div>
                                    <div class='form_elements'> 
                                    <p><label class='label left' for='plot'>Text:</label>\n
                                    <textarea   class='blog_text left' name='text'>{$this->text()}</textarea></p>\n
                                    <div class='form_elements'>
                                        <p><label class='label left' for='image'>Filter:</label>\n
                                        {$this->text_filter()}</p>\n
                                    </div>
                                    <div class='form_elements'>
                                        <p><label class='label left' for='author'>Författare:</label>\n
                                        <div class='input left'>{$this->author()}</div></p>\n
                                    </div>
                                </div>\n
                                <div class='form_date_string'>\n                                
                                    {$this->dates()}
                                </div>
                                <div class='form_elements'>
                                    <input type='submit' name='{$this->action()}' value='Spara' > 
                                    <input type='submit' name='delete_post' value='Radera' >
                                    <input type='reset' value='Ångra'>\n
                                </div>\n
                            </fieldset>\n
                         </form>\n" ;
        return $html;
    }
          
}
