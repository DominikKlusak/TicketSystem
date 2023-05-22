-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Sty 2023, 18:16
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ticketsystem`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `chat_wiadomosci`
--

CREATE TABLE `chat_wiadomosci` (
  `id` int(11) NOT NULL,
  `przeczytane` enum('tak','nie') DEFAULT 'nie',
  `sesja_id` varchar(255) DEFAULT NULL,
  `data_add` datetime DEFAULT NULL,
  `kto_dodal` int(11) DEFAULT NULL,
  `wiadomosc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `chat_wiadomosci`
--

INSERT INTO `chat_wiadomosci` (`id`, `przeczytane`, `sesja_id`, `data_add`, `kto_dodal`, `wiadomosc`) VALUES
(3, 'nie', 'p4uaj3etf1ghap90ul50qh1sbm', '2023-01-15 21:05:22', 10, 'Test2'),
(4, 'tak', 'ndb7gthkoukduojmr5jjjk23po', '2023-01-15 21:14:47', 0, 'Aaaa'),
(5, 'nie', 'p4uaj3etf1ghap90ul50qh1sbm', '2023-01-15 21:15:52', 10, 'Hello'),
(24, 'tak', '6j8vef2jhriqfsli2i29gitifc', '2023-01-16 13:39:27', 0, 'Witam.'),
(25, 'tak', '6j8vef2jhriqfsli2i29gitifc', '2023-01-16 13:42:04', 10, 'Witam serdecznie, w czym mogę pom&oacute;c?'),
(26, 'tak', '6j8vef2jhriqfsli2i29gitifc', '2023-01-16 13:46:46', 10, 'halo?'),
(27, 'tak', '6j8vef2jhriqfsli2i29gitifc', '2023-01-16 13:47:47', 0, 'Jestem jestm'),
(32, 'tak', '6j8vef2jhriqfsli2i29gitifc', '2023-01-16 13:52:35', 10, 'To w czym mogę pom&oacute;c?'),
(33, 'tak', '6j8vef2jhriqfsli2i29gitifc', '2023-01-16 13:52:52', 0, 'A już sobie poradziłem. Dziękuję.'),
(34, 'tak', '6j8vef2jhriqfsli2i29gitifc', '2023-01-16 13:53:01', 10, 'Okej :)');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `historia_zamowien`
--

CREATE TABLE `historia_zamowien` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `zam_id` int(11) DEFAULT NULL,
  `czynnosc` varchar(255) DEFAULT NULL,
  `data_czynnosci` datetime DEFAULT NULL,
  `status` enum('on','off') DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `historia_zamowien`
--

INSERT INTO `historia_zamowien` (`id`, `user_id`, `zam_id`, `czynnosc`, `data_czynnosci`, `status`) VALUES
(1, 10, 10, 'Zmieniono dane zamówienia.', '2023-01-15 19:50:40', 'on'),
(2, 10, 12, 'Wysłano maila z powiadomieniem.', '2023-01-15 20:11:49', 'on'),
(6, 10, 10, 'Zmieniono status zamówienia na: wysłane .', '2023-01-15 20:22:04', 'on'),
(7, 10, 10, 'Przydzielono opiekuna: Administrator .', '2023-01-15 20:39:06', 'on'),
(8, 10, 10, 'Zmieniono status zamówienia na: zrealizowane .', '2023-01-15 20:39:58', 'on'),
(9, 10, 12, 'Zmieniono status zamówienia na: anulowane .', '2023-01-15 20:41:40', 'on'),
(10, 10, 0, 'Wysłano maila z powiadomieniem.', '2023-01-16 14:35:30', 'on'),
(11, 10, 10, 'Zmieniono dane zamówienia.', '2023-01-16 18:24:31', 'on'),
(12, 10, 10, 'Zmieniono dane zamówienia.', '2023-01-16 18:24:31', 'on'),
(13, 10, 10, 'Zmieniono status zamówienia na: wysłane .', '2023-01-16 18:27:51', 'on'),
(14, 10, 10, 'Zmieniono status zamówienia na: zrealizowane .', '2023-01-16 18:31:55', 'on');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kontakt`
--

CREATE TABLE `kontakt` (
  `id` int(11) NOT NULL,
  `kanal` varchar(30) DEFAULT NULL,
  `sesja_id` varchar(255) DEFAULT NULL,
  `imie` varchar(45) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `temat` varchar(45) DEFAULT NULL,
  `wiadomosc` text DEFAULT NULL,
  `kiedy_wyslano` datetime DEFAULT NULL,
  `status` enum('on','off') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kontakt`
--

INSERT INTO `kontakt` (`id`, `kanal`, `sesja_id`, `imie`, `email`, `temat`, `wiadomosc`, `kiedy_wyslano`, `status`) VALUES
(2, 'FORMULARZ', NULL, 'Tester', 'test@gmail.com', 'Test temat', 'Test wiadomość', '2023-01-07 15:12:25', 'on'),
(19, 'EMAIL', NULL, NULL, 'bok@firma.interia.pl', 'Logowanie_z_nowego_urządzenia', NULL, '2023-01-11 17:21:07', 'on'),
(20, 'EMAIL', NULL, NULL, 'mojnowysklep1@interia.pl', 'Testowa', NULL, '2023-01-11 18:31:12', 'on'),
(23, 'EMAIL', NULL, NULL, 'mojnowysklep1@interia.pl', 'Testowa -2Bd2lhZG9tb7bm 2', NULL, '2023-01-11 19:16:56', 'on'),
(25, 'EMAIL', NULL, NULL, 'bok@firma.interia.pl', 'Logowanie_z_nowego_urządzenia', NULL, '2023-01-14 22:38:23', 'on'),
(26, 'CHAT', 'ndb7gthkoukduojmr5jjjk23po', 'ndb7gthkoukduojmr5jjjk23po', 'ndb7gthkoukduojmr5jjjk23po', 'Aaaa', 'Aaaa', '2023-01-15 21:14:47', 'on'),
(27, 'CHAT', 'p4uaj3etf1ghap90ul50qh1sbm', 'p4uaj3etf1ghap90ul50qh1sbm', 'p4uaj3etf1ghap90ul50qh1sbm', 'Hello', 'Hello', '2023-01-15 21:15:52', 'on'),
(28, 'EMAIL', NULL, NULL, 'bok@firma.interia.pl', 'Blokada_konta._Sprawdź,_co_zrobić_dalej.', NULL, '2023-01-15 21:51:17', 'on'),
(31, 'CHAT', '6j8vef2jhriqfsli2i29gitifc', '6j8vef2jhriqfsli2i29gitifc', '6j8vef2jhriqfsli2i29gitifc', 'No spoko', 'No spoko', '2023-01-16 11:54:41', 'on'),
(32, 'FORMULARZ', NULL, 'Mariusz', 'kkkowalski@interia.pl', 'Test', 'Witam, chciałbym się zapytać czy możliwy jest rabat przy większym zam&oacute;wieniu', '2023-01-16 13:58:53', 'on'),
(51, 'EMAIL', NULL, NULL, 'bok@firma.interia.pl', 'Logowanie_z_nowego_urządzenia', NULL, '2023-01-16 14:37:21', 'on'),
(52, 'FORMULARZ', NULL, 'Lucek', 'lucek@gmail.com', 'Pytanie', 'Witam, jak się powodzi?', '2023-01-16 14:49:00', 'on'),
(53, 'EMAIL', NULL, NULL, 'MAILER-DAEMON@interia.pl', 'Niedostarczona Wiadomosc Zwrocona do Nadawcy ', NULL, '2023-01-18 18:59:05', 'on'),
(54, 'EMAIL', NULL, NULL, 'MAILER-DAEMON@interia.pl', 'Niedostarczona Wiadomosc Zwrocona do Nadawcy ', NULL, '2023-01-18 18:59:05', 'on'),
(55, 'EMAIL', NULL, NULL, 'noreply@tpay.com', 'Nowa_transakcja_płatnicza_TR-BRA-82J3SMX_za_O', NULL, '2023-01-18 20:02:10', 'on'),
(56, 'EMAIL', NULL, NULL, 'noreply@tpay.com', 'Nowa transakcja TR-BRA-82J3SMX', NULL, '2023-01-18 20:02:15', 'on'),
(57, 'EMAIL', NULL, NULL, 'noreply@tpay.com', 'Potwierdzenie_transakcji_TR-BRA-82J3SMX_za_Op', NULL, '2023-01-18 20:02:16', 'on'),
(58, 'EMAIL', NULL, NULL, 'noreply@tpay.com', 'Nowa_transakcja_płatnicza_TR-BRA-82J46GX_za_O', NULL, '2023-01-18 20:03:40', 'on'),
(59, 'EMAIL', NULL, NULL, 'noreply@tpay.com', 'Nowa transakcja TR-BRA-82J46GX', NULL, '2023-01-18 20:03:48', 'on'),
(60, 'EMAIL', NULL, NULL, 'noreply@tpay.com', 'Potwierdzenie_transakcji_TR-BRA-82J46GX_za_Op', NULL, '2023-01-18 20:03:49', 'on');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `id` int(11) NOT NULL,
  `produkt_id` int(11) DEFAULT NULL,
  `sesja` varchar(255) DEFAULT NULL,
  `aktywny` enum('on','off') DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `koszyk`
--

INSERT INTO `koszyk` (`id`, `produkt_id`, `sesja`, `aktywny`) VALUES
(47, 6, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(48, 5, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(49, 6, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(50, 5, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(56, 7, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(57, 3, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(60, 7, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(61, 5, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(62, 1, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(63, 2, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(64, 9, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(65, 4, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(66, 4, 'ndb7gthkoukduojmr5jjjk23po', 'off'),
(67, 3, 'ndb7gthkoukduojmr5jjjk23po', 'off');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL,
  `stara_cena` decimal(10,2) DEFAULT 0.00,
  `promocja` enum('on','off') DEFAULT 'off',
  `zdjecie` varchar(255) DEFAULT NULL,
  `status` enum('on','off') DEFAULT 'off'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id`, `nazwa`, `cena`, `stara_cena`, `promocja`, `zdjecie`, `status`) VALUES
(1, 'Buty', '99.00', '0.00', 'off', 'zdjecia/buty.png', 'on'),
(2, 'Kapelusz', '59.99', '0.00', 'off', 'zdjecia/kapelusz.png', 'on'),
(3, 'Spodnie', '199.99', '0.00', 'off', 'zdjecia/spodnie.jpg', 'on'),
(4, 'Sweter', '75.00', '0.00', 'off', 'zdjecia/sweter.jpg', 'on'),
(5, 'Szpilki', '120.00', '0.00', 'off', 'zdjecia/szpilki.jpg', 'on'),
(6, 'Torebka', '299.00', '0.00', 'off', 'zdjecia/torebka.jpg', 'on'),
(7, 'Plecak', '110.99', '0.00', 'off', 'zdjecia/plecak.jpg', 'on'),
(8, 'Koszulka', '30.00', '0.00', 'off', 'zdjecia/koszulka.png', 'off'),
(9, 'Okulary', '85.00', '0.00', 'off', 'zdjecia/okulary.jpg', 'on');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `haslo` varchar(255) DEFAULT NULL,
  `imie` varchar(255) DEFAULT NULL,
  `nazwisko` varchar(255) DEFAULT NULL,
  `zdjecie` varchar(255) DEFAULT NULL,
  `miasto` varchar(255) DEFAULT NULL,
  `kraj` varchar(255) DEFAULT NULL,
  `ulica` varchar(255) DEFAULT NULL,
  `administrator` enum('tak','nie') DEFAULT 'nie',
  `state` enum('on','off') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `haslo`, `imie`, `nazwisko`, `zdjecie`, `miasto`, `kraj`, `ulica`, `administrator`, `state`) VALUES
(1, 'test@gmail.com', 'c445fa82f7c36d10c14d7a8950550abd', 'Janeczek', 'Kowalskii', 'img/avatar4123121.png', 'Testowee', 'Polska', 'ul. Czekoladowa 5', 'nie', 'on'),
(10, 'administrator@gmail.com', 'c445fa82f7c36d10c14d7a8950550abd', 'Administrator', '', 'img/avatar5123110.png', '', 'Polska', 'ul. Administratorska', 'tak', 'on'),
(13, 'tester@gmail.com', 'c445fa82f7c36d10c14d7a8950550abd', 'Tester', 'Tester', 'img/default.png', 'Test', 'Test', 'Test', 'tak', 'on'),
(14, 'admin2@gmail.com', 'ecc4208a7778c1d76e7e89c5253128c5', 'admin2', '', 'img/default.png', '', '', '', 'tak', 'off'),
(15, 'casddasid@gmail.com', 'c445fa82f7c36d10c14d7a8950550abd', 'Aaaa', 'bbbbb', 'img/default.png', 'Test', 'Test', 'Test', 'nie', 'on'),
(16, 'tes32131t@gmail.com', 'c445fa82f7c36d10c14d7a8950550abd', 'Spoko', 'Oko', 'img/default.png', 'Test', 'Test', 'Test', 'nie', 'on');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia_klientow`
--

CREATE TABLE `zamowienia_klientow` (
  `id` int(11) NOT NULL,
  `user_login` varchar(100) DEFAULT NULL,
  `data_zam` datetime DEFAULT NULL,
  `produkt_id` text DEFAULT NULL,
  `sesja_id` varchar(255) DEFAULT NULL,
  `imie` varchar(40) DEFAULT NULL,
  `nazwisko` varchar(40) DEFAULT NULL,
  `kraj` varchar(60) DEFAULT NULL,
  `miasto` varchar(60) DEFAULT NULL,
  `ulica` varchar(40) DEFAULT NULL,
  `kurierDPD` enum('tak','nie') DEFAULT NULL,
  `kurierINPOST` enum('tak','nie') DEFAULT NULL,
  `uwagi` text DEFAULT NULL,
  `status` enum('złożone','wysłane','anulowane','zrealizowane') DEFAULT 'złożone'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamowienia_klientow`
--

INSERT INTO `zamowienia_klientow` (`id`, `user_login`, `data_zam`, `produkt_id`, `sesja_id`, `imie`, `nazwisko`, `kraj`, `miasto`, `ulica`, `kurierDPD`, `kurierINPOST`, `uwagi`, `status`) VALUES
(10, 'test@gmail.com', '2023-01-11 17:17:16', '5-6', 'ndb7gthkoukduojmr5jjjk23po', 'Katarzynaa', 'Kowalska', 'Polska', 'Mysłowice', 'ul. Kolorowa 6', 'nie', 'nie', '', 'zrealizowane'),
(11, 'administrator@gmail.com', '2022-12-06 17:17:21', '1-2', 'ndb7gthkoukduojmr5jjjk23po', 'Arek', 'Milik', 'Polska', 'Kraków', 'ul. Krakowska 33', 'nie', 'nie', 'Abra', 'wysłane'),
(12, 'kmakuszynski@gmail.com', '2023-01-14 19:11:00', '3-7', 'ndb7gthkoukduojmr5jjjk23po', 'Kornel', 'Makuszyński', 'Polska', 'Zakopane', 'ul. Zakopiańska 33', 'tak', 'nie', 'Tak szybko jak to możliwe', 'anulowane'),
(13, 'mkrawczyk@gmail.com', '2023-01-18 19:53:04', '7', 'ndb7gthkoukduojmr5jjjk23po', 'Maciej', 'Krawczyk', 'Polska', 'Katowice', 'ul. Katowicka', 'tak', 'nie', '', 'złożone'),
(14, 'testowski@gmail.com', '2023-01-18 19:54:57', '5', 'ndb7gthkoukduojmr5jjjk23po', 'Tester', 'Testowski', 'Polska', 'Krak&oacute;w', 'Krakowska', 'nie', 'tak', '', 'złożone'),
(15, 'here@gmail.com', '2023-01-18 20:00:51', '2-1', 'ndb7gthkoukduojmr5jjjk23po', 'Here', 'Here', 'Test', 'Krak&oacute;w', 'ul. Kolorowa', 'tak', 'nie', '', 'złożone'),
(16, 'dsadas@gmail.com', '2023-01-18 20:01:40', '4-9', 'ndb7gthkoukduojmr5jjjk23po', 'mmm', 'dddd', 'Test', 'Test', 'Test', 'nie', 'tak', '', 'złożone'),
(17, 'test@gmail.com', '2023-01-18 20:03:19', '3-4', 'ndb7gthkoukduojmr5jjjk23po', 'Test', 'Test1', 'Test123', 'Test', 'Test', 'tak', 'nie', '', 'złożone');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `chat_wiadomosci`
--
ALTER TABLE `chat_wiadomosci`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `historia_zamowien`
--
ALTER TABLE `historia_zamowien`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kontakt`
--
ALTER TABLE `kontakt`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowienia_klientow`
--
ALTER TABLE `zamowienia_klientow`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `chat_wiadomosci`
--
ALTER TABLE `chat_wiadomosci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT dla tabeli `historia_zamowien`
--
ALTER TABLE `historia_zamowien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `kontakt`
--
ALTER TABLE `kontakt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `zamowienia_klientow`
--
ALTER TABLE `zamowienia_klientow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
