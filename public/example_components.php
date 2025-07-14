<?php
// public/example_components.php
session_start(); // To musi być na samym początku pliku!

// --- PHP do obsługi formularza testowego ---
// Ten blok MUSI być przed jakimkolwiek outputem HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $duration_val = isset($_POST['duration']) ? (int)$_POST['duration'] : 5000;
    if ($duration_val < 0) { $duration_val = 0; }

    $_SESSION['notification'] = [
        'message' => htmlspecialchars($_POST['message'] ?? 'Brak komunikatu', ENT_QUOTES, 'UTF-8'),
        'type' => htmlspecialchars($_POST['type'] ?? 'info', ENT_QUOTES, 'UTF-8'),
        'duration' => $duration_val,
        'dismissible' => isset($_POST['dismissible'])
    ];
    header('Location: example_components.php'); // To wywołanie musi być przed outputem
    exit(); // Ważne: Zakończ skrypt po przekierowaniu
}

// --- WAŻNE: Dołącz notifications_engine.php TUTAJ ---
// require_once '../src/templates/notifications_engine.php';
// Ten plik również generuje HTML, więc powinien być dołączony po obróbce POST
// i przed głównym outputem HTML, ale nie na samym początku.
// Najlepiej, aby został dołączony zaraz przed zamknięciem tagu </body>,
// jak to już zrobiliśmy w poprzedniej instrukcji,
// ale po całej logice nagłówków i przekierowań.
// Dlatego zostawiamy to require_once na dole pliku, tak jak było.

// reszta kodu HTML zaczyna się poniżej...
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SinmoPay - Wspólne Rozliczanie Kosztów</title>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header style="padding: 20px; text-align: center; border-bottom: 1px solid var(--border-color-light);">
        <h1>SinmoPay</h1>
        <button id="theme-toggle" class="btn btn--outline">Przełącz tryb</button>
    </header>

    <main style="max-width: 800px; margin: 40px auto; padding: 20px; flex-grow: 1;">
        <h2>Przykładowe Komponenty UI</h2>

        <h3>Przyciski</h3>
        <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 30px;">
            <button class="btn">Główny Przycisk</button>
            <button class="btn btn--secondary">Drugi Przycisk</button>
            <button class="btn btn--outline">Przycisk Outline</button>
            <button class="btn btn--outline-secondary">Drugi Outline</button>
            <button class="btn btn--small">Mały Przycisk</button>
            <a href="#" class="btn btn--secondary">Przycisk jako Link</a>
        </div>

        <h3>Karty</h3>
        <div class="card">
            <h3>Karta Grupy: Wycieczka w Tatry</h3>
            <p>Ostatni wydatek: Nocleg - 500 PLN</p>
            <p>Twoje saldo w grupie: **-25.00 PLN**</p>
            <button class="btn btn--small">Zobacz szczegóły</button>
        </div>

        <div class="card">
            <h3>Karta Wydatku: Obiad w restauracji</h3>
            <p>Kwota: 120.00 PLN</p>
            <p>Zapłacono przez: Jan Kowalski</p>
            <p>Uczestnicy: Jan, Anna, Piotr</p>
            <p>Kategoria: Jedzenie</p>
            <button class="btn btn--small btn--outline">Edytuj wydatek</button>
        </div>

        <h3>Pola Formularzy</h3>
        <div class="card">
            <form>
                <div class="form-group">
                    <label for="username">Nazwa użytkownika:</label>
                    <input type="text" id="username" name="username" placeholder="Wprowadź swoją nazwę">
                </div>

                <div class="form-group">
                    <label for="email">Adres E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="email@example.com">
                </div>

                <div class="form-group">
                    <label for="password">Hasło:</label>
                    <input type="password" id="password" name="password" placeholder="*****">
                </div>

                <div class="form-group">
                    <label for="message">Wiadomość:</label>
                    <textarea id="message" name="message" placeholder="Twoja wiadomość..."></textarea>
                </div>

                <button type="submit" class="btn">Wyślij formularz</button>
                <button type="reset" class="btn btn--outline">Resetuj</button>
            </form>
        </div>

          <h3>Kontrolki Wyboru</h3>
        <div class="card">
            <h4>Checkboxy</h4>
            <div class="form-group">
                <label class="checkbox-container">
                    <input type="checkbox" name="option1" value="value1" checked>
                    <span class="checkmark">
                        <i class="material-icons">check</i> </span>
                    <span class="checkbox-label">Zaznaczona opcja</span>
                </label>
                <label class="checkbox-container">
                    <input type="checkbox" name="option2" value="value2">
                    <span class="checkmark">
                        <i class="material-icons">check</i> </span>
                    <span class="checkbox-label">Niezaznaczona opcja</span>
                </label>
            </div>

            <h4>Radio Buttony</h4>
            <div class="form-group">
                <label class="radio-container">
                    <input type="radio" name="radio-group" value="radio1" checked>
                    <span class="radiomark"></span>
                    <span class="radio-label">Opcja radiowa 1</span>
                </label>
                <label class="radio-container">
                    <input type="radio" name="radio-group" value="radio2">
                    <span class="radiomark"></span>
                    <span class="radio-label">Opcja radiowa 2</span>
                </label>
            </div>

            <h4>Toggle Switch (iOS Style)</h4>
            <div class="form-group">
                <label class="switch-container">
                    <input type="checkbox" name="notifications" checked>
                    <span class="switch-slider"></span>
                    <span class="switch-label">Włącz powiadomienia</span>
                </label>
                <label class="switch-container">
                    <input type="checkbox" name="darkmode_pref">
                    <span class="switch-slider"></span>
                    <span class="switch-label">Preferuj tryb ciemny</span>
                </label>
            </div>
        </div>

        <h3>Test Powiadomień Banerowych</h3>
        <div class="card">
            <form action="example_components.php" method="POST">
                <div class="form-group">
                    <label for="message">Treść komunikatu:</label>
                    <textarea id="message" name="message" rows="3" required>To jest testowe powiadomienie.</textarea>
                </div>
                <div class="form-group">
                    <label for="type">Typ komunikatu:</label>
                    <select id="type" name="type" required>
                        <option value="success">Success</option>
                        <option value="error">Error</option>
                        <option value="info">Info</option>
                        <option value="warning">Warning</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="duration">Czas trwania (ms, 0 = bez auto-zamykania):</label>
                    <input type="number" id="duration" name="duration" value="5000" min="0">
                </div>
                <div class="form-group">
                    <label class="checkbox-container">
                        <input type="checkbox" id="dismissible" name="dismissible" checked>
                        <span class="checkmark"><i class="material-icons">check</i></span>
                        <span class="checkbox-label">Możliwość zamknięcia (przycisk X)</span>
                    </label>
                </div>
                <button type="submit" class="btn btn--primary">Wyślij powiadomienie</button>
            </form>
        </div>

    </main>

    <footer style="padding: 20px; text-align: center; margin-top: auto;">
        <p>&copy; 2025 SinmoPay</p>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <?php
    // Ten require_once pozostał na dole, ponieważ generuje HTML,
    // który jest potem odczytywany przez JavaScript.
    require_once '../src/templates/notifications_engine.php';
    ?>
</body>
</html>