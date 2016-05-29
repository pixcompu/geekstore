/**
 * Cookie manipulation wrapper with JSON content By PIXCOMPU (Felix)
 */

function CookieManager(){

    var firstCookie = document.cookie.length == 0;

    this.create = function(name, value, days){
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var cookie = {};
        cookie['value'] = value;
        cookie['expires'] = date.toGMTString();
        cookie['path'] = '\\';
        document.cookie = name  + "=" + JSON.stringify(cookie);
    };

    this.getValue = function(name){
        var cookie = JSON.parse(getStringCookie(name));
        return cookie['value'];
    };

    this.setValue = function(name, newValue){
        var cookie = JSON.parse(getStringCookie(name));
        cookie['value'] = newValue;
        document.cookie = name  + "=" + JSON.stringify(cookie);
    };

    this.erase = function(name){
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    };

    this.check = function(name){
        return document.cookie.indexOf(name+"=") != -1;
    };

    function getStringCookie(name){
        var inferiorIndex = document.cookie.indexOf(name+"=") + name.length + 1;
        var superiorIndex = document.cookie.indexOf(";", inferiorIndex);
        if( superiorIndex == -1){
            superiorIndex = document.cookie.length;
        }
        if( inferiorIndex == -1){
            throw new Error('Cookie doesnt exist!');
        }
        return document.cookie.substring(inferiorIndex, superiorIndex);
    }
}

var cookieManager = new CookieManager();