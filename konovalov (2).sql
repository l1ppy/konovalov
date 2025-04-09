-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 05 2025 г., 17:27
-- Версия сервера: 5.7.33-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `konovalov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `checki`
--

CREATE TABLE `checki` (
  `id_checki` int(11) NOT NULL,
  `id_tovar` int(11) NOT NULL,
  `id_manager` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `kolichestvo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `checki`
--

INSERT INTO `checki` (`id_checki`, `id_tovar`, `id_manager`, `id_client`, `date`, `kolichestvo`) VALUES
(1, 3, 5, 11, '2025-04-05 16:39:17', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `fio` text COLLATE utf8mb4_unicode_ci,
  `number` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `pasport` text COLLATE utf8mb4_unicode_ci,
  `login` text COLLATE utf8mb4_unicode_ci,
  `password` text COLLATE utf8mb4_unicode_ci,
  `avatar` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id_client`, `fio`, `number`, `email`, `pasport`, `login`, `password`, `avatar`) VALUES
(9, 'sadsad', 'adsasd', 'dfsdsf@list.ru', 'sadasdsad', 'asdasd', '202cb962ac59075b964b07152d234b70', 'uploads/default_avatar.png'),
(10, 'sadsad', 'adsasd', 'dfsdsf@list.ru', 'sadasdsad', 'asdasd', '202cb962ac59075b964b07152d234b70', 'uploads/default_avatar.png'),
(11, 'sadsad', '563453453', 'dfsdsf@list.ru', 'у34ывавыа', 'йци', '202cb962ac59075b964b07152d234b70', 'uploads/photo_3_2024-08-26_17-20-07.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `manager`
--

CREATE TABLE `manager` (
  `id_manager` int(11) NOT NULL,
  `fio` text COLLATE utf8mb4_unicode_ci,
  `number` text COLLATE utf8mb4_unicode_ci,
  `login` text COLLATE utf8mb4_unicode_ci,
  `password` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `manager`
--

INSERT INTO `manager` (`id_manager`, `fio`, `number`, `login`, `password`) VALUES
(2, 'Саламонов Юрий Олегович', '+79215446788', 'protocoll', '1112'),
(3, 'Поставьте Пожалуйста Отлично', '+79215446788', 'abs', '1111'),
(5, 'Агеев Станислав Николаевич', '+79221445593', 'ubivashka', 'special_killer07');

-- --------------------------------------------------------

--
-- Структура таблицы `postavki`
--

CREATE TABLE `postavki` (
  `id_postavki` int(11) NOT NULL,
  `nazvanie` text COLLATE utf8mb4_unicode_ci,
  `city` text COLLATE utf8mb4_unicode_ci,
  `number` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `postavki`
--

INSERT INTO `postavki` (`id_postavki`, `nazvanie`, `city`, `number`) VALUES
(1, 'БыстроЕд', 'Санкт-Петербург', '88002201212'),
(2, 'Магазин Оп!', 'МСК', '989 876 45 87'),
(3, 'Ну, ПОГОДИ!', 'МСК', '989 454 56 78');

-- --------------------------------------------------------

--
-- Структура таблицы `tovar`
--

CREATE TABLE `tovar` (
  `id_tovar` int(11) NOT NULL,
  `nazvanie` text COLLATE utf8mb4_unicode_ci,
  `price` int(11) DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `opisanie` text COLLATE utf8mb4_unicode_ci,
  `id_type` int(11) NOT NULL,
  `id_postavki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tovar`
--

INSERT INTO `tovar` (`id_tovar`, `nazvanie`, `price`, `image`, `opisanie`, `id_type`, `id_postavki`) VALUES
(1, 'Paralax Ultra2000', 20000, 'uploads/1.jpg', 'Функция СНПЧ делает Paralax Ultra2000 отличным выбором для тех, кто часто пользуется принтером и хочет максимально снизить стоимость печати и обслуживания. Порадует модель и возможностью печати непосредственно со смартфона, и качеством распечатанных материалов, и функцией фотопечати.', 1, 1),
(2, 'Asus', 78725, 'uploads/2.jpg', 'Если Asus Legion 7 Pro 16IRX8H все-таки придется немного доработать для того, чтобы получить идеальный игровой ноутбук, то Asus G834JY SCAR 18 в такой доработке не нуждается в принципе. Правда, и стоит этот монстр хорошо, а его вес достигает 3,1 кг.', 2, 2),
(3, 'Acer', 88456, 'uploads/3.jpg', 'Доминируйте в играх благодаря сочетанию мощного процессора AMD Ryzen™ серии 6000 и видеокарты NVIDIA® GeForce RTX™ 3070 Ti (с полной оптимизацией для максимальной производительности). Высокая скорость и большой объем памяти благодаря двум разъемам M.2 PCIe и поддержке до 32 ГБ ОЗУ DDR5 4800. (Технические характеристики могут различаться в зависимости от модели)', 2, 3),
(4, 'Samsung', 46675, 'uploads/4.jpg', 'это небольшое электронное устройство, состоящее из различных радиоэлементов и помещенное в неразборный корпус. Зачем она нужна? По сути, это «кирпичик», благодаря которому происходит миниатюризация проблем для работоспособности электроники.', 3, 1),
(5, 'Apple', 42000, 'uploads/5.jpg', 'Наушники Apple AirPods Pro 2 оставляют впечатление продукта высокого качества, что можно ожидать от Apple. Их дизайн, функциональность и звуковые возможности делают их чрезвычайно привлекательными для пользователей, ценящих современные технологии и комфорт в использовании.', 5, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `type`
--

CREATE TABLE `type` (
  `id_type` int(11) NOT NULL,
  `nazvanie` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `type`
--

INSERT INTO `type` (`id_type`, `nazvanie`) VALUES
(1, 'Принтер'),
(2, 'Ноутбук'),
(3, 'Микросхема'),
(4, 'Мышка'),
(5, 'Наушники');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `checki`
--
ALTER TABLE `checki`
  ADD PRIMARY KEY (`id_checki`),
  ADD KEY `id_tovar` (`id_tovar`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_manager` (`id_manager`);

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Индексы таблицы `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id_manager`);

--
-- Индексы таблицы `postavki`
--
ALTER TABLE `postavki`
  ADD PRIMARY KEY (`id_postavki`);

--
-- Индексы таблицы `tovar`
--
ALTER TABLE `tovar`
  ADD PRIMARY KEY (`id_tovar`),
  ADD KEY `id_postavki` (`id_postavki`),
  ADD KEY `id_type` (`id_type`);

--
-- Индексы таблицы `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `checki`
--
ALTER TABLE `checki`
  MODIFY `id_checki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `manager`
--
ALTER TABLE `manager`
  MODIFY `id_manager` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `postavki`
--
ALTER TABLE `postavki`
  MODIFY `id_postavki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tovar`
--
ALTER TABLE `tovar`
  MODIFY `id_tovar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `checki`
--
ALTER TABLE `checki`
  ADD CONSTRAINT `checki_ibfk_1` FOREIGN KEY (`id_tovar`) REFERENCES `tovar` (`id_tovar`),
  ADD CONSTRAINT `checki_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `checki_ibfk_3` FOREIGN KEY (`id_manager`) REFERENCES `manager` (`id_manager`);

--
-- Ограничения внешнего ключа таблицы `tovar`
--
ALTER TABLE `tovar`
  ADD CONSTRAINT `tovar_ibfk_1` FOREIGN KEY (`id_postavki`) REFERENCES `postavki` (`id_postavki`),
  ADD CONSTRAINT `tovar_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
