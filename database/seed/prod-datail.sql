-- -------------------------------------------------------------
-- TablePlus 6.4.4(604)
--
-- https://tableplus.com/
--
-- Database: promozioni_ariston
-- Generation Time: 2025-11-11 09:00:35.0040
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `ocr_document_details`;
CREATE TABLE `ocr_document_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nullable` tinyint(1) NOT NULL,
  `format` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_info_for_ai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `brand_id` bigint unsigned NOT NULL DEFAULT '1',
  `campaign_id` bigint unsigned NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=405 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` bigint unsigned NOT NULL,
  `campaign_id` bigint unsigned NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `not_used` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cashback_value` double NOT NULL,
  `quantity_bound` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ocr_document_details` (`id`, `name`, `type`, `nullable`, `format`, `additional_info_for_ai`, `brand_id`, `campaign_id`, `updated_at`, `created_at`) VALUES
(314, 'document_type', 'string', 0, NULL, 'Transport Documents are called \"ddt\".\nThis field must be only \'invoice\' or \'ddt\'', 1, 2, '2025-04-30 18:03:45', '2025-04-26 23:05:19'),
(315, 'document_number', 'string', 0, NULL, 'document_number  is usually called \'NUMERO DOCUMENTO\' or something similar, it can also be the invoice number', 1, 2, '2025-04-30 17:24:57', '2025-04-26 23:05:31'),
(316, 'total_amount', 'number', 0, NULL, 'Find the total with taxes included.', 1, 2, '2025-04-30 17:42:51', '2025-04-26 23:05:44'),
(317, 'date', 'string', 0, 'date', 'If is needed convert the date in format day-month-year', 1, 2, '2025-05-27 08:54:28', '2025-04-26 23:06:01'),
(328, 'genus-one-genus-premium-e-alteas-one_quantity', 'number', 1, NULL, 'Genus ONE, Genus Premium e Alteas ONE+ ', 1, 2, '2025-05-14 12:54:44', '2025-04-30 14:56:00'),
(329, 'clas-one-e-clas_quantity', 'number', 1, NULL, 'Clas ONE o Clas B', 1, 2, '2025-05-14 17:46:49', '2025-04-30 14:56:09'),
(330, 'cares-premium-e-cares_quantity', 'number', 1, NULL, 'Cares Premium o Cares S', 1, 2, '2025-05-14 17:46:57', '2025-04-30 14:56:21'),
(331, 'company_vat_number', 'string', 0, NULL, 'Remember: we need the BUYER vat number. \nYou can sometimes recognize  the buyer because  he\'s mentioned in the good destination or delivery destination section. Important: we do not need WHOLESALER vat number, if the vat number is phisically near to wholesaler name it is the wrong vat number. Important!!', 1, 2, '2025-06-12 11:01:54', '2025-04-30 15:24:26'),
(332, 'company_name', 'string', 0, NULL, NULL, 1, 2, '2025-04-30 17:25:28', '2025-04-30 17:25:28'),
(333, 'mira-urbia-e-talia_quantity', 'number', 1, NULL, 'Mira, Urbia e Talia', 1, 3, '2025-05-14 12:56:21', '2025-05-02 12:38:19'),
(334, 'pigma_quantity', 'number', 1, NULL, 'Pigma', 1, 3, '2025-07-02 10:42:26', '2025-05-02 12:38:29'),
(335, 'inoa_quantity', 'number', 1, NULL, 'Inoa', 1, 3, '2025-07-02 10:42:45', '2025-05-02 12:38:35'),
(336, 'document_type', 'string', 0, NULL, 'Transport Documents are called \"ddt\".\nThis field must be only \'invoice\' or \'ddt\'', 1, 3, '2025-04-30 18:03:45', '2025-04-26 23:05:19'),
(337, 'document_number', 'string', 0, NULL, 'document_number  is usually called \'NUMERO DOCUMENTO\' or something similar, it can also be the invoice number', 1, 3, '2025-04-30 17:24:57', '2025-04-26 23:05:31'),
(338, 'total_amount', 'number', 0, NULL, 'Find the total with taxes included.', 1, 3, '2025-04-30 17:42:51', '2025-04-26 23:05:44'),
(339, 'date', 'string', 0, 'date', NULL, 1, 3, '2025-04-26 23:06:01', '2025-04-26 23:06:01'),
(340, 'company_vat_number', 'string', 0, NULL, 'Remember: we need the BUYER vat number. \nYou can sometimes recognize  the buyer because  he\'s mentioned in the good destination or delivery destination section', 1, 3, '2025-04-30 16:49:58', '2025-04-30 15:24:26'),
(341, 'company_name', 'string', 0, NULL, NULL, 1, 3, '2025-04-30 17:25:28', '2025-04-30 17:25:28'),
(342, 'wholesaler', 'string', 1, NULL, NULL, 1, 2, '2025-05-13 09:25:28', '2025-05-13 09:25:28'),
(343, 'wholesaler', 'string', 1, NULL, NULL, 1, 3, '2025-05-13 09:25:28', '2025-05-13 09:25:28'),
(344, 'caldaia-gamma-fgb_quantity', 'number', 1, NULL, 'Caldaia gamma FGB', 1, 4, '2025-05-14 11:38:55', '2025-05-14 11:38:55'),
(345, 'caldaia-gamma-cgb-2_quantity', 'number', 1, NULL, 'Caldaia gamma CGB-2', 1, 4, '2025-05-14 11:39:11', '2025-05-14 11:39:11'),
(346, 'caldaia-gamme-cgs-e-cgw_quantity', 'number', 1, NULL, 'Caldaia gamme CGS e CGW', 1, 4, '2025-05-14 11:39:26', '2025-05-14 11:39:26'),
(347, 'unita-di-ventilazione-cwl-2_quantity', 'number', 1, NULL, 'Unità di ventilazione CWL-2', 1, 4, '2025-05-14 11:39:50', '2025-05-14 11:39:50'),
(348, 'unita-di-ventilazione-fwl-push-pull_quantity', 'number', 1, NULL, 'Unità di ventilazione FWL Push Pull', 1, 4, '2025-05-14 11:42:28', '2025-05-14 11:42:28'),
(349, 'gamma-pompe-di-calore-fha_quantity', 'number', 1, NULL, 'Gamma pompe di calore FHA', 1, 4, '2025-05-14 11:43:19', '2025-05-14 11:43:19'),
(350, 'document_type', 'string', 0, NULL, 'Transport Documents are called \"ddt\".\nThis field must be only \'invoice\' or \'ddt\'', 1, 4, '2025-04-30 18:03:45', '2025-04-26 23:05:19'),
(351, 'document_number', 'string', 0, NULL, 'document_number  is usually called \'NUMERO DOCUMENTO\' or something similar, it can also be the invoice number', 1, 4, '2025-04-30 17:24:57', '2025-04-26 23:05:31'),
(352, 'total_amount', 'number', 0, NULL, 'Find the total with taxes included.', 1, 4, '2025-04-30 17:42:51', '2025-04-26 23:05:44'),
(353, 'date', 'string', 0, 'date', NULL, 1, 4, '2025-04-26 23:06:01', '2025-04-26 23:06:01'),
(354, 'company_vat_number', 'string', 0, NULL, 'Remember: we need the BUYER vat number. \nYou can sometimes recognize  the buyer because  he\'s mentioned in the good destination or delivery destination section', 1, 4, '2025-04-30 16:49:58', '2025-04-30 15:24:26'),
(355, 'company_name', 'string', 0, NULL, NULL, 1, 4, '2025-04-30 17:25:28', '2025-04-30 17:25:28'),
(356, 'wholesaler', 'string', 1, NULL, NULL, 1, 4, '2025-05-13 09:25:28', '2025-05-13 09:25:28'),
(357, 'document_type', 'string', 0, NULL, 'Transport Documents are called \"ddt\".\nThis field must be only \'invoice\' or \'ddt\'', 1, 5, '2025-04-30 18:03:45', '2025-04-26 23:05:19'),
(358, 'document_number', 'string', 0, NULL, 'document_number  is usually called \'NUMERO DOCUMENTO\' or something similar, it can also be the invoice number', 1, 5, '2025-04-30 17:24:57', '2025-04-26 23:05:31'),
(359, 'total_amount', 'number', 0, NULL, 'Find the total with taxes included.', 1, 5, '2025-04-30 17:42:51', '2025-04-26 23:05:44'),
(360, 'date', 'string', 0, 'date', NULL, 1, 5, '2025-04-26 23:06:01', '2025-04-26 23:06:01'),
(361, 'company_vat_number', 'string', 0, NULL, 'Remember: we need the BUYER vat number. \nYou can sometimes recognize  the buyer because  he\'s mentioned in the good destination or delivery destination section', 1, 5, '2025-04-30 16:49:58', '2025-04-30 15:24:26'),
(362, 'company_name', 'string', 0, NULL, NULL, 1, 5, '2025-04-30 17:25:28', '2025-04-30 17:25:28'),
(363, 'wholesaler', 'string', 1, NULL, NULL, 1, 5, '2025-05-13 09:25:28', '2025-05-13 09:25:28'),
(364, 'document_type', 'string', 0, NULL, 'Transport Documents are called \"ddt\".\nThis field must be only \'invoice\' or \'ddt\'', 1, 6, '2025-04-30 18:03:45', '2025-04-26 23:05:19'),
(365, 'document_number', 'string', 0, NULL, 'document_number  is usually called \'NUMERO DOCUMENTO\' or something similar, it can also be the invoice number', 1, 6, '2025-04-30 17:24:57', '2025-04-26 23:05:31'),
(366, 'total_amount', 'number', 0, NULL, 'Find the total with taxes included.', 1, 6, '2025-04-30 17:42:51', '2025-04-26 23:05:44'),
(367, 'date', 'string', 0, 'date', NULL, 1, 6, '2025-04-26 23:06:01', '2025-04-26 23:06:01'),
(368, 'company_vat_number', 'string', 0, NULL, 'Remember: we need the BUYER vat number. \nYou can sometimes recognize  the buyer because  he\'s mentioned in the good destination or delivery destination section', 1, 6, '2025-04-30 16:49:58', '2025-04-30 15:24:26'),
(369, 'company_name', 'string', 0, NULL, NULL, 1, 6, '2025-04-30 17:25:28', '2025-04-30 17:25:28'),
(370, 'wholesaler', 'string', 1, NULL, NULL, 1, 6, '2025-05-13 09:25:28', '2025-05-13 09:25:28'),
(371, 'genus-alteas_quantity', 'number', 1, NULL, 'Genus/Alteas', 1, 5, '2025-06-27 10:24:09', '2025-06-27 10:24:09'),
(372, 'clas_quantity', 'number', 1, NULL, 'Clas', 1, 5, '2025-06-27 10:24:24', '2025-06-27 10:24:24'),
(373, 'cares_quantity', 'number', 1, NULL, 'Cares', 1, 5, '2025-06-27 10:25:00', '2025-06-27 10:25:00'),
(374, 'clas+genus-alteas_quantity', 'number', 1, NULL, 'Clas + Genus/Alteas', 1, 5, '2025-06-27 10:25:43', '2025-06-27 10:25:43'),
(375, 'nuos-basamento-murale_quantity', 'number', 1, NULL, 'Nuos Basamento/Murale', 1, 5, '2025-06-27 10:26:12', '2025-06-27 10:26:12'),
(376, 'hhp-ibrido_quantity', 'number', 1, NULL, 'HHP-Ibrido', 1, 5, '2025-07-21 09:11:03', '2025-06-27 10:26:45'),
(377, 'mira-urbia-talia_quantity', 'number', 1, NULL, 'Mira/Urbia/Talia', 1, 6, '2025-06-27 10:28:20', '2025-06-27 10:28:20'),
(378, 'pigma+mira-urbia-talia_quantity', 'number', 1, NULL, 'Pigma + Mira/Urbia/Talia', 1, 6, '2025-06-27 10:29:59', '2025-06-27 10:29:59'),
(379, 'aquanext-basamento-murale_quantity', 'number', 1, NULL, 'Aquanext Basamento/Murale', 1, 6, '2025-06-27 10:30:45', '2025-06-27 10:30:45'),
(381, 'genus-one-genus-premium-e-alteas-one_quantity', 'number', 1, NULL, 'Product range name: \"Genus ONE\", \"Genus Premium\", \"Alteas ONE\". The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion.', 1, 8, '2025-09-09 12:57:36', '2025-04-30 14:56:00'),
(382, 'cares-premium-e-cares-s_quantity', 'number', 1, NULL, 'Product range name: \"Cares Premium\", \"Cares S\".  The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion. Do not consider \"Cares x\" !', 1, 8, '2025-10-27 12:23:40', '2025-07-25 10:10:51'),
(383, 'clas-one-genus-one-genus-premium-e-alteas-one_quantity', 'number', 1, NULL, 'Product range name: \"Clas ONE\", \"Clas B\". The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion. Do not consider \"Clas x\"', 1, 8, '2025-10-27 12:24:01', '2025-07-25 10:13:03'),
(384, 'nuos-murale-o-a-basamento_quantity', 'number', 1, NULL, 'Product range name: \"Nuos murale\", \"Nuos a basamento\", \"Scaldacqua pompa di calore Nuos\". \n\n\"The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion. \"\n\n\"If the product after the word \"Nuos\" has a different word from \"murale\" or \"basamento\" or \"a basamento\", you have to not consider it. The product you read is to be considered part of this range only if the full name is written: if it says \"Nuos\" and nothing after, then it is not valid; if it says \"Nuos primo\", \"Nuos secondo\", \"Nuos\" + any word, then it is not valid.\" Do not consider \"Nuos Primo\" !!!!', 1, 8, '2025-10-27 12:24:53', '2025-07-25 10:13:51'),
(385, 'pompe-di-calore-o-sistemi-ibridi_quantity', 'number', 1, NULL, 'Product range name: \"Pompe di calore\", \"sistemi ibridi\", \"NIMBUS POCKET\" , \"Hybrid\". This product is a heat pump. The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion. Do not include accessories for heat pump like \"Volano termico PDC grezzo per pompa di calore\", it isn\'t a heat pump but a its accessory, so not include accessories.', 1, 8, '2025-10-22 11:57:31', '2025-07-25 10:14:05'),
(386, 'document_type', 'string', 0, NULL, 'Transport Documents are called \"ddt\".\nThis field must be only \'invoice\' or \'ddt\'', 1, 8, '2025-04-30 18:03:45', '2025-04-26 23:05:19'),
(387, 'document_number', 'string', 0, NULL, 'document_number  is usually called \'NUMERO DOCUMENTO\' or something similar, it can also be the invoice number', 1, 8, '2025-04-30 17:24:57', '2025-04-26 23:05:31'),
(388, 'total_amount', 'number', 0, NULL, 'Find the total with taxes included.', 1, 8, '2025-10-20 15:11:11', '2025-04-26 23:05:44'),
(389, 'date', 'string', 0, 'date', 'If is needed convert the date in format day-month-year. Dates separated with dash are valid dates, example: \"15-09-2025\" is a valid date, you must be convert the dash ( - ) in slash ( / ) if you do not reconize it. It is an italian document so the date is in italian format dd/mm/yyyy, not convert the date to other formats.', 1, 8, '2025-09-16 09:48:11', '2025-04-26 23:06:01'),
(390, 'company_vat_number', 'string', 0, NULL, 'Remember: we need the BUYER vat number. \nYou can sometimes recognize  the buyer because  he\'s mentioned in the good destination or delivery destination section. Important: we do not need WHOLESALER vat number, if the vat number is phisically near to wholesaler name it is the wrong vat number. Important!!', 1, 8, '2025-10-20 15:11:06', '2025-04-30 15:24:26'),
(391, 'company_name', 'string', 0, NULL, NULL, 1, 8, '2025-04-30 17:25:28', '2025-04-30 17:25:28'),
(392, 'wholesaler', 'string', 1, NULL, NULL, 1, 8, '2025-05-13 09:25:28', '2025-05-13 09:25:28'),
(393, 'gamma-inoa-s-e-inoa-green_quantity', 'number', 1, NULL, 'Product range name: \"Inoa S\", \"Inoa Green\". The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion.', 2, 9, '2025-09-11 09:48:14', '2025-09-10 12:06:55'),
(394, 'gamma-pigma-advance_quantity', 'number', 1, NULL, 'Product range name: \"Pigma Advance\". The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion.', 2, 9, '2025-09-11 09:48:31', '2025-09-10 12:09:06'),
(395, 'gamma-mira-advance-urbia-advance-talia-green-niagara-advance_quantity', 'number', 1, NULL, 'Product range name: \"Mira Advance\", \"Urbia Advance\", \"Niagara Advance\",\"Talia Green\". The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion. ', 2, 9, '2025-09-12 11:13:52', '2025-09-10 12:10:09'),
(396, 'scaldacqua-gamma-aquanext-murale-basamento_quantity', 'number', 1, NULL, 'Product range name: \"Aquanext murale/basamento\", \"Aquanext Performance\". The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion.', 2, 9, '2025-10-14 11:45:24', '2025-09-10 12:10:30'),
(397, 'pompe-di-calore-riscaldamento-sistemi-ibridi_quantity', 'number', 1, NULL, 'Product range name: \"Pompe di calore riscaldamento\", \"sistemi ibridi\", \"Arianext\". This product is a heat pump. The product name must obligatorily contain the words present in the product range name, if they are combined with other names. A product belongs to the range ONLY if the name contains the words present in the range name. All other products will be rejected and not considered, to avoid selecting products not included in the promotion. Do not include accessories for heat pump like \"Volano termico PDC grezzo per pompa di calore\", it isn\'t a heat pump but a its accessory, so not include accessories.', 2, 9, '2025-10-22 11:58:46', '2025-09-10 12:10:47'),
(398, 'document_type', 'string', 0, NULL, 'Transport Documents are called \"ddt\".\nThis field must be only \'invoice\' or \'ddt\'', 2, 9, '2025-04-30 18:03:45', '2025-04-26 23:05:19'),
(399, 'document_number', 'string', 0, NULL, 'document_number  is usually called \'NUMERO DOCUMENTO\' or something similar, it can also be the invoice number', 2, 9, '2025-04-30 17:24:57', '2025-04-26 23:05:31'),
(400, 'total_amount', 'number', 0, NULL, 'Find the total with taxes included.', 2, 9, '2025-04-30 17:42:51', '2025-04-26 23:05:44'),
(401, 'date', 'string', 0, 'date', 'If is needed convert the date in format day-month-year. Dates separated with dash are valid dates, example: \"15-09-2025\" is a valid date, you must be convert the dash ( - ) in slash ( / ) if you do not reconize it. It is an italian document so the date is in italian format dd/mm/yyyy, not convert the date to other formats.', 2, 9, '2025-10-15 16:35:40', '2025-04-26 23:06:01'),
(402, 'company_vat_number', 'string', 0, NULL, 'Remember: we need the BUYER vat number. \nYou can sometimes recognize  the buyer because  he\'s mentioned in the good destination or delivery destination section. Important: we do not need WHOLESALER vat number, if the vat number is phisically near to wholesaler name it is the wrong vat number. Important!!', 2, 9, '2025-06-12 11:01:54', '2025-04-30 15:24:26'),
(403, 'company_name', 'string', 0, NULL, NULL, 2, 9, '2025-04-30 17:25:28', '2025-04-30 17:25:28'),
(404, 'wholesaler', 'string', 1, NULL, NULL, 2, 9, '2025-05-13 09:25:28', '2025-05-13 09:25:28');

INSERT INTO `products` (`id`, `name`, `brand_id`, `campaign_id`, `slug`, `not_used`, `cashback_value`, `quantity_bound`, `updated_at`, `created_at`) VALUES
(6, 'Genus ONE, Genus Premium e Alteas ONE+ ', 1, 2, 'genus-one-genus-premium-e-alteas-one', NULL, 70, NULL, '2025-05-14 12:54:44', '2025-04-26 23:03:51'),
(7, 'Clas ONE o Clas B', 1, 2, 'clas-one-e-clas', NULL, 55, NULL, '2025-05-14 17:46:49', '2025-04-28 09:08:02'),
(8, 'Cares Premium o Cares S', 1, 2, 'cares-premium-e-cares', NULL, 40, NULL, '2025-05-14 17:46:57', '2025-04-28 09:21:36'),
(9, 'Mira, Urbia e Talia', 2, 3, 'mira-urbia-e-talia', NULL, 70, NULL, '2025-05-14 12:56:21', '2025-05-02 12:38:19'),
(10, 'Pigma', 2, 3, 'pigma', NULL, 55, NULL, '2025-07-02 10:42:26', '2025-07-02 10:42:26'),
(11, 'Inoa', 2, 3, 'inoa', NULL, 40, NULL, '2025-07-02 10:42:45', '2025-07-02 10:42:45'),
(12, ' Caldaia gamma FGB', 3, 4, 'caldaia-gamma-fgb', NULL, 60, NULL, '2025-05-14 11:38:55', '2025-05-14 11:38:55'),
(13, ' Caldaia gamma CGB-2', 3, 4, 'caldaia-gamma-cgb-2', NULL, 100, NULL, '2025-05-14 11:39:11', '2025-05-14 11:39:11'),
(14, ' Caldaia gamme CGS e CGW', 3, 4, 'caldaia-gamme-cgs-e-cgw', NULL, 125, NULL, '2025-05-14 11:39:26', '2025-05-14 11:39:26'),
(15, 'Unità di ventilazione CWL-2', 3, 4, 'unita-di-ventilazione-cwl-2', NULL, 120, NULL, '2025-05-14 11:39:50', '2025-05-14 11:39:50'),
(16, 'Unità di ventilazione FWL Push Pull', 3, 4, 'unita-di-ventilazione-fwl-push-pull', NULL, 50, NULL, '2025-05-14 11:42:28', '2025-05-14 11:42:28'),
(17, 'Gamma pompe di calore FHA', 3, 4, 'gamma-pompe-di-calore-fha', NULL, 220, NULL, '2025-05-14 11:43:19', '2025-05-14 11:43:19'),
(18, 'Genus/Alteas', 1, 5, 'genus-alteas', NULL, 100, 1, '2025-06-27 10:24:09', '2025-06-27 10:24:09'),
(19, 'Clas', 1, 5, 'clas', NULL, 60, 1, '2025-06-27 10:24:24', '2025-06-27 10:24:24'),
(20, 'Cares', 1, 5, 'cares', NULL, 40, 1, '2025-06-27 10:25:00', '2025-06-27 10:25:00'),
(21, 'Clas + Genus/Alteas', 1, 5, 'clas+genus-alteas', NULL, 200, 1, '2025-06-27 10:25:43', '2025-06-27 10:25:43'),
(22, 'Nuos Basamento/Murale', 1, 5, 'nuos-basamento-murale', NULL, 100, 1, '2025-06-27 10:26:12', '2025-06-27 10:26:12'),
(24, 'Mira/Urbia/Talia', 2, 6, 'mira-urbia-talia', NULL, 100, 1, '2025-06-27 10:28:20', '2025-06-27 10:28:20'),
(25, 'Pigma', 2, 6, 'pigma', NULL, 60, 1, '2025-06-27 10:28:41', '2025-06-27 10:28:41'),
(26, 'Inoa', 2, 6, 'inoa', NULL, 40, 1, '2025-06-27 10:29:20', '2025-06-27 10:29:20'),
(27, 'Pigma + Mira/Urbia/Talia', 2, 6, 'pigma+mira-urbia-talia', NULL, 200, 1, '2025-06-27 10:29:59', '2025-06-27 10:29:59'),
(28, 'Aquanext Basamento/Murale', 2, 6, 'aquanext-basamento-murale', NULL, 100, 1, '2025-06-27 10:30:45', '2025-06-27 10:30:45'),
(29, 'HHP/Ibrido', 2, 6, 'hhp-ibrido', NULL, 200, 1, '2025-06-27 10:31:15', '2025-06-27 10:31:15'),
(32, 'HHP-Ibrido', 1, 5, 'hhp-ibrido', NULL, 200, 1, '2025-07-21 09:11:03', '2025-07-21 09:10:51'),
(33, 'gamma Cares Premium o Cares S', 1, 8, 'cares-premium-e-cares-s', NULL, 40, NULL, '2025-09-02 12:40:49', '2025-07-25 10:10:51'),
(34, 'gamma Clas ONE o Clas B', 1, 8, 'clas-one-genus-one-genus-premium-e-alteas-one', NULL, 65, NULL, '2025-09-02 12:41:14', '2025-07-25 10:13:03'),
(35, 'gamma Genus ONE, Genus Premium o Alteas ONE', 1, 8, 'genus-one-genus-premium-e-alteas-one', NULL, 90, NULL, '2025-09-02 12:41:26', '2025-07-25 10:13:19'),
(36, 'gamma Nuos murale o a basamento', 1, 8, 'nuos-murale-o-a-basamento', NULL, 100, NULL, '2025-09-02 12:41:39', '2025-07-25 10:13:51'),
(37, 'gamma Pompe di calore o sistemi ibridi', 1, 8, 'pompe-di-calore-o-sistemi-ibridi', NULL, 200, NULL, '2025-09-02 12:41:49', '2025-07-25 10:14:05'),
(38, 'Inoa S o Inoa Green', 2, 9, 'gamma-inoa-s-e-inoa-green', NULL, 40, NULL, '2025-09-10 17:04:56', '2025-09-10 12:06:55'),
(39, 'Pigma Advance', 2, 9, 'gamma-pigma-advance', NULL, 65, NULL, '2025-09-10 17:04:13', '2025-09-10 12:09:06'),
(40, 'Mira Advance o Urbia Advance o Niagara Advance o Talia Green ', 2, 9, 'gamma-mira-advance-urbia-advance-talia-green-niagara-advance', NULL, 90, NULL, '2025-09-12 11:13:52', '2025-09-10 12:10:09'),
(41, 'Aquanext murale/basamento', 2, 9, 'scaldacqua-gamma-aquanext-murale-basamento', NULL, 100, NULL, '2025-09-10 17:04:33', '2025-09-10 12:10:30'),
(42, 'Pompe di calore riscaldamento o sistemi ibridi', 2, 9, 'pompe-di-calore-riscaldamento-sistemi-ibridi', NULL, 200, NULL, '2025-09-10 12:10:47', '2025-09-10 12:10:47');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;