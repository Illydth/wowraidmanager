function tooltip_charid(realm,lang,name) {

  var url = "wowchar-tooltip/charid.php?r=" + realm + "&n=" + encodeURIComponent(name) + "&lang=" + lang;
  if (lang == "de") {
	  overlib("<table cellpadding='0' border='0' class='tooltip_new_char'><tr><td><center><img src='wowchar-tooltip/image/ajax-loader.gif' border='0' align='Lade...' /><br />Suche...bitte warten.</center></td></tr></table>",VAUTO,HAUTO,FULLHTML);
  }
  else {
	  overlib("<table cellpadding='0' border='0' class='tooltip_new_char'><tr><td><center><img src='wowchar-tooltip/image/ajax-loader.gif' border='0' align='Loading...' /><br />Searching...please wait.</center></td></tr></table>",VAUTO,HAUTO,FULLHTML);
  }
  xsgetURL_char(url);
  
}


//begin UTF8
var Utf8 = {
    // public method for url encoding
    encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
		var sLength = string.length;

        for (var n = 0; n < sLength; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            } else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            } else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // public method for url decoding
    decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
		var textLength = utftext.length;
        while ( i <  textLength) {
            c = utftext.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            } else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}
//end UTF8


function xsgetURL_char(url) {
  if (window.XMLHttpRequest) { // Non-IE browsers
    response = new XMLHttpRequest();
    response.onreadystatechange = processStateChange_char;
    try {
      response.open("GET", url, true);
    } catch (e) {
            alert(e);
    }
    response.send(null);
  } else if (window.ActiveXObject) { // IE
    response = new ActiveXObject("Microsoft.XMLHTTP");
    if (response) {
      response.onreadystatechange = processStateChange_char;
      response.open("GET", url, true);
      response.send();
    }
  }
}

function processStateChange_char() {
  if (response.readyState == 4) 
  { // Complete
    if (response.status == 200) 
    { // OK response
      if (response.responseText.length > 0)
      {
        overlib(response.responseText,VAUTO,HAUTO,FULLHTML);
      }
      else
      {
        overlib("<table cellpadding='0' border='0' class='tooltip_new_char'><tr><td>Character not found!</td></tr></table>",VAUTO,HAUTO,FULLHTML);
      }
    } else {
      alert("Problem: " + response.statusText);
    }
  }
}

function tooltip_close_char() {
    if( response!=null ) {
        try { 
            response.onreadystatechange = function () {}
            response.abort();
        } 
        catch(e) {}
    }
    nd();
}
function abort(message) { throw 'Parse error in selector: ' + message; }
function reportError() {
    window.alert('Ajax error');
}





function xsgetURL2_char(url, div) {
  if (window.XMLHttpRequest) { // Non-IE browsers
    response = new XMLHttpRequest();
    try {
      response.open("GET", url, true);
	  response.onreadystatechange = function () {
        if (response.readyState == 4) {
			if (response.status == 200) {
				document.getElementById(div).innerHTML = response.responseText;
			}
     		else {
				//alert("Status is "+response.status)
			}
            //alert(response.responseText);
          }
      }
    } catch (e) {
            alert(e);
    }
    response.send(null);
  } else if (window.ActiveXObject) { // IE
    response = new ActiveXObject("Microsoft.XMLHTTP");
    if (response) {
      response.open("GET", url, true);
	  response.onreadystatechange = function () {
        if (response.readyState == 4) {
			if (response.status == 200) {
				document.getElementById(div).innerHTML = response.responseText;
			}
     		else {
				//alert("Status is "+response.status)
			}
            //alert(response.responseText);
          }
      }
      response.send();
    }
  }
}

function sendRequest_char(realm, div, name, lang) {
var xmlHttp = null;
// Mozilla, Opera, Safari sowie Internet Explorer 7
if (typeof XMLHttpRequest != 'undefined') {
    xmlHttp = new XMLHttpRequest();
}
if (!xmlHttp) {
    // Internet Explorer 6 und älter
    try {
        xmlHttp  = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
        try {
            xmlHttp  = new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e) {
            xmlHttp  = null;
        }
    }
}
if (xmlHttp) {
	var string = Utf8.encode(name);
	var neu = string.replace(/&#39;/, "'")
	var neew = neu.replace(/([^a-zA-Z0-9])/g, '-');
	
	var string_realm = Utf8.encode(realm);
	var neu_realm = string_realm.replace(/&#39;/, "'")
	var neew_realm = neu_realm.replace(/([^a-zA-Z0-9])/g, '-');
	//alert("alter String:\n" + string + "\n" + neu + "\n\nneuer String:\n" + neew);
	
    xmlHttp.open('GET', 'wowchar-tooltip/cache/'+neew_realm+'-'+neew+'-'+lang+'-name.html', true);
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById(div).innerHTML = xmlHttp.responseText;
			}
    		else if (xmlHttp.status == 404) {
				if (lang == "de") {
					document.getElementById(div).innerHTML = '<img src="wowchar-tooltip/image/ajax-loading.gif" align="top" border="0" alt="Lade..." /> ['+name+']';
				}
				else {
					document.getElementById(div).innerHTML = '<img src="wowchar-tooltip/image/ajax-loading.gif" align="top" border="0" alt="Loading..." /> ['+name+']';
				}
				xsgetURL2_char("wowchar-tooltip/charname.php?r=" + Utf8.decode(neu_realm) + "&n=" + Utf8.encode(encodeURIComponent(Utf8.decode(neu))) + "&lang=" + lang, div);
			}
     		else {
				//alert("Status is "+xmlHttp.status)
			}
            //alert(xmlHttp.responseText);
        }
    }
    xmlHttp.send(null);
}
}