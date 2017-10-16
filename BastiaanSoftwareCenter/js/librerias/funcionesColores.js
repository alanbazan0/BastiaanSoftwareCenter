/*
* regresa el brillo de un objeto, usado para determinar el color de los labels
* recibe el color en el formato #ff00ff
*/

function getBrillo(rgb){
	var r = parseInt(rgb.substring(1,3),16);
	var g = parseInt(rgb.substring(3,5),16);
	var b = parseInt(rgb.substring(5,7),16);
	return (r + g + b )/3;
}

/**
 * Converts an RGB color value to HSL. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
 * Assumes r, g, and b are contained in the set [0, 255] and
 * returns h, s, and l in the set [0, 1].
 *
 * @param   Number  r       The red color value
 * @param   Number  g       The green color value
 * @param   Number  b       The blue color value
 * @return  Array           The HSL representation
 */
function rgbToHsl(r, g, b){
    r /= 255, g /= 255, b /= 255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2;

    if(max == min){
        h = s = 0; // achromatic
    }else{
        var d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch(max){
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
        }
        h /= 6;
    }

    return [h, s, l];
}

/**
 * Converts an HSL color value to RGB. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
 * Assumes h, s, and l are contained in the set [0, 1] and
 * returns r, g, and b in the set [0, 255].
 *
 * @param   Number  h       The hue
 * @param   Number  s       The saturation
 * @param   Number  l       The lightness
 * @return  Array           The RGB representation
 */
function hslToRgb(h, s, l){
    var r, g, b;

    if(s == 0){
        r = g = b = l; // achromatic
    }else{
        function hue2rgb(p, q, t){
            if(t < 0) t += 1;
            if(t > 1) t -= 1;
            if(t < 1/6) return p + (q - p) * 6 * t;
            if(t < 1/2) return q;
            if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
            return p;
        }

        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        var p = 2 * l - q;
        r = hue2rgb(p, q, h + 1/3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1/3);
    }

    return [r * 255, g * 255, b * 255];
}

/**
 * Converts an RGB color value to HSV. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSV_color_space.
 * Assumes r, g, and b are contained in the set [0, 255] and
 * returns h, s, and v in the set [0, 1].
 *
 * @param   Number  r       The red color value
 * @param   Number  g       The green color value
 * @param   Number  b       The blue color value
 * @return  Array           The HSV representation
 */
function rgbToHsv(r, g, b){
    r = r/255, g = g/255, b = b/255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b);
    var h, s, v = max;

    var d = max - min;
    s = max == 0 ? 0 : d / max;

    if(max == min){
        h = 0; // achromatic
    }else{
        switch(max){
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
        }
        h /= 6;
    }

    return [h, s, v];
}

/**
 * Converts an HSV color value to RGB. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSV_color_space.
 * Assumes h, s, and v are contained in the set [0, 1] and
 * returns r, g, and b in the set [0, 255].
 *
 * @param   Number  h       The hue
 * @param   Number  s       The saturation
 * @param   Number  v       The value
 * @return  Array           The RGB representation
 */
function hsvToRgb(h, s, v){
    var r, g, b;

    var i = Math.floor(h * 6);
    var f = h * 6 - i;
    var p = v * (1 - s);
    var q = v * (1 - f * s);
    var t = v * (1 - (1 - f) * s);

    switch(i % 6){
        case 0: r = v, g = t, b = p; break;
        case 1: r = q, g = v, b = p; break;
        case 2: r = p, g = v, b = t; break;
        case 3: r = p, g = q, b = v; break;
        case 4: r = t, g = p, b = v; break;
        case 5: r = v, g = p, b = q; break;
    }

    return [r * 255, g * 255, b * 255];
}

/*
* esta funcion convierte un color de microsoft a hexadecimal
*
*/
function decimalColorToHTMLcolor(number) {
     var intnumber = number - 0;
     var red, green, blue;
     var template = "#000000";
     blue = (intnumber&0x0000ff);
     green = intnumber&0x00ff00;
     red = (intnumber&0xff0000);
     intnumber = red|green|blue;
     var HTMLcolor = intnumber.toString(16);
     HTMLcolor = template.substring(0,7 - HTMLcolor.length) + HTMLcolor;
     return HTMLcolor;
}


/*
* esta funcion convierte un color de hexadecimal a microsoft
*/
function HTMLcolorTodecimalColor( HTMLcolor) {
	var hexString = HTMLcolor.substring(1, HTMLcolor.length)
    var color = parseInt(hexString, 16);
	return color;
}

/*
* esta funcion convierte un color de microsoft invertido a hexadecimal pero con RGb invertidos
* 
*/
function decimalColorToHTMLcolorInv(number) {
     var intnumber = number - 0;
     var red, green, blue;
     var template = "#000000";
     red = (intnumber&0x0000ff) << 16;
     green = intnumber&0x00ff00;
     blue = (intnumber&0xff0000) >>> 16;
     intnumber = red|green|blue;
     var HTMLcolor = intnumber.toString(16);
     HTMLcolor = template.substring(0,7 - HTMLcolor.length) + HTMLcolor;
     return HTMLcolor;
} 

/*
* esta funcion oscurece un color html
* 0 - 1.00
*/
function oscurecerHTMLcolor(htmlColor, porcentaje) {

     var red, green, blue;
     blue = parseInt(htmlColor.substring(5,7),16);
     green = parseInt(htmlColor.substring(3,5),16);
     red = parseInt(htmlColor.substring(1,3),16);
     blue = parseInt(porcentaje*blue);
     green = parseInt(porcentaje*green);
     red = parseInt(porcentaje*red);
	decColor = red + 256 * green + 65536 * blue;
	 var clo = decimalColorToHTMLcolorInv(decColor);
    return clo; 
}

/*
* esta funcion nos regresa un arreglo de colores html
*/
function obtenerColores() {               //amarillo, naranja,lavanda ,   rosa,      gris,      marron, violeta
    return ["#ff0000","#00ff00","#0000ff","#ffff00","#FF8000","#8000FF","#FF8080","#808080","#800000","#800080"];
}

/*
* esta funcion nos regresa un arreglo de colores html, en un contraste menor
*/
function obtenerColores2() {
    return ["#000000","#00ff00","#0000ff","#ffff00","#FF8000","#8000FF","#FF8080","#808080","#800000","#800080",
    		"#000000","#00ff00","#0000ff","#ffff00","#FF8000","#8000FF","#FF8080","#808080","#800000","#800080",
    		"#000000","#00ff00","#0000ff","#ffff00","#FF8000","#8000FF","#FF8080","#808080","#800000","#800080",
    		"#000000","#00ff00","#0000ff","#ffff00","#FF8000","#8000FF","#FF8080","#808080","#800000","#800080",
    		"#000000","#00ff00","#0000ff","#ffff00","#FF8000","#8000FF","#FF8080","#808080","#800000","#800080"];
}


/*
* esta funcion nos regresa un arreglo de colores html
*/
function obtenerColoresDegradados() {
    return ["90-#ff0000-#9d0000","90-#00ff00-#009d00","90-#0000ff-#00009d","90-#ffff00-#A99200","90-#FF8000-#AA6000","90-#8000FF-#420373","90-#FF8080-#FF8888","90-#808080-#00009d","90-#800000-#00009d","90-#800080-#4D0178"]; 
}

