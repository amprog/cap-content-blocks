jQuery(document).ready(function(){

    // Wrap content between chapters
    jQuery('.chapter').each(function(index) {
        jQuery(this).attr('data-chapter', index);
        jQuery(this).nextUntil('.chapter').appendTo(this);
    });

});
