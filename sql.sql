DROP TABLE IF EXISTS `users`;
CREATE TABLE `products`
(`product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
`image` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
`price` decimal(10,2) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`product_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `products` (`name`, `image`, `price`)
VALUES
('Product One',       '1.jpg', '101'),
('Product Two',       '1.jpg', '102'),
('Product Tree',      '1.jpg', '103'),
('Product Four',      '1.jpg', '104'),
('Product Five',      '1.jpg', '105'),
('Product Six',       '1.jpg', '106'),
('Product Seven',     '1.jpg', '107'),
('Product Eight',     '1.jpg', '101'),
('Product Nine',      '1.jpg', '102'),
('Product Ten',       '1.jpg', '103'),
('Product Eleven',    '1.jpg', '104'),
('Product Twelve',    '1.jpg', '105'),
('Product Thirteen',  '1.jpg', '106'),
('Product Fourteen',  '1.jpg', '107'),
('Product Fifteen',   '1.jpg', '101'),
('Product Sixteen',   '1.jpg', '102'),
('Product Seventeen', '1.jpg', '103'),
('Product Eighteen',  '1.jpg', '104'),
('Product Nineteen',  '1.jpg', '105'),
('Product Twenty',    '1.jpg', '106')
;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(`user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`password` char(32) COLLATE utf8_unicode_ci NOT NULL,
`first_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`last_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`gender` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
`about` text COLLATE utf8_unicode_ci NOT NULL,
`creation_date` datetime COLLATE utf8_unicode_ci NOT NULL,

PRIMARY KEY (`user_id`),
UNIQUE KEY `EMAIL` (`email`),
UNIQUE KEY `USERNAME` (`username`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
