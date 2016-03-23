jQuery(document).ready(function($) {

    $( "#wpaura_sortable" ).sortable({
        placeholder: "ui-state-highlight"
    });

    $( "#wpaura_sortable" ).disableSelection();

    var datahtml = $( '#wpaura_sortable_textarea' ).val();
    $('#wpaura_sortable').html(datahtml);
    var links = null;
    var count = $("#wpaura_sortable li").length;
    for (var j = 1; j <= count; j++) {
        if (links != null) {
            links += ',' + $('#wpaura_sortable li:nth-child('+ j +') img').attr('src');    
        } 
        else  {
            links = $('#wpaura_sortable li:nth-child('+ j +') img').attr('src');    
        }
    };
    $('#listofimages').val(links);
    

    var custom_uploader; 
    var i = 0;
    
    $('.upload_btn').click(function(e) {
 
        e.preventDefault();
        $(this).parent().addClass('activeImageUpload');

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            // attachment = custom_uploader.state().get('selection').first().toJSON();
            

            var selection = custom_uploader.state().get('selection');
            
            selection.map( function( attachment ) {
                    i++;
                    attach = attachment.toJSON();
                    console.log(i + ' ' + attach.url);
                    // $('#sortable').appendTo( $( 'li img' ).attr('src', attach.url) );
                    $('#wpaura_sortable').append(  $( '<li class="ui-state-default"><img src="'+ attach.url +'" style="max-width:200px;"><span>Delete</span></li>' ) );
            });
            // $('.activeImageUpload .spanClass img' ).attr( 'src', attachment.url);
            // $('.activeImageUpload .spanClass' ).parent().removeClass('activeImageUpload');
        });


 
        //Open the uploader dialog
        custom_uploader.open();
        
    });
  

    $('.save').on('click', function () {
        var idsInOrder = $("#wpaura_sortable").sortable("toArray");
        
        // alert($('#wpaura_sortable #image'+ i +' img').attr('src'));
        var orderOfImages = $('#wpaura_sortable').html();
        $('#wpaura_sortable_textarea').text(orderOfImages);

        

        // $('#data-html').attr('data-html', orderOfImages);
        // $('#wpaura_sortable_textarea').val(idsInOrder);
        // alert(idsInOrder)
        
    });

    $('#wpaura_sortable li span').on('click', function() {
        $(this).parent().remove();
    });


    
	// $('#widget-imagewidget-3-upload_image').click(function(e) {
 
 //        e.preventDefault();
 
 //        //If the uploader object has already been created, reopen the dialog
 //        if (custom_uploader) {
 //            custom_uploader.open();
 //            return;
 //        }
 
 //        //Extend the wp.media object
 //        custom_uploader = wp.media.frames.file_frame = wp.media({
 //            title: 'Choose Image',
 //            button: {
 //                text: 'Choose Image'
 //            },
 //            multiple: true
 //        });
 
 //        //When a file is selected, grab the URL and set it as the text field's value
 //        custom_uploader.on('select', function() {
 //            var selection = custom_uploader.state().get('selection');
 //            var i = 0;
 //            selection.map( function( attachment ) {
 //                    i++;
 //                    attach = attachment.toJSON();
 //                    console.log(i + ' ' + attach.url);
 //                    $('#widget-imagewidget-3-upload_image ~ span').val(attach.url);
 //            });

 //            // $('#widget-imagewidget-3-upload_image').val(attachment.url);
 //        });
 
 //        //Open the uploader dialog
 //        custom_uploader.open();
 
 //    });
 
});