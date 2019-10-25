<?php
/* 
Sert a obtenir l'application à laquelle l'objet appartient.
Cette classe se chargera juste de stocker, pendant la construction de l'objet, l'instance de l'application exécutée.
*/
namespace OCFram;

abstract class ApplicationComponent 
{
  protected $app;
  
  public function __construct(Application $app)
  {
    $this->app = $app;
  }
  
  public function app()
  {
    return $this->app;
  }
}