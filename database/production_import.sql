-- ============================================================
-- ROOTBIO - schema + data for MySQL / MariaDB
-- Generated: 2026-10-28 11:41:54
-- Import this file into phpMyAdmin to get a ready-to-use database.
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- ---------- SCHEMA ----------
-- MySQL schema for the tungg (ROOTBIO) Laravel application
-- Run this BEFORE importing data_export.sql, or use production_import.sql which contains both.

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_factor_secret` text NULL,
  `two_factor_recovery_codes` text NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned NULL DEFAULT NULL,
  `ip_address` varchar(45) NULL DEFAULT NULL,
  `user_agent` text NULL,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned NULL DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`, `queue`, `failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `passkeys` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `credential` json NOT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passkeys_credential_id_unique` (`credential_id`),
  KEY `passkeys_user_id_index` (`user_id`),
  CONSTRAINT `passkeys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NULL DEFAULT NULL,
  `coupon_code` varchar(255) NULL DEFAULT NULL,
  `plant_type` varchar(255) NULL DEFAULT NULL,
  `symptoms` json NULL,
  `note` varchar(255) NULL DEFAULT NULL,
  `source` varchar(255) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leads_phone_index` (`phone`),
  KEY `leads_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` json NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------- DATA ----------

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
  ('1', '0001_01_01_000000_create_users_table', '1'),
  ('2', '0001_01_01_000001_create_cache_table', '1'),
  ('3', '0001_01_01_000002_create_jobs_table', '1'),
  ('4', '2024_01_01_000000_create_passkeys_table', '1'),
  ('5', '2025_08_14_170933_add_two_factor_columns_to_users_table', '1'),
  ('6', '2026_10_27_000000_create_leads_table', '2'),
  ('7', '2026_10_27_154449_create_site_settings_table', '3');

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `is_admin`) VALUES
  ('1', 'Test User', 'test@example.com', '2026-10-27 14:20:30', '$2y$12$SfSPFxYeWOYrANNt9g9Pqu4dJHYTRzPEkgSm0rO6QfJN.fN9AGMHO', 'zUL5vBiiVl', '2026-10-27 14:20:30', '2026-10-27 14:20:30', NULL, NULL, NULL, '0'),
  ('2', 'Admin ROOTBIO', 'admin@rootbio.test', '2026-10-27 14:20:30', '$2y$12$uaOSlZ5V/tx27Gu8WsQs4.CW7d0LBOwvHZ8sUcJiNFLr5rbYNKVQi', '3V9CEb11UF4qjGOLcFcrpPew8qESAS8HXrl37upR6TJwwldbunPwMLr3IdEI', '2026-10-27 14:20:30', '2026-10-27 14:20:30', NULL, NULL, NULL, '1');

INSERT INTO `leads` (`id`, `name`, `phone`, `address`, `coupon_code`, `plant_type`, `symptoms`, `note`, `source`, `created_at`, `updated_at`) VALUES
  ('1', 'Erin Waters', '0958623437', '16902 Laverne Crescent Suite 423
Krysteltown, MO 11928-2044', 'HT212', 'Cây rau, củ', '["VÀNG LÁ","THỐI RỄ"]', 'Eum itaque adipisci autem ullam blanditiis occaecati et.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('2', 'Rudy Abshire', '0946591485', '88664 Hammes Ways Apt. 450
Port Ibrahim, MS 75106-4492', 'HT212', 'Bonsai', '["VÀNG LÁ","CÂY CÒI CỌC"]', 'Eos saepe cum reprehenderit qui molestiae quia.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('3', 'Prof. Ismael Dare', '0942545865', '467 Halvorson Flats
Jamesonside, MS 44553', 'HT212', 'Cây rau, củ', '["CÂY CÒI CỌC","THỐI RỄ"]', 'Quia sed sit aspernatur quae pariatur dolor illo.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('4', 'Theresa Abbott', '0920901572', '41152 Feil Square Apt. 485
South Vance, FL 35428', 'HT212', 'Cây cảnh', '["CÂY CÒI CỌC","THỐI RỄ"]', 'Expedita saepe repellat nisi unde.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('5', 'Princess Hills', '0978843112', '151 Reichel Radial
Tiffanyport, HI 78634-9527', 'HT212', 'Cây rau, củ', '["CÂY CÒI CỌC","VÀNG LÁ"]', 'Expedita et ducimus ut facere.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('6', 'Myrna Sawayn Sr.', '0992491291', '5644 Kling Field Apt. 943
Manuelberg, LA 78744', 'HT212', 'Cây cảnh', '["VÀNG LÁ","CÂY CÒI CỌC"]', 'Explicabo molestias optio numquam vitae.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('7', 'Ashton Kemmer', '0916400323', '37117 Rozella Shore
East Hallieburgh, MN 32691-7914', 'HT212', 'Bonsai', '["VÀNG LÁ","THỐI RỄ"]', 'Nostrum sint est ad sit totam.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('8', 'Claude Graham', '0920002144', '22002 Danial Avenue
Port Camryntown, TX 79532-1403', 'HT212', 'Cây ăn quả', '["CÂY CÒI CỌC","THỐI RỄ"]', 'Suscipit fuga sed quasi odio a rerum.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('9', 'Jaylan Wiegand', '0997522857', '8997 Collier Flat
West Alessiashire, RI 33549', 'HT212', 'Cây rau, củ', '["VÀNG LÁ","CÂY CÒI CỌC"]', 'Voluptas dicta fugiat molestiae quisquam.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('10', 'Ms. Clarissa Eichmann Jr.', '0974927693', '4757 Everette River
Lake Allisonmouth, NH 85203-1140', 'HT212', 'Cây ăn quả', '["VÀNG LÁ","THỐI RỄ"]', 'Voluptatem ratione aliquid consequatur nostrum.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('11', 'Flavio Gusikowski II', '0928688020', '86316 Bailey Orchard
Port Lavadaland, NC 06428-2755', 'HT212', 'Cây rau, củ', '["CÂY CÒI CỌC","THỐI RỄ"]', 'Ex ipsum recusandae doloribus provident totam labore numquam.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('12', 'Cassandra Kshlerin', '0939333466', '920 Trent Ford Apt. 167
North Herminiamouth, NC 20983', 'HT212', 'Cây rau, củ', '["THỐI RỄ","VÀNG LÁ"]', 'Dolores sit numquam accusamus deleniti molestias.', 'landing', '2026-10-27 14:20:30', '2026-10-27 14:20:30'),
  ('13', 'Nguyen Van Test', '0905551234', 'So 1, Ha Noi', 'HT212', 'Cây ăn quả', '["VÀNG LÁ","THỐI RỂ"]', 'Vuon sau rieng 2 ha, cay dang vang la va ngung ra dot.', 'landing', '2026-10-27 14:33:21', '2026-10-27 14:33:21');

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
  ('1', 'home_content', '{"seo":{"title":"Phân bón ROOTBIO","description":"Phân bón sinh học ROOTBIO - kích rễ, bung đọt, hết vàng lá thối rễ chỉ sau 2 lần tưới. Nhận ưu đãi tặng 100 chai dùng thử."},"hero":{"brandName":"ROOTBIO","brandTagline":"Phân bón sinh học","brandLetter":"R","navPhone":"0939.393.912","navCtaLabel":"Đăng ký ngay","badgeText":"Nhận ưu đãi - Tặng 100 chai dùng thử","titlePrefix":"Phân bón","titleAccent":"ROOTBIO","titleSubtitle":"Chỉ 2 lần phun – cây bung đọt, ra rễ mạnh","description":"Cam kết hiệu quả sau 5 - 7 ngày. Công nghệ Nano đạt chuẩn Thụy Sỹ, vi lượng chelate mạnh gấp 10 lần, axit humic 7% và 7% Kali hữu hiệu giúp cây hết vàng lá, thối rễ, còi cọc.","primaryCtaLabel":"Nhận ưu đãi","primaryCtaHref":"#dang-ky","secondaryCtaLabel":"Xem hiệu quả","secondaryCtaHref":"#hieu-qua","features":[{"value":"cam kết hiệu quả sau 5 -7 ngày"},{"value":"X100 LẦN"},{"value":"CÔNG NGHỆ TIÊN TIẾN"},{"value":"Vi lượng đầy đủ"},{"value":"Axit Humic 7%"},{"value":"Dạng lỏng"},{"value":"NPK 3-3-3"}],"productImage":"/images/rootbio/product.png","productBadgeTitle":"Hiệu quả gấp 10 lần","productBadgeText":"Hơn 3.826.534 người đã sử dụng và cho ra hiệu quả năng suất vượt trội","floatingBadgeValue":"100","floatingBadgeLabel":"Chai dùng thử"},"plantTypes":{"heading":"Giải pháp an toàn cho mọi loại cây","items":[{"value":"Cây thân gỗ"},{"value":"Cây Bonsai"},{"value":"Cây ăn quả"},{"value":"Cây Rau, củ"},{"value":"Các cây hoa"},{"value":"Các cây cảnh"}]},"problems":{"heading":"Bà con đang đau đầu về điều gì?","items":[{"title":"Cây không ra đọt, ngừng phát triển","description":"Cây không ra đọt, thậm chí ngừng phát triển dù đã bón phân.","image":"/images/rootbio/problem3.png"},{"title":"Đất chai cứng, cây không bám rễ","description":"Đất trồng lâu năm bị chai, rễ không thể lấy dinh dưỡng, khiến cây còi cọc.","image":"/images/rootbio/problem5.webp"},{"title":"Cây héo rũ, rễ yếu, dễ chết","description":"Cây non nhưng mà rễ không phát triển, nhanh héo rũ, thậm chí chết cây.","image":"/images/rootbio/problem1.jpg"},{"title":"Cây thối rễ, cây suy kiệt","description":"Cây yếu, khó ra đọt thường bị nấm hại rễ, giâm cành nhưng không thành công.","image":"/images/rootbio/problem4.jpg"}],"warningTitle":"Cảnh báo!","warningText":"Cây khó kích rễ, kích đọt và chậm đẻ nhánh chủ yếu do đất trồng nghèo dinh dưỡng, chai cứng hoặc bị úng nước, khiến rễ không thể phát triển và hấp thu chất cần thiết. Ngoài ra, việc bón phân không cân đối, thiếu vi lượng quan trọng cũng làm cây suy yếu, khó ra đọt và chậm đẻ nhánh.","warningTags":[{"value":"CÂY CÒI CỌC"},{"value":"CÂY VÀNG LÁ"},{"value":"CÂY THỐI RỄ"},{"value":"ĐẤT BẠC MÀU"},{"value":"MẤT MÙA, GIẢM NĂNG SUẤT"}]},"solutions":{"eyebrow":"Chỉ 2 lần phun","heading":"Giải quyết ngay các vấn đề","description":"Chỉ cần 2 lần phun, tái sinh lại bộ rễ, hấp thu dinh dưỡng siêu tốt. Mầm, chồi khỏe mạnh, cây suy khoẻ lại thần kỳ.","items":[{"title":"HẾT Vàng Lá Thối Rễ sau 2 lần tưới","description":"Kích thích RA RỄ nhanh, cây tăng trưởng mạnh! Cây hấp thụ tối đa dưỡng chất, cây nhanh lớn, bung đọt mạnh, kích rễ nhanh phát triển gấp 5 lần sau 2 lần sử dụng nhờ 45% lượng axit humic có trong sản phẩm.","image":"/images/rootbio/feature5.png"},{"title":"Đảm bảo tỷ lệ kích thích ra hoa, đậu quả lên tới 93%","description":"Chỉ sau 2 lần tưới với 7% Kali hữu hiệu. Tổng hợp các chất điều hòa sinh trưởng, kích thích quả, hoa, lá phát triển mạnh mẽ, tăng 30% chất lượng nông sản so với thông thường.","image":"/images/rootbio/feature6.png"},{"title":"Tăng sức đề kháng với công nghệ Probiotics","description":"Ứng dụng công nghệ Probiotics cung cấp hàng tỷ lợi khuẩn cho cây và môi trường đất, tăng khả năng chống nấm bệnh và cải thiện chất đất.","image":"/images/rootbio/tech1.png"},{"title":"Công nghệ Nano đạt chuẩn công nghệ Thụy Sỹ","description":"Giúp cây hấp thụ qua lá nhanh hơn, hiệu quả hơn gấp 3 lần so với bón gốc.","image":"/images/rootbio/tech2.png"}],"statsEyebrow":"Theo thống kê lên đến hơn","statsValue":3826534,"statsValueLabel":"người đã sử dụng và cho ra hiệu quả năng suất vượt trội","statsSecondaryValue":99,"statsSecondaryLabel":"người đăng ký nhận ưu đãi"},"press":{"heading":"Những ngày gần đây, trên một số tờ báo và kênh truyền hình nổi tiếng xuất hiện thông tin về sản phẩm Phân bón ROOTBIO giúp cây ra rễ mạnh, mầm khoẻ, sinh trưởng tốt.","description":"Sản phẩm cũng được người Nhật đánh giá cao, khi lấy nguồn nguyên liệu nhập khẩu chất lượng từ Nhật Bản.","badgeOne":"Được người Nhật đánh giá cao","badgeTwo":"Được chứng nhận bởi báo chí","image":"/images/rootbio/japan.webp"},"testimonials":{"heading":"Bà con nông dân sau khi sử dụng phân bón ROOTBIO","items":[{"quote":"Tôi đã dùng rất nhiều loại phân bón khác nhau, nhưng để tiết kiệm và hiệu quả nhanh nhất thì có lẽ là sản phẩm phân bón ROOTBIO này. hiệu quả rất nhanh mà lại tiết kiệm.","author":"Anh Hùng chủ trại Cà Phê Gia Lai","image":"/images/rootbio/testimonial1.jpg"},{"quote":"Rất cảm ơn ROOTBIO đã cứu sống vườn cây của tôi, tôi không nghĩ nó hiệu quả nhanh đến vậy. lúc đầu thấy quảng cáo thì cũng mua thử dùng trước cho vài gốc. Ai ngờ hiệu quả nhanh thật sự, đúng là hàng nhật, chất thật.","author":"Anh Trần Hùng chủ trại bưởi ở Vĩnh Long","image":"/images/rootbio/cta3.jpg"},{"quote":"Tôi cũng chỉ vô tình được bà con tặng cho 1 lọ dùng thử. Nhưng đúng là hiệu quả khách xa với nhưng loại phân bón trước kia từng sử dụng tôi mới đặt thêm 2 thùng về dùng cho toàn bộ vườn cây của mình. Bà con yên tâm mà dùng.","author":"Anh Việt Vương chủ trại ở Lâm Đồng","image":"/images/rootbio/cta2.jpg"}]},"highlights":{"heading":"Tác dụng nổi bật của ROOTBIO","subheading":"Cây xanh dày lá - vọt đọt - bung đọt chỉ sau 3 - 5 ngày","items":[{"value":"Siêu kích rễ, đi đọt cho cây sầu riêng, ca cao, cafe, điều, tiêu…"},{"value":"Siêu kích mầm cho mọi loại cây, cây cảnh, cây bonsai, rau màu, cây ăn quả"},{"value":"Mầm xanh ra đều mơn mởn khỏe mạnh, không chết thối, hoa trái phát triển mạnh"},{"value":"Nguyên liệu nhập khẩu Nhật Bản, ứng dụng công nghệ sinh học của Nhật Bản"}]},"ingredients":{"heading":"Thành phần nguyên liệu và công nghệ","items":[{"title":"Siêu Vi Lượng Chelate","description":"Dòng siêu vi lượng này mạnh gấp 10 lần so với các dòng vi lượng thông thường.","image":"/images/rootbio/effect1.png"},{"title":"Công nghệ Nano","description":"Giúp các phân tử Nano Đạm, Nano Lân, Nano Kali giúp hấp thụ nhanh gấp 100 lần.","image":"/images/rootbio/effect2.png"},{"title":"Amino acid","description":"Từ rong biển, bột cá, tảo biển, bột thịt giúp cung cấp hơn 50 loại amino acid.","image":"/images/rootbio/effect3.png"},{"title":"Acid humic, Acid Fulvic","description":"Tinh chất bột khoáng... giúp hệ rễ của cây trồng phát triển cực kì mạnh mẽ.","image":"/images/rootbio/effect4.png"}],"footerText":"Hiệu quả gấp 10 lần"},"cta":{"heading":"Bà con đăng ký để được kỹ sư nông nghiệp tư vấn miễn phí","description":"Chọn tình trạng cây trồng để được chuyên gia tư vấn cải thiện ngay.","benefits":[{"value":"kích thích bung rễ cực mạnh"},{"value":"nuôi hoa trái tốt, lá xanh mơn mởn"},{"value":"KÍCH THÍCH BẬT CHỒI, BUNG ĐỌT"},{"value":"TIẾT KIỆM CHI PHÍ, HIỆU QUẢ LÂU DÀI"}],"commitments":[{"value":"Tự hào là biểu tượng của sự đồng lòng và phục vụ, mang lại nguồn cung ứng phân bón chế phẩm sinh học hàng đầu."},{"value":"Sản phẩm được các cơ quan nhà nước kiểm nghiệm và chứng nhận, được kiểm soát chặt chẽ về chất lượng cũng giá thành hợp lý."},{"value":"Công ty đã nhận được nhiều bằng khen, chứng nhận để trở thành một trong những công ty tiên phong và có khả năng xuất sắc trong việc tạo ra những sản phẩm sinh học chất lượng."},{"value":"Được đưa ra thị trường Nhật Bản. Không chỉ đáp ứng được yêu cầu và kỳ vọng của khách hàng, mà còn vượt qua được các đối thủ cạnh tranh trong thị trường."}],"formTitle":"Anh/Chị hãy điền thông tin để được chuyên gia tư vấn","formSubtitle":"Kỹ sư nông nghiệp sẽ liên hệ trực tiếp tư vấn miễn phí.","couponCode":"HT212","plantTypes":[{"value":"Cây ăn quả"},{"value":"Cây cảnh"},{"value":"Cây Bonsai"},{"value":"Cây thân gỗ"},{"value":"Cây rau, củ"},{"value":"Cây hoa"}]},"certificates":{"heading":"Chứng nhận và xét nghiệm phân bón ROOTBIO","description":"Sản phẩm PHÂN BÓN ROOTBIO được Cục An toàn NÔNG NGHIỆP kiểm định an toàn và chất lượng, được bào chế theo công nghệ hiện đại và đạt chuẩn GMP.","image":"/images/rootbio/certs.png","primaryCtaLabel":"Chỉ 2 lần phun – Đăng ký ngay","primaryCtaHref":"#dang-ky","secondaryCtaLabel":"Gọi 0973.42.6704","secondaryCtaHref":"tel:0973426704"},"problemSelector":{"heading":"Bạn đang gặp tình trạng nào?","items":[{"value":"VÀNG LÁ"},{"value":"THỐI RỂ"},{"value":"CÂY CÒI CỌC"},{"value":"CÂY SÂU BỆNH"},{"value":"KHÔNG RA HOA"},{"value":"CÂY HÉO ÚA"}]},"reviews":{"heading":"Khách hàng đánh giá về phân bón ROOTBIO","averageRating":5,"totalReviews":"1.545 nhận xét","ratingBars":[{"stars":5,"percent":100},{"stars":4,"percent":0},{"stars":3,"percent":0},{"stars":2,"percent":0},{"stars":1,"percent":0}],"items":[{"name":"Hảo Lâm","time":"5 tiếng trước","content":"Dùng rất tuyệt vời. Chất lượng đúng mô tả cảm ơn shop rất nhiều."},{"name":"Văn Long","time":"45 phút trước","content":"Thích cái là hàng trực tiếp từ nhà máy nên cũng yên tâm, với cả giá cũng hợp lý. Xài mấy ngày là thấy rể với đọt ra rồi, nhanh thiệt."},{"name":"Kim Hậu","time":"1 giờ trước","content":"Nhà mình có vườn sầu, mà thấy bác hàng xóm quảng cáo quá trời, mua 1 thùng về dùng thử, hiệu quả lắm, mà mua theo thùng thì được chiết khấu ưu đãi nhiều nữa."},{"name":"Kim Lan","time":"1 tiếng trước","content":"Vườn tui có mấy cây ăn trái năm đầu xong bị chết đọt, vàng lá mình sử dụng loại này thấy ok lắm."},{"name":"Uyên Trần","time":"2 tiếng trước","content":"Cái này mua theo vườn bên cạnh tại thấy cây tốt mà ra hoa cũng đậu quả nhiều. Cũng may nó mới cứ được cái rẫy nhà mình."}]},"finalCta":{"heading":"Sử dụng phân bón ROOTBIO sẽ giúp cây trồng của bạn chắc khoẻ từ sâu bên trong, phát triển một cách mạnh mẽ, đem đến năng suất vượt trội","couponLabel":"Nhập mã nhận ưu đãi","couponCode":"HT212","peopleCount":99,"urgencyText":"Nhanh tay đặt hàng nhận ngay ưu đãi!","buttonLabel":"Đăng ký ngay","buttonHref":"#dang-ky"},"footer":{"brandName":"ROOTBIO","companyName":"CÔNG TY TNHH WI GROUP","address":"ĐỊA CHỈ: Tầng 4 Toà TH OFFICE TOWER 18, Số 438 Đường Khương Đình, Phường Hạ Đình, Thanh Xuân, Hà Nội","hotline":"0973.42.6704","hotlineHref":"tel:0973426704","plantListHeading":"Sử dụng trên nhiều loại cây","infoHeading":"Thông tin","infoLinks":[{"value":"Thông báo về quyền riêng tư"},{"value":"Thông báo cookies"},{"value":"Điều khoản sử dụng"},{"value":"Chính sách bảo mật"}],"copyright":"Copyright @ ROOTBIO - Tập Đoàn Phân Bón Sinh Học. All Rights Reserved"},"stickyCta":{"callLabel":"Gọi ngay","callHref":"tel:0973426704","registerLabel":"Đăng ký nhận ưu đãi","registerHref":"#dang-ky"}}', '2026-10-27 16:11:17', '2026-10-27 16:36:55');

SET FOREIGN_KEY_CHECKS=1;
