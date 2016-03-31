/**
 * Created by Chanh on 16/12/2015.
 */
$(function(){
    $('#profiletabs ul li a').on('click', function(e){
        e.preventDefault();
        var newcontent = $(this).attr('href');

        $('#profiletabs ul li a').removeClass('sel');
        $(this).addClass('sel');

        $('#content section').each(function(){
            if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
        });

        $(newcontent).removeClass('hidden');
    });
});
$("ul li").click(function(e){
    //make sure we can not click on the slider
    if ($(this).hasClass('slider')){
        return;
    }

    //add the slider movement

    //what tab was pressed
    var whatTab = $(this).index();

    //work out how far the slider needs to go
    var howFar = $(this).width() * whatTab;

    $(".tabMenuWrapper ul li.slider").css({
        left: howFar + "px"
    });

    // add the ripple

    //remove old ones
    $(".ripple").remove();

    //setup
    var posX = $(this).offset().left;
    var posY = $(this).offset().top;
    var buttonWidth = $(this).width();
    var buttonHeight = $(this).height();

    $(this).prepend("<span class='ripple'></span>");

    //make it round!
    if (buttonWidth >= buttonHeight){
        buttonHeight = buttonWidth;
    } else {
        buttonWidth = buttonHeight;
    }

    //get the center of the elementFromPoint
    var x = e.pageX - posX - buttonWidth / 2;
    var y = e.pageY - posY - buttonHeight / 2;

    //add the ripple css and start the animation
    $(".ripple").css({
        width: buttonWidth,
        height: buttonHeight,
        top: y + 'px',
        left: x + 'px'
    }).addClass("rippleEffect");


});

jQuery('.tabMenuWrapper #tabMenu a').on('click', function(e)  {
    var currentAttrValue = jQuery(this).attr('href');
    // Show/Hide Tabs
    jQuery('.tab-content ' + currentAttrValue).fadeIn(400).siblings().hide();

    // Change/remove current tab to active
    jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

    e.preventDefault();
});