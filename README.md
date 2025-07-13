# SinmoPay

**SinmoPay** to aplikacja webowa stworzona z myślą o wspólnym rozliczaniu i dzieleniu kosztów w grupach. Idealna dla współlokatorów, przyjaciół na wakacjach, rodzin czy studentów, którzy chcą w prosty i przejrzysty sposób zarządzać wspólnymi wydatkami i rozliczeniami.

---

## Główne Funkcjonalności (MVP)

* **Zarządzanie Użytkownikami**: Rejestracja, logowanie, zarządzanie profilem.
* **Tworzenie i Zarządzanie Grupami**: Tworzenie grup, dodawanie członków, system ról (Owner, Moderator, Member) z różnymi uprawnieniami.
* **Dodawanie i Dzielenie Wydatków**: Intuicyjne wprowadzanie kosztów, możliwość dzielenia ich po równo lub w niestandardowych proporcjach między członków grupy.
* **Rozliczenia Grupowe**: Przejrzyste podsumowanie należności i zobowiązań w ramach każdej grupy.
* **Nowoczesny i Responsywny UI**: Minimalistyczny design inspirowany aplikacjami takimi jak Revolut czy Notion, z obsługą trybu jasnego i ciemnego, dostosowany do różnych rozmiarów ekranów (desktop, tablet, mobile).

---

## Technologie

* **Frontend**:
    * **HTML5**: Struktura i semantyka strony.
    * **SCSS (Sass)**: Preprocesor CSS do modularnego i rozszerzalnego stylowania.
    * **jQuery**: Szybkie i efektywne manipulacje DOM oraz obsługa interakcji użytkownika.
* **Backend**:
    * **PHP**: Główny język programowania po stronie serwera.
* **Baza Danych**:
    * **MySQL**: Relacyjna baza danych do przechowywania danych użytkowników, grup i wydatków.

---

## Instalacja i Uruchomienie

1.  **Sklonuj repozytorium:**
    ```bash
    git clone [https://github.com/TwojaNazwaUzytkownika/sinmopay.git](https://github.com/TwojaNazwaUzytkownika/sinmopay.git)
    cd sinmopay
    ```
2.  **Skonfiguruj Bazę Danych:**
    * Utwórz nową bazę danych MySQL (np. `sinmopay_db`).
    * Wykonaj skrypty SQL znajdujące się w katalogu `src/sql/` (lub innym miejscu, gdzie je umieścisz) aby stworzyć wymagane tabele.
    * Skonfiguruj połączenie z bazą danych w pliku konfiguracyjnym PHP (np. `src/php/config.php` - do stworzenia w przyszłości).
3.  **Wymagania PHP:**
    * Upewnij się, że masz zainstalowany PHP (zalecana wersja 7.4+ lub 8.x).
    * **Upewnij się, że Twój serwer webowy (np. Apache w XAMPP) jest uruchomiony i serwuje pliki z katalogu `public/`.**
4.  **Zainstaluj zależności front-endowe (Sass):**
    * Upewnij się, że masz zainstalowany Node.js i npm.
    * W katalogu głównym projektu (gdzie jest `package.json`), uruchom:
        ```bash
        npm install
        ```
        Spowoduje to zainstalowanie wszystkich zależności deweloperskich (w tym Sassa).
5.  **Uruchom Kompilator SCSS (ważne podczas pracy nad CSS):**
    * **Otwórz nowe okno terminala.**
    * Przejdź do katalogu głównego projektu i uruchom:
        ```bash
        npm run watch:sass
        ```
        **Pozostaw to okno terminala otwarte w tle** podczas pracy nad plikami SCSS. Będzie ono automatycznie kompilować zmiany do `public/css/style.css`.
6.  **Otwórz w przeglądarce:**
    * Przejdź do adresu URL, pod którym skonfigurowałeś aplikację (np. `http://localhost/sinmopay/`).

---

## Autor

* **[Twoja Nazwa/Pseudonim]** - *Początkujący Solo Developer*

---

## Licencja

Ten projekt jest objęty licencją [Wstaw tutaj rodzaj licencji, np. MIT License] - zobacz plik [LICENSE.md](LICENSE.md) po szczegóły.