<?php

namespace JavierSeixas\PracBundle\Entity;

class Producte
{
	protected $id_producte;
	protected $preu_actual;
	protected $es_oferta;
	protected $preu_oferta;
	protected $estoc_inicial;
	protected $estoc_final;
	protected $estoc_notificacio;

	public function getIdProducte()
	{
		return $this->id_producte;
	}

	public function getPreuActual()
	{
	    return $this->preu_actual;
	}
	
	public function setPreuActual($preu_actual)
	{
	    $this->preu_actual = $preu_actual;
	
	    return $this;
	}
	
	public function getEsOferta()
	{
	    return $this->es_oferta;
	}
	
	public function setEsOferta($es_oferta)
	{
	    $this->es_oferta = $es_oferta;
	
	    return $this;
	}
	
	public function getPreuOferta()
	{
	    return $this->preu_oferta;
	}
	
	public function setPreuOferta($preu_oferta)
	{
	    $this->preu_oferta = $preu_oferta;
	
	    return $this;
	}

	public function getEstocInicial()
	{
	    return $this->estoc_inicial;
	}
	
	public function setEstocInicial($estoc_inicial)
	{
	    $this->estoc_inicial = $estoc_inicial;
	
	    return $this;
	}

	public function getEstocFinal()
	{
	    return $this->estoc_final;
	}
	
	public function setEstocFinal($estoc_final)
	{
	    $this->estoc_final = $estoc_final;
	
	    return $this;
	}

	public function getEstocNotificacio()
	{
	    return $this->estoc_notificacio;
	}
	
	public function setEstocNotificacio($estoc_notificacio)
	{
	    $this->estoc_notificacio = $estoc_notificacio;
	
	    return $this;
	}
	
}