<?php

namespace adapt\contacts{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class view_form_page_contact extends \adapt\view{
        
        public function __construct($data = array(), $title = 'Contact information', $description = '', $step_label = 'Contact info', $step_description = ''){
            parent::__construct('div');
            $this->add_class('form_page col-xs-12');
            
            if (!is_null($title)) $this->add(new \bootstrap_views\view_h2($title));
            if (!is_null($description)) $this->add(new \bootstrap_views\view_p($description));
            if (!is_null($step_label)) $this->attr('data-step-label', $step_label);
            if (!is_null($step_description)) $this->attr('data-step-description', $step_description);
            
            $this->set_id();
            
            $this->add(new html_div(array('class' => 'error-panel')));
            
            $section = new \adapt\forms\view_form_page_section('Personal information');
            $section->add_class('clearfix');
            $this->add($section);
            
            /* Add contact_id */
            $this->add(new html_input(array('type' => 'hidden', 'name' => 'contact[contact_id]', 'value' => isset($data['contact']) && isset($data['contact']['contact_id']) ? $data['contact']['contact_id'] : '')));
            
            /* Add country_id */
            $country_id = null;
            if (strtolower($this->setting('contacts.show_country_id_field')) == 'yes'){
                $sql = $this->data_source->sql;
                $sql->select('*')
                    ->from('country', 'c')
                    ->where(
                        new \adapt\sql_condition($this->data_source->sql('c.date_deleted'), 'is', $this->data_source->sql('null'))
                    )
                    ->order_by('c.label');
                
                $results = $sql->execute()->results();
                
                $items = array();
                
                foreach($results as $result){
                    $items[$result['country_id']] = $result['label'];
                }
                
                $value = null;
                if (isset($data['contact']) && isset($data['contact']['contact_id'])){
                    $value = $data['contact']['contact_id'];
                }else{
                    $label = $this->setting('contacts.default_country_name');
                    
                    if (isset($label) && $label != ''){
                        /* Lets find the country */
                        $sql = $this->data_source->sql;
                        $sql->select('country_id')
                            ->from('country')
                            ->where(
                                new \adapt\sql_and(
                                    new \adapt\sql_condition(
                                        new \adapt\sql('date_deleted'),
                                        'is',
                                        new \adapt\sql('null')
                                    ),
                                    new \adapt\sql_condition(
                                        new \adapt\sql('label'),
                                        '=',
                                        $label
                                    )
                                )
                            );
                        
                        $results = $sql
                            ->execute()
                            ->results();
                        
                        
                        if (is_array($results) && count($results)){
                            $value = $results[0]['country_id'];
                        }
                    }
                }
                $country_id = $value;
                
                $section->add(
                    new \bootstrap_views\view_cell(
                        new \adapt\forms\view_field_select(
                            array(
                                'name' => 'contact[country_id]',
                                'mandatory' => 'Yes',
                                'allowed_values' => $items,
                                'label' => 'Country',
                                'value' => $value
                            )
                        ),
                        12, 6, 4, 3
                    )
                );
                
            }else{
                /* Hidden field */
                $value = null;
                if (isset($data['contact']) && isset($data['contact']['contact_id'])){
                    $value = $data['contact']['contact_id'];
                }else{
                    $label = $this->setting('contacts.default_country_name');
                    
                    if (isset($label) && $label != ''){
                        /* Lets find the country */
                        $results = $this->data_source->sql
                            ->select('country_id')
                            ->from('country')
                            ->where(
                                new \adapt\sql_and(
                                    new \adapt\sql_condition(
                                        new \adapt\sql('date_deleted'),
                                        'is',
                                        new \adapt\sql('null')
                                    ),
                                    new \adapt\sql_condition(
                                        new \adapt\sql('label'),
                                        '=',
                                        $label
                                    )
                                )
                            )
                            ->execute()
                            ->results();
                        
                        if (is_array($results) && count($results)){
                            $value = $results[0]['country_id'];
                        }
                    }
                }
                
                $country_id = $value;
                
                $section->add(new html_input(array('type' => 'hidden', 'name' => 'contact[country_id]', 'value' => $value)));
            }
            
            
            /* Title field */
            if (strtolower($this->setting('contacts.show_title')) == 'yes'){
                $section->add(
                    new \bootstrap\views\view_cell(
                        new \forms\view_field_select(
                            array(
                                'name' => 'contact[title]',
                                'label' => 'Title',
                                'mandatory' => 'Yes',
                                'allowed_values' => array('Mr', 'Mrs', 'Miss', 'Ms')
                            )
                        ),
                        12, 6, 4, 3
                    )
                );
            }
            
            /* Forename */
            $section->add(
                new \bootstrap\views\view_cell(
                    new \adapt\forms\view_field_input(
                        array(
                            'name' => 'contact[forename]',
                            'label' => 'Forename',
                            'mandatory' => 'Yes',
                            'validator' => 'name',
                            'formatter' => 'name',
                            'placeholder_label' => 'Firstname'
                        )
                    ),
                    12, 6, 4, 3
                )
            );
            
            /* Middle names */
            if (strtolower($this->setting('contacts.show_middle_names')) == 'yes'){
                $section->add(
                    new \bootstrap\views\view_cell(
                        new \adapt\forms\view_field_input(
                            array(
                                'name' => 'contact[middle_names]',
                                'label' => 'Middle name(s)',
                                'validator' => 'name',
                                'formatter' => 'name',
                                'placeholder_label' => 'Middle name(s)'
                            )
                        ),
                        12, 6, 4, 3
                    )
                );
            }
            
            /* Surname */
            $section->add(
                new \bootstrap\views\view_cell(
                    new \adapt\forms\view_field_input(
                        array(
                            'name' => 'contact[surname]',
                            'label' => 'Surname',
                            'mandatory' => 'Yes',
                            'validator' => 'name',
                            'formatter' => 'name',
                            'placeholder_label' => 'Surname'
                        )
                    ),
                    12, 6, 4, 3
                )
            );
            
            /* Nickname */
            if (strtolower($this->setting('contacts.show_nickname')) == 'yes'){
                $section->add(
                    new \bootstrap\views\view_cell(
                        new \adapt\forms\view_field_input(
                            array(
                                'name' => 'contact[nickname]',
                                'label' => 'Known as',
                                'placeholder_label' => 'Nickname'
                            )
                        ),
                        12, 6, 4, 3
                    )
                );
            }
            
            /* Date of birth */
            if (strtolower($this->setting('contacts.show_date_of_birth')) == 'yes'){                
                $values = array(
                    'name' => 'contact[date_of_birth]',
                    'label' => 'Date of birth',
                    'validator' => $this->setting('locales.default_date_format'),
                    'formatter' => $this->setting('locales.default_date_format'),
                    'placeholder_label' => '...'
                );
                
                if (strtolower($this->setting('contacts.date_of_birth_mandatory')) == 'yes') $values['mandatory'] = 'Yes';
                
                $data_type = $this->data_source->get_data_type($this->setting('locales.default_date_format'));
                if (is_array($data_type) && isset($data_type['datetime_format'])){
                    $format = strtolower($data_type['datetime_format']);
                    $format = str_replace('d', 'dd', $format);
                    $format = str_replace('m', 'mm', $format);
                    $format = str_replace('y', 'yyyy', $format);
                    $format = str_replace('h', 'hh', $format);
                    $format = str_replace('i', 'mm', $format);
                    $values['placeholder_label'] = $format;
                }
                
                $section->add(new \bootstrap\views\view_cell(new \adapt\forms\view_field_input($values), 12, 6, 4, 3));
            }
            
            /*
             * Add contact information section
             */
            $section = new \adapt\forms\view_form_page_section('Contact information');
            $section->add_class('clearfix');
            $this->add($section);
            
            /* Phone number */
            if(strtolower($this->setting('contacts.show_phone')) == 'yes'){
                /* Get a list of phone types */
                if (is_numeric($country_id)){
                    $sql = $this->data_source->sql;
                    $sql->select(array('id' => 'c.country_phone_data_type_id', 'name' => 'c.label', 'validator' => 'd.validator', 'formatter' => 'd.formatter', 'unformatter' => 'd.unformatter'))
                        ->from('country_phone_data_type', 'c')
                        ->join('data_type', 'd', 'data_type_id')
                        ->where(
                            new \adapt\sql_and(
                                new \adapt\sql_condition(
                                    new \adapt\sql('c.country_id'), '=', $country_id
                                ),
                                new \adapt\sql_condition(
                                    new \adapt\sql('c.date_deleted'), 'is', new \frameworks\adapt\sql('null')
                                )
                            )
                        )
                        ->order_by('c.label');
                    $results = $sql->execute()->results();
                    
                    $phone_types = array();
                    
                    if (is_array($results)){
                        foreach($results as $result){
                            $phone_types[$result['id']] = $result['name'];
                        }
                    }
                    
                    $values = array(
                        'name' => 'contact_phone[country_phone_data_type_id][]',
                        'label' => 'Phone',
                        'allowed_values' => $phone_types
                    );
                    
                    if (strtolower($this->setting('contacts.phone_mandatory')) == 'yes') $values['mandatory'] = 'Yes';
                    
                    
                    $type_field = new \adapt\forms\view_field_select($values);
                    
                    //$section->add(
                    //    new \extensions\bootstrap_views\view_cell($field, 12, 6, 4, 3)
                    //);
                    
                    $phone_cell = new \bootstrap\views\view_row();
                    $phone_cell->add_class('field-input contacts phone-group form-group');
                    $section->add(new \bootstrap\views\view_cell($phone_cell, 12, 6, 4, 3));
                    
                    $phone_cell->add(new html_label('Phone', array('class' => 'col-xs-12')));
                    
                    $phone_cell->add(new html_div(array('class' => 'phone-content')));
                    
                    $new_label = new \bootstrap\views\view_cell('Add phone number', 10);
                    $new_icon = new \bootstrap\views\view_cell(new html_a(new \font_awesome\views\view_icon('plus-circle', \font_awesome\views\view_icon::LARGE2X), array('href' => 'javascript: void(0);', 'title' => 'Add new phone number', 'class' => 'add-phone')), 2);
                    
                    $new_label->add_class('new desc');
                    $new_icon->add_class('new icon');
                    
                    $phone_cell->add(
                        array(
                            $new_label,
                            $new_icon
                        )
                    );
                    
                }
            }
            
            
            /* Email address */

            /* Get a list of phone types */
            //$sql = $this->data_source->sql;
            //$sql->select(array('id' => 'c.country_phone_data_type_id', 'name' => 'c.label', 'validator' => 'd.validator', 'formatter' => 'd.formatter', 'unformatter' => 'd.unformatter'))
            //    ->from('country_phone_data_type', 'c')
            //    ->join('data_type', 'd', 'data_type_id')
            //    ->where(
            //        new \frameworks\adapt\sql_and(
            //            new \frameworks\adapt\sql_condition(
            //                new \frameworks\adapt\sql('c.country_id'), '=', $country_id
            //            ),
            //            new \frameworks\adapt\sql_condition(
            //                new \frameworks\adapt\sql('c.date_deleted'), 'is', new \frameworks\adapt\sql('null')
            //            )
            //        )
            //    )
            //    ->order_by('c.label');
            //$results = $sql->execute()->results();
            //
            //$phone_types = array();
            //
            //if (is_array($results)){
            //    foreach($results as $result){
            //        $phone_types[$result['id']] = $result['name'];
            //    }
            //}
            //
            //$values = array(
            //    'name' => 'contact_phone[country_phone_data_type_id][]',
            //    'label' => 'Phone',
            //    'allowed_values' => $phone_types
            //);
            //
            //if (strtolower($this->setting('contacts.phone_mandatory')) == 'yes') $values['mandatory'] = 'Yes';
            //
            //
            //$type_field = new \extensions\forms\view_field_select($values);
            
            //$section->add(
            //    new \extensions\bootstrap_views\view_cell($field, 12, 6, 4, 3)
            //);
            
            $email_cell = new \bootstrap\views\view_row();
            $email_cell->add_class('field-input contacts email-group form-group');
            $section->add(new \bootstrap\views\view_cell($email_cell, 12, 6, 4, 3));
            
            $email_cell->add(new html_label('Email', array('class' => 'col-xs-12')));
            
            $email_cell->add(new html_div(array('class' => 'email-content')));
            
            $new_label = new \bootstrap\views\view_cell('Add email address', 10);
            $new_icon = new \bootstrap\views\view_cell(new html_a(new \font_awesome\views\view_icon('plus-circle', \font_awesome\views\view_icon::LARGE2X), array('href' => 'javascript: void(0);', 'title' => 'Add new email address', 'class' => 'add-email')), 2);
            
            $new_label->add_class('new desc');
            $new_icon->add_class('new icon');
            
            $email_cell->add(
                array(
                    $new_label,
                    $new_icon
                )
            );
            
            
            /*
             * Add address information
             */
            $section = new \adapt\forms\view_form_page_section('Address');
            $section->add_class('clearfix');
            $this->add($section);
            
            //$address_cell = new \extensions\bootstrap_views\view_row();
            //$address_cell->add_class('field-input contacts address-group form-group');
            //$section->add(new \extensions\bootstrap_views\view_cell($address_cell, 12, 6, 6, 6));
            //
            //$address_cell->add(new html_label('Address', array('class' => 'col-xs-12')));
            //
            //$address_cell->add(new html_div(array('class' => 'address-content')));
            //
            //$new_label = new \extensions\bootstrap_views\view_cell('Add address', 10);
            //$new_icon = new \extensions\bootstrap_views\view_cell(new html_a(new \extensions\font_awesome_views\view_icon('plus-circle', \extensions\font_awesome_views\view_icon::LARGE2X), array('href' => 'javascript: void(0);', 'title' => 'Add new address', 'class' => 'add-address')), 2);
            //
            //$new_label->add_class('new desc');
            //$new_icon->add_class('new icon');
            //
            //$address_cell->add(
            //    array(
            //        $new_label,
            //        $new_icon
            //    )
            //);
            
            if (is_numeric($country_id)){
                $section->add(new html_input(array('type' => 'hidden', 'name' => 'contact_address[contact_address_id][]')));
                $section->add(new html_input(array('type' => 'hidden', 'name' => 'contact_address[contact_id][]')));
                $section->add(new html_input(array('type' => 'hidden', 'name' => 'contact_address[priority][]')));
                
                //TODO: country_id
                
                /* Get the address types */
                $sql = $this->data_source->sql;
                $sql->select(array('id' => 'contact_address_type_id', 'name' => 'label'))
                    ->from('contact_address_type')
                    ->where(
                        new \adapt\sql_condition(
                            new \adapt\sql('date_deleted'),
                            'is',
                            new \adapt\sql('null')
                        )
                    )
                    ->order_by('label');
                
                $results = $sql->execute()->results();
                
                $types = array();
                
                foreach($results as $result){
                    $types[$result['id']] = $result['name'];
                }
                
                $field = new \adapt\forms\view_field_select(
                    array(
                        'name' => 'contact_address[contact_address_type_id][]',
                        'mandatory' => 'Yes',
                        'allowed_values' => $types,
                        'label' => 'Address type',
                        'value' => ''
                    )
                );
                
                /* Make the field hoizonal */
                //$field->find('label')->add_class('col-sm-4');
                //$control = $field->find('.form-control')->detach();
                //$field->add(new html_div($control->get(0), array('class' => 'col-sm-8')));
                
                $section->add(new \bootstrap\views\view_cell($field, 12, 6, 4, 3));
                
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
                    new \adapt\sql_and(
                        new \adapt\sql_condition(
                            new \adapt\sql('c.country_id'), '=', $country_id
                        ),
                        new \adapt\sql_condition(
                            new \adapt\sql('c.date_deleted'), 'is', new \adapt\sql('null')
                        ),
                        new \adapt\sql_condition(
                            new \adapt\sql('d.date_deleted'), 'is', new \adapt\sql('null')
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
                    
                    $field = new \adapt\forms\view_field_input($field_options);
                    $section->add(new \bootstrap\views\view_cell($field, 12, 6, 4, 3));
                    
                    //$field->find('label')->add_class('col-sm-4');
                    //$control = $field->find('.form-control')->detach();
                    //$field->add(new html_div($control->get(0), array('class' => 'col-sm-8')));
                    
                    $i++;
                }
                
                for($i; $i <= 10; $i++){
                    $section->add(new html_input(array('type' => 'hidden', 'name' => "contact_address[address_{$i}][]", 'value' => '')));
                }
                
            }
        }
        
    }

}

?>