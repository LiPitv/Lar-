<?php
include 'conexao.php';

// Busca todos os imóveis cadastrados
$sql = "SELECT * FROM imoveis";
$result = $conn->query($sql);

// Verifica se há um imóvel publicado
$sql_publicado = "SELECT * FROM imoveis WHERE publicado = 1 LIMIT 1";
$result_publicado = $conn->query($sql_publicado);
$imovel_publicado = $result_publicado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Realvine - Escolha o lugar dos seus sonhos</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/images/buildings-fill.svg" type="image/svg+xml">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body id="top">

  <!-- Header -->
  <header class="header" data-header>
    <div class="container">
      <a href="#" class="logo">
        <ion-icon name="business-outline"></ion-icon> Lar Ideal
      </a>

      <nav class="navbar container" data-navbar>
        <ul class="navbar-list">

          <li>
            <a href="Prat-1.html" class="navbar-link" data-nav-link>Home</a>
          </li>

          <li>
            <a href="casas.html" class="navbar-link" data-nav-link>Comprar</a>
          </li>

          <li>
            <a href="Sobre_nós.html" class="navbar-link" data-nav-link>Sobre nós</a>
          </li>

          <li>
            <a href="Contacto.html" class="navbar-link" data-nav-link>Contacto</a>
          </li>

        </ul>
      </nav>

      <a href="Par2-2.html" class="btn btn-secondary">Vender</a>

      <button class="nav-toggle-btn" aria-label="Toggle menu" data-nav-toggler>
        <ion-icon name="menu-outline" aria-hidden="true" class="menu-icon"></ion-icon>
        <ion-icon name="close-outline" aria-hidden="true" class="close-icon"></ion-icon>
      </button>
    </div>
  </header>

  <br><br><br><br><br>

  <!-- Imóvel Publicado -->
  <?php if ($imovel_publicado): ?>
    <section class="section property" aria-label="property">
      <div class="container">
        <h2 style="text-align: center; margin-bottom: 20px;">Imóvel Publicado</h2>
        <ul class="property-list">
          <li>
            <div class="property-card">
              <figure class="card-banner img-holder" style="--width: 800; --height: 533;">
                <img src="./assets/images/P2.jpg" width="800" height="533" loading="lazy" alt="Luanda, Talatona, Condomínio Malunga" class="img-cover">
              </figure>
              <div class="card-content">
                <h3 class="h3">
                  <a href="Detalhes da casa.html" class="card-title"><?php echo $imovel_publicado['titulo']; ?></a>
                </h3>
                <ul class="card-list">
                  <li class="card-item">
                    <div class="item-icon">
                      <ion-icon name="cube-outline"></ion-icon>
                    </div>
                    <span class="item-text"><?php echo $imovel_publicado['quartos']; ?> Quartos</span>
                  </li>
                  <li class="card-item">
                    <div class="item-icon">
                      <ion-icon name="bed-outline"></ion-icon>
                    </div>
                    <span class="item-text"><?php echo $imovel_publicado['banheiros']; ?> Banheiros</span>
                  </li>
                  <li class="card-item">
                    <div class="item-icon">
                      <ion-icon name="man-outline"></ion-icon>
                    </div>
                    <span class="item-text"><?php echo $imovel_publicado['tipo']; ?></span>
                  </li>
                </ul>
                <div class="card-meta">
                  <div>
                    <span class="meta-title">Preço</span>
                    <span class="meta-text"><?php echo $imovel_publicado['preco']; ?> AKZ</span>
                  </div>
                  <div>
                    <span class="meta-title">Venda</span>
                    <span class="meta-text"></span>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </section>
  <?php endif; ?>

  <!-- Property Section -->
  <section class="section property" aria-label="property">
    <div class="container">
      <ul class="property-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<div class='property-card'>";
                echo "<figure class='card-banner img-holder' style='--width: 800; --height: 533;'>";
                echo "<img src='./assets/images/P2.jpg' width='800' height='533' loading='lazy' alt='Luanda, Talatona, Condomínio Malunga' class='img-cover'>";
                echo "</figure>";
                echo "<div class='card-content'>";
                echo "<h3 class='h3'>";
                echo "<a href='Detalhes da casa.html' class='card-title'>" . $row["titulo"] . "</a>";
                echo "</h3>";
                echo "<ul class='card-list'>";
                echo "<li class='card-item'>";
                echo "<div class='item-icon'>";
                echo "<ion-icon name='cube-outline'></ion-icon>";
                echo "</div>";
                echo "<span class='item-text'>" . $row["quartos"] . " Quartos</span>";
                echo "</li>";
                echo "<li class='card-item'>";
                echo "<div class='item-icon'>";
                echo "<ion-icon name='bed-outline'></ion-icon>";
                echo "</div>";
                echo "<span class='item-text'>" . $row["banheiros"] . " Banheiros</span>";
                echo "</li>";
                echo "<li class='card-item'>";
                echo "<div class='item-icon'>";
                echo "<ion-icon name='man-outline'></ion-icon>";
                echo "</div>";
                echo "<span class='item-text'>" . $row["tipo"] . "</span>";
                echo "</li>";
                echo "</ul>";
                echo "<div class='card-meta'>";
                echo "<div>";
                echo "<span class='meta-title'>Preço</span>";
                echo "<span class='meta-text'>" . $row["preco"] . " AKZ</span>";
                echo "</div>";
                echo "<div>";
                echo "<span class='meta-title'>Venda</span>";
                echo "<span class='meta-text'></span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
        } else {
            echo "<li>Nenhum imóvel cadastrado.</li>";
        }
        ?>
      </ul>
    </div>
  </section>

  <!-- Navigation Buttons -->
  <div class="navigation-buttons" style="display: flex; justify-content: center; margin: 20px 0;">
    <a href="casas.html" class="btn btn-secondary" style="margin-right: 10px;">Anterior</a>
    <a href="casas2.html" class="btn btn-secondary">Próximo</a>
  </div>

  <!-- Back to Top -->
  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="arrow-up" aria-hidden="true"></ion-icon>
  </a>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-top">
      <div class="container">
        <div class="footer-brand">
          <a href="#" class="logo">
            <ion-icon name="business-outline"></ion-icon> Realvine
          </a>
          <p class="footer-text">
            Uma ótima plataforma para comprar, vender e alugar seus imóveis sem nenhum agente ou comissão.
          </p>
        </div>

        <ul class="footer-list">
          <li>
            <p class="footer-list-title">Empresa</p>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Sobre nós</span>
            </a>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Serviços</span>
            </a>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Preços</span>
            </a>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Blog</span>
            </a>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Conecte-se</span>
            </a>
          </li>
        </ul>

        <ul class="footer-list">
          <li>
            <p class="footer-list-title">Links úteis</p>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Termos de Serviços</span>
            </a>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Política de Privacidade</span>
            </a>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Listagem</span>
            </a>
          </li>
          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward"></ion-icon>
              <span class="span">Contato</span>
            </a>
          </li>
        </ul>

        <ul class="footer-list">
          <li>
            <p class="footer-list-title">Detalhes de contato</p>
          </li>
          <li class="footer-item">
            <ion-icon name="location-outline"></ion-icon>
            <address class="address">
              C/54 Northwest Freeway,<br>
              Suite 558,<br>
              Houston, USA 485
              <a href="#" class="address-link">Ver no mapa do Google</a>
            </address>
          </li>
          <li class="footer-item">
            <ion-icon name="mail-outline"></ion-icon>
            <a href="mailto:contact@example.com" class="footer-link">marquesbilaliedson@gmail.com</a>
          </li>
          <li class="footer-item">
            <ion-icon name="call-outline"></ion-icon>
            <a href="tel:+244930728358" class="footer-link">+244 930 728 358</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <p class="copyright">
          &copy; 2024 Realvine. Todos os direitos reservados por <a href="#" class="copyright-link">LiPi1_18</a>.
        </p>
        <ul class="social-list">
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </footer>

  <!-- Back to Top -->
  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="arrow-up" aria-hidden="true"></ion-icon>
  </a>

  <!-- Custom JS -->
  <script src="./assets/js/script.js" defer></script>

  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>