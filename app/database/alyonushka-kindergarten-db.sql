-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 02 2025 г., 12:56
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
-- База данных: `alyonushka-kindergarten-db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `id` int(12) NOT NULL,
  `login` varchar(50) NOT NULL COMMENT 'Логин пользователя',
  `child_name` varchar(50) NOT NULL COMMENT 'Имя ребёнка',
  `child_surname` varchar(50) NOT NULL COMMENT 'Фамилия ребёнка',
  `child_patronymic` varchar(50) NOT NULL DEFAULT 'none' COMMENT 'Отчество ребёнка',
  `child_birthdate` date NOT NULL COMMENT 'Дата рождения ребёнка',
  `parent_name` varchar(50) NOT NULL COMMENT 'Имя родителя',
  `parent_surname` varchar(50) NOT NULL COMMENT 'Фамилия родителя',
  `parent_patronymic` varchar(50) NOT NULL DEFAULT 'none' COMMENT 'Отчество родителя',
  `parent_phone` varchar(50) NOT NULL COMMENT 'Номер телефона родителя',
  `parent_email` varchar(50) NOT NULL DEFAULT 'none' COMMENT 'Почта родителя',
  `address` varchar(50) NOT NULL COMMENT 'Адрес проживания',
  `desired_group` varchar(50) NOT NULL COMMENT 'Группа (младшая, средняя, старшая)',
  `application_date` date NOT NULL COMMENT 'Дата подачи заявления',
  `status` varchar(50) NOT NULL DEFAULT 'не рассмотрено' COMMENT 'Статус заявления (не рассмотрен, принят, отклонён)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`id`, `login`, `child_name`, `child_surname`, `child_patronymic`, `child_birthdate`, `parent_name`, `parent_surname`, `parent_patronymic`, `parent_phone`, `parent_email`, `address`, `desired_group`, `application_date`, `status`) VALUES
(3, 'test', 'qwe', 'qwe', '', '2025-03-02', 'qwe', 'qwe', '', '1234', 'qwe@mail.ru', 'qwe', 'младшая группа', '2025-03-02', 'принято'),
(4, 'test', 'qwerty', 'qwe', '', '2025-03-02', 'qwe', 'qwe', '', '123', 'qwe@mail.ru', 'qwe', 'старшая группа', '2025-03-02', 'отклонено');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(12) NOT NULL,
  `title` varchar(50) NOT NULL COMMENT 'Название новости',
  `data` date DEFAULT NULL COMMENT 'Дата создания | последнего редактирования новости',
  `image_src` varchar(128) NOT NULL COMMENT 'Путь до файла новости',
  `introductory_text` text NOT NULL COMMENT 'Вступительный текст новости',
  `text` text NOT NULL COMMENT 'Основной текст новости'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `data`, `image_src`, `introductory_text`, `text`) VALUES
(1, 'Комната', '2025-02-03', '/application/images/news/test_image_news_1.jpg', 'Типичная комната творческого человека...', 'Типичная комната творческого человека наполнена атмосферой вдохновения и хаоса. Стены украшены яркими картинами и заметками, на которых запечатлены идеи и мысли, пришедшие в голову в самые неожиданные моменты. На столе разбросаны кисти, краски и блокноты, в которых можно найти как законченные работы, так и наброски, ждущие своего часа.\r\n\r\nВ углу стоит старый рояль, покрытый пылью, но готовый к тому, чтобы его снова оживили мелодии. На полках — книги, которые были прочитаны и перечитаны, каждая из которых оставила свой след в душе хозяина. Здесь же можно найти коллекцию виниловых пластинок, которые создают идеальный фон для творческих вечеров.\r\n\r\nОкно открыто, и в комнату проникает свежий воздух, наполняя пространство звуками природы. На подоконнике растут зелёные растения, которые, как и сам творческий человек, требуют заботы и внимания. В этом месте царит гармония между порядком и беспорядком, где каждая деталь имеет своё значение и вдохновляет на новые свершения.'),
(2, 'Город', '2025-02-03', '/application/images/news/test_image_news_2.jpg', 'Неоновые и железно-бетонные джунгли, берегитесь голодных людей!', '\"Неоновые и железно-бетонные джунгли, берегитесь голодных людей!\" — этот крик раздавался в ночном городе, где яркие огни реклам и светящихся вывесок сливались в единый поток, создавая иллюзию жизни и движения. В этом мире, где высокие здания пронзают небо, а улицы заполнены спешащими прохожими, скрывается другая реальность — реальность тех, кто остался на обочине.\r\n\r\nГолодные люди, потерянные в этом безумном ритме, ищут не только еды, но и смысла. Их глаза полны усталости и надежды, а лица отражают истории, которые никто не хочет слышать. Они бродят по улицам, искренне веря, что однажды найдут свой путь к свету, который так ярко сверкает над ними.\r\n\r\nВ этих джунглях, где бетон и стекло создают холодную атмосферу, человеческие судьбы переплетаются, как корни деревьев, пробивающиеся сквозь трещины асфальта. Каждый шаг — это борьба, каждый взгляд — это вызов. Но среди этого хаоса есть и те, кто не теряет надежды, кто продолжает мечтать о лучшем будущем, несмотря на все преграды.\r\n\r\nИменно в этом контрасте между яркостью неона и серостью реальности рождается искусство, музыка и поэзия — отражение жизни, которая продолжается, несмотря на все трудности. В этих джунглях, где каждый день — это новая битва, голодные люди становятся голосом перемен, призывающим к справедливости и пониманию.'),
(3, 'Дед', '2025-02-03', '/application/images/news/test_image_news_3.webp', 'Это добрый и миленький дедушка – основатель нашего замечательного садика (^w^)', '\"Это добрый и миленький дедушка – основатель нашего замечательного садика (^w^). Его светлая улыбка и добрые глаза всегда согревают сердца детей и взрослых. Каждый день он приходит в садик с корзиной свежих фруктов и сладостей, чтобы порадовать малышей. Дедушка рассказывает им удивительные истории о своих приключениях в молодости, о том, как он сажал первые цветы в нашем саду и ухаживал за ними с любовью.\r\n\r\nОн знает каждого ребенка по имени и всегда находит время, чтобы поговорить с ними, выслушать их мечты и заботы. Его мудрость и терпение вдохновляют детей на творчество и исследование окружающего мира. В его присутствии даже самые стеснительные ребята раскрываются, как цветы на солнце.\r\n\r\nКаждую весну дедушка организует праздник, на котором дети могут показать свои таланты: кто-то поет, кто-то танцует, а кто-то рисует. Он всегда поддерживает их, подбадривая и восхищаясь каждым выступлением. Для него нет ничего важнее, чем видеть, как растут и развиваются его маленькие подопечные.\r\n\r\nЭтот добрый дедушка стал не только основателем садика, но и настоящим другом для всех нас. Его любовь и забота создают атмосферу тепла и уюта, где каждый ребенок чувствует себя особенным и любимым.\"'),
(7, 'Редактированная созданная новость 1', '2025-03-02', '/app/images/news/devushka_siluet_planeta_1067694_1920x1200.jpg', 'Вступительный текст созданной новости 1.', 'Основной текст созданной новости 1.'),
(8, 'Созданная новость 2 :p', '2025-03-02', '/app/images/news/devushka_siluet_planeta_1067694_1920x1200.jpg', 'Вступительный текст созданной новости 2.', 'Основной текст вступительной новости 2.');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `login` varchar(12) NOT NULL COMMENT 'Логин пользователя',
  `role` varchar(16) NOT NULL COMMENT 'Роль пользователя',
  `email` varchar(64) NOT NULL COMMENT 'Почта пользователя',
  `password` varchar(259) NOT NULL COMMENT 'Пароль пользователя (хеш)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `role`, `email`, `password`) VALUES
(3, 'test', 'user', 'test@mail.ru', '$2y$10$V5TRH98nP6qjyF24Lzpn/OBQm0x/9isOowj.XqAn022WiKAsJXzza'),
(4, 'admin', 'administrator', 'admin@mail.ru', '$2y$10$onvrqF/k5XujoDYCiUm6EuW65Wv/1WuPXLAxJ6yS2mqJOgOZyjNUO');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
