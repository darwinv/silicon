<?php
class paginacion {
	private $pag;
	private $top;
	private $pag_count;
	private $items;
	public function __construct($pag, $items, $total) {
		$this->items = $items;
		$this->top = ceil ( $total / $items ); // Obtener el maximo de paginas a mostrar
		if (($pag <= 1) || ($pag > $this->top)) : // Si la variable pagina es = 1, esta !set, tiene un valor no admitido o es > que el top ponemos valores default
			$this->pag_count = 0; // inicio para la consulta
			$this->pag = 1;
				// pagina por defecto #1
		elseif ($pag > 1) : // si la variable pagina esta set y tiene un valor permitido la iniciamos y calculamos el contador para la consulta
			$this->pag = $pag; // iniciamos la variable
			$this->pag_count = ($this->pag - 1) * $items;
				// inicamos el contador en base a la pagina
		endif;
	}
	public function get_paginacion($view = "",$q = "",$orden = "") {
		if($this->top > 1):
			if ($this->pag > 1) : // si la pagina es mayor a 1 se muestra el boton de anterior
				$calculo = $this->pag - 1;
				echo "<li><a href='?{$view}{$q}{$orden}pag=$calculo' aria-label='Anterior'><span
						aria-hidden='true'>&laquo;</span></a></li>";					
				endif;
			if ($this->pag == $this->top && ($this->pag - 4) >= 1) : // este codigo muesta en el caso de ser la pagina = top el valor del extremo izquiedo para tener 5 botones en la paginacion
				$calculo = $this->pag - 4;
				echo "<li><a href='?{$view}{$q}{$orden}pag=$calculo'>$calculo</a></li>";			
			endif;
			if (($this->pag == $this->top || $this->pag == ($this->top - 1)) && ($this->pag - 3) >= 1) : // este codigo muesta en el caso de ser la pagina = top el valor del extremo izquiedo para tener 5 botones en la paginacion
				$calculo = $this->pag - 3;
				echo "<li><a href='?{$view}{$q}{$orden}pag=$calculo'>$calculo</a></li>";			
			endif;
			for($i = ($this->pag - 2); $i <= $this->pag + 2; $i ++) : // ciclo que genera la paginacion de 5 botones, si es un extremo no muestra dos valores por eso se sacan forzados fuera del ciclo
				if ($i == $this->pag) : // si la pagina = indice del ciclo ponemos la clase active
					echo "<li class='active'><a href='?{$view}{$q}{$orden}pag=$i'>$i</a></li>";
				elseif ($i >= 1 && $i <= $this->top) : // si no verificamos q el indice este entre 1 y el top para mostrarla como boton
					echo "<li><a href='?{$view}{$q}{$orden}pag=$i'>$i</a></li>";
				endif;
			endfor; // fin del ciclo
			if ($this->pag == 1 && $this->top >= 4) : // este codigo muesta en el caso de ser la pagina = top el valor del extremo derecho para tener 5 botones en la paginacion
				echo "<li><a href='?{$view}{$q}{$orden}pag=4'>4</a></li>";			
			endif;
			if (($this->pag == 1 || $this->pag == 2) && $this->top >= 5) : // este codigo muesta en el caso de ser la pagina = top el valor del extremo derecho para tener 5 botones en la paginacion
				echo "<li><a href='?{$view}{$q}{$orden}pag=5'>5</a></li>";			
			endif;
			if ($this->pag < $this->top) : // si la pagina es mayor a 1 se muestra el boton de anterior
				$calculo = $this->pag + 1;
				echo "<li><a href='?{$view}{$q}{$orden}pag=$calculo' aria-label='Siguiente'> <span
						aria-hidden = 'true'>&raquo;</span></a></li>";
			endif;
		endif;
	}
	public function get_pag() {
		return $this->pag;
	}
	public function get_items() {
		return $this->items;
	}
	public function get_top() {
		return $this->top;
	}
	public function get_pag_count() {
		return $this->pag_count;
	}
}