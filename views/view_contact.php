<?php

namespace adapt\contacts{
    
    /* Prevent direct access */
    defined('ADAPT_STARTED') or die;
    
    class view_contact extends view{
        
        public function __construct($model_data, $editable = false){
            parent::__construct('div');
            
            if (is_array($model_data)){
                
                if ($editable == true){
                    
                    $form = new model_form();
                    $form->load_by_name('contact');
                    $view = $form->get_view($model_data);
                    $this->add($view);
                    
                    //$data = array(
                    //    'title' => 'Contact information'
                    //);
                    //
                    //$form_section = new \adapt\forms\view_form_page_section($data, $model_data);
                    //$this->add($form_section);
                    //
                    //$layout_engine = new \adapt\forms\view_section_layout_three_col(array());
                    //$form_section->add_layout_engine($layout_engine);
                    //
                    //$form_group = new \adapt\forms\view_form_page_section_group(array(), $model_data);
                    //$form_section->add($form_group);
                    //
                    //$layout_engine = new \adapt\forms\view_group_layout_simple(array());
                    //$form_group->add_layout_engine($layout_engine);
                    //
                    //$field = $this->data_source->get_field_structure('contact', 'forenames');
                    //
                    //$data = array(
                    //    'name' => "contact[forenames]",
                    //    'label' => "Forenames"
                    //);
                    //
                    //$field_view = new \adapt\forms\view_field_input($data, $this->data_source->get_data_type($field['data_type_id']), $model_data);
                    //$form_group->add($field_view);
                    
                }else{
                    $this->add(new html_pre(print_r($model_data, true)));
                }
                
            }else{
                $this->add_class('hidden');
                $this->error("data must be a hash array");
            }
        }
        
    }
    
}

?>