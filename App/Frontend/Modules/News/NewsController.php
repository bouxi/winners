<?php
namespace App\Frontend\Modules\News;
 
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \OCFram\FormHandler;
use \OCFram\Form;
use \OCRFram\StringField;
use \OCFram\TextField;
 
class NewsController extends BackController
{
  public function createCache()
  {
    return ['index' => '1 year'];
  }

  public function executeIndex(HTTPRequest $request) // executeIndex = afficher l'index du module (qui nous dévoilera la liste des cinq dernières news)
  {
    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
 
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreNews.' dernières news');
 
    // On récupère le manager des news.
    $manager = $this->managers->getManagerOf('News');
 
    $listeNews = $manager->getList(0, $nombreNews);
 
    foreach ($listeNews as $news)
    {
      if (strlen($news->contenu()) > $nombreCaracteres) // strlen : Calcule la taille d'une chaîne
      {
        $debut = substr($news->contenu(), 0, $nombreCaracteres); // substr : Retourne un segment de chaîne
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';  /* strrpos : Cherche la position de la dernière occurence d'une sous-chaîne dans une chaîne */
 
        $news->setContenu($debut);
      }
    }
 
    // On ajoute la variable $listeNews à la vue.
    $this->page->addVar('listeNews', $listeNews);
  }

  public function executeShow(HTTPRequest $request)
  {
    $newsId = $request->getData('id');

    $news = $this->cache->read('news_'.$newsId);

    if ($news === null)
    {
      $news = $this->managers->getManagerOf('News')->getUnique($newsId);

      if (!empty($news)) // empty : Détermine si une variable est vide. Ne pas oublié inversé du au "!"
      {
        $this->cache->write('news_'.$newsId, $news, '1 year');
      }
    }

    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }

    $comments = $this->cache->read('comments_'.$newsId);

    if ($comments === null)
    {
      $comments = $this->managers->getManagerOf('Comments')->getListOf($newsId);
      $this->cache->write('comments_'.$newsId, $comments, '1 year');
    }

    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $comments);
  }

  /* 
  public function executeShow(HTTPRequest $request)
  {
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
 
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }
 
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
  }
  */
  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'news' => $request->getData('news'),
        'auteur' => $request->postData('auteur'),
        'contenu' => $request->postData('contenu')
      ]);
    }
    else
    {
      $comment = new Comment;
    }
 
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
 
      $this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }
}