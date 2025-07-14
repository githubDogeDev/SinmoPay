<?php
// public/process_register.php

// 1. Rozpoczęcie sesji
// Sesja jest niezbędna do przechowywania komunikatów o błędach/sukcesie
// oraz danych formularza między przekierowaniami.
session_start();

// 2. Załączenie pliku z połączeniem do bazy danych
// Używamy 'require_once', aby upewnić się, że plik jest załączony tylko raz
// i że skrypt zatrzyma się, jeśli plik nie zostanie znaleziony.
// Ścieżka "../src/php/Database.php" oznacza:
// - "../" wyjdź z katalogu 'public' do katalogu głównego projektu 'MY_APP/'
// - "src/php/Database.php" wejdź do 'src', potem do 'php', i załaduj 'Database.php'.
require_once '../src/php/Database.php';

// Zmienne do przechowywania błędów walidacji i starych danych formularza
$errors = []; // Pusta tablica do gromadzenia komunikatów o błędach
$old_input = []; // Tablica do przechowywania danych wprowadzonych przez użytkownika (oprócz haseł)

// 3. Sprawdzenie, czy żądanie jest metodą POST
// Skrypt powinien przetwarzać dane tylko wtedy, gdy formularz został wysłany
// metodą POST. Bezpośrednie wejście na ten plik metodą GET powinno być zablokowane.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 4. Odbieranie i czyszczenie danych z formularza
    // $_POST[] zawiera dane wysłane z formularza HTML.
    // trim() usuwa białe znaki (spacje, tabulatory, nowe linie) z początku i końca stringa.
    // ?? '' to operator 'null coalescing' (PHP 7+), który przypisuje pusty string,
    // jeśli dany indeks w $_POST nie istnieje (zapobiega błędom 'undefined index').
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // Hasła nie czyścimy trimem, bo białe znaki mogą być celowe
    $confirmPassword = $_POST['confirm-password'] ?? '';

    // Zachowaj stare dane wejściowe w sesji (oprócz haseł)
    // To pozwala na ponowne wypełnienie formularza po błędzie walidacji,
    // co poprawia doświadczenie użytkownika.
    $old_input['username'] = $username;
    $old_input['email'] = $email;
    $_SESSION['old_input'] = $old_input; // Zapisz całą tablicę do sesji

    // 5. Walidacja danych
    // Przeprowadzamy serię sprawdzeń, aby upewnić się, że dane są poprawne i bezpieczne.

    // Walidacja nazwy użytkownika
    if (empty($username)) {
        $errors[] = 'Nazwa użytkownika jest wymagana.';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Nazwa użytkownika musi mieć co najmniej 3 znaki.';
    } elseif (strlen($username) > 50) {
        $errors[] = 'Nazwa użytkownika jest zbyt długa (maksymalnie 50 znaków).';
    }

    // Walidacja adresu e-mail
    if (empty($email)) {
        $errors[] = 'Adres e-mail jest wymagany.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Sprawdza poprawność formatu e-maila
        $errors[] = 'Niepoprawny format adresu e-mail.';
    } elseif (strlen($email) > 100) {
        $errors[] = 'Adres e-mail jest zbyt długi (maksymalnie 100 znaków).';
    }

    // Walidacja hasła
    if (empty($password)) {
        $errors[] = 'Hasło jest wymagane.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Hasło musi mieć co najmniej 8 znaków.';
    } elseif (!preg_match('/[A-Z]/', $password)) { // Wymaga co najmniej jednej dużej litery
        $errors[] = 'Hasło musi zawierać co najmniej jedną dużą literę.';
    } elseif (!preg_match('/[a-z]/', $password)) { // Wymaga co najmniej jednej małej litery
        $errors[] = 'Hasło musi zawierać co najmniej jedną małą literę.';
    } elseif (!preg_match('/[0-9]/', $password)) { // Wymaga co najmniej jednej cyfry
        $errors[] = 'Hasło musi zawierać co najmniej jedną cyfrę.';
    } elseif (!preg_match('/[^a-zA-Z0-9]/', $password)) { // Wymaga co najmniej jednego znaku specjalnego
        $errors[] = 'Hasło musi zawierać co najmniej jeden znak specjalny (np. !, @, #, $).';
    }

    // Walidacja potwierdzenia hasła
    if ($password !== $confirmPassword) {
        $errors[] = 'Hasła nie pasują do siebie.';
    }

    // 6. Sprawdzenie unikalności e-maila i nazwy użytkownika w bazie danych
    // Ten krok wykonujemy tylko, jeśli wcześniejsze walidacje (format, długość itp.) przeszły,
    // aby uniknąć zbędnego obciążania bazy danych.
    if (empty($errors)) {
        try {
            $pdo = getDbConnection(); // Uzyskaj obiekt PDO do połączenia z bazą danych

            // Sprawdzenie, czy podany adres e-mail już istnieje
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetchColumn() > 0) { // fetchColumn() pobiera wartość z pierwszej kolumny pierwszego wiersza
                $errors[] = 'Podany adres e-mail jest już zarejestrowany.';
            }

            // Sprawdzenie, czy podana nazwa użytkownika już istnieje (jeśli chcesz, aby były unikalne)
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = 'Nazwa użytkownika jest już zajęta.';
            }

        } catch (PDOException $e) {
            // W przypadku błędu bazy danych podczas sprawdzania unikalności
            $errors[] = 'Wystąpił błąd podczas weryfikacji danych. Spróbuj ponownie później.';
            // WAŻNE: W środowisku produkcyjnym powinieneś zalogować $e->getMessage() do pliku logów,
            // zamiast wyświetlać go użytkownikowi.
            error_log('Błąd sprawdzania unikalności użytkownika: ' . $e->getMessage());
        }
    }

    // 7. Obsługa błędów walidacji
    // Jeśli po wszystkich sprawdzeniach tablica $errors nie jest pusta,
    // oznacza to, że są błędy.
    if (!empty($errors)) {
        // Zapisz komunikat o błędach do sesji.
        // implode('. ', $errors) łączy wszystkie błędy w jeden string, rozdzielając je kropką i spacją.
        $_SESSION['registration_error'] = implode('. ', $errors);

        // Przekieruj użytkownika z powrotem na stronę rejestracji.
        header('Location: register.php');
        exit(); // Zakończ działanie skryptu po przekierowaniu.
    }

    // 8. Hashowanie hasła i zapis do bazy danych
    // Jeśli wszystkie walidacje przeszły pomyślnie, czas zahaszować hasło
    // i zapisać nowego użytkownika.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Bezpieczne hashowanie hasła

    try {
        $pdo = getDbConnection(); // Ponownie uzyskaj połączenie z bazą danych

        // Przygotowanie zapytania SQL INSERT
        // Używamy prepared statements (:placeholder), aby zapobiec atakom SQL Injection.
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at, updated_at) VALUES (:username, :email, :password, NOW(), NOW())");

        // Wykonanie zapytania z przypisaniem wartości do placeholderów
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        // 9. Przekierowanie po udanej rejestracji
        // Użytkownik został pomyślnie zarejestrowany.
        // Ustaw komunikat o sukcesie w sesji.
        $_SESSION['registration_success'] = 'Konto zostało pomyślnie utworzone! Możesz się teraz zalogować.';

        // Przekieruj użytkownika na stronę logowania.
        header('Location: login.php'); // Zakładamy, że masz plik public/login.php
        exit();

    } catch (PDOException $e) {
        // 10. Obsługa błędów zapisu do bazy danych
        // Jeśli wystąpi błąd podczas próby zapisu do bazy danych.
        $_SESSION['registration_error'] = 'Wystąpił błąd podczas tworzenia konta. Spróbuj ponownie później.';
        // WAŻNE: W środowisku produkcyjnym: error_log('Błąd zapisu użytkownika do DB: ' . $e->getMessage());
        error_log('Błąd zapisu użytkownika do DB: ' . $e->getMessage());

        // Przekieruj z powrotem na stronę rejestracji z komunikatem o błędzie.
        header('Location: register.php');
        exit();
    }

} else {
    // 11. Obsługa bezpośredniego dostępu (GET request)
    // Jeśli ktoś próbuje wejść bezpośrednio na process_register.php (np. wpisując URL w przeglądarce),
    // przekieruj go z powrotem na stronę rejestracji, ponieważ ten plik jest przeznaczony tylko
    // do przetwarzania danych POST z formularza.
    header('Location: register.php');
    exit();
}