-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2024 年 12 月 02 日 19:03
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `pets`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `animals`
--

CREATE TABLE `animals` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `indate` datetime NOT NULL,
  `imgfile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `lid` varchar(128) NOT NULL,
  `lpw` varchar(255) NOT NULL,
  `kanrisya_flg` int(1) NOT NULL,
  `life_flg` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- テーブルのデータのダンプ `animals`
-- 注意：以下はダミーデータです
--

INSERT INTO `animals` (`id`, `name`, `indate`, `imgfile`) VALUES
(1, 'Lion', '2024-12-03 03:22:58', 'lion.jpg'),
(2, 'Elephant', '2024-12-03 03:22:58', 'elephant.jpg'),
(3, 'Tiger', '2024-12-03 03:22:58', 'tiger.jpg'),
(4, 'Giraffe', '2024-12-03 03:22:58', 'giraffe.jpg'),
(5, 'Zebra', '2024-12-03 03:22:58', 'zebra.jpg'),
(6, 'Monkey', '2024-12-03 03:22:58', 'monkey.jpg'),
(7, 'Kangaroo', '2024-12-03 03:22:58', 'kangaroo.jpg'),
(8, 'Panda', '2024-12-03 03:22:58', 'panda.jpg'),
(9, 'Koala', '2024-12-03 03:22:58', 'koala.jpg'),
(10, 'Penguin', '2024-12-03 03:22:58', 'penguin.jpg');

-- テーブルのデータのダンプ `users`
-- 注意：以下はダミーデータです
--

INSERT INTO `users` (`id`, `name`, `lid`, `lpw`, `kanrisya_flg`, `life_flg`) VALUES
(1, 'Alice(CEO)', 'alice@example.com', 'password123', 1, 1),
(2, 'Bob', 'bob@example.com', 'password456', 0, 1),
(3, 'Charlie', 'charlie@example.com', 'password789', 0, 0);
