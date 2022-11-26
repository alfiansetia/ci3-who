-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Nov 2022 pada 00.54
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci3-who`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akl`
--

CREATE TABLE `akl` (
  `akl_id` int(11) NOT NULL,
  `akl_name` varchar(100) NOT NULL,
  `akl_start` date DEFAULT NULL,
  `akl_end` date DEFAULT NULL,
  `akl_desc` varchar(200) DEFAULT NULL,
  `akl_file` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akl`
--

INSERT INTO `akl` (`akl_id`, `akl_name`, `akl_start`, `akl_end`, `akl_desc`, `akl_file`) VALUES
(1, 'dsfdfe', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(2, 'dsfsddfe', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(3, 'dsfghsddfe', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(4, 'sfsfs', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(5, 'dsfsdddsfdsfe', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(6, 'dsfsddasfe', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(7, 'asfghj', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(8, 'asfsaf', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(9, 'asdsa', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true'),
(10, 'dgdfsg', '2022-11-09', '2022-11-01', 'ewfwefgwef', 'true');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_desc`) VALUES
(1, 'fdgdf', 'fdgdfgdf'),
(2, 'fdgsdg', 'sdgsdg'),
(3, 'sdgsdg', 'sdgsdg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_code` varchar(100) NOT NULL,
  `prod_desc` varchar(200) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `akl_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`prod_id`, `prod_code`, `prod_desc`, `cat_id`, `akl_id`) VALUES
(1, 'asdfsafsaf', 'safasfas', 1, 1),
(2, 'fsafas', 'fasfasfas', 2, 1),
(3, 'safasdvasdv', 'asasfgasgf', 3, 2),
(4, 'dasfa', 'Pengenalan HTML', 1, 2),
(5, 'adasfa', 'sfas HTML', 1, 2),
(6, 'adassaffa', 'sfasdfas HTML', 1, 2),
(7, 'htjrt', 'tjrrtj HTML', 1, 2),
(8, 'sadfga', 'dfsd HTML', 1, 2),
(9, 'yujy', 'rttr HTML', 1, 2),
(10, 'cvd', 'sfas sda', 1, 2),
(11, 'sdg', 'sfas as', 1, 2),
(12, 'adasdsdsfa', 'hjgh HTML', 1, 2),
(13, 'adadsfgsdsfa', 'fgdf HTML', 1, 2),
(14, 'af', 'sfas fgfd', 1, 2),
(15, 'addsasfa', 'sfafgjhs HTML', 1, 2),
(16, 'adaassfa', 'sfas jfgHTML', 1, 2),
(17, 'jghdasfa', 'sfahjs HTML', 1, 2),
(18, 'aghdasfa', 'sfhjas HTML', 1, 2),
(19, 'aghdasfa', 'sghjfas HTML', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akl`
--
ALTER TABLE `akl`
  ADD PRIMARY KEY (`akl_id`);

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `akl_id` (`akl_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akl`
--
ALTER TABLE `akl`
  MODIFY `akl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`akl_id`) REFERENCES `akl` (`akl_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
