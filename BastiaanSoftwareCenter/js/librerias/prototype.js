/*
* funciones para manejo de clases
*/

/*
* simplifica la herencia de clases
*/
Function.prototype.inheritsFrom = function( parentClassOrObject ){ 
	if ( parentClassOrObject.constructor == Function ) 
	{ 
		//Normal Inheritance 
		this.prototype = new parentClassOrObject;
		this.prototype.constructor = this;
		this.prototype.parent = parentClassOrObject.prototype;
	} 
	else 
	{ 
		//Pure Virtual Inheritance 
		this.prototype = parentClassOrObject;
		this.prototype.constructor = this;
		this.prototype.parent = parentClassOrObject;
	} 
	return this;
} 

Array.prototype.contains = function(obj) {
  var i = this.length;
  while (i--) {
    if (this[i] === obj) {
      return i;
    }
  }
  return -1;
}

Array.prototype.indiceDe = function(obj, propiedad) {
  var i = this.length;
  while (i--) {
    if (this[i][propiedad] == obj[propiedad]) {
      return i;
    }
  }
  return -1;
}

Function.prototype.bind = function(obj) {
    var _method = this;
    return function() {
        return _method.apply(obj, arguments);
    };    
} 
