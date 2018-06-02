-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2018 at 04:56 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_skt`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_update_barang_harga` (IN `pbarang_id` INT, IN `pbarang_harga_id` INT, IN `p_is_update_harga` INT, IN `p_is_reset` INT)  BEGIN
  DECLARE v_harga_beli DOUBLE;
  DECLARE v_harga_jual DOUBLE; 
  
  IF (p_is_reset = 1) THEN
     UPDATE barang_harga SET pilih = 0 WHERE barang_id = pbarang_id;
  END IF;
  
  IF (p_is_update_harga = 1) THEN
     SELECT harga_beli, harga_jual INTO v_harga_beli, v_harga_jual 
            FROM barang_harga WHERE id = pbarang_harga_id;
     UPDATE sales_master_barang SET harga_beli = v_harga_beli, harga_jual = v_harga_jual
     WHERE id_barang = pbarang_id;
     UPDATE barang_harga SET pilih = 1 WHERE id = pbarang_harga_id;
  END IF;
  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_update_status_gudang` (IN `pid_gudang` INT, IN `pid_barang` INT)  BEGIN
  DECLARE v_is_sejenis,v_is_penuh,v_id_gudang, v_id_barang INT;
  DECLARE v_kapasitas,v_stok DOUBLE;
  
  SELECT id_gudang, id_barang, jumlah 
  INTO v_id_gudang, v_id_barang, v_stok
  FROM sales_stok_gudang
  WHERE id_gudang = pid_gudang 
  AND id_barang = pid_barang;
  
  SELECT kapasitas, is_sejenis 
  INTO v_kapasitas, v_is_sejenis
  FROM sales_master_gudang 
  WHERE id_gudang = pid_gudang;
  
  UPDATE sales_master_gudang SET is_penuh = 0 
        WHERE id_gudang = pid_gudang;
  
  IF v_is_sejenis = 1 THEN
     IF v_stok > 0 THEN
        UPDATE sales_master_gudang 
        SET is_penuh = 1 
        WHERE id_gudang = pid_gudang;
     END IF;
  ELSE 
     IF v_stok >= v_kapasitas THEN
        UPDATE sales_master_gudang 
        SET is_penuh = 1 
        WHERE id_gudang = pid_gudang;
     END IF;  
  END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 5, 1527656078),
('adminSpbu', 3, 1527843528),
('admSalesCab', 4, 1527652005),
('gudang', 6, 1527656282),
('theCreator', 1, 1515743504),
('theCreator', 2, 1527609790);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Administrator pusat', NULL, NULL, 1515743426, 1515743426),
('adminSpbu', 1, 'Administrator SPBU', NULL, NULL, NULL, NULL),
('admSalesCab', 1, 'admin PT Cabang sales\r\n', NULL, NULL, NULL, NULL),
('employee', 1, 'Employee of this site/company who has lower rights than admin', NULL, NULL, 1515743426, 1515743426),
('gudang', 1, 'Operator Gudang', NULL, NULL, NULL, NULL),
('manageUsers', 2, 'Allows admin+ roles to manage users', NULL, NULL, 1515743426, 1515743426),
('member', 1, 'Authenticated user, equal to \"@\"', NULL, NULL, 1515743426, 1515743426),
('operatorShift', 1, 'Operator Shift', NULL, '', NULL, NULL),
('premium', 1, 'Premium users. Authenticated users with extra powers', NULL, NULL, 1515743426, 1515743426),
('theCreator', 1, 'You!', NULL, NULL, 1515743426, 1515743426),
('usePremiumContent', 2, 'Allows premium+ roles to use premium content', NULL, NULL, 1515743426, 1515743426);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'adminSpbu'),
('admin', 'admSalesCab'),
('admin', 'employee'),
('admin', 'gudang'),
('admin', 'manageUsers'),
('admSalesCab', 'operatorShift'),
('employee', 'premium'),
('premium', 'member'),
('premium', 'usePremiumContent'),
('theCreator', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 'O:25:\"app\\rbac\\rules\\AuthorRule\":3:{s:4:\"name\";s:8:\"isAuthor\";s:9:\"createdAt\";i:1515743426;s:9:\"updatedAt\";i:1515743426;}', 1515743426, 1515743426);

-- --------------------------------------------------------

--
-- Table structure for table `auto_number`
--

CREATE TABLE `auto_number` (
  `group` varchar(32) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `optimistic_lock` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auto_number`
--

INSERT INTO `auto_number` (`group`, `number`, `optimistic_lock`, `update_time`) VALUES
('3073fa165df37027a3a4886e6097c4eb', 6, 5, 1527658597),
('4822a6f222854cab437ef9ff8128ed72', 1, NULL, 1527654512);

-- --------------------------------------------------------

--
-- Table structure for table `barang_harga`
--

CREATE TABLE `barang_harga` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga_beli` double NOT NULL,
  `harga_jual` double NOT NULL,
  `pilih` int(11) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_harga`
--

INSERT INTO `barang_harga` (`id`, `barang_id`, `harga_beli`, `harga_jual`, `pilih`, `created`) VALUES
(7, 1, 6320, 6550, 1, '2018-05-29 09:24:29'),
(8, 5, 1100, 1300, 1, '2018-05-30 04:37:08'),
(9, 4, 5050, 5150, 1, '2018-06-01 15:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `barang_stok`
--

CREATE TABLE `barang_stok` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `stok` double NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `stok_bulan_lalu` double DEFAULT '0',
  `tebus_liter` double DEFAULT '0',
  `tebus_rupiah` double DEFAULT '0',
  `dropping` double DEFAULT '0',
  `sisa_do` double DEFAULT '0',
  `perusahaan_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sisa_do_lalu` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_stok`
--

INSERT INTO `barang_stok` (`id`, `barang_id`, `stok`, `bulan`, `tahun`, `tanggal`, `stok_bulan_lalu`, `tebus_liter`, `tebus_rupiah`, `dropping`, `sisa_do`, `perusahaan_id`, `created`, `sisa_do_lalu`) VALUES
(6, 1, 31361, 5, 2018, '2018-05-31', 31361, 0, 0, 0, 0, 2, '2018-06-02 01:28:57', 0),
(7, 1, 16000, 6, 2018, '2018-06-04', 31361, 16000, 101120000, 0, 16000, 2, '2018-06-02 01:40:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bbm_dispenser`
--

CREATE TABLE `bbm_dispenser` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bbm_dispenser`
--

INSERT INTO `bbm_dispenser` (`id`, `nama`, `perusahaan_id`, `barang_id`) VALUES
(1, 'Dispenser 1', 2, 1),
(2, 'Dispenser 2', 2, 1),
(3, 'Dispenser 1', 2, 2),
(4, 'Dispenser 2', 2, 2),
(5, 'Dispenser 3', 2, 3),
(6, 'Dispenser 1', 2, 4),
(7, 'Dispenser 2', 2, 4),
(8, 'Dispenser 3', 2, 4),
(9, 'Dispenser 4', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `bbm_faktur`
--

CREATE TABLE `bbm_faktur` (
  `id` int(11) NOT NULL,
  `suplier_id` int(11) NOT NULL,
  `no_lo` varchar(100) DEFAULT '-',
  `tanggal_lo` date DEFAULT '0000-00-00',
  `no_so` varchar(100) DEFAULT NULL,
  `tanggal_so` date DEFAULT '0000-00-00',
  `perusahaan_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_selesai` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bbm_faktur`
--

INSERT INTO `bbm_faktur` (`id`, `suplier_id`, `no_lo`, `tanggal_lo`, `no_so`, `tanggal_so`, `perusahaan_id`, `created`, `is_selesai`) VALUES
(4, 1, '8011486356', '2018-06-01', '4.003.062.015', '2018-06-02', 2, '2018-06-01 23:56:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bbm_faktur_item`
--

CREATE TABLE `bbm_faktur_item` (
  `id` int(11) NOT NULL,
  `faktur_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` double NOT NULL DEFAULT '0',
  `stok_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bbm_faktur_item`
--

INSERT INTO `bbm_faktur_item` (`id`, `faktur_id`, `barang_id`, `jumlah`, `stok_id`, `created`) VALUES
(7, 4, 1, 16000, 1, '2018-06-01 23:58:09');

--
-- Triggers `bbm_faktur_item`
--
DELIMITER $$
CREATE TRIGGER `trg_insert_stok_gudang` AFTER INSERT ON `bbm_faktur_item` FOR EACH ROW BEGIN
  DECLARE v_stok_baru, v_stok_lama DOUBLE;
  

  SELECT jumlah INTO v_stok_lama FROM sales_stok_gudang 
  WHERE id_stok = NEW.stok_id;
  
  SET v_stok_baru = v_stok_lama + NEW.jumlah;
  
  UPDATE sales_stok_gudang
  SET jumlah = v_stok_baru 
  WHERE id_stok = NEW.stok_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bbm_jual`
--

CREATE TABLE `bbm_jual` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `barang_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `perusahaan_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `dispenser_id` int(11) NOT NULL,
  `stok_awal` double NOT NULL,
  `stok_akhir` double NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bbm_jual`
--

INSERT INTO `bbm_jual` (`id`, `tanggal`, `barang_id`, `created`, `perusahaan_id`, `shift_id`, `dispenser_id`, `stok_awal`, `stok_akhir`, `harga`) VALUES
(1, '2018-06-01', 1, '2018-06-01 09:29:44', 2, 1, 1, 4483314, 4484192, 6550),
(2, '2018-06-01', 1, '2018-06-01 09:30:13', 2, 1, 2, 2989987, 2991801, 6550),
(3, '2018-06-01', 1, '2018-06-01 09:42:08', 2, 2, 1, 4484192, 4485176, 6550),
(4, '2018-06-01', 1, '2018-06-01 10:04:37', 2, 2, 2, 2991801, 2993356, 6550),
(7, '2018-06-01', 1, '2018-06-01 13:37:51', 2, 3, 1, 4485176, 4485499, 6550),
(8, '2018-06-01', 1, '2018-06-01 13:38:05', 2, 3, 2, 2993356, 2993649, 6550),
(9, '2018-06-02', 1, '2018-06-01 13:38:32', 2, 1, 1, 4485499, 4486403, 6550),
(10, '2018-06-02', 1, '2018-06-01 13:58:28', 2, 2, 1, 4486403, 4486762, 6550),
(11, '2018-06-02', 1, '2018-06-01 14:30:53', 2, 1, 2, 2993649, 2995269, 6550),
(12, '2018-06-02', 1, '2018-06-01 14:35:55', 2, 2, 2, 2995269, 2996086, 6550),
(15, '2018-06-01', 4, '2018-06-01 15:40:24', 2, 1, 6, 3064430, 3064946, 5150),
(16, '2018-06-01', 4, '2018-06-01 15:43:48', 2, 1, 7, 4259421, 4259786, 5150),
(17, '2018-06-01', 4, '2018-06-01 15:44:04', 2, 1, 8, 6327078, 6327423, 5150),
(18, '2018-06-01', 4, '2018-06-01 15:44:17', 2, 1, 9, 7669584, 7669726, 5150),
(19, '2018-06-01', 4, '2018-06-01 16:04:22', 2, 2, 6, 3064946, 3065520, 5150),
(20, '2018-06-02', 1, '2018-06-02 02:03:32', 2, 3, 1, 4486762, 4486762, 6550),
(21, '2018-06-02', 1, '2018-06-02 02:03:53', 2, 3, 2, 2996086, 2996086, 6550),
(22, '2018-06-03', 1, '2018-06-02 02:04:19', 2, 1, 1, 4486762, 4487470, 6550),
(23, '2018-06-03', 1, '2018-06-02 02:04:47', 2, 1, 2, 2996086, 2997457, 6550),
(24, '2018-06-03', 1, '2018-06-02 02:05:36', 2, 2, 1, 4487470, 4487948, 6550),
(25, '2018-06-03', 1, '2018-06-02 02:05:51', 2, 2, 2, 2997457, 2998395, 6550),
(26, '2018-06-03', 1, '2018-06-02 02:06:14', 2, 3, 1, 4487948, 4487948, 6550),
(27, '2018-06-03', 1, '2018-06-02 02:06:32', 2, 3, 2, 2998395, 2998395, 6550);

-- --------------------------------------------------------

--
-- Table structure for table `master_akun`
--

CREATE TABLE `master_akun` (
  `kode_akun` varchar(8) NOT NULL,
  `uraian_akun` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_akun`
--

INSERT INTO `master_akun` (`kode_akun`, `uraian_akun`) VALUES
('10000000', 'Aset Lancar'),
('20000000', 'Aset Tidak Lancar'),
('70000000', 'Biaya Operasional'),
('30000000', 'Hutang Lancar'),
('40000000', 'Hutang Tidak Lancar'),
('50000000', 'Modal'),
('80000000', 'Pendapatan & Biaya, Pajak'),
('60000000', 'Pendapatan & HPP');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1515743391),
('m141022_115823_create_user_table', 1515743393),
('m141022_115912_create_rbac_tables', 1515743393),
('m190118_154802_create_level_perusahaan', 1516354228),
('m190118_161702_create_perusahaan_jenis', 1516355004),
('m190118_162301_create_perusahaan_table', 1516355251),
('m190118_200001_update_table_perusahaan_jenis', 1516355251),
('m190118_200002_create_master_akun', 1516363124);

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jenis` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `nama`, `email`, `alamat`, `telp`, `jenis`, `level`, `created_at`, `updated_at`) VALUES
(1, 'PT Trisna Group', 'trisna.group@gmail.com', 'Jl Soekarno Hatta 1 Katang, Kediri', '0354 123456', 1, 1, 0, 0),
(2, 'SPBU Paron', 'spbu@gmail.com', 'test', '123413', 5, 3, 0, 0),
(3, 'PT Maju Jaya', 'majujaya@gmail.com', 'Paron', '123123123', 3, 3, 0, 0),
(4, 'Super Admin', 'admin@gmail.com', 'aa', 'aa', 1, 1, 0, 0),
(5, 'Apotek Timur RSUD Pare', 'rsudkabunpaten@gmail.com', 'Pare', '0354 123123', 6, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan_jenis`
--

CREATE TABLE `perusahaan_jenis` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perusahaan_jenis`
--

INSERT INTO `perusahaan_jenis` (`id`, `kode`, `nama`) VALUES
(1, 'HD', 'Holding'),
(2, 'JS', 'Jasa'),
(3, 'TD', 'Penjualan'),
(4, 'MN', 'Manufaktu'),
(5, 'SPBU', 'SPBU'),
(6, 'APT', 'Apotek');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan_level`
--

CREATE TABLE `perusahaan_level` (
  `id` smallint(8) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perusahaan_level`
--

INSERT INTO `perusahaan_level` (`id`, `nama`, `level`) VALUES
(1, 'Holding', 1),
(2, 'Pusat', 2),
(3, 'Cabang', 3);

-- --------------------------------------------------------

--
-- Table structure for table `request_order`
--

CREATE TABLE `request_order` (
  `id` int(11) NOT NULL,
  `no_ro` varchar(100) NOT NULL,
  `petugas1` varchar(100) NOT NULL DEFAULT '-',
  `petugas2` varchar(100) DEFAULT '-',
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_penyetujuan` date DEFAULT '0000-00-00',
  `perusahaan_id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_approved` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_order`
--

INSERT INTO `request_order` (`id`, `no_ro`, `petugas1`, `petugas2`, `tanggal_pengajuan`, `tanggal_penyetujuan`, `perusahaan_id`, `created`, `is_approved`) VALUES
(3, 'RO.2018-05-30.6', 'apttimur', '-', '2018-05-01', '0000-00-00', 5, '2018-05-30 05:36:37', 2);

-- --------------------------------------------------------

--
-- Table structure for table `request_order_item`
--

CREATE TABLE `request_order_item` (
  `id` int(11) NOT NULL,
  `ro_id` int(11) NOT NULL,
  `stok_id` int(11) NOT NULL,
  `jumlah_minta` double NOT NULL,
  `jumlah_beri` double NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_order_item`
--

INSERT INTO `request_order_item` (`id`, `ro_id`, `stok_id`, `jumlah_minta`, `jumlah_beri`, `satuan`, `keterangan`, `created`, `item_id`) VALUES
(3, 3, 4, 1000, 500, 'tablet', '-', '2018-05-30 05:36:59', 5);

-- --------------------------------------------------------

--
-- Table structure for table `sales_faktur`
--

CREATE TABLE `sales_faktur` (
  `id_faktur` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `no_faktur` varchar(50) DEFAULT '-',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_faktur` date NOT NULL,
  `id_perusahaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_faktur`
--

INSERT INTO `sales_faktur` (`id_faktur`, `id_suplier`, `no_faktur`, `created`, `tanggal_faktur`, `id_perusahaan`) VALUES
(1, 1, '123', '2018-05-28 01:07:16', '2018-05-15', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales_faktur_barang`
--

CREATE TABLE `sales_faktur_barang` (
  `id_faktur_barang` int(11) NOT NULL,
  `id_faktur` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `id_satuan` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_gudang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_faktur_barang`
--

INSERT INTO `sales_faktur_barang` (`id_faktur_barang`, `id_faktur`, `id_barang`, `jumlah`, `id_satuan`, `created`, `id_gudang`) VALUES
(8, 1, 2, 16000, 3, '2018-05-28 01:39:50', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales_income`
--

CREATE TABLE `sales_income` (
  `id_sales` int(11) NOT NULL,
  `stok_id` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `harga` double DEFAULT '0',
  `tanggal` date NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_perusahaan` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_master_barang`
--

CREATE TABLE `sales_master_barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_beli` double NOT NULL,
  `harga_jual` double NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_perusahaan` int(11) NOT NULL,
  `is_hapus` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_master_barang`
--

INSERT INTO `sales_master_barang` (`id_barang`, `nama_barang`, `harga_beli`, `harga_jual`, `id_satuan`, `created`, `id_perusahaan`, `is_hapus`) VALUES
(1, 'Premium', 6320, 6550, 3, '2018-05-19 07:50:25', 2, 0),
(2, 'Pertalite', 7000, 7600, 3, '2018-05-19 09:11:02', 2, 0),
(3, 'Pertamax', 5500, 6000, 3, '2018-05-19 09:27:25', 2, 0),
(4, 'Bio Solar', 5050, 5150, 3, '2018-05-29 09:45:50', 2, 0),
(5, 'Paracetamol 100mg', 1100, 1300, 7, '2018-05-30 04:36:52', 5, 0);

--
-- Triggers `sales_master_barang`
--
DELIMITER $$
CREATE TRIGGER `trg_hapus_harga` BEFORE DELETE ON `sales_master_barang` FOR EACH ROW BEGIN
  DELETE FROM barang_harga WHERE barang_id = OLD.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales_master_gudang`
--

CREATE TABLE `sales_master_gudang` (
  `id_gudang` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `kapasitas` double NOT NULL DEFAULT '0',
  `id_perusahaan` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_sejenis` int(11) NOT NULL DEFAULT '0',
  `is_hapus` int(11) DEFAULT '0',
  `is_penuh` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_master_gudang`
--

INSERT INTO `sales_master_gudang` (`id_gudang`, `nama`, `alamat`, `telp`, `kapasitas`, `id_perusahaan`, `created`, `is_sejenis`, `is_hapus`, `is_penuh`) VALUES
(1, 'Gudang A', 'Katang', '1123123', 0, 3, '2018-05-29 09:40:43', 0, 0, 0),
(2, 'Tangki 1', 'Katang', '1123123', 32000, 2, '2018-05-29 09:40:43', 1, 0, 1),
(3, 'Tangki 2', 'Katang', '1123123', 32000, 2, '2018-05-29 09:40:43', 1, 0, 1),
(4, 'Tangki 3', 'Katang', '111', 32000, 2, '2018-05-29 10:00:06', 1, 0, 0),
(5, 'Gudang Belakang', 'Pare', '0354 1234123', 20000, 5, '2018-05-30 04:37:40', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_stok_gudang`
--

CREATE TABLE `sales_stok_gudang` (
  `id_stok` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_hapus` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_stok_gudang`
--

INSERT INTO `sales_stok_gudang` (`id_stok`, `id_gudang`, `id_barang`, `jumlah`, `created`, `is_hapus`) VALUES
(1, 2, 1, 91000, '2018-05-29 11:38:40', 0),
(2, 3, 2, 17500, '2018-05-29 13:40:10', 0),
(3, 4, 3, 0, '2018-05-29 13:40:48', 0),
(4, 5, 5, 2000, '2018-05-30 04:37:56', 0);

--
-- Triggers `sales_stok_gudang`
--
DELIMITER $$
CREATE TRIGGER `trg_insert_status_gudang` AFTER INSERT ON `sales_stok_gudang` FOR EACH ROW BEGIN
  CALL proc_update_status_gudang(NEW.id_gudang, NEW.id_barang);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_status_gudang` AFTER UPDATE ON `sales_stok_gudang` FOR EACH ROW BEGIN
  CALL proc_update_status_gudang(NEW.id_gudang, NEW.id_barang);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales_suplier`
--

CREATE TABLE `sales_suplier` (
  `id_suplier` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_suplier`
--

INSERT INTO `sales_suplier` (`id_suplier`, `nama`, `alamat`, `telp`, `email`, `id_perusahaan`, `created`) VALUES
(1, 'PT Pertamina', 'Surabaya', '031 123123', 'cs@pertamina.com', 2, '2018-05-28 01:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `satuan_barang`
--

CREATE TABLE `satuan_barang` (
  `id_satuan` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan_barang`
--

INSERT INTO `satuan_barang` (`id_satuan`, `kode`, `nama`, `jenis`) VALUES
(1, 'kg', 'Kilogram', 3),
(2, 'gr', 'Gram', 3),
(3, 'lt', 'Liter', 5),
(4, 'm2', 'Meter Persegi', 3),
(5, 'cm2', 'centimeter persegi', 3),
(6, 'box', 'Box', 3),
(7, 'TBLT', 'Tablet', 6);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `perusahaan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `nama`, `jam_mulai`, `jam_selesai`, `perusahaan_id`) VALUES
(1, 'Shift 1', '07:00:00', '12:00:00', 2),
(2, 'Shift 2', '12:00:40', '18:10:40', 2),
(3, 'Shift 3', '18:10:00', '00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `shift_user`
--

CREATE TABLE `shift_user` (
  `id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `perusahaan_id` int(11) DEFAULT NULL,
  `access_role` varchar(50) COLLATE utf8_unicode_ci DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `status`, `auth_key`, `password_reset_token`, `account_activation_token`, `created_at`, `updated_at`, `perusahaan_id`, `access_role`) VALUES
(2, 'mumtazika', 'vinux.edu@gmail.com', '$2y$13$2oU.cjLtlJUwHwm4/qk45O7ufUf23nX6N3E40qE/xTS6qSI0aZsgK', 10, 'reqFDYYkr2qTsUVWxF0i1avvb3z10nak', NULL, NULL, 1526700962, 1527609790, 4, 'theCreator'),
(3, 'admin_spbu_paron', 'admin_spbu_paron@gmail.com', '$2y$13$S3Y1NOplIE6jjObdtMUyMOaS60a4Jlf3NW4Jwo8yT2QFHux2uIKoW', 10, '9-Wbr4yIK9r49K1I8mA8zUnQJVD62gE7', NULL, NULL, 1526787550, 1527843528, 2, 'adminSpbu'),
(4, 'apttimur', 'apttimur@gmail.com', '$2y$13$KPbl50oQHZ9IreUpSynrp.fGX5X6rOeAf35oD97nV97YErAIm9BAW', 10, 'Kd-0bDF5GhsVu4ZnXYj5ITme20M6hjH2', NULL, NULL, 1527651781, 1527652005, 5, 'admSalesCab'),
(5, 'adminapotek', 'adminapotek@gmail.com', '$2y$13$rcf0SRulDHUMKv0u9RIvAOTON30GRIaMPIzDdNE/GYlnHaQYQs1NO', 10, 'L_KxP7M_zmUOGPbsx73CbDHyR3TYCtN8', NULL, NULL, 1527656078, 1527656078, 5, 'admin'),
(6, 'opgudang', 'opgudang@gmail.com', '$2y$13$RxlrCMVQiHGH2xIBf46vjunDUGyUD1bjexG9bqEhXMxhUb9FAKXYi', 10, '8Qc8jIX1SWB_62n2FhCcWwBfWitDv9dv', NULL, NULL, 1527656282, 1527656282, 5, 'gudang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `auto_number`
--
ALTER TABLE `auto_number`
  ADD PRIMARY KEY (`group`);

--
-- Indexes for table `barang_harga`
--
ALTER TABLE `barang_harga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_brg_harga` (`barang_id`);

--
-- Indexes for table `barang_stok`
--
ALTER TABLE `barang_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_brg_stok_bulan_prsh` (`perusahaan_id`),
  ADD KEY `fk_brg_stok_bulanan` (`barang_id`);

--
-- Indexes for table `bbm_dispenser`
--
ALTER TABLE `bbm_dispenser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_disp_brg` (`barang_id`),
  ADD KEY `fk_bbm_disp_perusahaan` (`perusahaan_id`);

--
-- Indexes for table `bbm_faktur`
--
ALTER TABLE `bbm_faktur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bbm_suplier` (`suplier_id`),
  ADD KEY `fk_bbm_perusahaan` (`perusahaan_id`);

--
-- Indexes for table `bbm_faktur_item`
--
ALTER TABLE `bbm_faktur_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bbm_faktur` (`faktur_id`),
  ADD KEY `fk_bbm_barang` (`barang_id`),
  ADD KEY `fk_bbm_stok_gudang` (`stok_id`);

--
-- Indexes for table `bbm_jual`
--
ALTER TABLE `bbm_jual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_disp_jual` (`dispenser_id`),
  ADD KEY `foreign_key01` (`shift_id`),
  ADD KEY `fk_brg_jual_shift` (`barang_id`),
  ADD KEY `fk_prsh_jual_shift` (`perusahaan_id`);

--
-- Indexes for table `master_akun`
--
ALTER TABLE `master_akun`
  ADD PRIMARY KEY (`kode_akun`),
  ADD UNIQUE KEY `uraian_akun` (`uraian_akun`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `idx-jenis_pid` (`jenis`);

--
-- Indexes for table `perusahaan_jenis`
--
ALTER TABLE `perusahaan_jenis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `perusahaan_level`
--
ALTER TABLE `perusahaan_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_order`
--
ALTER TABLE `request_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ro_perusahaan` (`perusahaan_id`);

--
-- Indexes for table `request_order_item`
--
ALTER TABLE `request_order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ro_id` (`ro_id`),
  ADD KEY `fk_ro_item_stok` (`stok_id`),
  ADD KEY `fk_ro_item` (`item_id`);

--
-- Indexes for table `sales_faktur`
--
ALTER TABLE `sales_faktur`
  ADD PRIMARY KEY (`id_faktur`),
  ADD KEY `fk_faktur_perusahaan` (`id_perusahaan`),
  ADD KEY `fk_faktur_suplier` (`id_suplier`);

--
-- Indexes for table `sales_faktur_barang`
--
ALTER TABLE `sales_faktur_barang`
  ADD PRIMARY KEY (`id_faktur_barang`),
  ADD KEY `fk_faktur_brg` (`id_barang`),
  ADD KEY `fk_faktur_per` (`id_faktur`),
  ADD KEY `fk_sat_brg` (`id_satuan`),
  ADD KEY `fk_faktur_brg_gdg` (`id_gudang`);

--
-- Indexes for table `sales_income`
--
ALTER TABLE `sales_income`
  ADD PRIMARY KEY (`id_sales`),
  ADD KEY `fk_inc_per` (`id_perusahaan`);

--
-- Indexes for table `sales_master_barang`
--
ALTER TABLE `sales_master_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `fk_brg_per` (`id_perusahaan`),
  ADD KEY `fk_sat_mbrg` (`id_satuan`);

--
-- Indexes for table `sales_master_gudang`
--
ALTER TABLE `sales_master_gudang`
  ADD PRIMARY KEY (`id_gudang`),
  ADD KEY `fk_gd_perusahaan` (`id_perusahaan`);

--
-- Indexes for table `sales_stok_gudang`
--
ALTER TABLE `sales_stok_gudang`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `fk_stok_gd` (`id_gudang`),
  ADD KEY `fk_stk_brg` (`id_barang`);

--
-- Indexes for table `sales_suplier`
--
ALTER TABLE `sales_suplier`
  ADD PRIMARY KEY (`id_suplier`);

--
-- Indexes for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  ADD PRIMARY KEY (`id_satuan`),
  ADD KEY `fk_jenis_satuan` (`jenis`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shift_perusahaan` (`perusahaan_id`);

--
-- Indexes for table `shift_user`
--
ALTER TABLE `shift_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD UNIQUE KEY `account_activation_token` (`account_activation_token`),
  ADD KEY `fk_user_per` (`perusahaan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_harga`
--
ALTER TABLE `barang_harga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `barang_stok`
--
ALTER TABLE `barang_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bbm_dispenser`
--
ALTER TABLE `bbm_dispenser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bbm_faktur`
--
ALTER TABLE `bbm_faktur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bbm_faktur_item`
--
ALTER TABLE `bbm_faktur_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bbm_jual`
--
ALTER TABLE `bbm_jual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `perusahaan_jenis`
--
ALTER TABLE `perusahaan_jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `perusahaan_level`
--
ALTER TABLE `perusahaan_level`
  MODIFY `id` smallint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `request_order`
--
ALTER TABLE `request_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `request_order_item`
--
ALTER TABLE `request_order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales_faktur`
--
ALTER TABLE `sales_faktur`
  MODIFY `id_faktur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_faktur_barang`
--
ALTER TABLE `sales_faktur_barang`
  MODIFY `id_faktur_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales_income`
--
ALTER TABLE `sales_income`
  MODIFY `id_sales` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_master_barang`
--
ALTER TABLE `sales_master_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_master_gudang`
--
ALTER TABLE `sales_master_gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_stok_gudang`
--
ALTER TABLE `sales_stok_gudang`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_suplier`
--
ALTER TABLE `sales_suplier`
  MODIFY `id_suplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shift_user`
--
ALTER TABLE `shift_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_harga`
--
ALTER TABLE `barang_harga`
  ADD CONSTRAINT `fk_brg_harga` FOREIGN KEY (`barang_id`) REFERENCES `sales_master_barang` (`id_barang`);

--
-- Constraints for table `barang_stok`
--
ALTER TABLE `barang_stok`
  ADD CONSTRAINT `fk_brg_stok_bulan_prsh` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`),
  ADD CONSTRAINT `fk_brg_stok_bulanan` FOREIGN KEY (`barang_id`) REFERENCES `sales_master_barang` (`id_barang`);

--
-- Constraints for table `bbm_dispenser`
--
ALTER TABLE `bbm_dispenser`
  ADD CONSTRAINT `fk_bbm_disp_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`),
  ADD CONSTRAINT `fk_disp_brg` FOREIGN KEY (`barang_id`) REFERENCES `sales_master_barang` (`id_barang`);

--
-- Constraints for table `bbm_faktur`
--
ALTER TABLE `bbm_faktur`
  ADD CONSTRAINT `fk_bbm_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`),
  ADD CONSTRAINT `fk_bbm_suplier` FOREIGN KEY (`suplier_id`) REFERENCES `sales_suplier` (`id_suplier`);

--
-- Constraints for table `bbm_faktur_item`
--
ALTER TABLE `bbm_faktur_item`
  ADD CONSTRAINT `fk_bbm_barang` FOREIGN KEY (`barang_id`) REFERENCES `sales_master_barang` (`id_barang`),
  ADD CONSTRAINT `fk_bbm_faktur` FOREIGN KEY (`faktur_id`) REFERENCES `bbm_faktur` (`id`),
  ADD CONSTRAINT `fk_bbm_stok_gudang` FOREIGN KEY (`stok_id`) REFERENCES `sales_stok_gudang` (`id_stok`);

--
-- Constraints for table `bbm_jual`
--
ALTER TABLE `bbm_jual`
  ADD CONSTRAINT `bbm_jual_ibfk_1` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`),
  ADD CONSTRAINT `fk_brg_jual_shift` FOREIGN KEY (`barang_id`) REFERENCES `sales_master_barang` (`id_barang`),
  ADD CONSTRAINT `fk_disp_jual` FOREIGN KEY (`dispenser_id`) REFERENCES `bbm_dispenser` (`id`),
  ADD CONSTRAINT `fk_prsh_jual_shift` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`);

--
-- Constraints for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD CONSTRAINT `fk-jenis_pid` FOREIGN KEY (`jenis`) REFERENCES `perusahaan_jenis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_order`
--
ALTER TABLE `request_order`
  ADD CONSTRAINT `fk_ro_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`);

--
-- Constraints for table `request_order_item`
--
ALTER TABLE `request_order_item`
  ADD CONSTRAINT `fk_ro_item` FOREIGN KEY (`item_id`) REFERENCES `sales_master_barang` (`id_barang`),
  ADD CONSTRAINT `fk_ro_item_stok` FOREIGN KEY (`stok_id`) REFERENCES `sales_stok_gudang` (`id_stok`),
  ADD CONSTRAINT `request_order_item_ibfk_1` FOREIGN KEY (`ro_id`) REFERENCES `request_order` (`id`);

--
-- Constraints for table `sales_faktur`
--
ALTER TABLE `sales_faktur`
  ADD CONSTRAINT `fk_faktur_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`),
  ADD CONSTRAINT `fk_faktur_suplier` FOREIGN KEY (`id_suplier`) REFERENCES `sales_suplier` (`id_suplier`);

--
-- Constraints for table `sales_faktur_barang`
--
ALTER TABLE `sales_faktur_barang`
  ADD CONSTRAINT `fk_faktur_brg` FOREIGN KEY (`id_barang`) REFERENCES `sales_master_barang` (`id_barang`),
  ADD CONSTRAINT `fk_faktur_brg_gdg` FOREIGN KEY (`id_gudang`) REFERENCES `sales_master_gudang` (`id_gudang`),
  ADD CONSTRAINT `fk_faktur_per` FOREIGN KEY (`id_faktur`) REFERENCES `sales_faktur` (`id_faktur`),
  ADD CONSTRAINT `fk_sat_brg` FOREIGN KEY (`id_satuan`) REFERENCES `satuan_barang` (`id_satuan`);

--
-- Constraints for table `sales_income`
--
ALTER TABLE `sales_income`
  ADD CONSTRAINT `fk_inc_per` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`);

--
-- Constraints for table `sales_master_barang`
--
ALTER TABLE `sales_master_barang`
  ADD CONSTRAINT `fk_brg_per` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`),
  ADD CONSTRAINT `fk_sat_mbrg` FOREIGN KEY (`id_satuan`) REFERENCES `satuan_barang` (`id_satuan`);

--
-- Constraints for table `sales_master_gudang`
--
ALTER TABLE `sales_master_gudang`
  ADD CONSTRAINT `fk_gd_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`);

--
-- Constraints for table `sales_stok_gudang`
--
ALTER TABLE `sales_stok_gudang`
  ADD CONSTRAINT `fk_stk_brg` FOREIGN KEY (`id_barang`) REFERENCES `sales_master_barang` (`id_barang`),
  ADD CONSTRAINT `fk_stok_gd` FOREIGN KEY (`id_gudang`) REFERENCES `sales_master_gudang` (`id_gudang`);

--
-- Constraints for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  ADD CONSTRAINT `fk_jenis_satuan` FOREIGN KEY (`jenis`) REFERENCES `perusahaan_jenis` (`id`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `fk_shift_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_per` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
