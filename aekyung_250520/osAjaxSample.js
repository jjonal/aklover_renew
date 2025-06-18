/* osAjax Copyright (c) 2008 oursu.com */

var osActive =
{
    getThese: function()
	{
	    var returnValue;
		for( var i=0; i<arguments.length; i++ )
		{
		    var lambda = arguments[i];
			try { returnValue = lambda(); break; }
			catch (e) {}
		}
		return returnValue;
	},

    getHeader: function()
	{
	    var requestHeaders = ['X-Requested-With', 'XMLHttpRequest', 'Content-type', 'application/x-www-form-urlencoded', 'Connection', 'close'];
	},

    getPort: function()
	{
	    return this.getThese( 
		function() { return new XMLHttpRequest() },
		function() { return new ActiveXObject('Msxml2.XMLHTTP') },
		function() { return new ActiveXObject('Microsoft.XMLHTTP') } 
		) || false;
    },

    getEvaluation : function( obj )
    {
		if( !obj )
		return;

	    if( typeof(obj) == 'string' )
		{ 
		    var htmlElemens = $c("div");  // 새로운 객체로 만듦
	        htmlElemens.innerHTML = obj;
		}
		else
		{
			var htmlElemens;
		    htmlElemens = obj;
		}
        
        var head = $t('head')[0];

		// script type
        var tags = htmlElemens.getElementsByTagName('script'); 
		for( var i=0; i<tags.length; i++ )
		{ 
             var match = tags[i].innerHTML;
			 if( match == "" ) // src mode
			 {
                 var script  = $c("script");
                 script.setAttribute("type", "text/javascript");
                 script.setAttribute("src", tags[i].src);

			     head.appendChild(script);
			 }

			 eval.call(window, match);
        }
        
		// link css type
        var linkFragment ='(?:<link.*?>)';
		var linkMatch = obj.match(linkFragment);

        if( linkMatch )
		{		
			var m = linkMatch.toString();
			var reg = new RegExp("[\'\"]", "g");
			var str = m.replace(reg, ""); 
			var p1 = (/(href)\W+(.+?)\.(css)/);
			var s1 = str.match(p1);

			// match 결과 가 있다면
            if( s1 )
			{
                var p2 = /(\w+)\=([^# ]*)/;
                var s2 = s1[0].toString().match(p2);

                var link  = $c("link");
			    link.rel  = 'stylesheet';
                link.type = 'text/css';
                link.setAttribute('href', s2[2]);
				head.appendChild(link);
			}
		}
	}
};

var osAjax =
{
    Hearder: osActive.getHeader(),
    Port: osActive.getPort(),

    getMethod: function( m )
	{ 
	    var useMethod = 'POST';
		if( m != undefined )
		{
	        if( m.toUpperCase() == "POST" ) useMethod = 'POST';
			else if( m.toUpperCase() == "GET" ) useMethod = 'GET';
			return useMethod;
		}
        else
		{
			alert(" plese opthons's method check! " );
		    return;
		}
	},

    getType: function( t )
	{ 
	    var useType = 'TEXT';

	    if( t != undefined )
		{
	        if( t.toUpperCase() == "TEXT" ) useType = 'TEXT';
			else if( t.toUpperCase() == "XML" ) useType = 'XML';
			return useType;
		}
        else
		{
			alert(" plese opthons's type check! " );
		    return;
		}
	},

    getOn: function( o )
	{   
	    var useOption = false;
		if( o != undefined ) 
		useOption = o;
		return useOption;
	},

    getOptions: function( options )
	{
		requestUrl = options.url;
		requestParameters = options.parameters;
        requestMethod     = this.getMethod(options.method);
		requestType       = this.getType(options.type);
		requestFailure    = this.getOn(options.onFailure);
	    requestSuccess    = this.getOn(options.onSuccess);
		requestComplete   = this.getOn(options.onComplete);
	},

	getRequest: function()
	{
        var httpRequest = this.Port;

        httpRequest.open(requestMethod, requestUrl, true);
		httpRequest.onreadystatechange = function() { osAjax.getStatus(httpRequest); };

		if( requestMethod == "POST" )
		{
            httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			httpRequest.setRequestHeader('Content-length',  requestParameters.length);
			httpRequest.setRequestHeader("Cache-Control", "no-cache");
            httpRequest.setRequestHeader("Connection", "close");
            httpRequest.send(requestParameters);
		}
		else if( requestMethod == "GET" )
		{ 
            httpRequest.setRequestHeader("Cache-Control", "no-cache");
            httpRequest.send(null);
		}
	},

	getStatus: function( httpRequest )
	{
        if( httpRequest.readyState == 4 )
	    {
            if( httpRequest.status == 200 )
			{
                var result;
				
	            if( requestType == "XML" ) 
				result = httpRequest.responseXML;

				else if( requestType == "TEXT" )
				result = httpRequest.responseText;
                
                if( requestSuccess ) // use success
				{   
                    if( requestComplete ) // use onComplete
					{
						toggle.alert( "cannot onComplete option <br />  onComplete option 을 사용하지 못합니다." );
						return;
					}

					$i(requestSuccess).innerHTML = result;

                    if( requestType != "XML" )
				    osActive.getEvaluation(result);
                }
                else
				{
                    if( requestComplete ) // use onComplete
					{
					    requestComplete(result);

                        if( requestType != "XML" )
                        osActive.getEvaluation(result);
					}
				}

			    if( $i('progress') != null )
                $i('progress').display = 'none';
            }
			else
			{
			    if( requestFailure != false ) Failure(); //  use onFailure
				//else toggle.alert('There was a problem with the request. <br>서버주소 경로를 확인 하십시요.');
			}
		}
		else
		{
			if( $i('progress') != null )
			$i('progress').display = 'block';
		}
    },

	updater: function( options )
	{
	    if( options.onSuccess && options.onComplete )
	    {
		    toggle.alert("onSuccess or onComplete <br /> 둘중에 한 옵션만 사용하십시요");
		    return;
	    }

        osAjax.getOptions(options);
	    osAjax.getRequest();
	}
};

//Ajax = new osAjax();
aUrlMove = function( url, params, em )
{
    Ajax = new osAjax.updater( 
	{ url:url, parameters:params, method:'post', type:'text', onSuccess:em } )
};

aComplete = function( url, params, method, type, complete )
{
    Ajax = new osAjax.updater( 
	{ url:url, parameters:params, method:method, type:type, onSuccess:'', onComplete:complete } )
};

// dom
$i = function( obj ) { return document.getElementById(obj); };
$t = function( obj ) { return document.getElementsByTagName(obj); };
$c = function( obj ) { return document.createElement(obj); };
$r = function( obj ) { document.body.removeChild($i(obj)); };
$d = function( obj ) { 
    var mode = $i(obj).style;
	if( mode.display == "block" )
	mode.display = 'none';
	else if( mode.visibility == "visible" )
	mode.visibility = 'hidden';
}; 