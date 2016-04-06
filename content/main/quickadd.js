/*globals $:false */
/**
 * Created by rares.neagu on 05/04/16.
 */

function QuickAdd(target, selector) {
    var $modal = $("#quickAdd");
    $modal.find('#quickAdd-content').load(target + " " + selector);
    $modal.foundation('open');
}