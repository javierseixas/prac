<?php

namespace JavierSeixas\PracBundle\Entity;

class TipusProducte
{
	protected $id_tipus_producte;
	protected $dte;

	public function get_id_tipus_producte()
	{
	    return $this->id_tipus_producte;
	}
	
	public function set_id_tipus_producte($id_tipus_producte)
	{
	    $this->id_tipus_producte = $id_tipus_producte;
	
	    return $this;
	}
	
	public function get_dte()
	{
	    return $this->dte;
	}
	
	public function set_dte($dte)
	{
	    $this->dte = $dte;
	
	    return $this;
	}
			
}