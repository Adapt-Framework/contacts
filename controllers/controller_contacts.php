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
        
        
        /*
         * Views
         */
        public function view_phone_type_dropdown(){
            $country_id = $this->data_source->escape($this->request['country_id']);
            
            $view = new html_ul(array('class' => 'dropdown-menu phone-type-selector'));
            
            if (is_numeric($country_id)){
                $sql = $this->data_source->sql;
                $sql->select(array('id' => 'c.country_phone_data_type_id', 'name' => 'c.label', 'validator' => 'd.validator', 'formatter' => 'd.formatter', 'unformatter' => 'd.unformatter'))
                    ->from('country_phone_data_type', 'c')
                    ->join('data_type', 'd', 'data_type_id')
                    ->where(
                        new \frameworks\adapt\sql_and(
                            new \frameworks\adapt\sql_condition(
                                new \frameworks\adapt\sql('c.country_id'), '=', $country_id
                            ),
                            new \frameworks\adapt\sql_condition(
                                new \frameworks\adapt\sql('c.date_deleted'), 'is', new \frameworks\adapt\sql('null')
                            )
                        )
                    )
                    ->order_by('c.label');
                
                $results = $sql->execute()->results();
                
                foreach($results as $result){
                    $li = new html_li(new html_a($result['name'], array('href' => 'javascript: void(0)', 'title' => $result['name'], 'data-id' => $result['id'], 'data-validator' => $result['validator'], 'data-formatter' => $result['formatter'], 'data-unformatter' => $result['unformatter'])));
                    $view->add($li);
                }
            }
            
            return $view;
        }
        
        public function view_email_type_dropdown(){
            $view = new html_ul(array('class' => 'dropdown-menu email-type-selector'));
            
            $sql = $this->data_source->sql;
            $sql->select(array('id' => 'c.contact_email_type_id', 'name' => 'c.label', 'validator' => q("email_address"), 'formatter' => q("email_address"), 'unformatter' => q("email_address")))
                ->from('contact_email_type', 'c')
                ->where(
                    new \frameworks\adapt\sql_condition(
                        new \frameworks\adapt\sql('c.date_deleted'), 'is', new \frameworks\adapt\sql('null')
                    )
                )
                ->order_by('c.label');
            
            $results = $sql->execute()->results();
            
            foreach($results as $result){
                $li = new html_li(new html_a($result['name'], array('href' => 'javascript: void(0)', 'title' => $result['name'], 'data-id' => $result['id'], 'data-validator' => $result['validator'], 'data-formatter' => $result['formatter'], 'data-unformatter' => $result['unformatter'])));
                $view->add($li);
            }
            
            return $view;
        }
        
        public function view_address_field(){
            $country_id = $this->data_source->escape($this->request['country_id']);
            
            $view = new html_div(array('class' => 'address-set form-horizontal'));
            
            if (is_numeric($country_id)){
                $view->add(new html_input(array('type' => 'hidden', 'name' => 'contact_address[contact_address_id][]')));
                $view->add(new html_input(array('type' => 'hidden', 'name' => 'contact_address[contact_id][]')));
                $view->add(new html_input(array('type' => 'hidden', 'name' => 'contact_address[priority][]')));
                
                //TODO: country_id
                
                /* Get the address types */
                $sql = $this->data_source->sql;
                $sql->select(array('id' => 'contact_address_type_id', 'name' => 'label'))
                    ->from('contact_address_type')
                    ->where(
                        new \frameworks\adapt\sql_condition(
                            new \frameworks\adapt\sql('date_deleted'),
                            'is',
                            new \frameworks\adapt\sql('null')
                        )
                    )
                    ->order_by('label');
                
                $results = $sql->execute()->results();
                
                $types = array();
                
                foreach($results as $result){
                    $types[$result['id']] = $result['name'];
                }
                
                $field = new \extensions\forms\view_field_select(
                    array(
                        'name' => 'contact_address[contact_address_type_id][]',
                        'mandatory' => 'Yes',
                        'allowed_values' => $types,
                        'label' => 'Address type',
                        'value' => ''
                    )
                );
                
                /* Make the field hoizonal */
                $field->find('label')->add_class('col-sm-4');
                $control = $field->find('.form-control')->detach();
                $field->add(new html_div($control->get(0), array('class' => 'col-sm-8')));
                
                $view->add($field);
                
                /* Lets get a list of address fields used by this  */
                $sql = $this->data_source->sql;
                
                $sql->select(
                    array(
                        'name' => 'c.label',
                        'validator' => 'd.validator',
                        'formatter' => 'd.formatter',
                        'unformatter' => 'd.unformatter',
                        'max_length' => 'c.max_length'
                    )
                )
                ->from(
                    'country_address_format', 'c'
                )
                ->join(
                    'data_type', 'd', 'data_type_id'
                )
                ->where(
                    new \frameworks\adapt\sql_and(
                        new \frameworks\adapt\sql_condition(
                            new \frameworks\adapt\sql('c.country_id'), '=', $country_id
                        ),
                        new \frameworks\adapt\sql_condition(
                            new \frameworks\adapt\sql('c.date_deleted'), 'is', new \frameworks\adapt\sql('null')
                        ),
                        new \frameworks\adapt\sql_condition(
                            new \frameworks\adapt\sql('d.date_deleted'), 'is', new \frameworks\adapt\sql('null')
                        )
                    )
                )
                ->order_by('priority');
                
                $results = $sql->execute()->results();
                
                $i = 1;
                
                foreach($results as $result){
                    
                    $field_options = array(
                        'name' => 'contact_address[address_' . $i . '][]',
                        'label' => $result['name']
                    );
                    
                    if (isset($result['validator'])) $field_options['validator'] = $result['validator'];
                    if (isset($result['formatter'])) $field_options['formatter'] = $result['formatter'];
                    if (isset($result['unformatter'])) $field_options['unformatter'] = $result['unformatter'];
                    if (isset($result['max_length'])) $field_options['max_length'] = $result['max_length'];
                    
                    $field = new \extensions\forms\view_field_input($field_options);
                    $view->add($field);
                    
                    $field->find('label')->add_class('col-sm-4');
                    $control = $field->find('.form-control')->detach();
                    $field->add(new html_div($control->get(0), array('class' => 'col-sm-8')));
                    
                    $i++;
                }
                
                for($i; $i <= 10; $i++){
                    $view->add(new html_input(array('type' => 'hidden', 'name' => "contact_address[address_{$i}][]", 'value' => '')));
                }
                
            }
            
            
            return $view;
        }
        
    }
}

?>