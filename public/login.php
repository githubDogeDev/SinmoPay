<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SinmoPay - Logowanie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="form-page">

    <main class="auth-container">
        <div class="auth-card">
            <h2>Zaloguj się do <a href="index.php">Sinmo<span>Pay</span></a></h2>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="email">Adres e-mail</label>
                    <input type="email" id="email" name="email" placeholder="Wprowadź swój adres e-mail" required>
                </div>
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" placeholder="Wprowadź swoje hasło" required>
                </div>
                
                <div class="auth-links">
                <button type="submit" class="btn btn--primary">Zaloguj się</button>
                <a href="register.php" class='btn btn--secondary'>Nie masz konta? <span>Zarejestruj się</span></a>
            </div>
            </form>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>