<?php

namespace adapt\contacts{
    
    /* Prevent Direct Access */
    defined('ADAPT_STARTED') or die;
    
    class bundle_contacts extends \adapt\bundle{
        
        public function __construct($data){
            parent::__construct('contacts', $data);
        }
        
        public function boot(){
            if (parent::boot()){
                $this->dom->head->add(new adapt\html_link(array('type' => 'text/css', 'rel' => 'stylesheet', 'href' => "/adapt/contacts/contacts-{$this->version}/static/css/contacts.css")));
                $this->dom->head->add(new html_script(array('type' => 'text/javascript', 'src' => "/adapt/contacts/contacts-{$this->version}/static/js/contacts.js")));
                return true;
            }
            
            return false;
        }
        
    }
    
    
}

?>