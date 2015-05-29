<?php

namespace extensions\contacts{
        
    /*
     * Prevent direct access
     */
    defined('ADAPT_STARTED') or die;
    
    class controller_contacts extends controller{
        
        public function __construct(){
            parent::__construct();
        }
        
        /*
         * This controller exists to handle ajax requests
         * so that the contact form can alter it's field
         * layouts for address and change validators
         * for dates, times and phone numbers
         */
        
    }
}

?>