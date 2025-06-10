-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Jún 10. 11:59
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `job`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `applied_at` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Jelentkezve',
  `notes` text DEFAULT NULL,
  `redflag` tinyint(1) NOT NULL DEFAULT 0,
  `resume_path` varchar(255) DEFAULT NULL,
  `motivation_path` varchar(255) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `cover_letter_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `company`, `position`, `applied_at`, `status`, `notes`, `redflag`, `resume_path`, `motivation_path`, `cv_path`, `cover_letter_path`, `created_at`, `updated_at`) VALUES
(2, 1, 'Potts Newton Traders', 'Doloribus cillum inv', '2025-06-09', 'Elutasítva', NULL, 1, NULL, NULL, NULL, NULL, '2025-06-09 13:43:38', '2025-06-09 17:57:50'),
(3, 1, 'Lester and Pierce Trading', 'Asperiores in quasi', '2025-06-13', 'Jelentkezve', 'Eveniet anim nostru', 1, NULL, NULL, NULL, NULL, '2025-06-09 17:15:10', '2025-06-09 18:09:10'),
(4, 1, 'Yates Casey Co', 'Laudantium magna ex', '2001-07-06', 'Id tempora consequat', 'Voluptatem ab atque', 1, NULL, NULL, NULL, NULL, '2025-06-10 05:34:08', '2025-06-10 05:34:08'),
(5, 1, 'Obrien Mack Associates', 'Ea aliqua Magna seq', '2010-06-28', 'palyazva', 'Unde molestias eaque', 1, NULL, NULL, NULL, NULL, '2025-06-10 06:28:11', '2025-06-10 06:28:11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `application_logs`
--

CREATE TABLE `application_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `logged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `application_logs`
--

INSERT INTO `application_logs` (`id`, `application_id`, `status`, `note`, `logged_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Semmi válasu', 'Már elegem van', '2025-06-20 18:45:00', '2025-06-09 16:45:28', '2025-06-09 16:45:28'),
(2, 3, 'Technikai interú', 'utálom', '2025-06-20 19:34:00', '2025-06-09 17:34:37', '2025-06-09 17:34:37');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `application_notes`
--

CREATE TABLE `application_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `noted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `application_notes`
--

INSERT INTO `application_notes` (`id`, `application_id`, `note`, `noted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Hosszú interjúkör', '2025-06-09 16:44:55', NULL, NULL),
(2, 2, 'nem volt megfelelő a végzettség', '2025-06-09 17:00:11', NULL, NULL),
(3, 2, 'nem jelenik meg a jegyzet!!!', '2025-06-09 17:01:07', NULL, NULL),
(4, 2, 'nrm', '2025-06-09 17:08:00', NULL, NULL),
(5, 2, 'Nem', '2025-06-09 17:08:16', NULL, NULL),
(6, 3, 'h', '2025-06-09 17:31:13', NULL, NULL),
(7, 3, 'Nem sikerült', '2025-06-09 17:34:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `application_status_changes`
--

CREATE TABLE `application_status_changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `old_status` varchar(255) NOT NULL,
  `new_status` varchar(255) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `application_status_changes`
--

INSERT INTO `application_status_changes` (`id`, `application_id`, `old_status`, `new_status`, `changed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Jelentkezve', 'Elutasítva', '2025-06-09 16:46:14', '2025-06-09 16:46:14', '2025-06-09 16:46:14');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `failed_jobs`
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
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_06_09_091349_create_applications_table', 1),
(6, '2025_06_09_161604_create_application_logs_table', 2),
(8, '2025_06_09_163048_add_files_to_applications_table', 3),
(9, '2025_06_09_172414_create_application_status_changes_table', 4),
(10, '2025_06_09_172424_create_application_notes_table', 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Szijártó Ferenc', 'szijartoferenc@gmail.com', NULL, '$2y$12$tpKpSfwesV6GpUDTQk0ZHOjmKMQ2m5dPWoOspcLJ/gFkMzS9mN7..', NULL, '2025-06-09 07:44:17', '2025-06-09 07:44:17');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`);

--
-- A tábla indexei `application_logs`
--
ALTER TABLE `application_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_logs_application_id_foreign` (`application_id`);

--
-- A tábla indexei `application_notes`
--
ALTER TABLE `application_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_notes_application_id_foreign` (`application_id`);

--
-- A tábla indexei `application_status_changes`
--
ALTER TABLE `application_status_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_status_changes_application_id_foreign` (`application_id`);

--
-- A tábla indexei `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `application_logs`
--
ALTER TABLE `application_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `application_notes`
--
ALTER TABLE `application_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `application_status_changes`
--
ALTER TABLE `application_status_changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `application_logs`
--
ALTER TABLE `application_logs`
  ADD CONSTRAINT `application_logs_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `application_notes`
--
ALTER TABLE `application_notes`
  ADD CONSTRAINT `application_notes_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `application_status_changes`
--
ALTER TABLE `application_status_changes`
  ADD CONSTRAINT `application_status_changes_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
