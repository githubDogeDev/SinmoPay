<?php
// src/php/Database.php

// Definicje stałych do połączenia z bazą danych
// Upewnij się, że te wartości są zgodne z Twoją konfiguracją XAMPP i bazą danych
define('DB_HOST', 'localhost'); // Zazwyczaj 'localhost'
define('DB_USER', 'root');     // Domyślny użytkownik XAMPP MySQL
define('DB_PASS', '');         // Domyślne puste hasło dla użytkownika 'root' w XAMPP
define('DB_NAME', 'sinmopay_db'); // Nazwa Twojej bazy danych, którą utworzyłeś/aś

/**
 * Funkcja do nawiązywania połączenia z bazą danych za pomocą PDO.
 * @return PDO Obiekt PDO reprezentujący aktywne połączenie z bazą danych.
 * @throws PDOException Jeśli wystąpi błąd podczas próby połączenia.
 */
function getDbConnection() {
    try {
        // Data Source Name (DSN) dla MySQL
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        // Utworzenie nowego obiektu PDO
        $pdo = new PDO($dsn, DB_USER, DB_PASS);

        // Ustawienie atrybutów PDO dla lepszego zarządzania błędami i pobierania danych
        // PDO::ATTR_ERRMODE: Ustawia tryb raportowania błędów. PDO::ERRMODE_EXCEPTION
        // powoduje, że PDO będzie rzucać wyjątki (PDOException) w przypadku błędów,
        // co jest znacznie lepsze niż tryb cichy lub ostrzeżeń do debugowania.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // PDO::ATTR_DEFAULT_FETCH_MODE: Ustawia domyślny tryb pobierania danych.
        // PDO::FETCH_ASSOC powoduje, że wyniki są zwracane jako tablice asocjacyjne (klucz => wartość),
        // gdzie kluczem jest nazwa kolumny.
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo; // Zwróć obiekt połączenia
    } catch (PDOException $e) {
        // W przypadku błędu połączenia, wyświetl komunikat i zakończ skrypt.
        // W środowisku produkcyjnym powinieneś zalogować błąd do pliku logów,
        // a użytkownikowi wyświetlić ogólny, przyjazny komunikat.
        die('Błąd połączenia z bazą danych: ' . $e->getMessage());
    }
} 