<?php

/* Prevent Direct Access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];

$sql = $adapt->data_source->sql;

/* Create the tables */
$sql->create_table('contact')
    ->add('contact_id', 'bigint')
    ->add('country_id', 'bigint')
    ->add('title', 'varchar(32)')
    ->add('forename', 'name')
    ->add('middle_names', 'name')
    ->add('surname', 'name')
    ->add('nickname', 'varchar(32)')
    ->add('date_of_birth', 'date')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('contact_id')
    ->foreign_key('country_id', 'country', 'country_id')
    ->execute();

$sql->create_table('contact_phone')
    ->add('contact_phone_id', 'bigint')
    ->add('contact_id', 'bigint')
    ->add('country_phone_data_type_id', 'bigint')
    ->add('priority', 'int')
    ->add('phone_number', 'varchar(64)')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('contact_phone_id')
    ->foreign_key('contact_id', 'contact', 'contact_id')
    ->foreign_key('country_phone_data_type_id', 'country_phone_data_type', 'country_phone_data_type_id')
    ->execute();

$sql->create_table('contact_address_type')
    ->add('contact_address_type_id', 'bigint')
    ->add('bundle_name', 'varchar(128)')
    ->add('label', 'varchar(128)', false)
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('contact_address_type_id')
    ->execute();

$sql->create_table('contact_address')
    ->add('contact_address_id', 'bigint')
    ->add('contact_id', 'bigint')
    ->add('contact_address_type_id', 'bigint')
    ->add('priority', 'int')
    ->add('country_id', 'bigint')
    ->add('address_1', 'varchar(128)')
    ->add('address_2', 'varchar(128)')
    ->add('address_3', 'varchar(128)')
    ->add('address_4', 'varchar(128)')
    ->add('address_5', 'varchar(128)')
    ->add('address_6', 'varchar(128)')
    ->add('address_7', 'varchar(128)')
    ->add('address_8', 'varchar(128)')
    ->add('address_9', 'varchar(128)')
    ->add('address_10', 'varchar(128)')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('contact_address_id')
    ->foreign_key('contact_id', 'contact', 'contact_id')
    ->foreign_key('contact_address_type_id', 'contact_address_type', 'contact_address_type_id')
    ->foreign_key('country_id', 'country', 'country_id')
    ->execute();

$sql->create_table('contact_email_type')
    ->add('contact_email_type_id', 'bigint')
    ->add('bundle_name', 'varchar(128)')
    ->add('label', 'varchar(128)', false)
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('contact_email_type_id')
    ->execute();

$sql->create_table('contact_email')
    ->add('contact_email_id', 'bigint')
    ->add('contact_id', 'bigint')
    ->add('contact_email_type_id', 'bigint')
    ->add('priority', 'int')
    ->add('email', 'email_address')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('contact_email_id')
    ->foreign_key('contact_id', 'contact', 'contact_id')
    ->foreign_key('contact_email_type_id', 'contact_email_type', 'contact_email_type_id')
    ->execute();

/* Add the email types */
$model = new \model_contact_email_type();
$model->bundle_name = 'contacts';
$model->label = 'Home';
$model->save();

$model = new \model_contact_email_type();
$model->bundle_name = 'contacts';
$model->label = 'Office';
$model->save();
    

///* Lets create the form */
//$form = new \extensions\forms\model_form();
//$form->bundle_name = 'contacts';
//$form->name = 'contact';
//$form->style = 'Standard';
//$form->show_steps = 'No';
//$form->show_processing_page = 'No';
//
///* Add a page */
//$page = new \extensions\forms\model_form_page();
//$page->bundle_name = 'contacts';
//$page->priority = 1;
//$form->add($page);
//
///* Create a new section */
//$section = new \extensions\forms\model_form_page_section();
//$section->bundle_name = 'contacts';
//$section->priority = 1;
//$section->repeatable = 'No';
//$section->title = 'Personal details';
//$page->add($section);
//
///*
// * Field type ids
// */
//$hidden = new \model_form_field_type();
//$hidden->load_by_name('Hidden');
//$hidden = $hidden->form_field_type_id;
//
//$select = new \model_form_field_type();
//$select->load_by_name('Select');
//$select = $select->form_field_type_id;
//
//$text = new \model_form_field_type();
//$text->load_by_name('Text');
//$text = $text->form_field_type_id;
//
//$country = new \model_form_field_type();
//$country->load_by_name('Country');
//$country = $country->form_field_type_id;
//
///* Create a field for contact_id */
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 1;
//$field->form_field_type_id = $hidden;
//$field->name = "contact[content_id]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('bigint');
//$section->add($field);
//
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 2;
//$field->form_field_type_id = $country;
//$field->name = "contact[country_id]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('bigint');
//$field->lookup_table = 'country';
//$field->label = 'Country';
//$field->mandatory = 'Yes';
//$section->add($field);
//
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 2;
//$field->form_field_type_id = $select;
//$field->name = "contact[title]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('name');
//$field->max_length = 12;
//$field->allowed_values = json_encode(array('Mr', 'Mrs', 'Ms', 'Miss'));
//$field->label = 'Title';
//$field->mandatory = 'Yes';
//$section->add($field);
//
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 3;
//$field->form_field_type_id = $text;
//$field->name = "contact[forename]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('name');
//$field->max_length = 32;
//$field->label = 'Forename';
//$field->placeholder_label = 'First name...';
//$field->mandatory = 'Yes';
//$section->add($field);
//
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 4;
//$field->form_field_type_id = $text;
//$field->name = "contact[middle_names]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('name');
//$field->max_length = 64;
//$field->label = 'Middle name(s)';
//$field->placeholder_label = 'Middle names...';
//$field->mandatory = 'No';
//$section->add($field);
//
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 5;
//$field->form_field_type_id = $text;
//$field->name = "contact[surname]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('name');
//$field->max_length = 32;
//$field->label = 'Surname';
//$field->placeholder_label = 'Family name...';
//$field->mandatory = 'Yes';
//$section->add($field);
//
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 6;
//$field->form_field_type_id = $text;
//$field->name = "contact[nickname]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('name');
//$field->max_length = 32;
//$field->label = 'Nickname';
//$field->description = "What do your friends call you?";
//$field->placeholder_label = 'Nickname?...';
//$field->mandatory = 'No';
//$section->add($field);
//
//$field = new \extensions\forms\model_form_page_section_field();
//$field->bundle_name = 'contacts';
//$field->priority = 7;
//$field->form_field_type_id = $text;
//$field->name = "contact[date_of_birth]";
//$field->data_type_id = $adapt->data_source->get_data_type_id('date');
//$field->label = 'Date of birth';
//$field->placeholder_label = 'dd/mm/yyyy';
//$field->mandatory = 'Yes';
//$section->add($field);




?>