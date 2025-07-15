-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2025 at 04:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produkID` int NOT NULL,
  `kodeProduk` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaProduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produkID`, `kodeProduk`, `namaProduk`, `harga`) VALUES
(2, '8992752112013', 'Mizone', 7000),
(4, '011234567890123', 'Pucuk', 5000),
(6, '545784921556', 'Indomie Goreng', 3500),
(9, '545784121556', 'Nestle', 3000),
(11, '(01)1234567890123', 'Sunlight', 5000),
(12, '054881003995', 'Fruit Tea Selection', 45000),
(13, '8998866203920', 'Milku Original', 4000),
(26, '013', 'p2', 1000),
(28, '012', 'P1', 1000),
(29, '014', 'msmdmsm', 1000),
(34, '019', '1000', 1000),
(35, '015', 'kakask', 1000),
(37, '200', '212ikas', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `stokID` int NOT NULL,
  `produkID` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`stokID`, `produkID`, `jumlah`) VALUES
(1, 2, 197),
(2, 4, 12),
(3, 6, 8),
(5, 9, 48),
(7, 11, 36),
(8, 12, 12),
(9, 13, 6),
(11, 26, 0),
(13, 28, 0),
(14, 29, 0),
(15, 34, 0),
(16, 35, 0),
(17, 37, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksiID` int NOT NULL,
  `userID` int NOT NULL,
  `tglTransaksi` datetime NOT NULL,
  `totalHarga` int NOT NULL,
  `totalBayar` int NOT NULL,
  `statusTransaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksiID`, `userID`, `tglTransaksi`, `totalHarga`, `totalBayar`, `statusTransaksi`) VALUES
(4, 1, '2025-06-27 15:14:53', 12000, 20000, 'Done'),
(6, 1, '2025-06-28 15:12:44', 10000, 20000, 'Done'),
(7, 1, '2025-07-02 23:27:34', 19000, 20000, 'Done'),
(11, 1, '2025-07-14 11:55:50', 68500, 70000, 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `trDetailID` int NOT NULL,
  `transaksiID` int NOT NULL,
  `produkID` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`trDetailID`, `transaksiID`, `produkID`, `quantity`) VALUES
(5, 4, 2, 1),
(6, 4, 4, 1),
(8, 6, 2, 1),
(9, 6, 9, 1),
(10, 7, 2, 2),
(11, 7, 4, 1),
(16, 11, 2, 3),
(17, 11, 4, 6),
(18, 11, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` enum('admin','kasir') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `name`, `username`, `password`, `roles`) VALUES
(1, 'Administrator', 'admin', '$2y$10$zAkLpZFM0vEkM4Vu0eLVH.7wUjWQ54Vyw2o3jkX1.Aojwjo9slGSu', 'admin'),
(5, 'kasir', 'kasir1', '$2y$10$BqAnBWS3BCFVJdMh0PrdpuTXZnjAANeIpsYAXl0IWE4oKYX53ly8W', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produkID`),
  ADD UNIQUE KEY `kodeProduk` (`kodeProduk`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`stokID`),
  ADD KEY `productID` (`produkID`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksiID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`trDetailID`),
  ADD KEY `productID` (`produkID`),
  ADD KEY `transaksiID` (`transaksiID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produkID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `stokID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksiID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `trDetailID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`produkID`) REFERENCES `produk` (`produkID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`produkID`) REFERENCES `produk` (`produkID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`transaksiID`) REFERENCES `transaksi` (`transaksiID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
