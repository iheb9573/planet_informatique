<footer class="mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>Planet Informatique</h5>
          <p>Votre partenaire informatique de confiance pour tous vos besoins en matériel et services.</p>
        </div>
        <div class="col-md-4">
          <h5>Liens rapides</h5>
          <ul class="list-unstyled">
            <li><a href="<?= $basePath ?? '' ?>index.php" class="text-white">Accueil</a></li>
            <li><a href="<?= $basePath ?? '' ?>pages/produits.php" class="text-white">Produits</a></li>
            <li><a href="<?= $basePath ?? '' ?>pages/login.php" class="text-white">Mon compte</a></li>
            <!-- Nouveaux liens -->
            <li><a href="<?= $basePath ?? '' ?>pages/a-propos.php" class="text-white">À propos de nous</a></li>
            <li><a href="<?= $basePath ?? '' ?>pages/contact.php" class="text-white">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Contact</h5>
          <p><i class="fas fa-map-marker-alt me-2"></i> 123 Rue de l'Informatique, Tunis</p>
          <p><i class="fas fa-phone me-2"></i> +216 71 123 456</p>
          <p><i class="fas fa-envelope me-2"></i> contact@planet-informatique.com</p>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-12 text-center">
          <p class="mb-0">&copy; <?= date('Y') ?> Planet Informatique. Tous droits réservés.</p>
        </div>
      </div>
    </div>
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>