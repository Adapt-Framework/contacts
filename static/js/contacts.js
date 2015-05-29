(function($){
    
    /*
     * We need to check when the country changes
     * so that we can update our fields as required.
     */
    $(document).on(
        'change',
        "select[name='contact[country_id]']",
        function(event){
            
            alert('Update regional fields');
            
        }
    );
    
    
})(jQuery);