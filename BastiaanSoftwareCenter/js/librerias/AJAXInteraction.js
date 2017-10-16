function AJAXInteraction(url, callback, errorcallback) {

    var req = init();
    req.onreadystatechange = processRequest;
        
    function init() {
      if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
      } else if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    
    function processRequest () {
      if (req.readyState == 4) {
        if (req.status == 200) {
			if (callback){
				callback(req.responseText);
			}else{
				
			}
        }else{
        	if (errorcallback){
        		errorcallback(req.responseText);
        	}else{
        		alert("error al consultar informacion" + req.responseText);
        		if(cargador){
        			cargador();
        		}
        	}
        }
      }
    }

    this.doGet = function() {
      req.open("GET", url, true);
      req.send(null);
    }
    
    this.doPost = function(body) {
      req.open("POST", url, true);
      req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      req.send(body);
    }
}
