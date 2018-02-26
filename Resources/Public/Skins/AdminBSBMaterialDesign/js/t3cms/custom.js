$(document).ready(function() {

    $('#confSaveForm').on('submit', function(e) {
        e.preventDefault();

        var actionUrl = $(this).attr('action');

        $.post(actionUrl,{
            'tx_t3cms_web_t3cmsoptions[uid]':$('[name="tx_t3cms_web_t3cmsoptions[uid]"]').val(),
            'tx_t3cms_web_t3cmsoptions[t3themesConf]':$('#t3themes_conf').val(),
        }).done(function(response) {
            if (response.status == 'success') {
                showSuccessMessage();
            } else {
                showAutoCloseTimerMessage()
            }
        });
    });

    if ($('#t3themes_conf').length > 0) {
        var dbValue = $('#t3themes_conf').val();
        if (dbValue.length > 0) {
            $.each(JSON.parse(dbValue), function(nameKey, value) {
                var formField = $("[name="+nameKey+"]");

                if (formField.length > 0) {

                    /*
                     * BUGFIX: Creating e.g. missing <options> for t3themesConf setting to prevent overwriting values, when your custom provided Options are not available for a time.
                     * Ist das Feld KEIN <select>..
                     */
                    if (!formField.is("select")) {
                        /* .. Wert setzen. */
                        formField.val(value);
                    } else {
                        if (null !== value && "undefined" !== value && value.length < 1) {
                            /* Setze Feld mit leerem Wert, wenn in der DB auch leer ist. */
                            formField.val(value);
                        } else {
                            /* Prüfen, ob es die <option> gibt, die wir setzen können. */
                            if (formField.find("option[value=\""+value+"\"]").length < 1) {
                                /* Die <option> existiert nicht. wir erstellen sie als selected. */
                                formField.append(new Option(value, value, true, true));
                            } else {
                                /* Die <option> existiert. Wert setzen. */
                                formField.val(value);
                            }
                        }
                    }
                    formField.trigger("change");

                }

            });
        }
    }


    $('.search-bar input[type="text"]').on('keyup',function(){
        var searchTerm = $(this).val().toLowerCase();
        if (searchTerm.length > 0) {
            $(".tab-content .tab-pane").css({display: "block",opacity: "1"});
            $(".nav.nav-tabs").hide();

            $(".formengine-field-item .hightlight").each(function(){
                var lineStr = $.trim($(this).text().toLowerCase());
                if(lineStr.indexOf(searchTerm) === -1){
                    $(this).parent('.formengine-field-item').hide();
                    $(this).css("background-color", "inherit");
                }else{
                    $(this).parent('.formengine-field-item').show();
                    $(this).css("background-color", "rgba(250, 255, 129, 0.48)");
                }
            });
            $(".formengine-field-item").each(function(){
                var lineStr = $.trim($(this).text().toLowerCase());
                if(lineStr.indexOf(searchTerm) === -1){
                    $(this).hide();
                }else{
                    $(this).show();
                }
            });
        } else {
            $(".tab-content .tab-pane").css({display: "",opacity: ""});
            $(".tab-content .tab-pane.active").css({display: "block",opacity: "1"});
            $(".formengine-field-item .hightlight").css("background-color", "inherit");
            $(".nav.nav-tabs").show();
            $(".formengine-field-item").show();
        }

    });
});

$(document).ready(function() {
    var fields = {};

    $.each($(".t3themes-tca-field"), function(index, field) {
        var fieldName = $(field).attr("name");
        var fieldValue = $(field).val();
        // fields[index] = {name:fieldName,value:fieldValue};
        fields[fieldName] = fieldValue;
    });
    $("#t3themes_conf").html(JSON.stringify(fields));

    $.each($(".t3themes-tca-field"), function(index, field) {
        $(field).on("change", function() {
            var fieldName = $(this).attr("name");
            var fieldValue = $(this).val();
            fields[fieldName] = fieldValue;
            $("#t3themes_conf").html(JSON.stringify(fields));
        });
    });
});

function showHeaderContent(elem){
    switch (elem.value) {
        case "shownav":
            document.getElementById("headerContentNavigation").style.display = "table-row";
            document.getElementById("headerContentAds").style.display = "none";
            break;
        case "showads":
            document.getElementById("headerContentAds").style.display = "table-row";
            document.getElementById("headerContentNavigation").style.display = "none";
            break;
        case "hide":
            document.getElementById("headerContentNavigation").style.display = "none";
            document.getElementById("headerContentAds").style.display = "none";
            break;
        default:
            document.getElementById("headerContentNavigation").style.display = "none";
            document.getElementById("headerContentAds").style.display = "none";
            break;
    }
}

function showSuccessMessage() {
    alert("Successfully saved!");
}
function showAutoCloseTimerMessage() {
    alert("Something went wrong!");
}
