<?php

namespace JavierSeixas\PracBundle\Entity;

class Idioma
{
	protected $id_idioma;
	protected $descripcio;

	public function get_id_idioma()
	{
	    return $this->id_idioma;
	}

	public function get_descripcio()
	{
	    return $this->descripcio;
	}
	
	public function set_descripcio($descripcio)
	{
	    $this->descripcio = $descripcio;
	
	    return $this;
	}
	
}
