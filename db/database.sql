-- phpMyAdmin SQL Dump

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- 
-- База данных: `api_db`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(256) NOT NULL,
  `lastname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(2048) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Индексы сохранённых таблиц
-- 

-- 
-- Индексы таблицы `users`
-- 
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

-- 
-- AUTO_INCREMENT для сохранённых таблиц
-- 

-- 
-- AUTO_INCREMENT для таблицы `users`
-- 
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;