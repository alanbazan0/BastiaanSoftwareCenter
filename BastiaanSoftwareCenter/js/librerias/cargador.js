var cargador;
/*
* funcion del cargador de datos
*/
 function spinner(holderid, R1, R2, count, stroke_width, colour) {
    var sectorsCount = count || 12,
        color = colour || "#fff",
        width = stroke_width || 15,
        r1 = Math.min(R1, R2) || 35,
        r2 = Math.max(R1, R2) || 60,
        cx = r2 + width,
        cy = r2 + width,
        r = Raphael(holderid, r2 * 2 + width * 2, r2 * 2 + width * 2),
        
        sectors = [],
        opacity = [],
        beta = 2 * Math.PI / sectorsCount,

        pathParams = {stroke: color, "stroke-width": width, "stroke-linecap": "round"};
        Raphael.getColor.reset();
    for (var i = 0; i < sectorsCount; i++) {
        var alpha = beta * i - Math.PI / 2,
            cos = Math.cos(alpha),
            sin = Math.sin(alpha);
        opacity[i] = 1 / sectorsCount * i;
        sectors[i] = r.path([["M", cx + r1 * cos, cy + r1 * sin], ["L", cx + r2 * cos, cy + r2 * sin]]).attr(pathParams);
        if (color == "rainbow") {
            sectors[i].attr("stroke", Raphael.getColor());
        }
    }
    var tick;
    (function ticker() {
        opacity.unshift(opacity.pop());
        for (var i = 0; i < sectorsCount; i++) {
            sectors[i].attr("opacity", opacity[i]);
        }
        r.safari();
        tick = setTimeout(ticker, 1000 / sectorsCount);
    })();
    return function () {
        clearTimeout(tick);
        r.remove();
    };
}

Cargador = function(id) {

	this._id = id;
	this._queriesActivos = 0;
	
	/*
	* esta funcion se ejecuta al iniciar un query
	* incrementa el numero de queries activos y si hay exactamente uno, crea un cargador
	*/
	this.iniciaQuery = function (){
		this._queriesActivos++;
		//alert(this._queriesActivos);
		if(this._queriesActivos == 1){
			cargador = spinner("cargador", 25, 40, 55, 2, "#fff");
			//			cargador = spinner("cargador", 18, 11, 45, 2, "#fff");
		}
	}
	
	/*
	* esta funcion se ejecuta al finalizar un query
	* disminuye el numero de queries activos y si ya no hay ninguno activo desaparece el cargador
	*/
	this.finalizaQuery = function(){
		this._queriesActivos--;
		//alert(this._queriesActivos);
		if(this._queriesActivos == 0){
			// usar try catch
			try {cargador();}catch(e){}
		}
	}
};