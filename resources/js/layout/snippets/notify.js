module.exports = {
    Me : function (options, expiration = 6000) {
        let params = {
            "message" : "This is default notifyMe message",
            "class" : "nt-success",
            "expiration" : 6000,
            'icon' : "fas fa-check"
        };

        let customID = (new Date).getTime();

        if (!$( ".notifyMeWrapper" ).length) {
            $("body").append(function () {
                return $("<div/>").attr('class', 'notifyMeWrapper')
            });
        }

        if(options.length >= 1) params['message'] = options[0];
        if(options.length >= 2) {
            if(options[1] === 'success'){
                params['class'] = "nt-success";
                params['icon']  = "fas fa-check";
            }
            if(options[1] === 'warn'){
                params['class'] = "nt-warn";
                params['icon']  = "fas fa-exclamation-triangle";
            }
            if(options[1] === 'danger'){
                params['class'] = "nt-danger";
                params['icon']  = "fas fa-radiation";
            }
        }
        params['expiration'] = expiration;

        let mainWrapper = $(".notifyMeWrapper");

        mainWrapper.append(function () {
            return $("<div/>").attr("id", customID)
                .attr('class', 'notifyMe')
                .append(function () {
                    return $("<div/>").attr('class', 'nt-inline')
                        .append(function () {
                            return $("<div/>").attr("class", "nt-icon")
                                .append(function () {
                                    return $("<i>").attr('class', params['icon']);
                                })
                        })
                        .append(function () {
                            return $("<p>").html(params['message'])
                        })
                })
                .addClass(params['class'])
                .hide()
                .fadeIn(500)
                .delay(params['expiration'])
                .queue(function() {
                    $(this).remove();
                    if (!$( ".notifyMe" ).length) mainWrapper.remove();
                })
        });
        $("body").on('click', "#" + customID, function () {
            $(this).remove();
            if (!$( ".notifyMe" ).length) mainWrapper.remove();
        });
    }
};

$(document).ready(function () {

});
