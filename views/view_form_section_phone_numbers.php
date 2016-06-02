<?php

namespace adapt\contacts{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class view_form_section_phone_numbers extends \adapt\forms\view_form_page_section{
        
        public function __construct($form_data, &$user_data){
            parent::__construct($form_data, $user_data);
            
            
        }
    }
    
}

?>