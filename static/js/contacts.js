(function($){
    
    /*
     * We need to check when the country changes
     * so that we can update our fields as required.
     */
    $(document).on(
        'change',
        "select[name='contact\\[country_id\\]']",
        function(event){
            
            alert('Update regional fields');
            
        }
    );
    
    $(document).on(
        'click',
        '.phone-group .add-phone',
        function(event){
            var $this = $(this);
            var $container = $(this).parents('.phone-group').find('.phone-content');
            var country_id = $(this).parents('.form-page-contact').find('[name="contact\\[country_id\\]"]').val();
            
            var $group = $('<div class="phone-input-set"></div>');
            
            $this.parents('.phone-group').find('.fa-rotate-90').removeClass('fa-rotate-90');
            
            var $input_group = $('<div class="input-group col-xs-10"><div class="input-group-btn"></div></div>');
            $input_group.find('.input-group-btn').append('<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-circle-o-notch fa-spin"></span></button>');
            $input_group.find('.input-group-btn').append('<ul class="dropdown-menu phone-type-selector"></ul>');
            $input_group.append('<input type="text" class="form-control" name="contact_phone[phone_number][]" placeholder="Phone number">');
            
            $group.append($input_group);
            $group.append('<div class="view cell col-xs-2"><a href="javascript: void(0);" title="Remove phone number" class="phone-remove"><span class="fa fa-minus-circle fa-2x"></span></a></div>');
            
            /* Add hidden fields to the group */
            //var priority = $container.children().size() + 1;
            
            
            $group.append('<input type="hidden" name="contact_phone[country_phone_data_type_id][]" value="">');
            //$group.append('<input type="hidden" name="contact_phone[priority][]" value="' + priority + '">');
            $group.append('<input type="hidden" name="contact_phone[priority][]" value="">');
            $group.append('<input type="hidden" name="contact_phone[contact_id][]" value="">');
            $group.append('<input type="hidden" name="contact_phone[contact_phone_id][]" value="">');
            
            $container.append($group);
            
            var url = "/_contacts/phone-type-dropdown?country_id=" + country_id;
            
            $.get(
                url,
                function(data){
                    var $data = $(data);
                    var $item = $data.find('a').first();
                    
                    $input_group.find('ul.dropdown-menu').replaceWith($data);
                    $input_group.find('button').empty().append($data.find('a').first().text()).append(' ').append('<span class="caret"></span>');
                    $input_group.find('input')
                        .attr('data-validator', $item.attr('data-validator'))
                        .attr('data-formatter', $item.attr('data-formatter'))
                        .attr('data-unformatter', $item.attr('data-unformatter'));
                    $group.find('[name="contact_phone\\[country_phone_data_type_id\\]\\[\\]"]').val($item.attr('data-id'));
                }
            );
        }
    );
    
    $(document).on(
        'click',
        '.phone-group .phone-type-selector a',
        function(event){
            var $item = $(this);
            var $input_group = $item.parents('.input-group');
            var $group = $input_group.parents('.phone-input-set');
            
            $input_group.find('button').empty().append($item.text()).append(' ').append('<span class="caret"></span>');
            $input_group.find('input')
                .attr('data-validator', $item.attr('data-validator'))
                .attr('data-formatter', $item.attr('data-formatter'))
                .attr('data-unformatter', $item.attr('data-unformatter'));
            $group.find('[name="contact_phone\\[country_phone_data_type_id\\]\\[\\]"]').val($item.attr('data-id'));
            //TODO: Revalidate
        }
    );
    
    $(document).on(
        'click',
        '.phone-group .phone-remove',
        function (event){
            var $this = $(this);
            if ($this.find('.fa-minus-circle').hasClass('fa-rotate-90')){
                
                $this.parents('.phone-input-set').slideUp(
                    'slow',
                    function(){
                        $(this).detach();
                    }
                );
                
            }else{
                /* Remove the class from any other items */
                $this.parents('.phone-group').find('.fa-rotate-90').removeClass('fa-rotate-90');
                $this.find('.fa-minus-circle').addClass('fa-rotate-90');
            }
        }
    );
    
    
    $(document).on(
        'click',
        '.email-group .add-email',
        function(event){
            var $this = $(this);
            var $container = $(this).parents('.email-group').find('.email-content');
            
            var $group = $('<div class="email-input-set"></div>');
            
            $this.parents('.email-group').find('.fa-rotate-90').removeClass('fa-rotate-90');
            
            var $input_group = $('<div class="input-group col-xs-10"><div class="input-group-btn"></div></div>');
            $input_group.find('.input-group-btn').append('<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-circle-o-notch fa-spin"></span></button>');
            $input_group.find('.input-group-btn').append('<ul class="dropdown-menu email-type-selector"></ul>');
            $input_group.append('<input type="text" class="form-control" name="contact_email[email][]" placeholder="Email address">');
            
            $group.append($input_group);
            $group.append('<div class="view cell col-xs-2"><a href="javascript: void(0);" title="Remove email address" class="email-remove"><span class="fa fa-minus-circle fa-2x"></span></a></div>');
            
            /* Add hidden fields to the group */
            //var priority = $container.children().size() + 1;
            
            $group.append('<input type="hidden" name="contact_email[contact_email_id][]" value="">');
            $group.append('<input type="hidden" name="contact_email[priority][]" value="">');
            $group.append('<input type="hidden" name="contact_email[contact_id][]" value="">');
            $group.append('<input type="hidden" name="contact_email[contact_email_type_id][]" value="">');
            
            $container.append($group);
            
            var url = "/_contacts/email-type-dropdown";
            
            $.get(
                url,
                function(data){
                    var $data = $(data);
                    var $item = $data.find('a').first();
                    
                    $input_group.find('ul.dropdown-menu').replaceWith($data);
                    $input_group.find('button').empty().append($data.find('a').first().text()).append(' ').append('<span class="caret"></span>');
                    $input_group.find('input')
                        .attr('data-validator', $item.attr('data-validator'))
                        .attr('data-formatter', $item.attr('data-formatter'))
                        .attr('data-unformatter', $item.attr('data-unformatter'));
                    $group.find('[name="contact_email\\[contact_email_type_id\\]\\[\\]"]').val($item.attr('data-id'));
                }
            );
        }
    );
    
    $(document).on(
        'click',
        '.email-group .email-type-selector a',
        function(event){
            var $item = $(this);
            var $input_group = $item.parents('.input-group');
            var $group = $input_group.parents('.email-input-set');
            
            $input_group.find('button').empty().append($item.text()).append(' ').append('<span class="caret"></span>');
            $input_group.find('input')
                .attr('data-validator', $item.attr('data-validator'))
                .attr('data-formatter', $item.attr('data-formatter'))
                .attr('data-unformatter', $item.attr('data-unformatter'));
            $group.find('[name="contact_email\\[contact_email_type_id\\]\\[\\]"]').val($item.attr('data-id'));
            //TODO: Revalidate
        }
    );
    
    $(document).on(
        'click',
        '.email-group .email-remove',
        function (event){
            var $this = $(this);
            if ($this.find('.fa-minus-circle').hasClass('fa-rotate-90')){
                
                $this.parents('.email-input-set').slideUp(
                    'slow',
                    function(){
                        $(this).detach();
                    }
                );
                
            }else{
                /* Remove the class from any other items */
                $this.parents('.email-group').find('.fa-rotate-90').removeClass('fa-rotate-90');
                $this.find('.fa-minus-circle').addClass('fa-rotate-90');
            }
        }
    );
    
    
    $(document).on(
        'click',
        '.address-group .add-address',
        function(event){
            var $this = $(this);
            var $container = $(this).parents('.address-group').find('.address-content');
            var country_id = $(this).parents('.form-page-contact').find('[name="contact\\[country_id\\]"]').val();
            var $group = $('<div class="address-input-set"></div>');
            
            $this.parents('.address-group').find('.fa-rotate-90').removeClass('fa-rotate-90');
            console.log('Adding address');
            
            $container.append($group);
            
            var url = "/_contacts/address_field?country_id=" + country_id;
            
            $.get(
                url,
                function(data){
                    var $data = $(data);
                    
                    $data.addClass('col-xs-10');
                    $group.append($data);
                }
            );
            
            
            return;
            var $input_group = $('<div class="input-group col-xs-10"><div class="input-group-btn"></div></div>');
            $input_group.find('.input-group-btn').append('<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-circle-o-notch fa-spin"></span></button>');
            $input_group.find('.input-group-btn').append('<ul class="dropdown-menu email-type-selector"></ul>');
            $input_group.append('<input type="text" class="form-control" name="contact_email[email][]" placeholder="Email address">');
            
            $group.append($input_group);
            $group.append('<div class="view cell col-xs-2"><a href="javascript: void(0);" title="Remove email address" class="email-remove"><span class="fa fa-minus-circle fa-2x"></span></a></div>');
            
            /* Add hidden fields to the group */
            //var priority = $container.children().size() + 1;
            
            $group.append('<input type="hidden" name="contact_email[contact_email_id][]" value="">');
            $group.append('<input type="hidden" name="contact_email[priority][]" value="">');
            $group.append('<input type="hidden" name="contact_email[contact_id][]" value="">');
            $group.append('<input type="hidden" name="contact_email[contact_email_type_id][]" value="">');
            
            $container.append($group);
            
            var url = "/_contacts/email-type-dropdown";
            
            $.get(
                url,
                function(data){
                    var $data = $(data);
                    var $item = $data.find('a').first();
                    
                    $input_group.find('ul.dropdown-menu').replaceWith($data);
                    $input_group.find('button').empty().append($data.find('a').first().text()).append(' ').append('<span class="caret"></span>');
                    $input_group.find('input')
                        .attr('data-validator', $item.attr('data-validator'))
                        .attr('data-formatter', $item.attr('data-formatter'))
                        .attr('data-unformatter', $item.attr('data-unformatter'));
                    $group.find('[name="contact_email\\[contact_email_type_id\\]\\[\\]"]').val($item.attr('data-id'));
                }
            );
        }
    );
    
    
})(jQuery);