<?php

namespace extensions\contacts;
use \frameworks\adapt as adapt;

/* Prevent direct access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];

/*
 * Include  css & javascript
 */
$adapt->dom->head->add(new adapt\html_link(array('type' => 'text/css', 'rel' => 'stylesheet', 'href' => '/adapt/extensions/contacts/static/css/contacts.css')));
$adapt->dom->head->add(new adapt\html_script(array('type' => 'text/javascript', 'src' => '/adapt/extensions/contacts/static/js/contacts.js')));


/*
 * Lets register a view on the root controller
 * to handle ajax updates
 */


\application\controller_root::extend('view__contacts', function($_this){
    /*
     * The view name has double _'s, this is so the view is accessed
     * via <HOST>/_contacts and not <HOST>/contacts because this controller
     * is for background requests and not foreground displays.
     *
     * Adapt does not define a direct way to add a background controller
     * but this method is considered clean and anyone looking to duplicate
     * this functionality should copy this example.
     *
     * Other things to note, the namespace is defined as \application, this
     * namespace doesn't exist, it is an alias of the current running application,
     * this allows you to access key componets of the application, such as the
     * root controller without needing to workout the bundle name of the
     * running application.
     * 
     */
    return $_this->load_controller('\\extensions\\contacts\\controller_contacts');
});

?>