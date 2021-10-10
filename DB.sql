-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 11 2021 г., 01:03
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `soundcloud`
--

-- --------------------------------------------------------

--
-- Структура таблицы `artistsc`
--

CREATE TABLE `artistsc` (
  `id_artist` int NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudonym` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `followers` int NOT NULL,
  `last_up` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Структура таблицы `songsc`
--

CREATE TABLE `songsc` (
  `id_song` int NOT NULL,
  `song_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sings_artist` int NOT NULL,
  `duration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `artistsc`
--
ALTER TABLE `artistsc`
  ADD PRIMARY KEY (`id_artist`);

--
-- Индексы таблицы `songsc`
--
ALTER TABLE `songsc`
  ADD PRIMARY KEY (`id_song`),
  ADD KEY `songsc_ibfk_1` (`sings_artist`);


--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `songsc`
--
ALTER TABLE `songsc`
  ADD CONSTRAINT `songsc_ibfk_1` FOREIGN KEY (`sings_artist`) REFERENCES `artistsc` (`id_artist`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
