$(function () {

    initSkin();
    skinChanger();

});

//Init Skin
function initSkin() {

    var theme = getCookie('theme');
    if (theme.length > 0) {
        var $body = $('body');
        var existTheme = $('.right-sidebar .demo-choose-skin li.active').data('theme');
        $body.removeClass('theme-' + existTheme);

        $body.addClass('theme-' + theme);
        $('.right-sidebar .demo-choose-skin li.active').removeClass('active');
        $('.right-sidebar .demo-choose-skin li[data-theme="'+theme+'"]').addClass('active');
    }


}

//Skin changer
function skinChanger() {
    $('.right-sidebar .demo-choose-skin li').on('click', function () {

        var $body = $('body');
        var $this = $(this);

        document.cookie = "theme="+$this.data('theme')+"; expires=Thu, 31 Dec 2018 12:00:00 UTC; path=/";

        var existTheme = $('.right-sidebar .demo-choose-skin li.active').data('theme');
        $('.right-sidebar .demo-choose-skin li').removeClass('active');
        $body.removeClass('theme-' + existTheme);
        $this.addClass('active');

        $body.addClass('theme-' + $this.data('theme'));
    });
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}