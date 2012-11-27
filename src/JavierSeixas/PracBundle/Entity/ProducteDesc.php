<?php

namespace JavierSeixas\PracBundle\Entity;

class ProducteDesc
{
	protected $idProducte;
	protected $idIdioma;
	protected $descripcioCurta;
	protected $descripcioLlarga;

	public function getIdProducte()
	{
	    return $this->idProducte;
	}
	
	public function setIdProducte($idProducte)
	{
	    $this->idProducte = $idProducte;
	
	    return $this;
	}
	
	public function getIdIdioma()
	{
	    return $this->idIdioma;
	}
	
	public function setIdIdioma($idIdioma)
	{
	    $this->idIdioma = $idIdioma;
	
	    return $this;
	}

	public function getDescripcioCurta()
	{
	    return $this->descripcioCurta;
	}
	
	public function setDescripcioCurta($descripcioCurta)
	{
	    $this->descripcioCurta = $descripcioCurta;
	
	    return $this;
	}

	public function getDescripcioLlarga()
	{
	    return $this->descripcioLlarga;
	}
	
	public function setDescripcioLlarga($descripcioLlarga)
	{
	    $this->descripcioLlarga = $descripcioLlarga;
	
	    return $this;
	}
	
	
			
	
}