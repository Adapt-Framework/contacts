<?php

namespace adapt\contacts{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class model_contact extends model{
        
        public function __construct($id = null){
            parent::__construct('contact', $id);
        }
        
        /* Over-ride the initialiser to auto load children */
        public function initialise(){
            /* We must initialise first! */
            parent::initialise();
            
            /* We need to limit what we auto load */
            $this->_auto_load_only_tables = array(
                'contact_email',
                'contact_phone'
            );
            
            /* Switch on auto loading */
            $this->_auto_load_children = true;
        }
        
        /*
         * Properties
         */
        public function pget_name(){
            return $this->forename . " " . $this->surname;
        }
        
        public function pget_forenames(){
            return $this->forename . " " . $this->middle_names;
        }
        
        public function pget_full_name(){
            return $this->title . " " . $this->forenames . " " . $this->surname;
        }
        
        
    }
    
}

?>