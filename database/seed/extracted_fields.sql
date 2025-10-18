create table extracted_fields
(
    document_id        bigint unsigned not null,
    id                 int unsigned auto_increment
        primary key,
    document_detail_id bigint unsigned not null,
    value              varchar(255)    not null,
    created_at         timestamp       null,
    updated_at         timestamp       null
)
    collate = utf8mb4_unicode_ci;

create fulltext index extracted_fields_value_fulltext
    on extracted_fields (value);

INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (1, 1, 1, '123123', '2025-08-02 12:07:48', '2025-08-02 12:07:48');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (24, 2, 3, 'Document Schema', '2025-08-02 19:31:12', '2025-08-02 19:31:12');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (27, 3, 3, 'This is a transport document dated 30/06/2025 regarding thermosanitary products.', '2025-08-02 19:42:09', '2025-08-02 19:42:09');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (27, 4, 2, 'transport document', '2025-08-02 19:42:09', '2025-08-02 19:42:09');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (27, 5, 4, '30/06/2025', '2025-08-02 19:42:09', '2025-08-02 19:42:09');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (28, 6, 3, 'This is a payment notice for a university enrollment fee, with an amount due of 140 Euros by 21/10/2024.', '2025-08-02 19:46:59', '2025-08-02 19:46:59');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (28, 7, 2, 'payment notice', '2025-08-02 19:46:59', '2025-08-02 19:46:59');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (28, 8, 4, '21/10/2024', '2025-08-02 19:46:59', '2025-08-02 19:46:59');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (29, 9, 3, 'Transport document from AGGLITTA S.R.L. to LENTINI TECNO IMPIANTI, including thermosanitary items like boilers. Date: 30/06/2025.', '2025-08-02 19:55:18', '2025-08-02 19:55:18');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (29, 10, 2, 'transport document', '2025-08-02 19:55:18', '2025-08-02 19:55:18');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (29, 11, 4, '30/06/2025', '2025-08-02 19:55:18', '2025-08-02 19:55:18');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (30, 12, 3, 'Payment notice for university enrollment fee.', '2025-08-02 19:57:15', '2025-08-02 19:57:15');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (32, 13, 3, 'Documento di trasporto per articoli termoidraulici da Agoglitta a Lentini Tecno Impianti.', '2025-08-02 20:01:03', '2025-08-02 20:01:03');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (32, 14, 2, 'Documento di Trasporto', '2025-08-02 20:01:03', '2025-08-02 20:01:03');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (32, 15, 4, '30/06/2025', '2025-08-02 20:01:03', '2025-08-02 20:01:03');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (33, 16, 3, 'Transport document for thermosanitary products with details like goods, prices, and VAT.', '2025-08-02 20:03:57', '2025-08-02 20:03:57');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (35, 17, 2, 'transport document', '2025-08-02 20:05:30', '2025-08-02 20:05:30');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (35, 18, 3, 'Transport document from Agoglitta to Lentini Tecno Impianti, including purchase details of thermosanitary products.', '2025-08-02 20:05:30', '2025-08-02 20:05:30');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (35, 19, 4, '30/06/2025', '2025-08-02 20:05:30', '2025-08-02 20:05:30');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (46, 20, 2, 'invoice', '2025-08-24 18:48:22', '2025-08-24 18:48:22');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (46, 21, 3, 'Invoice from Stripe Payments Europe, Limited to IL GUARDIANO DEL CHIARO SAS.', '2025-08-24 18:48:22', '2025-08-24 18:48:22');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (46, 22, 4, 'Aug 1, 2025', '2025-08-24 18:48:22', '2025-08-24 18:48:22');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (47, 23, 2, 'invoice', '2025-08-24 20:46:13', '2025-08-24 20:46:13');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (47, 24, 3, 'An invoice document from AGOGLITTA S.R.L. detailing the sale and transport of heating equipment to LENTINI TECNO IMPIANTI.', '2025-08-24 20:46:13', '2025-08-24 20:46:13');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (47, 25, 4, '30/06/2025', '2025-08-24 20:46:13', '2025-08-24 20:46:13');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (58, 26, 2, 'transport document', '2025-09-21 11:57:39', '2025-09-21 11:57:39');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (58, 27, 3, 'Italian transport document for Ariston heating equipment.', '2025-09-21 11:57:39', '2025-09-21 11:57:39');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (58, 28, 4, '30/06/2025', '2025-09-21 11:57:39', '2025-09-21 11:57:39');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (59, 29, 2, 'fattura', '2025-09-21 11:59:33', '2025-09-21 11:59:33');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (59, 30, 3, 'Questa fattura riguarda l\'acquisto di componenti elettroniche con data di emissione 10 gennaio 2023.', '2025-09-21 11:59:33', '2025-09-21 11:59:33');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (59, 31, 4, '10/01/2023', '2025-09-21 11:59:33', '2025-09-21 11:59:33');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (60, 32, 2, 'invoice', '2025-09-21 12:09:02', '2025-09-21 12:09:02');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (60, 33, 3, 'Invoice detailing the purchase of electronic goods from XYZ suppliers.', '2025-09-21 12:09:02', '2025-09-21 12:09:02');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (60, 34, 4, '15-09-2023', '2025-09-21 12:09:02', '2025-09-21 12:09:02');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (61, 35, 2, 'legal document', '2025-09-21 12:13:31', '2025-09-21 12:13:31');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (61, 36, 3, 'Invoice details from Agoglitto\'s transport document', '2025-09-21 12:13:31', '2025-09-21 12:13:31');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (61, 37, 4, '30/06/2025', '2025-09-21 12:13:31', '2025-09-21 12:13:31');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (62, 38, 2, 'Invoice', '2025-09-21 12:14:33', '2025-09-21 12:14:33');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (62, 39, 3, 'This document details a bill for goods/services rendered, listing individual charges and total amount due.', '2025-09-21 12:14:33', '2025-09-21 12:14:33');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (62, 40, 4, '15/09/2023', '2025-09-21 12:14:33', '2025-09-21 12:14:33');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (63, 41, 2, 'Transport Document', '2025-09-21 12:17:05', '2025-09-21 12:17:05');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (63, 42, 3, 'Italian invoice details including product codes, descriptions, and amounts', '2025-09-21 12:17:05', '2025-09-21 12:17:05');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (63, 43, 4, '30/06/2025', '2025-09-21 12:17:05', '2025-09-21 12:17:05');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (64, 44, 2, 'Fattura (Invoice)', '2025-09-21 12:18:58', '2025-09-21 12:18:58');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (64, 45, 3, 'Fornitura di beni generali per il mese di settembre', '2025-09-21 12:18:58', '2025-09-21 12:18:58');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (64, 46, 4, '2023-09-29', '2025-09-21 12:18:58', '2025-09-21 12:18:58');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (65, 47, 2, 'invoice', '2025-09-21 12:19:56', '2025-09-21 12:19:56');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (65, 48, 3, 'An invoice from Agoglitta S.R.L. for heating systems.', '2025-09-21 12:19:56', '2025-09-21 12:19:56');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (65, 49, 4, '30/06/2025', '2025-09-21 12:19:56', '2025-09-21 12:19:56');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (66, 50, 2, 'Fattura', '2025-09-21 17:19:54', '2025-09-21 17:19:54');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (66, 51, 3, 'Fattura per acquisto beni emessa il 03/11/2023.', '2025-09-21 17:19:54', '2025-09-21 17:19:54');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (66, 52, 4, '03/11/2023', '2025-09-21 17:19:54', '2025-09-21 17:19:54');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 53, 7, 'FAT-2023-0001', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 54, 8, '15 ottobre 2023', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 55, 9, 'Fornitori Elettronici S.p.A.', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 56, 10, 'IT01234567890', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 57, 11, 'Rivenditori Tech S.r.l.', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 58, 12, 'IT98765432101', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 59, 13, '€2,500.00', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 60, 14, '€500.00', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (69, 61, 15, '10', '2025-09-25 18:11:49', '2025-09-25 18:11:49');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 62, 7, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 63, 8, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 64, 9, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 65, 10, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 66, 11, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 67, 12, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 68, 13, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 69, 14, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (70, 70, 15, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 71, 7, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 72, 8, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 73, 9, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 74, 10, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 75, 11, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 76, 12, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 77, 13, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 78, 14, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (71, 79, 15, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (73, 80, 7, '3545', '2025-09-25 18:33:23', '2025-09-25 18:33:23');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (73, 81, 8, '2025-06-30', '2025-09-25 18:33:23', '2025-09-25 18:33:23');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (73, 82, 9, 'AGOGLITTA S.R.L. Unipersonale', '2025-09-25 18:33:23', '2025-09-25 18:33:23');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 83, 7, 'F123456789', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 84, 8, '15/09/2023', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 85, 9, 'Azienda S.r.l.', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 86, 10, '12345678901', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 87, 11, 'Cliente S.p.A.', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 88, 12, '98765432109', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 89, 13, '€1.000,00', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 90, 14, '€220,00', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (75, 91, 15, '10', '2025-10-17 11:33:07', '2025-10-17 11:33:07');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 92, 44, 'EXPLORA S.P.A.', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 93, 45, '', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 94, 46, '31-12-2020', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 95, 47, '4.795.936', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 96, 48, '', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 97, 49, '47.291', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 98, 50, '47.291', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 99, 51, '----', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
INSERT INTO laravel.extracted_fields (document_id, id, document_detail_id, value, created_at, updated_at) VALUES (76, 100, 52, '----', '2025-10-17 11:36:11', '2025-10-17 11:36:11');
