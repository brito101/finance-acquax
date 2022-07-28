--
-- 06JUN2022
--
ALTER TABLE
  app_invoices
ADD
  COLUMN category varchar(255);

UPDATE
  app_invoices
SET
  category = 'Atualizar';

ALTER TABLE
  `app_wallets` CHANGE `user_id` `user_id` INT(11) UNSIGNED NULL;

ALTER TABLE
  `app_invoices` CHANGE `category_id` `category_id` INT(11) UNSIGNED NULL;

--
-- 13JUN2022
--
CREATE TABLE `purchase_order` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp(),
  `amount` decimal(10, 2) NOT NULL,
  `material` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `value` decimal(10, 2) NOT NULL,
  `requester` varchar(255) DEFAULT NULL,
  `forecast` timestamp NULL,
  `authorized` varchar(255) DEFAULT NULL,
  `authorized_date` timestamp NULL,
  `freight` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

ALTER TABLE
  `purchase_order`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `purchase_order_user` (`user_id`);

ALTER TABLE
  `purchase_order`
MODIFY
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE
  `purchase_order`
ADD
  CONSTRAINT `purchase_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 15JUN2022
-- 
ALTER TABLE
  `app_invoices`
ADD
  COLUMN `purchase_mode` varchar(255) DEFAULT NULL;

--
--16JUN
--
ALTER TABLE
  `purchase_order`
ADD
  COLUMN `provider` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `invoice` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_1` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_2` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_3` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_4` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_5` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_6` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_7` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_8` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_9` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_10` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_11` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_12` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_13` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_14` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_15` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_16` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_17` varchar(255) DEFAULT NULL,
ADD
  COLUMN `material_18` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_19` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_20` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_21` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_22` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_23` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_24` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_25` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_26` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_27` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_28` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_29` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_30` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_31` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_32` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_33` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_34` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_36` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_35` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_37` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_38` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_39` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_40` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_41` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_42` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_43` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_44` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_45` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_46` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_47` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_48` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_49` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `material_50` varchar(255) DEFAULT NULL;

ALTER TABLE
  `purchase_order`
ADD
  COLUMN `serie` varchar(255) DEFAULT NULL;

ALTER TABLE
  app_invoices
ADD
  COLUMN annotation varchar(255);