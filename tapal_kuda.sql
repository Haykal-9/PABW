-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2025 pada 10.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tapal_kuda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pembayaran`
--

CREATE TABLE `detail_pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pembayaran_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_item` decimal(10,2) NOT NULL,
  `item_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_pembayaran`
--

INSERT INTO `detail_pembayaran` (`id`, `pembayaran_id`, `menu_id`, `quantity`, `price_per_item`, `item_notes`) VALUES
(11, 7, 2, 2, 22000.00, 'Less sugar'),
(12, 7, 15, 2, 20000.00, 'setengah porsi'),
(13, 8, 16, 1, 15000.00, 'enak nagihhh'),
(14, 9, 20, 1, 13000.00, 'extra cabe'),
(15, 10, 21, 1, 16000.00, 'bestt!!'),
(16, 11, 2, 1, 22000.00, 'Test Customer'),
(17, 11, 4, 1, 14000.00, 'Test Customer'),
(18, 11, 15, 1, 20000.00, 'Test Customer'),
(19, 12, 2, 1, 22000.00, 'Test Customer'),
(20, 12, 4, 1, 14000.00, 'Test Customer'),
(21, 12, 15, 1, 20000.00, 'Test Customer'),
(22, 13, 3, 1, 22000.00, 'test'),
(23, 14, 2, 1, 22000.00, 'Modal Test'),
(24, 14, 4, 1, 14000.00, 'Modal Test'),
(25, 15, 5, 1, 17000.00, 'test'),
(26, 15, 6, 1, 21000.00, 'test'),
(27, 15, 1, 1, 14000.00, 'test'),
(28, 16, 17, 1, 15000.00, 'test'),
(29, 16, 18, 1, 15000.00, 'test'),
(30, 16, 11, 1, 17000.00, 'test'),
(31, 17, 6, 1, 21000.00, 'test'),
(32, 17, 1, 1, 14000.00, 'test'),
(33, 18, 2, 1, 22000.00, 'test'),
(34, 19, 3, 1, 22000.00, 'haykal'),
(35, 19, 4, 1, 14000.00, 'haykal'),
(36, 20, 3, 1, 22000.00, 'haykal'),
(37, 20, 4, 1, 14000.00, 'haykal'),
(38, 20, 5, 1, 17000.00, 'haykal'),
(39, 21, 4, 1, 14000.00, 'haykal'),
(40, 21, 9, 1, 19000.00, 'haykal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `favorites`
--

CREATE TABLE `favorites` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `favorites`
--

INSERT INTO `favorites` (`user_id`, `menu_id`, `created_at`) VALUES
(7, 1, '2025-06-15 10:58:32'),
(7, 21, '2025-06-15 11:10:51'),
(7, 22, '2025-06-15 11:10:53'),
(8, 9, '2025-06-15 22:29:50'),
(8, 19, '2025-06-15 22:29:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gender_types`
--

CREATE TABLE `gender_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gender_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gender_types`
--

INSERT INTO `gender_types` (`id`, `gender_name`) VALUES
(1, 'Laki-laki'),
(2, 'Perempuan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `nama`, `url_foto`, `type_id`, `price`, `deskripsi`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'Kopi Tubruk Arabika', 'arabika.jpg', 1, 14000.00, 'Nikmati kenikmatan sejati dari secangkir Kopi Tubruk Arabika...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:31'),
(2, 'Cappucino', 'cappucino.jpg', 1, 22000.00, 'Butuh pelukan hangat dalam bentuk kopi? Coba Cappuccino kami...', 1, '2025-05-05 14:52:58', '2025-12-02 03:51:18'),
(3, 'ES Kopi Susu', 'kosu.jpg', 1, 22000.00, 'Minuman favorit semua kalangan! Es Kopi Susu kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:41'),
(4, 'Espresso', 'espresso.jpg', 1, 14000.00, 'Espresso kami dibuat dari biji arabika pilihan...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:44'),
(5, 'Espresso Double', 'espresso1.jpg', 1, 17000.00, 'Siap hadapi hari yang panjang? Espresso Double kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:47'),
(6, 'Japanase Flavour', 'JAPAN.jpg', 1, 21000.00, 'Rasakan kelembutan dan keunikan rasa Jepang...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:50'),
(7, 'Latte', 'Latte.jpg', 1, 25000.00, 'Butuh momen tenang di tengah hari yang sibuk? Latte kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:52'),
(8, 'Sukomon', 'SUKOMON.jpg', 1, 21000.00, 'Perpaduan yang tidak biasa, tapi luar biasa! Sukomon...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:55'),
(9, 'V60', 'V60.jpg', 1, 19000.00, 'Nikmati kelezatan kopi dengan cara yang lebih personal...', 1, '2025-05-05 14:52:58', '2025-06-15 11:03:58'),
(10, 'Vietname Drip', 'VIETNAME.jpg', 1, 19000.00, 'Rasakan kenikmatan kopi ala Vietnam dengan Vietnamese Drip kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:04:02'),
(11, 'Matcha', 'maca.jpg', 2, 17000.00, 'Rasakan kekayaan rasa dari Matcha kami...', 1, '2025-05-05 14:52:58', '2025-05-20 12:23:39'),
(12, 'Red Velvet Latte', 'red.jpg', 2, 17000.00, 'Nikmati kelezatan Red Velvet Latte kami...', 1, '2025-05-05 14:52:58', '2025-05-20 12:23:43'),
(13, 'Es Teh Manis', 'TehManis.jpg', 2, 8000.00, 'Nikmati kesegaran Es Teh Manis kami yang sempurna...', 1, '2025-05-05 14:52:58', '2025-05-21 16:47:56'),
(14, 'Wedang', 'wedang.jpg', 2, 8000.00, 'Nikmati kehangatan Wedang kami minuman tradisional...', 1, '2025-05-05 14:52:58', '2025-05-20 12:23:50'),
(15, 'Chicken Teriyaki', 'AyamTeriyaki.jpg', 3, 20000.00, 'Nikmati kelezatan Chicken Teriyaki kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:04:55'),
(16, 'Cuanki', 'cuanki.png', 3, 15000.00, 'Rasakan kenikmatan Cuanki kami, hidangan khas Bandung...', 1, '2025-05-05 14:52:58', '2025-06-15 11:04:58'),
(17, 'indomie goreng', 'indomieGoreng.jpg', 3, 15000.00, 'Indomie Goreng kami adalah pilihan sempurna...', 1, '2025-05-05 14:52:58', '2025-06-15 11:05:01'),
(18, 'indomie kuah', 'indomieKuah.jpeg', 3, 15000.00, 'Nikmati kehangatan Indomie Kuah kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:05:03'),
(19, 'Nasi Tutug Onceom', 'nasiTutug.webp', 3, 27000.00, 'Nikmati kelezatan Nasi Tutug Oncom kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:05:06'),
(20, 'Bala-bala', 'balabala.jpg', 4, 13000.00, 'Nikmati kelezatan Bala-Bala kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:04:14'),
(21, 'Kentang Sosis', 'kentangSosis.jpg', 4, 16000.00, 'Nikmati kelezatan Kentang Sosis kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:04:17'),
(22, 'Risoles', 'risol.jpg', 4, 18000.00, 'Nikmati Risoles kami yang lembut di luar...', 1, '2025-05-05 14:52:58', '2025-06-15 11:04:19'),
(23, 'Roti Bakar', 'Roti.jpg', 4, 16000.00, 'Nikmati kelezatan Roti Bakar kami...', 1, '2025-05-05 14:52:58', '2025-06-15 11:04:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_status`
--

CREATE TABLE `menu_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu_status`
--

INSERT INTO `menu_status` (`id`, `status_name`, `description`) VALUES
(1, 'tersedia', 'Menu tersedia untuk dipesan'),
(2, 'habis', 'Menu tidak tersedia sementara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_types`
--

CREATE TABLE `menu_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(30) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menu_types`
--

INSERT INTO `menu_types` (`id`, `type_name`, `description`) VALUES
(1, 'kopi', 'Minuman berbahan dasar kopi'),
(2, 'minuman', 'Minuman non-kopi'),
(3, 'makanan_berat', 'Hidangan utama'),
(4, 'cemilan', 'Camilan atau makanan ringan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '0001_01_01_000003_create_user_roles_table', 1),
(4, '0001_01_01_000004_create_gender_types_table', 1),
(5, '0001_01_01_000010_create_users_table', 1),
(6, '2025_11_15_162013_create_menu_statuses_table', 1),
(7, '2025_11_15_162032_create_menu_types_table', 1),
(8, '2025_11_15_162053_create_order_types_table', 1),
(9, '2025_11_15_162136_create_payment_methods_table', 1),
(10, '2025_11_15_162158_create_payment_statuses_table', 1),
(11, '2025_11_15_162229_create_reservation_statuses_table', 1),
(12, '2025_11_15_162316_create_menus_table', 1),
(13, '2025_11_15_162331_create_pembayarans_table', 1),
(14, '2025_11_15_162345_create_reservasis_table', 1),
(15, '2025_11_15_162402_create_favorites_table', 1),
(16, '2025_11_15_162429_create_reviews_table', 1),
(17, '2025_11_15_162452_create_detail_pembayarans_table', 1),
(18, '2025_11_15_162521_create_reservasi_ditolaks_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_types`
--

CREATE TABLE `order_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_types`
--

INSERT INTO `order_types` (`id`, `type_name`, `description`) VALUES
(1, 'dine_in', 'Makan di tempat'),
(2, 'take_away', 'Ambil sendiri'),
(3, 'delivery', 'Diantarkan ke lokasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method_name`, `description`) VALUES
(1, 'cash', 'Pembayaran tunai'),
(2, 'e-wallet', 'Pembayaran melalui dompet digital'),
(3, 'qris', 'Pembayaran melalui QRIS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_status`
--

CREATE TABLE `payment_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_status`
--

INSERT INTO `payment_status` (`id`, `status_name`, `description`) VALUES
(1, 'completed', 'Pembayaran berhasil'),
(2, 'pending', 'Menunggu pembayaran'),
(3, 'cancelled', 'Pembayaran dibatalkan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `order_type_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `user_id`, `order_date`, `status_id`, `payment_method_id`, `order_type_id`) VALUES
(3, 7, '2025-06-16 09:15:00', 2, 3, 3),
(7, 8, '2025-06-16 10:32:41', 1, 1, 1),
(8, 8, '2025-06-16 12:25:38', 1, 1, 1),
(9, 8, '2025-06-16 12:27:34', 1, 1, 2),
(10, 8, '2025-06-16 12:29:18', 1, 1, 1),
(11, 2, '2025-11-28 04:23:14', 1, 1, 1),
(12, 2, '2025-11-28 04:24:40', 1, 1, 1),
(13, 2, '2025-11-28 04:27:05', 1, 1, 1),
(14, 2, '2025-11-28 04:32:25', 1, 1, 1),
(15, 2, '2025-11-28 04:37:51', 1, 1, 1),
(16, 2, '2025-11-28 04:40:04', 1, 1, 1),
(17, 2, '2025-11-28 07:01:01', 1, 1, 1),
(18, 2, '2025-11-28 07:05:48', 1, 1, 1),
(19, 2, '2025-11-30 15:02:01', 1, 1, 1),
(20, 2, '2025-12-02 10:50:34', 1, 2, 2),
(21, 2, '2025-12-03 10:18:45', 1, 3, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kode_reservasi` varchar(20) NOT NULL,
  `tanggal_reservasi` datetime NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id`, `user_id`, `kode_reservasi`, `tanggal_reservasi`, `jumlah_orang`, `message`, `status_id`, `created_at`, `updated_at`) VALUES
(5, 9, 'RSV20250616073443524', '2025-06-17 17:00:00', 4, 'Buka bersama', 2, '2025-06-15 22:34:43', '2025-06-15 22:42:38'),
(6, 9, 'RSV20250616073826429', '2025-06-21 12:30:00', 5, 'Acara keluarga', 2, '2025-06-15 22:38:26', '2025-06-15 22:42:39'),
(7, 9, 'RSV20250616073907438', '2025-06-19 12:00:00', 6, 'meeting', 2, '2025-06-15 22:39:07', '2025-06-15 22:42:39'),
(8, 8, 'RSV20250616074033831', '2025-06-22 15:30:00', 2, 'Arisan Keluarga', 2, '2025-06-15 22:40:33', '2025-06-15 22:42:40'),
(9, 8, 'RSV20250616074136785', '2025-06-18 20:00:00', 2, 'Dinner keluarga', 2, '2025-06-15 22:41:36', '2025-06-15 22:42:40'),
(10, 8, 'RSV20250616074422916', '2025-06-19 15:00:00', 15, 'Acara ulang tahun anak', 3, '2025-06-15 22:44:22', '2025-06-15 22:48:15'),
(11, 8, 'RSV20250616074515627', '2025-06-24 14:00:00', 5, 'Outdoor', 3, '2025-06-15 22:45:15', '2025-06-15 22:48:26'),
(12, 9, 'RSV20250616074555866', '2025-06-25 19:00:00', 7, 'Indoor', 3, '2025-06-15 22:45:55', '2025-06-15 22:48:35'),
(13, 9, 'RSV20250616074641143', '2025-06-18 15:00:00', 3, 'Indoor yaaa', 3, '2025-06-15 22:46:41', '2025-06-15 22:48:42'),
(14, 7, 'RSV20250616074736369', '2025-06-20 19:30:00', 2, 'Ultah istri', 3, '2025-06-15 22:47:36', '2025-06-15 22:48:52'),
(15, 7, 'RSV-20251202-217', '2025-12-03 19:00:00', 5, 'Meja di dekat jendela', 3, '2025-12-01 21:56:08', '2025-12-01 22:14:36'),
(16, 7, 'RSV-20251202-368', '2025-12-05 18:00:00', 4, 'Test reservasi', 2, '2025-12-01 22:01:58', '2025-12-01 22:14:20'),
(17, 7, 'RSV-20251202-469', '2025-12-10 18:30:00', 6, 'Untuk acara ulang tahun', 3, '2025-12-01 22:17:53', '2025-12-01 22:20:36'),
(18, 7, 'RSV-20251202-986', '2025-12-31 14:44:00', 7, 'meja 2', 1, '2025-12-02 03:36:45', '2025-12-02 03:36:45'),
(19, 7, 'RSV-20251202-308', '2025-12-31 14:44:00', 7, 'meja 2', 1, '2025-12-02 03:46:38', '2025-12-02 03:46:38'),
(20, 7, 'RSV-20251202-426', '2025-12-15 18:48:00', 6, 'meja 3', 3, '2025-12-02 03:47:43', '2025-12-02 03:49:19'),
(21, 10, 'RSV-20251202-506', '2025-12-02 19:50:00', 10, 'meja dekat', 2, '2025-12-02 03:48:56', '2025-12-02 03:49:10'),
(22, 10, 'RSV-20251203-545', '2025-12-17 18:30:00', 8, 'meja 3 orang', 1, '2025-12-03 03:29:52', '2025-12-03 03:29:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi_ditolak`
--

CREATE TABLE `reservasi_ditolak` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `alasan_ditolak` text NOT NULL,
  `ditolak_oleh` varchar(50) NOT NULL,
  `cancelled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservasi_ditolak`
--

INSERT INTO `reservasi_ditolak` (`id`, `reservation_id`, `alasan_ditolak`, `ditolak_oleh`, `cancelled_at`) VALUES
(2, 10, 'Reservasi Penuh', 'kasir', '2025-06-15 22:48:15'),
(3, 11, 'Reservasi Penuh', 'kasir', '2025-06-15 22:48:26'),
(4, 12, 'Reservasi Penuh', 'kasir', '2025-06-15 22:48:35'),
(5, 13, 'Reservasi Penuh', 'kasir', '2025-06-15 22:48:42'),
(6, 14, 'Reservasi Penuh', 'kasir', '2025-06-15 22:48:52'),
(7, 17, 'Kapasitas penuh untuk tanggal tersebut', 'kasir', '2025-12-01 22:20:36'),
(8, 20, 'penuh', 'kasir', '2025-12-02 03:49:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservation_status`
--

CREATE TABLE `reservation_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservation_status`
--

INSERT INTO `reservation_status` (`id`, `status_name`, `description`) VALUES
(1, 'pending', 'Reservasi menunggu konfirmasi'),
(2, 'dikonfirmasi', 'Reservasi telah dikonfirmasi'),
(3, 'dibatalkan', 'Reservasi dibatalkan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `menu_id`, `rating`, `comment`, `created_at`) VALUES
(4, 8, 1, 5, 'kopinya enak sekali, wajib dicoba sihh', '2025-06-15 20:18:05'),
(5, 9, 1, 5, 'Enak bangettttt', '2025-06-15 20:18:34'),
(6, 8, 22, 5, 'risolnya enak bangett', '2025-06-15 20:19:39'),
(7, 8, 19, 5, 'besttttt!!', '2025-06-15 20:19:57'),
(8, 8, 20, 5, 'enakkk!!', '2025-06-15 20:20:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gZi93I9hRV8wwIa8ATxzYisfOEisW1mgjKkE3z0R', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRk96Tnl2NVlFT0NUdTVUYTB5YnhndkhkN3FrVk9udmdJZUtsMTQ4YSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9rYXNpci9yZXNlcnZhc2kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1764757804),
('HBA5lTtjKm3CyY5s8Zy4ldoxJkl7T5lkm80gCdds', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 OPR/125.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVWhGWW9xNVZORURjR0FCbVJYSUNwWmlXaU5KelpiY2hRVW1ZZkdsciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXNpci9wcm9maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1765702095),
('s26c0MKWIkUF1H469SBdm3NDovlN9P5pPeqbDOHB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT054MEdhSm5hWER5eUN2V0RLd0RBQTN3cEVUUmxtNjNrWUNORWt3dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765261168);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `gender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `nama`, `email`, `no_telp`, `gender_id`, `alamat`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'admin123', 'admin tapal kuda', 'tapalkuda@gmail.com', '06790879769', 1, 'jl. sumedang', 'null', NULL, NULL),
(2, 2, 'kasir', 'kasir123', 'kasir tapal kuda', 'kasirtapal@gmail.com', '09679697283', 2, 'jl. kebon jeruk 04', 'null', NULL, NULL),
(7, 3, 'salmana', 'salman123', 'ridhwan qo', 'salman@gmail.com', NULL, 1, NULL, 'profile_692ec530191e9.png', '2025-06-15 10:35:03', '2025-12-02 03:53:36'),
(8, 3, 'bian', 'bian123', 'biantara', 'biantarawi@gmail.com', '083130919334', 1, '0', 'profile_684f8c6bc7380.png', '2025-06-15 20:15:55', '2025-06-15 20:15:55'),
(9, 3, 'haykal', 'haykal123', 'M haykal', 'haykal@gmail.com', '087684747333', 1, '0', 'default-avatar.png', '2025-06-15 20:17:03', '2025-06-15 20:17:03'),
(10, 2, 'khaaal', '$2y$12$Ax8MSu8XCOfICf0xQZ9BsOm7pIr61l0o9A3oyjLXOJqA6QIOADCA6', 'haykal', 'hllzrd@gmail.com', NULL, 1, NULL, 'profile_693e79cf34da8.jpg', '2025-12-02 03:35:17', '2025-12-14 01:48:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`, `description`) VALUES
(1, 'admin', 'Administrator sistem dengan hak akses penuh'),
(2, 'kasir', 'Staf kasir untuk mengelola transaksi penjualan'),
(3, 'member', 'Pengguna umum atau pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `detail_pembayaran`
--
ALTER TABLE `detail_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pembayaran_pembayaran_id_foreign` (`pembayaran_id`),
  ADD KEY `detail_pembayaran_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`menu_id`),
  ADD KEY `favorites_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `gender_types`
--
ALTER TABLE `gender_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gender_types_gender_name_unique` (`gender_name`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_type_id_foreign` (`type_id`),
  ADD KEY `menu_status_id_foreign` (`status_id`);

--
-- Indeks untuk tabel `menu_status`
--
ALTER TABLE `menu_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_status_status_name_unique` (`status_name`);

--
-- Indeks untuk tabel `menu_types`
--
ALTER TABLE `menu_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_types_type_name_unique` (`type_name`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_types`
--
ALTER TABLE `order_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_types_type_name_unique` (`type_name`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_method_name_unique` (`method_name`);

--
-- Indeks untuk tabel `payment_status`
--
ALTER TABLE `payment_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_status_status_name_unique` (`status_name`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_user_id_foreign` (`user_id`),
  ADD KEY `pembayaran_status_id_foreign` (`status_id`),
  ADD KEY `pembayaran_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `pembayaran_order_type_id_foreign` (`order_type_id`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservasi_kode_reservasi_unique` (`kode_reservasi`),
  ADD KEY `reservasi_user_id_foreign` (`user_id`),
  ADD KEY `reservasi_status_id_foreign` (`status_id`);

--
-- Indeks untuk tabel `reservasi_ditolak`
--
ALTER TABLE `reservasi_ditolak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservasi_ditolak_reservation_id_foreign` (`reservation_id`);

--
-- Indeks untuk tabel `reservation_status`
--
ALTER TABLE `reservation_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_status_status_name_unique` (`status_name`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_gender_id_foreign` (`gender_id`);

--
-- Indeks untuk tabel `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_roles_role_name_unique` (`role_name`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pembayaran`
--
ALTER TABLE `detail_pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gender_types`
--
ALTER TABLE `gender_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `menu_status`
--
ALTER TABLE `menu_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `menu_types`
--
ALTER TABLE `menu_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `order_types`
--
ALTER TABLE `order_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `payment_status`
--
ALTER TABLE `payment_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `reservasi_ditolak`
--
ALTER TABLE `reservasi_ditolak`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `reservation_status`
--
ALTER TABLE `reservation_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pembayaran`
--
ALTER TABLE `detail_pembayaran`
  ADD CONSTRAINT `detail_pembayaran_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pembayaran_pembayaran_id_foreign` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `menu_status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `menu_types` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_order_type_id_foreign` FOREIGN KEY (`order_type_id`) REFERENCES `order_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `payment_status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `reservation_status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reservasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi_ditolak`
--
ALTER TABLE `reservasi_ditolak`
  ADD CONSTRAINT `reservasi_ditolak_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_gender_id_foreign` FOREIGN KEY (`gender_id`) REFERENCES `gender_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
