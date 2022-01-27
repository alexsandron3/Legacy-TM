$("#myInput").keyup(function() {
        var search = $(this).val();
        $(".time-entry").show();
        if (search)
            $(".time-entry").not(":containsNoCase(" + search + ")").hide();
});

$.expr[":"].containsNoCase = function (el, i, m) {
    var search = m[3];
    if (!search) return false;
      return new RegExp(search,"i").test($(el).text());
};


// jQuery Plug-in example
$("#txtSearchPagePlugin")
    .searchFilter({targetSelector: ".time-entry"})

