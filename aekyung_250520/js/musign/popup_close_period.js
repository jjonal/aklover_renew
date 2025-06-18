var cookieSetting = {
    setCookie: function (name, val, exp) {
        var date = new Date();
        date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
        document.cookie = name + "=" + val + ";expires=" + date.toUTCString() + ";";
    },

    getCookie: function (name) {
        var value = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
        return value ? value[2] : null;
    }
}
