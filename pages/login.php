<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 0.75rem;
            background: #0061f2;
            border: none;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #0056d6;
            transform: translateY(-2px);
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <h2 class="text-center mb-4">Connexion</h2>
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-info">
                            <?= $_SESSION['message'] ?>
                            <?php unset($_SESSION['message']); ?>
                        </div>
                    <?php endif; ?>
                    <form action="../handlers/login_handler.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="motdepasse" class="form-label">Mot de passe</label>
                            <div class="password-container">
                                <input type="password" class="form-control" name="motdepasse" id="motdepasse" required>
                                <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Se connecter</button>
                        <div class="text-center">
                            <a href="register.php" class="text-decoration-none">Pas encore inscrit ? Créer un compte</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('motdepasse');
        const toggleIcon = document.querySelector('.toggle-password');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>
