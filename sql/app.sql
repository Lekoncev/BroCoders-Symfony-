-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 25 2024 г., 01:35
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `app`
--

-- --------------------------------------------------------

--
-- Структура таблицы `developer`
--

CREATE TABLE `developer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `birthdate` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `developer`
--

INSERT INTO `developer` (`id`, `name`, `surname`, `fullname`, `birthdate`, `position`, `email`, `phone`, `is_active`) VALUES
(1, 'Иван', 'Иванов', 'Иванович', '10.03.1997', 'Junior Developer', 'ghost12@mail.ru', '+79120212121', 1),
(2, 'Сергей', 'Шишкин', 'Вадимович', '25.04.1998', 'MiddleDeveloper', 'specter@mail.ru', '+79120212145', 1),
(3, 'Иван', 'Горшков', 'Константинович', '14.11.1990', 'Dev-ops', 'ghost12@mail.ru', '+79120212120', 1),
(4, 'Евгений', 'Картышев', 'Валерьевич', '12.04.2000', 'Junior Developer', 'evgek@gmail.com', '+79127524442', 1),
(5, 'Павел', 'Русских', 'Петрович', '12.04.2002', 'Dev-ops', 'palok@gmail.com', '+79124548888', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `developers_projects`
--

CREATE TABLE `developers_projects` (
  `project_id` int(11) NOT NULL,
  `developer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `developers_projects`
--

INSERT INTO `developers_projects` (`project_id`, `developer_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(2, 4),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(4, 2),
(4, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241124210539', '2024-11-24 22:06:03', 142),
('DoctrineMigrations\\Version20241124235036', '2024-11-25 00:50:41', 57);

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `is_closed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `is_closed`) VALUES
(1, 'Project A', 'Project A (1)', 0),
(2, 'Project B', 'Project B (2)', 0),
(3, 'Project C', 'Project C (1)', 0),
(4, 'Project Bc', 'Project Bc (5)', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `developer`
--
ALTER TABLE `developer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `developers_projects`
--
ALTER TABLE `developers_projects`
  ADD PRIMARY KEY (`project_id`,`developer_id`),
  ADD KEY `IDX_23A8596B166D1F9C` (`project_id`),
  ADD KEY `IDX_23A8596B64DD9267` (`developer_id`);

--
-- Индексы таблицы `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `developer`
--
ALTER TABLE `developer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `developers_projects`
--
ALTER TABLE `developers_projects`
  ADD CONSTRAINT `FK_23A8596B166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_23A8596B64DD9267` FOREIGN KEY (`developer_id`) REFERENCES `developer` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
