$("[data-equal-size]").each(function () {
    var $r = $(this);
    $(window).resize(function () {
        $r.css('height', $r.width() + 'px');
    });
    $r.css('height', $r.width() + 'px');
    var html = $r.html();
    $r.html('<div style="display:table;width:100%;height:100%"><div style="display: table-cell;vertical-align: middle;">' + html + '</div></div>');
});

Foundation.Abide.defaults.patterns['cnp'] = /^[1-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/;
$(document).foundation();