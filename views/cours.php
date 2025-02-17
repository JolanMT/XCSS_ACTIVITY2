<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cours SCSS</title>
  <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
  <?php
  echo '
  <nav class="navbar">
  <div class="nav-container">
      <a href="index.php?page=home" class="nav-logo">SCSS Quiz</a>
      <div class="nav-links">';

  if (isset($username) && !empty($username)) {
    echo "<div class='user-info'>";

    if (isset($profilePicturePath) && !empty($profilePicturePath)) {
      echo "<img src='$profilePicturePath' alt='Profile Picture' class='profile-picture'>";
    } else {
      echo "<img src='public/images/default-profile.png' alt='Default Profile Picture' class='profile-picture'>";
    }

    echo "<span class='welcome-message'>Bonjour, <strong>$username</strong></span>";
    echo '<a href="handlers/logout_handler.php" class="btn-logout">Déconnexion</a>';
    echo '</div>';
  } else {
    echo '<a href="index.php?page=login" class="btn-login">Se connecter</a>
    <a href="index.php?page=register" class="btn-register">S\'inscrire</a>';
  }

  echo '      </div>
  </div>
</nav>
';
  ?>

  <section id="coursSection">
    <a href="index.php?page=home" class="btn-back">Retour à l'accueil</a>
    <h1>Cours sur SCSS</h1>
    <p>SCSS (Sassy CSS) est une extension de CSS qui introduit des fonctionnalités avancées pour faciliter l'écriture, la gestion et la réutilisation des styles.</p>

    <h2>1. Introduction à SCSS</h2>
    <p>L'extension de fichier pour SCSS est <code>.scss</code>, tandis que celle pour la syntaxe classique de Sass est <code>.sass</code>. SCSS est compatible avec CSS standard, ce qui signifie que tout fichier CSS valide est également un fichier SCSS valide.</p>

    <div class="code-block">
      <pre>
                <code>
<span class="variable">$primary-color</span>: <span class="value">#3498db</span>;
<span class="variable">$secondary-color</span>: <span class="value">#2ecc71</span>;

<span class="selector">body</span> {
  <span class="property">background-color</span>: <span class="variable">$primary-color</span>;
  <span class="property">color</span>: <span class="variable">$secondary-color</span>;
}
                </code>
            </pre>
    </div>

    <p>Ce code définit deux variables pour stocker des couleurs et les applique ensuite au fond et au texte du <code>body</code>.</p>

    <h2>2. Variables en SCSS</h2>
    <p>SCSS permet d'utiliser des variables pour stocker des valeurs réutilisables :</p>

    <div class="code-block">
      <pre>
                <code>
<span class="variable">$font-size</span>: <span class="value">16px</span>;
<span class="variable">$main-padding</span>: <span class="value">20px</span>;

<span class="selector">body</span> {
  <span class="property">font-size</span>: <span class="variable">$font-size</span>;
  <span class="property">padding</span>: <span class="variable">$main-padding</span>;
}
                </code>
            </pre>
    </div>

    <h2>3. Mixins</h2>
    <p>Les mixins permettent de réutiliser des blocs de styles :</p>

    <div class="code-block">
      <pre>
                <code>
<span class="keyword">@mixin</span> <span class="function">border-radius</span>(<span class="variable">$radius</span>) {
  <span class="property">border-radius</span>: <span class="variable">$radius</span>;
}

<span class="selector">.button</span> {
  <span class="property">padding</span>: <span class="value">10px 20px</span>;
  <span class="property">background-color</span>: <span class="variable">$primary-color</span>;
  <span class="property">color</span>: <span class="value">white</span>;
  <span class="keyword">@include</span> <span class="function">border-radius</span>(<span class="value">5px</span>);
}
                </code>
            </pre>
    </div>

    <h2>4. Boucles en SCSS</h2>
    <p>SCSS permet d'utiliser des boucles pour générer des styles dynamiques :</p>

    <div class="code-block">
      <pre>
                <code>
<span class="keyword">@for</span> <span class="variable">$i</span> <span class="keyword">from</span> <span class="value">1</span> <span class="keyword">through</span> <span class="value">3</span> {
  <span class="selector">.box-#{$i}</span> {
    <span class="property">width</span>: <span class="value">100px</span> * <span class="variable">$i</span>;
  }
}
                </code>
            </pre>
    </div>


    <h1>Cours sur SCSS</h1>

    <h2>5. Imbrication en SCSS</h2>
    <p>SCSS permet d'imbriquer les sélecteurs pour une organisation plus propre du code :</p>

    <div class="code-block">
        <pre>
            <code>
<span class="selector">.menu</span> {
  <span class="property">background</span>: <span class="value">#333</span>;
  <span class="selector">ul</span> {
    <span class="property">list-style</span>: <span class="value">none</span>;
    <span class="selector">li</span> {
      <span class="property">display</span>: <span class="value">inline-block</span>;
    }
  }
}
            </code>
        </pre>
    </div>

    <h3>Résultat CSS :</h3>
    <div class="code-block">
        <pre>
            <code>
.menu {
  background: #333;
}
.menu ul {
  list-style: none;
}
.menu ul li {
  display: inline-block;
}
            </code>
        </pre>
    </div>

    <h2>6. @Extend</h2>
    <p>@extend permet de partager des styles entre plusieurs classes, optimisant le CSS généré.</p>
    <div class="code-block">
        <pre>
            <code>
<span class="selector">.btn</span> {
  <span class="property">padding</span>: <span class="value">10px</span>;
  <span class="property">border-radius</span>: <span class="value">5px</span>;
}

<span class="selector">.btn-primary</span> {
  <span class="keyword">@extend</span> <span class="selector">.btn</span>;
  <span class="property">background</span>: <span class="value">#3498db</span>;
}
            </code>
        </pre>
    </div>

    <h3>Résultat CSS :</h3>
    <div class="code-block">
        <pre>
            <code>
.btn, .btn-primary {
  padding: 10px;
  border-radius: 5px;
}
.btn-primary {
  background: #3498db;
}
            </code>
        </pre>
    </div>

    <h2>8. Boucles (@for)</h2>
    <p>SCSS permet de générer dynamiquement des classes grâce aux boucles :</p>
    <div class="code-block">
        <pre>
            <code>
<span class="keyword">@for</span> <span class="variable">$i</span> <span class="keyword">from</span> <span class="value">1</span> <span class="keyword">through</span> <span class="value">3</span> {
  <span class="selector">.col-#{$i}</span> {
    <span class="property">width</span>: <span class="value">100px</span> * <span class="variable">$i</span>;
  }
}
            </code>
        </pre>
    </div>

    <h3>Résultat CSS :</h3>
    <div class="code-block">
        <pre>
            <code>
.col-1 {
  width: 100px;
}
.col-2 {
  width: 200px;
}
.col-3 {
  width: 300px;
}
            </code>
        </pre>
    </div>

    <h2>9. @Each</h2>
    <p>Cette directive permet d'itérer sur une liste de valeurs :</p>
    <div class="code-block">
        <pre>
            <code>
<span class="variable">$colors</span>: <span class="value">red, blue, green</span>;

<span class="keyword">@each</span> <span class="variable">$color</span> <span class="keyword">in</span> <span class="variable">$colors</span> {
  <span class="selector">.text-#{$color}</span> {
    <span class="property">color</span>: <span class="variable">$color</span>;
  }
}
            </code>
        </pre>
    </div>

    <h3>Résultat CSS :</h3>
    <div class="code-block">
        <pre>
            <code>
.text-red {
  color: red;
}
.text-blue {
  color: blue;
}
.text-green {
  color: green;
}
            </code>
        </pre>
    </div>

    <a href="index.php?page=home" class="btn-back">Retour à l'accueil</a>
</section>

  <br>
  <br>
</body>

</html>