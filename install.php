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

?>