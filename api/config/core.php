<?php

// Показ сообщений об ошибках
error_reporting(E_ALL);
 
// Установим часовой пояс по умолчанию
date_default_timezone_set("Europe/Moscow");
 
// Переменные, используемые для JWT
$key = "DSGFGS53";
$iss = "https://cv38872.tmweb.ru/";
$aud = "https://cv38872.tmweb.ru/";
$iat = 1356999524;
$nbf = 1357000000;