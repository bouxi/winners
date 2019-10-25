<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : 'Winners' ?>
    </title>
    
    <meta charset="utf-8" />
    
    <link rel="stylesheet" href="/css/Envision.css" type="text/css" />
  </head>
  
  <body>
    <div id="wrap">
      <header>
        <h1><a href="/">Mon super site</a></h1>
        <p>Comment ça, il n'y a presque rien ?</p>
      </header>
      
      <nav>
        <ul>
          <li><a href="/">Accueil</a></li>
          <?php if ($membre->isAuthenticated()) { ?>
          <li><a href="/membre/membre-profil.html">Profil</a></li>
          <li><a href="/membre/membre-deconnexion.html">Déconnexion</a></li>
          <?php } 
           ?>
          
        </ul>
      </nav>
      
      <div id="content-wrap">
        <section id="main">
          <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
          
          <?= $content ?>
        </section>
      </div>
    
      <footer></footer>
    </div>
  </body>
</html>