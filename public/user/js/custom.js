/**
Business Type
*************/
var length = $("#overlay").length;


$(document).ajaxSend(function() {
    if(length > 0){
        $("#overlay").fadeIn(300);
    }
});

$( document ).ajaxComplete(function() {
    if(length > 0){
       setTimeout(function(){
        $("#overlay").fadeOut(300);
       },500);
    }
});

$('#submit-business-type').click(function(){
    var url = $('.business-types-form').attr('action');
    var redirect_url = $('.business-types-form').attr('data-redirect-url');
    $.ajax ({
       type: 'POST',
       url: url,
       async: false,
       data: $('.business-types-form').serialize(),
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
       success : function(response) {
           $('#custom-modal').modal('hide');
           toaserMessage(response.status, response.message);
           window.location.href = redirect_url;
       },
       error: function (reject) {
           if( reject.status === 422 ) {
               var errors = $.parseJSON(reject.responseText);
               errors = errors['errors'];
               toaserMessage(422, Object.values(errors)[0]);
           }
       }
    }); 
});

function updateDirectorHeadings() {
    $('.additional_clone_fin').each(function(index) {
        $(this).find('.header-title-fin').text('Directors Personal Financial information : ' + (index + 1));
    });
}

function updateDirectorHeadingsOne() {
    $('.additional_clone').each(function(index) {
        $(this).find('.header-title-dir').text('Applicant/Director/Proprietor : ' + (index + 1));
    });
}

$("form").on("click", ".add_more_additional_fin", function() {
    var html = $('.additional_clone_fin:last').html();
    $('.additional_clone_fin:last').after('<div class="additional_clone_fin">' + html + '</div>');
    $(".additional_clone_fin:last").find('input').val('');
    $(".additional_clone_fin:last").find('select').val('');
    
    var total_div_available = $('.additional_clone_fin').length;
    if (total_div_available != 1) {
        $(".remove_add_s_fin").removeClass('d-none');
    }

    $(this).remove();
    updateDirectorHeadings(); // update numbers
    return false;
});

$("form").on("click", ".remove_add_s_fin", function() {
    $(this).closest(".additional_clone_fin").remove();
    
    $(".additional_clone_fin:last").find('.add_more_additional_fin').remove();
    $('<a href="javascript: void(0);" class="mr-2 rm-blk-add btn btn-xs btn-info add_more_additional_fin float-right text-white">  <i class="mdi mdi-plus"></i>Add more Applicant/Director/Proprietor Personal Financial Information</a>').insertAfter(".remove_add_s_fin:last");

    var total_div_available = $('.additional_clone_fin').length;
    if (total_div_available == 1) {
        $(".remove_add_s_fin").addClass('d-none');
    }

    updateDirectorHeadings(); // update numbers
});

/**
Inquiry Module
**************/
$(window).on('load', function() {
    if($('.sticky-checker').length == 1){
        setTimeout(function() {
            date = (new Date()).toISOString().split('T')[0];
            pop_up_date = localStorage.getItem("pop_up_date");
            if(pop_up_date != date)
            {
                localStorage.setItem("pop_up_date", date);
                $('#ask_a_question').modal('show');
            }
        }, 2000);
    }
});

$('select[name="purpose_of_visit"]').change(function(){
    var other = $('select[name="purpose_of_visit"] option:selected').text();
    if(other == "Other"){
        $('#message-box').removeClass('d-none');
    }else{
        $('#message-box').addClass('d-none');
    }
});

$('#submit-ask-inquiry').click(function(){
    var url = $('.inquiry-form').attr('action');
    $.ajax ({   
        type: 'POST',
        url: url,
        async: false,
        data: $(".inquiry-form").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function(){
            $('#submit-ask-inquiry').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Submit');
        },
        complete: function(){
            $('#submit-ask-inquiry').html('Submit');  
        },
        success : function(response) {
            $('#ask_a_question').modal('hide');
            $('.inquiry-form')[0].reset();
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('button[type="cancel"]').click(function(){
    $(this).closest('form')[0].reset();
});

/**
Favorites
*****************/
$(".content").on("click",".fvr-bs", function(){

    if($(this).find('i').hasClass('mdi-star-outline')){
        $(this).find('i').removeClass('mdi-star-outline').addClass('mdi-star');
    }else{
        $(this).find('i').removeClass('mdi-star').addClass('mdi-star-outline');
    }
    
    var id = $(this).closest('.card').attr('id');
    var url = $(this).attr('data-url');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {id:id,type:'business-proposal'},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$(".content").on("click",".fvr-resource", function(){

    if($(this).find('i').hasClass('mdi-star-outline')){
        $(this).find('i').removeClass('mdi-star-outline').addClass('mdi-star');
    }else{
        $(this).find('i').removeClass('mdi-star').addClass('mdi-star-outline');
    }
    
    var id = $(this).closest('.card').attr('id');
    var url = $(this).attr('data-url');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {id:id,type:'resources'},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

/**
Blog Categories
***************/

$('#blog-categories-add').click(function(){
    var url = $('#blog-categories-add').closest('form').attr('action');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $('#blog-categories-add').closest('form').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            $('#blog-categories-add').closest('form')[0].reset();
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('#blog-categories-update').click(function(){
    var url = $('#blog-categories-update').closest('form').attr('action');
    $.ajax ({
        type: 'PUT',
        url: url,
        async: false,
        data: $('#blog-categories-update').closest('form').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

/**
Count footable record
********************/

$('.cu-foo-count').change(function(){
    var count = $(this).find(':selected').attr('data-count');
    $('#record-count').html(count);
});

/**
Blog Add Or Update & Load More
*****************/

$("#image").change(function() {
  cropImage(this);
});

$('#blog-add').click(function(){
    var url = $('#blog-add').closest('form').attr('action');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $('#blog-add').closest('form').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            $('#blog-add').closest('form')[0].reset();
            $(".summernote-editor").summernote("reset");
            $('.my-cu-check-uncheck-array').removeAttr('checked');
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('#blog-update').click(function(){
    var url = $('#blog-update').closest('form').attr('action');
    $.ajax ({
        type: 'PUT',
        url: url,
        async: false,
        data: $('#blog-update').closest('form').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('#blog-loadmore').click(function(){
    var id = $('#my-list').find('.blog-row:last').attr('id');
    var url = $('#my-list').attr('data-url');
    var categories = $('.blog-checkbox:checked').map( function() {
        return this.value;
    }).get().join(",");
    
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {id:id, categories:categories},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                $(response.data).insertAfter(".blog-row:last").hide().fadeIn(700);
            }else{
                //toaserMessage(response.status, response.message);
            }
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$(".blog-checkbox").change(function() {
    blog_filter();    
}); 

// Category wise show blogs
if($('.blog-checkbox').length != 0){
    var url = $('#my-list').data('current-url');
    if(url.indexOf('category') != -1){
      var segment = url.split("/");
      var category = (segment[segment.length-1]);
      $('input[data-slug="'+category+'"]').attr('checked', 'checked');
      blog_filter();  
    }
}

function blog_filter(){
    var url = $('#my-list').attr('data-url');
    var categories = $('.blog-checkbox:checked').map( function() {
        return this.value;
    }).get().join(",");
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {categories:categories},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                $('#my-list').empty().append(response.data).hide().fadeIn(700);
            }else{
                toaserMessage(response.status, response.message);
            }
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
}


/**
Click View more button auto scroll
*********************************/
if($('#my-loadmore').length != 0){
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
           $('#my-loadmore').find('a').trigger('click');
        }
    });
}

/**
Click box to redirect
********************/
$(".container").on("click",".call-closest", function(){
    var url = $(this).attr('data-url');
    window.location.href = url;
});

/**
Resource Add Or Update
*********************/
$("#resource_image").change(function() {
  cropImage(this);
});

$('#resource').click(function(){
    var url = $('#resource').closest('form').attr('action');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $('#resource').closest('form').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            $('#resource').closest('form')[0].reset();
            $(".summernote-editor").summernote("reset");
            $('.my-cu-check-uncheck-array').removeAttr('checked');
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('#resource-update').click(function(){
    var url = $('#resource-update').closest('form').attr('action');
    $.ajax ({
        type: 'PUT',
        url: url,
        async: false,
        data: $('#resource-update').closest('form').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

/**
Filter Resources
***************/

//Category wise show resourecs
if($('#rs-listing-page').length != 0){
    var url = $('#my-list').data('current-url');
    if(url.indexOf('category') != -1){
        var segment = url.split("/");
        var category = (segment[segment.length-1]);
        $('option[data-slug="'+category+'"]').prop('selected', true);
        filter_resources();
    }
}

$('#filter-resource').click(function(){
    filter_resources();
});

$('#resource-loadmore').click(function(){
    var id = $('#my-list').find('.col-xl-4:last').attr('id');
    if($(this).is(".my")){
        filter_resources(id, 1);
    }else{
        filter_resources(id);
    }
});

function filter_resources(id="", my_resource=""){
    var category = $('select[name="category"]').val();
    var keyword = $('input[name="keyword"]').val();
    var url = $('#resource-loadmore').attr('data-url');
    
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {category:category, keyword:keyword, id:id, my_resource:my_resource},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                if(id == ""){
                    $('#my-list').empty();
                    $('#my-list').append(response.data).hide().fadeIn(700);
                }else{
                    $(response.data).insertAfter(".col-xl-4:last").hide().fadeIn(700);
                }

                /* if(response.count < 9){
                    $('#my-loadmore').css('display', 'none');
                }*/
                
            }else{
                //toaserMessage(response.status, response.message);
            }
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
}

/**
Business Proposal Filter
***********************/

//Category wise show business proposals
if($('#bp-listing-page').length != 0){
    var url = $('#my-list').data('current-url');
    if(url.indexOf('category') != -1){
        var segment = url.split("/");
        var category = (segment[segment.length-1]);
        $('option[data-slug="'+category+'"]').prop('selected', true);
        filter_business_proposal();
    }
}

$('#filter-business-proposal').click(function(){
    filter_business_proposal();
});

$('#bs-loadmore').click(function(){
    var id = $('#my-list').find('.col-xl-4:last').attr('id');
    if($(this).is(".my")){
        filter_business_proposal(id, 1);
    }else{
        filter_business_proposal(id);
    }
});

function filter_business_proposal(id="", my_proposal=""){
    var category = $('select[name="category"]').val();
    var keyword = $('input[name="keyword"]').val();
    var url = $('#bs-loadmore').attr('data-url');
    //$('#my-loadmore').css('display', 'block');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {category:category, keyword:keyword, id:id, my_proposal:my_proposal},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                if(id == ""){
                    $('#my-list').empty();
                    $('#my-list').append(response.data).hide().fadeIn(700);
                }else{
                    $(response.data).insertAfter(".col-xl-4:last").hide().fadeIn(700);
                }
                /*if(response.count < 9){
                    $('#my-loadmore').css('display', 'none');
                }*/
            }else{
                //toaserMessage(response.status, response.message);
                //$('#my-loadmore').css('display', 'none');
            }
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
}

/**
Login Manual
***********/
$('.login-manual').click(function(){
	$('.label-form-control').addClass('d-none');
   var phone = $(this).attr("data-phone");
   $('[name="phone"]').val(phone);
   var password = $(this).attr("data-password");
   $('[name="password"]').val(password);

   $('#login').click();
});


/**
Tab Open
********/
//$('.custom-select').select2();


/** 
Business Proposal Add
********************/

$("#profile_picture").change(function() {
  readImageURL(this, 'user-avtar');
  cropImage(this);
});

$('#update-personal-information').click(function(){
    var url = $('form[name="personal-information"]').attr('action');
    var form = $('form[name="personal-information"]')[0];
    var form_data = new FormData(form);
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: form_data,
        cache : false,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            toaserMessage(response.status, response.message);
            setTimeout(function() {
                location.reload();
            }, 5000);
            //window.location.href = url;
            /*toaserMessage(response.status, response.message);
            $('#my-profile-show').removeClass('d-none');
            $('#my-profile-text').addClass('d-none');*/
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('#btn-change-password').click(function(){
    var url = $('form[name="change-password"]').attr('action');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $('form[name="change-password"]').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
})

/**
Process Business Information
***************************/

$(".tab-content").on("click",'.paste-ev', function(){
   var text = $(this).attr('data-text');
   $(this).closest('span').next('input').val(text);
});

$(".tab-content").on("input",'input[name="position[]"]', function(){
    //var position = $(this).val();
    //$(this).closest('.additional_clone').find('.header-title').text(position);
});

$('#save-exit-loan-application').click(function(){
    $('#save-exit-loan-application').addClass('save-exit');
    var url = $(this).data('url');
    $('button[type="submit"]').trigger('click');
    
    var urls = $(this).data('urlexit');
    
    $.ajax ({
        type: 'POST',
        url: urls,
        async: false,
        data: {},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                setTimeout(function(){ window.location.href = url; }, 1000);
            }
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('#pr-first').click(function(){
    
    $('.error-block').remove();
    
    var url = $('#pr-first').data('url');
    var redirect_url = $('#pr-first').data('redirect');
    //$('input, select').removeClass('error-background');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $("#loan-application-first").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(save_exit_true()){
                if(response.status == 201){   
                    $('input[name="application_id"]').val(response.data.application_id);            
                    toaserMessage(response.status, response.message);
                    //window.location.href = redirect_url;
                    setTimeout(function(){ window.location.href = redirect_url; }, 2000);
                }    
            }
        },
        error: function (reject) {
            if(save_exit_true()){
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    
                    $.each(errors,function(field_name,error){
                        if(field_name == "year_established" || field_name == "business_structure" || field_name == "trade"){
                            $('select[name="'+field_name+'"]').next('span').after('<span class="help-block error-block text-danger"><small>'+error+'</small></span>');
                        }else if(field_name == "m_loan_amount"){
                            $('input[id="'+field_name+'"]').after('<span class="help-block error-block text-danger"><small>'+error+'</small></span>');  
                        }else{
                            $('input[name="'+field_name+'"]').after('<span class="help-block error-block text-danger"><small>'+error+'</small></span>');  
                        }
                    });
                    
                    
                    
                    
                    //$('[name="'+Object.keys(errors)[0]+'"]').addClass('error-background');
                    //console.log( Object.keys(errors)[0]);

                    //toaserMessage(422, Object.values(errors)[0]);
                }
            }
        }
    }); 
});

function check_mobile_number_validation_on_pr_second(){
    var mobile_numbers = $('input[name="mobile[]"]');
    var rv = true;
    $.each(mobile_numbers, function (key, val) {
        var mobile = $(this).val();
        var mobile_number = mobile.replace(/\s/g, '');
        if(mobile_number != ""){
            if( ($.isNumeric(mobile_number)) && (mobile_number.length == 10) ){
                return rv = true;
            }else{
                $(this).addClass('error-background');
                toaserMessage(401, "The mobile format is invalid.");
                return rv = false;
            } 
        }
    });
    return rv;
}

$('#pr-second').click(function(){

    if(check_mobile_number_validation_on_pr_second() == false){
        return false;
    }
    
    $('.error-block').remove();
    var url = $('#pr-second').data('url');
    var redirect_url = $('#pr-second').data('redirect');
    //$('input, select').removeClass('error-background');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $("#loan-application-second").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(save_exit_true()){
                if(response.status == 201){   
                    toaserMessage(response.status, response.message);
                    //window.location.href = redirect_url;
                    setTimeout(function(){ window.location.href = redirect_url; }, 2000);
                }  
            }  
        },
        error: function (reject) {
            if(save_exit_true()){
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    
                    $.each(errors,function(field_name,error){
                        
                        var field = field_name.replace(/[0-9]/g, '');
                        var number = field_name.replace(/\D/g, "");
                        field = field.replace('.', ''); 
                        
                        var string = error[0];
                        
                        var modifiedError = string.replace(/\.\d\s?/, ' ');
                        error_text = modifiedError.replace(/_/g, ' '); 
                       
                        
                        
                        if( (field == "title") || (field == "residential_status") || (field == "marital_status") || (field == "gender") || (field == "time_in_business") || (field == "time_at_business") ){
                            $('.additional_clone').eq(number).find('select[name="'+field+'[]"]').next('span').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        }else{
                            $('.additional_clone').eq(number).find('input[name="'+field+'[]"]').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        }
                        
                    });
                   
                }
            }
        }
    }); 
});

$('.remove-team-size').click(function(){
    var url = $(this).data('action');
    var team_id = $(this).attr('data-id');
    var application_id = $('input[name="application_id"]').val();
    $('input, select').removeClass('error-background');
    $('#team-'+team_id).remove();
    $(this).closest('.additional_clone').remove().fadeIn();

    $.ajax ({
        type: 'GET',
        url: url,
        async: false,
        data: {application_id:application_id},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){   
                toaserMessage(response.status, response.message);
            }    
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                var errors = Object.values(errors)[0];
                //var errors = errors[0].replace('.','').replace(/\d+/, '');
                toaserMessage(422, errors);
            }
        }
    }); 
});

$('input[name="finance_periods"]').click(function(){
    $('input[name="finance_periods"]').removeAttr('checked');
    $(this).attr('checked', 'checked');
});

$('#pr-third').click(function(){
    
    var url = $('#pr-third').data('url');
    var redirect_url = $('#pr-third').data('redirect');
    $('input, select').removeClass('error-background');
    $('.error-block').remove();
    
    /* 
    $("#loan-application-third").find('input[type="radio"]').each(function() {
        var className = $(this).attr('class');
        if(className == "purpose"){
            $(this).attr('name', "purpose[]");
        }
        if(className == "property_type"){
           $(this).attr('name', "property_type[]"); 
        }
    });
    */

    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $("#loan-application-third").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(save_exit_true()){
                if(response.status == 201){   
                    toaserMessage(response.status, response.message);
                    //window.location.href = redirect_url;
                    setTimeout(function(){ window.location.href = redirect_url; }, 2000);
                }   
            } 
        },
        error: function (reject) {
            if(save_exit_true()){
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    
                    $.each(errors,function(field_name,error){
                        if(field_name == "business_trade_year"){
                            $('select[name="'+field_name+'"]').next('span').after('<span class="help-block error-block text-danger"><small>'+error+'</small></span>');
                        }else if(field_name == "finance_periods" || field_name == "gross_income" || field_name == "total_expenses" || field_name == "net_income"){
                            $('input[name="'+field_name+'"]').after('<span class="help-block error-block text-danger"><small>'+error+'</small></span>');  
                        }else{
                            var field = field_name.replace(/[0-9]/g, '');
                            var number = field_name.replace(/\D/g, "");
                            field = field.replace('.', '');
                            
                            var string = error[0];
                            var modifiedError = string.replace(/\.\d\s?/, ' ');
                            error_text = modifiedError.replace(/_/g, ' '); 
                            
                            $('.d-property-sec').eq(number).find('input[name="'+field+'[]"]').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        }
                    });
                }
            }
        }
    }); 
});

$('#pr-four').click(function(){
    $('#overlay').fadeIn();
    $('.fetch-documents').remove();
    var url = $('#pr-four').data('url');
    var redirect_url = $('#pr-four').data('redirect');
    $('input, select').removeClass('error-background');
    $('.error-block').remove();

    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $("#loan-application-four").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(save_exit_true()){
                if(response.status == 201){   
                    toaserMessage(response.status, response.message);
                    //window.location.href = redirect_url;
                    setTimeout(function(){ window.location.href = redirect_url; }, 1000);
                }else{
                    toaserMessage(422, response.message);
                }  
            }  
        },
        error: function (reject) {
            if(save_exit_true()){
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    toaserMessage(422, Object.values(errors)[0]);
                }
            }
        }
    }); 
});

$(".gallery").on("click",".remove-document-img", function(){
    $(this).closest('div.col-3').remove();
})

$('.hard-remove-document-image').click(function(){
    var url = $(this).data('url');
    var document_id = $(this).attr('data-id');
    var application_id = $(this).attr('data-application-id');
    $(this).closest('div.col-3').remove();

    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {document_id:document_id, application_id:application_id},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){   
                toaserMessage(response.status, response.message);
            }    
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$(function() {
    var imagesPreview = function(input, placeToInsertImagePreview, document_type, pdf_placeholder) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    if(event.target.result.indexOf('data:application/pdf') != -1){
                        var show_image = pdf_placeholder;
                    }else{
                        var show_image = event.target.result;
                    }
                    var image = '<img class="rounded" src='+show_image+'><p class="remove-document-img  text-left font-20"><i class="mdi mdi-delete-outline"></i></p>';
                    var hidden_image = '<input type="hidden" name="image[]" value="'+event.target.result+'">';
                    var hidden_type = '<input type="hidden" name="document_type[]" value="'+document_type+'">';

                    $(placeToInsertImagePreview).append('<div class="col-3"><div class="item">'+hidden_image+hidden_type+image+'</div></div>');
                    //$($.parseHTML('<img height="125">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $('.upload-documents').on('change', function() {
        var position = $(this).attr('id');
        var pdf_placeholder = $(this).data('pdf-placeholder');
        imagesPreview(this, 'div#position-'+position, position, pdf_placeholder);
    });
    

    
});

$("body").on("click",".gallery .item", function(){
    
    var base64Image = $(this).find('input[name="image[]"]').attr('value');
    if (base64Image.indexOf('document/') > -1) {
        if(base64Image.indexOf('.pdf') > -1){
            var base64Image = $(this).find('a').attr('href');
        }else{
            var base64Image = $(this).find('img').attr('src');
        }
    }
    
    
    if(isValidURL(base64Image) == false){
        
        if (base64Image.indexOf('application/pdf') > -1) {
            
            // Remove the data URL prefix (e.g., 'data:application/pdf;base64,')
            const base64WithoutPrefix = base64Image.replace(/^data:application\/pdf;base64,/, '');
            
            // Convert the base64 string to a Uint8Array
            const byteCharacters = atob(base64WithoutPrefix);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
              byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            const byteArray = new Uint8Array(byteNumbers);
            
            // Create a Blob from the Uint8Array
            const blobPdf = new Blob([byteArray], { type: 'application/pdf' });
            var url = URL.createObjectURL(blobPdf);
            
            // Open the URL in a new tab
            window.open(url, '_blank');
            
        }else{
            // Remove the data URL prefix (e.g., 'data:image/jpeg;base64,')
            const base64WithoutPrefix = base64Image.replace(/^data:image\/(png|jpg|jpeg);base64,/, '');
            
            // Convert the base64 string to a Uint8Array
            const byteCharacters = atob(base64WithoutPrefix);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
              byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            const byteArray = new Uint8Array(byteNumbers);
            
            // Create a Blob from the Uint8Array
            const blob = new Blob([byteArray], { type: 'image/jpeg' }); // Adjust the type based on your image type
            var imageUrl = URL.createObjectURL(blob);
            // Open the URL in a new tab
            window.open(imageUrl, '_blank');
        }
        
        
    }else{
        var imageUrl = base64Image;
        // Open the URL in a new tab
        window.open(imageUrl, '_blank');
    }
    
    
})

$('.my-cu-check-uncheck').click(function(){
    var name = $(this).attr('name');
    var checked = $('input[name='+name+']').attr('checked');
    if(checked == 'checked'){
        $('input[name='+name+']').removeAttr('checked');
    }else{
        $('input[name='+name+']').attr('checked', 'checked');
    }
});

$('.my-cu-check-uncheck-array').click(function(){
    var name = $(this).attr('name');
    var checked = $(this).attr('checked');
    if(checked == 'checked'){
        $(this).removeAttr('checked');
    }else{
        $(this).attr('checked', 'checked');
    }
});

$('#pr-five').click(function(){
    $('.error-block').remove();
    if (confirm('Do you want to submit your loan application ?')) {
        var url = $('#pr-five').data('url');
        var redirect_url = $('#pr-five').data('redirect');
        $.ajax ({
            type: 'POST',
            url: url,
            async: false,
            data: $("#loan-application-five").serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success : function(response) {
                if(save_exit_true()){
                    if(response.status == 201){   
                        toaserMessage(response.status, response.message);
                        $('#settings').addClass('d-none');
                        $('#submit-success').removeClass('d-none');
                        //window.location.href = redirect_url;
                    }    
                }
            },
            error: function (reject) {
                if(save_exit_true()){
                    if( reject.status === 422 ) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];
                        //toaserMessage(422, Object.values(errors)[0]);
                        
                        $.each(errors,function(field_name,error){
                           $('input[name="'+field_name+'"]').closest('.checkbox').after('<span class="ml-1 help-block error-block text-danger"><small>'+error+'</small></span>'); 
                        });
                    
                    }
                }
            }
        });
    } 
});

/**
Update Assessor Review & status
*********************/

$('#assessor-review-note').click(function(){
    var urls = $('#assessor-write-review').attr('action');
    
    var status_vals = $('#status_vals').val();
    
    var formData = new FormData($('#assessor-write-review')[0]);
    formData.append('status_vals', status_vals);

    $.ajax({
        type: 'POST',
        url: urls,
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            if(response.status == 201){
                $("#assessor_note").val('');
                $("#assessor_file").val('');
                window.location.reload();
            }
        },
        error: function (reject) {
            $('.error-block-assessor').remove();
            if(reject.status === 422) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                $.each(errors, function(field_name, error){
                   $('textarea[name="'+field_name+'"]').closest('.media').after('<span class="help-block error-block error-block-assessor text-danger"><small>'+error+'</small></span>'); 
                });
            }
        }
    }); 
});


/*$('#assessor-review-note').click(function(){
    var urls = $('#assessor-write-review').attr('action');
    $.ajax ({
        type: 'POST',
        url: urls,
        async: false,
        data: $("#assessor-write-review").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                $("#assessor_note").val('');
                window.location.reload();
            }
        },
        error: function (reject) {
            $('.error-block-assessor').remove();
            if(reject.status === 422) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                $.each(errors,function(field_name,error){
                   $('textarea[name="'+field_name+'"]').closest('.media').after('<span class="help-block error-block error-block-assessor text-danger"><small>'+error+'</small></span>'); 
                });
                //toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});*/


/**
Update Review & status
*********************/

$('#review-note').click(function(){
    var url = $('#write-review').attr('action');
    var redirect_url = $('#write-review').data('redirect');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $("#write-review").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                $("#reviewnote").val('');
                //$("#write-review")['0'].reset();
                window.location.reload();
                
                //$('.data-note').prepend(response.html);
            }    
        },
        error: function (reject) {
             $('.error-block-notes').remove();
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                $.each(errors,function(field_name,error){
                   $('textarea[name="'+field_name+'"]').closest('.media').after('<span class="help-block error-block-notes error-block text-danger"><small>'+error+'</small></span>'); 
                });
                        
                //toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

$('#review-status-update-note').click(function(){
    
    var popup_status_id = $('#status_vals').val();
    var popup_application_id = $('#application_id_val').val();
    var validStatuses = [7, 8, 11];
    
    if ($.inArray(parseInt(popup_status_id), validStatuses) !== -1) {
        $('#popup_assessor_note').val('');
        $('#popup_application_id').val(popup_application_id);
        $('#popup_status_id').val(popup_status_id);
        $('#status_notes').modal('show');
    }else{
        var url = $('#update-status').attr('action');
        $.ajax ({
            type: 'POST',
            url: url,
            async: false,
            data: $("#update-status").serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success : function(response) {
                if(response.status == 201){
                    toaserMessage(response.status, response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }else{
                    $('#assessor_note').focus()[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    toaserMessage(response.status, response.message);
                }
            },
            error: function (reject) {
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    toaserMessage(422, Object.values(errors)[0]);
                }
            }
        }); 
    }
});

$('#submit-assessor-notes').click(function(){
        
    var url = $('#popup_assessor_note_form').attr('action');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $("#popup_assessor_note_form").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                $('#status_notes').modal('hide');
                toaserMessage(response.status, response.message);
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
    
});

/**
Clone People Block
*****************/
$("form").on("click",".add_more_additional", function(){
    var html = $('.additional_clone:last').html();
    $('.additional_clone:last').after('<div class="additional_clone">'+html+'</div>');
    $(".additional_clone:last").find('input').val('');
    $(".additional_clone:last").find('select').val('');
    var total_div_available = $('.additional_clone').length;
    if(total_div_available != 1){
        $(".remove_add_s").removeClass('d-none');
    }
    $(this).remove();
    updateDirectorHeadingsOne();
    
    
    $('.additional_clone:last').find('select[name="title[]"]').attr('id', 'title-'+total_div_available);
    $('#title-'+total_div_available).removeAttr('data-select2-id'); 
    $('#title-'+total_div_available).next('span').remove();
    $('#title-'+total_div_available).removeClass('select2-hidden-accessible');
    $('#title-'+total_div_available).find('option').removeAttr('data-select2-id');
    $('#title-'+total_div_available).select2();
    
    
    $('.additional_clone:last').find('select[name="marital_status[]"]').attr('id', 'marital_status-'+total_div_available);
    $('#marital_status-'+total_div_available).removeAttr('data-select2-id'); 
    $('#marital_status-'+total_div_available).next('span').remove();
    $('#marital_status-'+total_div_available).removeClass('select2-hidden-accessible');
    $('#marital_status-'+total_div_available).find('option').removeAttr('data-select2-id');
    $('#marital_status-'+total_div_available).select2();
    
    $('.additional_clone:last').find('select[name="gender[]"]').attr('id', 'gender-'+total_div_available);
    $('#gender-'+total_div_available).removeAttr('data-select2-id'); 
    $('#gender-'+total_div_available).next('span').remove();
    $('#gender-'+total_div_available).removeClass('select2-hidden-accessible');
    $('#gender-'+total_div_available).find('option').removeAttr('data-select2-id');
    $('#gender-'+total_div_available).select2();
    
    
    $('.additional_clone:last').find('select[name="residential_status[]"]').attr('id', 'residential_status-'+total_div_available);
    $('#residential_status-'+total_div_available).removeAttr('data-select2-id'); 
    $('#residential_status-'+total_div_available).next('span').remove();
    $('#residential_status-'+total_div_available).removeClass('select2-hidden-accessible');
    $('#residential_status-'+total_div_available).find('option').removeAttr('data-select2-id');
    $('#residential_status-'+total_div_available).select2();
    
    
    $('.additional_clone:last').find('select[name="time_in_business[]"]').attr('id', 'time_in_business-'+total_div_available);
    $('#time_in_business-'+total_div_available).removeAttr('data-select2-id'); 
    $('#time_in_business-'+total_div_available).next('span').remove();
    $('#time_in_business-'+total_div_available).removeClass('select2-hidden-accessible');
    $('#time_in_business-'+total_div_available).find('option').removeAttr('data-select2-id');
    $('#time_in_business-'+total_div_available).select2();
    
    
    $('.additional_clone:last').find('select[name="time_at_business[]"]').attr('id', 'time_at_business-'+total_div_available);
    $('#time_at_business-'+total_div_available).removeAttr('data-select2-id'); 
    $('#time_at_business-'+total_div_available).next('span').remove();
    $('#time_at_business-'+total_div_available).removeClass('select2-hidden-accessible');
    $('#time_at_business-'+total_div_available).find('option').removeAttr('data-select2-id');
    $('#time_at_business-'+total_div_available).select2();
    
     
    $('.date-field').mask("00-00-0000", {placeholder: "__-__-____"});
    $('.expire-date-field').mask("00-00-0000", {placeholder: "__-__-____"});
    
    $('.phone-field').mask("0000 000 000");
    $('.landline-field').mask("00 0000 0000");
    $('.license-card-number-field').mask("AAAAAAAAAA");
    
    $('.additional_clone:last').find('.buz_address').attr('id', 'buz_address-'+total_div_available);
    var options = {
      types: ['geocode'],
      componentRestrictions: { country: 'AU' }
    };
    var autocomplete = new google.maps.places.Autocomplete($("#buz_address-"+total_div_available)[0], options);
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
    });
    
    
    
    datepicker_load();
    return false; //prevent form submission
});

$("form").on("click",".remove_add_s", function(){
    $(this).closest(".additional_clone").remove();
    $(".additional_clone:last").find('.add_more_additional').remove();
    $('<a href="javascript: void(0);" class="mr-2 rm-blk-add btn btn-xs btn-info add_more_additional float-right text-white">  <i class="mdi mdi-plus"></i> Add more Applicant/Director/Proprietor</a>').insertAfter(".remove_add_s:last").find('.additional_clone:last');
    var total_div_available = $('.additional_clone').length;
    if(total_div_available == 1){
        $(".remove_add_s").addClass('d-none');
    }
    
    updateDirectorHeadingsOne();
});

$("form").on("click",".add_more_additional_in_up", function(){
    $(this).remove();

    var url = $('.add_more_additional_in_up').attr('data-action');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: {},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            $(".up_add_clone").append(response);
           
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

/**
Left Sidebar Confirmation
************************/

$('.confirmation').on('click', function () {
    if($(this).data('flag') == 1) {return true;}else{ return false; }
});


/**
Search ABN ACN
*************/

$('#search-abn-acn').click(function(){

    $('input[name="business_name"], input[name="postcode"], input[name="state"], input[name="business_address"]').val('');
    $('select[name="business_structure"] option:selected, select[name="year_established"]').removeAttr('selected');
    
    var abn_acn = $('input[name="abn_acn"]').val();
    var abn_acn = abn_acn.replace(/\s/g, ''); 

    if(abn_acn == ""){
        toaserMessage(422, "Required ABN OR ACN Number.");
        return false;
    }
    
    if( (abn_acn.length != '11') && (abn_acn.length != '9') ){ //acn=106 008 637, abn=32 106 008 637
        toaserMessage(422, "Invalid ABN OR ACN Number.");
        return false;
    }

    var type = (abn_acn.length == '11') ? 'ABN' : 'ACN';
    var url = $('input[name="abn_acn"]').data('action');


    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: { type: type, abn_acn :abn_acn},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            var response = $.parseJSON(response);
            var bs = response.data.response.businessEntity201408.entityType.entityDescription;
            
            if (response.data.response.businessEntity201408.hasOwnProperty("mainName")) {
                var mainName_length = response.data.response.businessEntity201408.mainName.length;
                if(mainName_length == undefined){
                    var business_name = response.data.response.businessEntity201408.mainName.organisationName;
                    var e_from = response.data.response.businessEntity201408.mainName.effectiveFrom;
                }else{
                    var business_name = response.data.response.businessEntity201408.mainName[0].organisationName;
                    var e_from = response.data.response.businessEntity201408.mainName[mainName_length-1].effectiveFrom;
                }
            }else if(response.data.response.businessEntity201408.hasOwnProperty("mainTradingName")){
                var mainName_length = response.data.response.businessEntity201408.mainTradingName.length;
                if(mainName_length == undefined){
                    var business_name = response.data.response.businessEntity201408.mainTradingName.organisationName;
                    var e_from = response.data.response.businessEntity201408.mainTradingName.effectiveFrom;
                }else{
                    var business_name = response.data.response.businessEntity201408.mainTradingName[0].organisationName;
                    var e_from = response.data.response.businessEntity201408.mainTradingName[mainName_length-1].effectiveFrom;
                }
            }else{
                var business_name = response.data.response.businessEntity201408.businessName.organisationName;
                var e_from = response.data.response.businessEntity201408.businessName.effectiveFrom;
            }
            var year_arr = e_from.split("-");
            var address_length = response.data.response.businessEntity201408.mainBusinessPhysicalAddress.length;
            if(address_length == undefined){
                var postcode = response.data.response.businessEntity201408.mainBusinessPhysicalAddress.postcode;
                var state = response.data.response.businessEntity201408.mainBusinessPhysicalAddress.stateCode;
            }else{
                var postcode = response.data.response.businessEntity201408.mainBusinessPhysicalAddress[0].postcode;
                var state = response.data.response.businessEntity201408.mainBusinessPhysicalAddress[0].stateCode;
            }   

            if (response.data.response.businessEntity201408.hasOwnProperty("mainPostalPhysicalAddress")) {
                var ph_add_length = response.data.response.businessEntity201408.mainPostalPhysicalAddress.length;   
                if(ph_add_length == undefined){
                    var address = response.data.response.businessEntity201408.mainPostalPhysicalAddress.addressLine1;
                }else{
                    var address = response.data.response.businessEntity201408.mainPostalPhysicalAddress[0].addressLine1;
                }
                $('input[name="business_address"]').val(address);
            }

            $('input[name="business_name"]').val(business_name);
            $('select[name="business_structure"] option').filter(function () { 
                return $(this).html() == bs; 
            }).prop('selected', true);   
            $('select[name="year_established"] option').filter(function () { 
                return $(this).html() == year_arr[0]; 
            }).prop('selected', true);   

            $('input[name="postcode"]').val(postcode);
            $('input[name="state"]').val(state);
            toaserMessage(response.status, response.message);
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

/**
Video Play
**********/
if($('#my-banner').length != 0){
    var video = document.getElementById("my-banner");   
    video.play();
}

/*BP - Owl*/
if($('#bp-owl').length != 0){
    $('#bp-owl').owlCarousel({
        loop:true,
        margin:30,
        smartSpeed :900,
        nav:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,

        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            768:{
                items:2
            },
            1000:{
                items:3
            },

        }
    })
}

/*RESOURCES - Owl*/
if($('#resources-owl').length != 0){
    $('#resources-owl').owlCarousel({
        loop:true,
        margin:30,
        nav:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            768:{
                items:2
            },
            1000:{
                items:3
            },
        }
    })
}
/**
Slider Range
************/
if($('#price-loan').length != 0){
    $("#price-loan").ionRangeSlider({
        min: 0,
        //max: 1000000,
        from: 1,
        //to: 165000,
        step: 1,
        prefix: "$",
        prettify_enabled: true,
        prettify_separator: ",",
        onStart: function (data) {
          $('input[name="loan_amount_requested"]').val(data.from);
        },
        onChange: function (data) {
            $('input[name="loan_amount_requested"]').val(data.from);
        },
    });
}

if($('#minimum-invest').length != 0){
    $("#minimum-invest").ionRangeSlider({
        type: "double",
        grid: true,
        min: 5000,
        max: 1000000,
        from: 5000,
        to: 180000,
        prefix: "$",
        onStart: function (data) {
          $('input[name="invest_amount"]').val(data.to);
        },

        onChange: function (data) {
            $('input[name="invest_amount"]').val(data.to);
        }
    });
}

/**
Contact Request
**************/

$('#submit-contact').click(function(){
    var url = $('.co-form').attr('action');
    $('.fa-spinner').removeClass('d-none');
    
    $.ajax ({   
        type: 'POST',
        url: url,
        async: false,
        data: $(".co-form").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            $('.fa-spinner').addClass('d-none');
            toaserMessage(response.status, response.message);
            $('.co-form')[0].reset();
        },
        error: function (reject) {
            if( reject.status === 422 ) {
                $('.fa-spinner').addClass('d-none');
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                toaserMessage(422, Object.values(errors)[0]);
            }
        }
    }); 
});

/**
Register Request
**************/
$('#request_a_callback').click(function(){
    var name = $(this).attr('id');
    var checked = $('input[name='+name+']').attr('checked');
    if(checked == 'checked'){
        $('input[name='+name+']').removeAttr('checked');
        $('#btn-register').text('Get started');
    	$('.password-row').fadeIn();
    }else{
        $('input[name='+name+']').attr('checked', 'checked');
        $('#btn-register').text('Request a call-back');
        $('.password-row').fadeOut();
    }
});

$('input[name="type"]').click(function(){
    var val_in = ( $('input[name="type"]').val() == 1) ? 0 : 1;
    $('input[name="type"]').val(val_in);
    $('input[name="type"]').removeAttr('checked');
    $(this).attr('checked', 'checked');
})

$('input[name="role"]').click(function(){
   $('input[name="role"]').removeAttr('checked');
   $(this).attr('checked', 'checked');
})

$('#btn-verify-otp').click(function() {
   var url = $('#otp-form').attr('action');
   var redirect_url = $('#otp-form').attr('data-redirect');
   
   $.ajax ({
        type: 'POST',
        url: url,
        data: $("#otp-form").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 201){
                
                $('#otp-form')[0].reset();
                window.location.href = redirect_url;
                
                /*
                toaserMessage(response.status, response.message);
                $('#step-3').fadeOut();
                $('#step-5').fadeIn().removeClass('d-none');
                */
                
            }else{
                $('.error-block').remove();
                $('.error-message').append('<span class="help-block error-block"><small>'+response.message+'</small></span>');  
            }
        },
        error: function (reject) {
            $('.error-block').remove();
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                
                $.each(errors,function(field_name,error){
                    if(field_name == "terms_and_condition"){
                        $('.error-message').append('<span class="help-block error-block"><small>'+error+'</small></span>');  
                    }else{
                        $('input[name="'+field_name+'"]').after('<span class="help-block error-block"><small>'+error+'</small></span>');  
                    }
                });
            }
        }
    }); 
    
});

$('#btn-register').click(function(){

    $('.error-block').remove();
    var url = $('.register-form').attr('action');
    var redirect_url = $('.register-form').attr('data-redirect-url');
    var request_a_callback = $('#policy-accept:checked').val();
   
 
    $.ajax ({
        type: 'POST',
        url: url,
        data: $(".register-form").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            //toaserMessage(response.status, response.message);
            if(response.status == 201){
                
                $('.register-form')[0].reset();
                
                if(request_a_callback == 1){
                    $('#step-2').fadeOut();
                    $('#step-4').fadeIn().removeClass('d-none');
                }else{
                    $('#step-2').fadeOut();
                    $('#step-3').fadeIn().removeClass('d-none');
                }
                
                
                
                /*
                $('.tag-line-create-account').addClass('d-none');  
                
                $('form').addClass('d-none');
                var fullname = $('#fullname').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var role = $('input[name="role"]:checked').val();
                if(role == undefined){
                    var role = $('input[name="role"]').val();
                }
                
                $('#splash-information').removeClass('d-none');
                var html = '<p class="text-muted font-15 mb-0">'+fullname.toUpperCase()+'</p><p class="text-muted font-15 mb-0">'+email+'</p><p class="text-muted font-15 mb-0">'+phone+' [ User ID ]</p>'
                $('#register-info').html(html);
                $('.role-'+role).removeClass('d-none');
                */
                

            }else{
                $('.error-block').remove();
                $('.error-message').append('<span class="help-block error-block"><small>'+response.message+'</small></span>');  
            }
        },
        error: function (reject) {
            $('.error-block').remove();
        
            if (reject.status === 422) {
                var errors = $.parseJSON(reject.responseText);
                errors = errors['errors'];
        
                $.each(errors, function(field_name, error) {
                    // Handle checkbox (terms) error separately
                    if (field_name === "terms_and_condition") {
                        $('.error-message').append('<span class="help-block error-block"><small>' + error + '</small></span>');
                    }
                    // Check if field is a select dropdown
                    else if ($('select[name="' + field_name + '"]').length) {
                        $('select[name="' + field_name + '"]').after('<span class="help-block error-block"><small>' + error + '</small></span>');
                    }
                    // Default for input fields
                    else {
                        $('input[name="' + field_name + '"]').after('<span class="help-block error-block"><small>' + error + '</small></span>');
                    }
                });
        
                // Optionally show first error in a toast
                // toasterMessage(422, Object.values(errors)[0]);
            }
        }

    }); 
});

/**
Login Request
**************/

$('#login').click(function(){
    
    $('.error-block').remove();

    var type = $('#type').val();
    var url = $('.login-form').attr('action');
    //if(type == 'user'){
        $.ajax ({
            type: 'POST',
            url: url,
            data: $(".login-form").serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success : function(response) {
                if(response.status == 201){
                    window.location.href = response.data.redirect_url;
                }else{
                    //toaserMessage(response.status, response.message);
                    $('.error-block').remove();
                    $('.error-message').append('<span class="help-block error-block"><small>'+response.message+'</small></span>');
                }
            },
            error: function (reject) {
                $('.error-block').remove();
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    $('input[name="'+Object.keys(errors)[0]+'"]').after('<span class="help-block error-block"><small>'+Object.values(errors)[0]+'</small></span>');
                    //toaserMessage(422, Object.values(errors)[0]);
                }
            }
        }); 
    /*}else{

        var field = $('#email_or_phone').val();
        if(is_email_or_phone(field))
        {
            
            $.ajax ({
                type: 'POST',
                url: url,
                data: $(".login-form").serialize()+ "&is_email_or_phone=" + is_email_or_phone(field),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success : function(response) {
                    if(response.status == 201){
                        window.location.href = response.data.redirect_url;
                    }else{
                        toaserMessage(response.status, response.message);
                    }
                },
                error: function (reject) {
                    if( reject.status === 422 ) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];
                        toaserMessage(422, Object.values(errors)[0]);
                    }
                }
            }); 
        }   
    }*/
});

/**
Crop Image
**********/
function cropImage(input) {
    if($('.cropme-container').length){
        $example.cropme("destroy");
    }

    $('.crop-div').remove();
    $(input).closest('div.cropme-div').after('<div class="row"><div class="col-md-12"><div class="mt-3 crop-div"><div id="upload-view"></div><div class="cropme-container crop-btn mt-2"><button type="button" class="btn btn-info waves-effect waves-light" id="crop-image">Crop</button></div></div></div>');
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var type =  $(input).data('type');
      var width =  $(input).data('width');
      var height =  $(input).data('height');
      if(type == 'rectangle'){
        var height = 400;
        var width = 650;
        var type = "square";
      }else{
        var height = height;
        var width = width;
        var type = type;
      }

      reader.onload = function (e) {
      $example = $('#upload-view').cropme({
            "container": {"width": "100%","height": (height+50)},
            "viewport": {
                "width": width,
                "height": height,
                "type": type, // or 'square'
                "border": {
                  "width": 2,
                  "enable": true,
                  "color": "#fff"
                }
            },
            // zoom options
           "zoom": {
             "min": .1,
             "max": 3,
             "enable": true,
             "mouseWheel": true,
             "slider": true
           },

           // rotation options
           "rotation": {
            "slider": false,
            "enable": false,
            "position": "right"
           },
           "transformOrigin": "viewport"
         });

         $example.cropme('bind', {
            url:e.target.result
         });
         $('#crop-image').attr('data-id', input.id);
      }           
      reader.readAsDataURL(input.files[0]);
  }
}
$("form").on("click","#crop-image", function(){
   var pic_field_id = $('#crop-image').attr('data-id');
   $example.cropme('crop', {
     type: 'base64', // or 'blob'
     width: 100,
     scale: 2,
     mimetype: 'image/png',
     quality: .92
   }).then(function(response) {
      toaserMessage("200", "Image has been croping success.");
      $('input[name="'+pic_field_id+'"]').val(response);
      $('.crop-div').remove();
   })
})


/**
Algolia Search Places
********************/

if($('.algolia-places').length != 0){
    var placesAutocomplete = places({
        appId: 'plXHOB0VRIWW',
        apiKey: 'dbe29a7784d7e5c5d078e40396fc5832',
        container: document.querySelector('.algolia-places')
    });
}

/**
Comman Function
**************/
function readImageURL(input, display_classname) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('.'+display_classname).attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

function process_validation(){
    $("input, select").each(function() {
        if($(this).is("[required]")){
            if($(this).attr('name') != undefined){
                if(this.value == ""){
                    var name = $(this).attr('name');
                    var name = name.replace(/_/g, ' ');
                    toaserMessage(422, "The "+name+" field is required.");
                    return false;
                }
            }    
        }
    });
}

function is_email_or_phone(field){
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if(field == ""){
        toaserMessage(422, "Required email or phone.");
        return false;
    }
    else if(testEmail.test(field)){
        return "email";
    }
    else if(field.length != 10){
        toaserMessage(422, "Phone number should be 10 digit number.");
        return false;
    }
    else{
        return "phone"
    }
}

function save_exit_true(){
    if($('.save-exit').length == 0){
        return true;
    }else{
        return false;
    }
}

function toaserMessage(status, message) {

    /**
    Remove Old Toast Message
    ***********************/

    $('#toast-container').remove();

    var type = ( (status == '200') || (status == '201') ) ? 'success' : 'error';
    toastr[type](message)
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "0",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}

function datepicker_load(){
    var currentYear = new Date().getFullYear();
    $('.p-date-picker').datepicker({
        orientation: "bottom auto",
        format: "dd-mm-yyyy",
        autoclose:true,
        forceParse: false,
        startDate: '01-01-1900', // Set start date to 01-01-1900
        endDate: '31-12-' + currentYear // Set end date to 31-12-currentYear
        
    }).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
    
    // Only use in license expire date
    var today = new Date();
    var tenYearsFromNow = new Date();
    tenYearsFromNow.setFullYear(today.getFullYear() + 10);
    
    $('.expire-date-field').datepicker({
        orientation: "bottom auto",
        format: "dd-mm-yyyy",
        autoclose: true,
        forceParse: false,
        startDate: today, // Set start date to today to block past dates
        endDate: tenYearsFromNow // Set end date to 10 years from now
    }).on('changeDate', function(e) {
        $(this).datepicker('hide');
    });
}

function isValidURL(string) {
  var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
  return (res !== null)
};


$(".numbers-only").keyup(function() {
    var $this = $(this);
    $this.val($this.val().replace(/[^\d.]/g, ''));        
});


if($('.p-date-picker').length){
    var currentYear = new Date().getFullYear();
    $('.p-date-picker').datepicker({
        orientation: "bottom auto",
        //format: "yyyy-mm-dd",
        format: "dd-mm-yyyy",
        autoclose:true,
        forceParse: false,
        startDate: '01-01-1900', // Set start date to 01-01-1900
        endDate: '31-12-' + currentYear // Set end date to 31-12-currentYear
    }).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
}

if($('.expire-date-field').length){
    // Only use in license expire date
    var today = new Date();
    var tenYearsFromNow = new Date();
    tenYearsFromNow.setFullYear(today.getFullYear() + 10);
    
    $('.expire-date-field').datepicker({
        orientation: "bottom auto",
        format: "dd-mm-yyyy",
        autoclose: true,
        forceParse: false,
        startDate: today, // Set start date to today to block past dates
        endDate: tenYearsFromNow // Set end date to 10 years from now
    }).on('changeDate', function(e) {
        $(this).datepicker('hide');
    });
}

/**
Delete Confirmation
******************/
$(".del-confirm").click(function(){
    if (!confirm("Do you want to delete")){
        return false;
    }
    else
    {
        var form_id = $(this).attr('data-id');
        $(this).closest("form").submit();
        $('#form-'+form_id).submit();
    }
});

$('.currency-input').on('input', function() {
    var input = $(this).val();
    var c = currency(input, { precision: 0, pattern: `#` }).format();
    if(c == ""){
        c = 0;
    }
    $(this).val(c);
});

var date_field = $('.date-field').length;
if(date_field > 0){
    $('.date-field').mask("00-00-0000", {placeholder: "__-__-____"});
}

var expire_date_field = $('.expire-date-field').length;
if(expire_date_field > 0){
    $('.expire-date-field').mask("00-00-0000", {placeholder: "__-__-____"});
}

var phone_field = $('.phone-field').length;
if(phone_field > 0){
    $('.phone-field').mask("0000 000 000");
}


/**
 * Cloning property in security Page
 * use in loan application
 **/

$('#property-sections-container').on('click', '.add-more-property', function() {
    var cloneCount = ($('#property-sections-container').find('.d-property-sec').length - 1);
    
    cloneCount++;
    // Clone the .d-property-sec element
    var newSection = $('.d-property-sec').first().clone();

    // Clear the input values in the cloned section
    newSection.find('input[type="text"]').val('');
    
    // Update IDs and labels dynamically for radio and checkbox inputs
    newSection.find('input[type="radio"]').each(function(index) {
        var oldId = $(this).attr('id');
        var newId = oldId + '_' + cloneCount; // Ensure unique IDs
        $(this).attr('id', newId);
        $(this).next('label').attr('for', newId);
        
        var name = $(this).attr('class');
        if(name == "purpose"){
            $(this).attr('name', "purpose_"+cloneCount+"[]");
        }
        
        if(name == "property_type"){
            $(this).attr('name', "property_type_"+cloneCount+"[]");
        }
    });
    
   
    
    // Append the cloned section to the container
    $('#property-sections-container').append(newSection);
    initializeAutocomplete();
    
    $('#property-sections-container').find('.remove-property').removeClass('d-none');
    
    // Remove add more button
    $('#property-sections-container').find('.add-more-property').addClass('d-none');
    $('#property-sections-container').find('.add-more-property:last').removeClass('d-none');
    
    
    
});

$('#property-sections-container').on('click', '.remove-property', function() {
    $(this).closest('.d-property-sec').remove();
    // Remove add more button
    $('#property-sections-container').find('.add-more-property').addClass('d-none');
    $('#property-sections-container').find('.add-more-property:last').removeClass('d-none');
    
    var count = $('#property-sections-container').find('.d-property-sec').length;
    if(count == 1){
        $('#property-sections-container').find('.remove-property').addClass('d-none');
    }
})

// Use event delegation for currency input formatting
$('#property-sections-container').on('input', '.currency-input', function() {
    var input = $(this).val();
    var c = currency(input, { precision: 0, pattern: `#` }).format();
    if (c == "") {
        c = 0;
    }
    $(this).val(c);
});

$('.property-sections-container').on('input', '.currency-input', function() {
    var input = $(this).val();
    var c = currency(input, { precision: 0, pattern: `#` }).format();
    if (c == "") {
        c = 0;
    }
    $(this).val(c);
});

$('.property-sections-container').on('change', 'input[type="radio"]', function() {
    var name = $(this).attr('name');
    var v = $(this).attr('value');
    var className = $(this).attr('class');
    //alert(name);
    //alert(v);
    //alert(className);
    if(className == "purpose"){
        $(this).closest('.d-property-sec').find('.hidden_purpose').val(v);
    }
    if(className == "property_type"){
        $(this).closest('.d-property-sec').find('.hidden_property_type').val(v);
    }
});

// Event delegation for radio buttons
$('#property-sections-container').on('change', 'input[type="radio"]', function() {
    var name = $(this).attr('name');
    var v = $(this).attr('value');
    var className = $(this).attr('class');
    //alert(name);
    //alert(v);
    //alert(className);
    if(className == "purpose"){
        $(this).closest('.d-property-sec').find('.hidden_purpose').val(v);
    }
    if(className == "property_type"){
        $(this).closest('.d-property-sec').find('.hidden_property_type').val(v);
    }
});


/**
 * Cloning crypto in security Page
 * use in loan application
 **/

$('#crypto-sections-container').on('click', '.add-more-crypto', function() {
    var cloneCount = ($('#crypto-sections-container').find('.d-crypto-sec').length - 1);
    
    cloneCount++;
    // Clone the .d-crypto-sec element
    var newSection = $('.d-crypto-sec').first().clone();

    // Clear the input values in the cloned section
    newSection.find('input[type="text"]').val('');
    
    // Update IDs and labels dynamically for radio and checkbox inputs
    newSection.find('input[type="radio"]').each(function(index) {
        var oldId = $(this).attr('id');
        var newId = oldId + '_' + cloneCount; // Ensure unique IDs
        $(this).attr('id', newId);
        $(this).next('label').attr('for', newId);
        
        var name = $(this).attr('class');
        if(name == "crypto_purpose"){
            $(this).attr('name', "crypto_purpose_"+cloneCount+"[]");
        }
        
        if(name == "crypto_property_type"){
            $(this).attr('name', "crypto_property_type_"+cloneCount+"[]");
        }
    });
    
   
    
    // Append the cloned section to the container
    $('#crypto-sections-container').append(newSection);
    initializeAutocomplete();
    
    $('#crypto-sections-container').find('.remove-crypto').removeClass('d-none');
    
    // Remove add more button
    $('#crypto-sections-container').find('.add-more-crypto').addClass('d-none');
    $('#crypto-sections-container').find('.add-more-crypto:last').removeClass('d-none');
    
    
    
});

$('#crypto-sections-container').on('click', '.remove-crypto', function() {
    $(this).closest('.d-crypto-sec').remove();
    // Remove add more button
    $('#crypto-sections-container').find('.add-more-crypto').addClass('d-none');
    $('#crypto-sections-container').find('.add-more-crypto:last').removeClass('d-none');
    
    var count = $('#crypto-sections-container').find('.d-crypto-sec').length;
    if(count == 1){
        $('#crypto-sections-container').find('.remove-crypto').addClass('d-none');
    }
})

// Use event delegation for currency input formatting
$('#crypto-sections-container').on('input', '.currency-input', function() {
    var input = $(this).val();
    var c = currency(input, { precision: 0, pattern: `#` }).format();
    if (c == "") {
        c = 0;
    }
    $(this).val(c);
});

$('.crypto-sections-container').on('input', '.currency-input', function() {
    var input = $(this).val();
    var c = currency(input, { precision: 0, pattern: `#` }).format();
    if (c == "") {
        c = 0;
    }
    $(this).val(c);
});

$('.crypto-sections-container').on('change', 'input[type="radio"]', function() {
    var name = $(this).attr('name');
    var v = $(this).attr('value');
    var className = $(this).attr('class');
    //alert(name);
    //alert(v);
    //alert(className);
    if(className == "crypto_purpose"){
        $(this).closest('.d-crypto-sec').find('.crypto_hidden_purpose').val(v);
    }
    if(className == "crypto_property_type"){
        $(this).closest('.d-crypto-sec').find('.crypto_hidden_property_type').val(v);
    }
});

// Event delegation for radio buttons
$('#crypto-sections-container').on('change', 'input[type="radio"]', function() {
    var name = $(this).attr('name');
    var v = $(this).attr('value');
    var className = $(this).attr('class');
    //alert(name);
    //alert(v);
    //alert(className);
    if(className == "crypto_purpose"){
        $(this).closest('.d-crypto-sec').find('.crypto_hidden_purpose').val(v);
    }
    if(className == "crypto_property_type"){
        $(this).closest('.d-crypto-sec').find('.crypto_hidden_property_type').val(v);
    }
});