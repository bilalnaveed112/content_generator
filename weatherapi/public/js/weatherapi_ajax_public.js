
jQuery(document).ready(function($){

    jQuery('body').on('click',function(){

        var weather_data = {
            'action': 'load_weather_status_with_ajax',
            'security': weather_ajax_params.security
        }
        // setInterval(function() {
            $.ajax({
                url: weather_ajax_params.ajaxurl,    //Ajax Url
                type: 'post',
                data: weather_data, 
                success: function(response){
                    $(".weather_status").empty();
                    $(".weather_status").append(response);
                    $(".weather_status_loading_text").hide();
                }
            });
        // }, 120000)
    });

});