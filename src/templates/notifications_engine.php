<?php
// src/templates/notifications_engine.php

// Ten plik powinien być dołączany (require_once) na każdej stronie,
// na której chcemy wyświetlać powiadomienia.

// Upewnij się, że sesja jest już rozpoczęta na stronie głównej (np. session_start() na początku index.php/register.php itp.)
// Jeśli z jakiegoś powodu ten plik jest dołączany, a sesja jeszcze nie jest rozpoczęta, to ją uruchom.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$notification_data = null;

// Sprawdź, czy w sesji istnieje zmienna 'notification'
if (isset($_SESSION['notification']) && is_array($_SESSION['notification'])) {
    // Odczytaj dane powiadomienia
    $notification_data = $_SESSION['notification'];

    // Wyczyść zmienną sesyjną, aby powiadomienie nie pokazywało się po odświeżeniu
    // Chyba że jest to zamierzone zachowanie - dla standardowych komunikatów błędu/sukcesu jest to pożądane
    unset($_SESSION['notification']);
}

// Jeśli są dane powiadomienia, wygeneruj ukryty element HTML z danymi JSON
if ($notification_data) {
    // To jest najbardziej pewny sposób:
    $json_output = json_encode($notification_data); // Tylko JSON encode
    // Teraz uciekamy wszystkie cudzysłowy i apostrofy dla atrybutu HTML
    $encoded_for_html_attribute = htmlspecialchars($json_output, ENT_QUOTES, 'UTF-8');

    echo '<div id="initial-notification-data" data-notification="' . $encoded_for_html_attribute . '"></div>';
}
?>