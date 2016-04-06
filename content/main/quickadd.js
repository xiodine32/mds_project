/*globals $:false */
/*globals Foundation:false */
/**
 * Created by rares.neagu on 05/04/16.
 */

/*eslint-disable no-unused-vars*/
function QuickAdd(target, selector) {
    var onclose = function () {
    };

    $("body").append("<div class=\"reveal\" id=\"quickAdd\" data-reveal data-close-on-click=\"true\" data-animation-in=\"fade-in\"" +
        " data-animation-out=\"fade-out\"" +
        " aria-labelledby=\"quickAdd-content\" aria-hidden=\"true\" role=\"dialog\">" +
        " <div id=\"quickAdd-content\"></div>" +
        " <button class=\"close-button\" data-close aria-label=\"Close reveal\" type=\"button\" id=\"closeButton\">" +
        " <span aria-hidden=\"true\">&times;</span></button></div>");


    var $modal = $("#quickAdd");

    //noinspection JSUnresolvedFunction
    var popup = new Foundation.Reveal($modal);

    $modal.bind("closed.zf.reveal", function () {
        onclose();
    });

    $modal.find("#quickAdd-content").load(target, function () {
        var $me = $(this);
        $me.children($me.find(selector));
        // open modal
        popup.open();

        // add datepicker
        $modal.find("input[pattern=date]").datepicker({dateFormat: "yy-mm-dd"});
    });

    return {
        close: function (item) {
            onclose = item;
        }
    };
}
/*eslint-enable no-unused-vars*/
