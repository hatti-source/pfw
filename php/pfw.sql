-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021 年 4 月 12 日 09:10
-- サーバのバージョン： 8.0.20
-- PHP のバージョン: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `pfw`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- テーブルのデータのダンプ `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cat name A', '2021-04-12 00:00:00', NULL, NULL),
(2, 'cat name B', '2021-04-12 00:00:01', NULL, NULL),
(3, 'cat name C', '2021-04-12 00:00:03', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `objects`
--

CREATE TABLE `objects` (
  `id` int NOT NULL,
  `cat_id` int NOT NULL,
  `object` varchar(12799) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- テーブルのデータのダンプ `objects`
--

INSERT INTO `objects` (`id`, `cat_id`, `object`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'data 1', '2021-04-10 00:00:00', NULL, NULL),
(2, 2, 'data 2', '2021-04-10 00:00:01', NULL, NULL),
(3, 3, 'data 3', '2021-04-11 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'a@ab.abc', 'password', '2021-04-01 00:00:00', NULL, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `objects`
--
ALTER TABLE `objects`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルのAUTO_INCREMENT `objects`
--
ALTER TABLE `objects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
