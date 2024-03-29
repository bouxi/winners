<?php
namespace OCFram;
 
abstract class BackController extends ApplicationComponent
{
  protected $action = '';
  protected $module = '';
  protected $page = null;
  protected $view = '';
  protected $managers = null;
  protected $cache = null;
 
  public function __construct(Application $app, $module, $action)
  {
    parent::__construct($app);
 
    $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    $this->page = new Page($app);
    $this->cache = new Cache(__DIR__.'/../../tmp/cache/datas', __DIR__.'/../../tmp/cache/views');
 
    $this->setModule($module);
    $this->setAction($action);
    $this->setView($action);
  }
 
  public function execute()
  {
    $method = 'execute'.ucfirst($this->action);  // ucfirst = Met le premier caractère en majuscule
 
    if (!is_callable([$this, $method]))  // is_callable = Détermine si l'argument peut être appelé comme fonction
    {
      throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
    }
 
    $this->$method($this->app->httpRequest());
  }

  public function module()
  {
    return $this->module;
  }

  public function action()
  {
    return $this->action;
  }

  public function cache()
  {
    return $this->cache;
  }
 
  public function page()
  {
    return $this->page;
  }
 
  public function setModule($module)
  {
    if (!is_string($module) || empty($module))
    {
      throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
    }
 
    $this->module = $module;
  }
 
  public function setAction($action)
  {
    if (!is_string($action) || empty($action))
    {
      throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
    }
 
    $this->action = $action;
  }
 
  public function setView($view)
  {
    if (!is_string($view) || empty($view))
    {
      throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
    }
 
    $this->view = $view;
 
    $this->page->setContentFile(__DIR__.'/../../App/'.$this->app->name().'/Modules/'.$this->module.'/Views/'.$this->view.'.php');
  }
}