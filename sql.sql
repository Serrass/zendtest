CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `image` varchar(60) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=1 ;

INSERT INTO `products` (`name`, `image`, `price`)
VALUES
('Product One', 'media/1.png', '101'),
('Product Two', 'media/1.png', '102'),
('Product Tree', 'media/1.png', '103'),
('Product Four', 'media/1.png', '104'),
('Product Five', 'media/1.png', '105'),
('Product Six', 'media/1.png', '106'),
('Product Seven', 'media/1.png', '107'),
('Product Eight', 'media1.png', '101'),
('Product Nine', 'media/1.png', '102'),
('Product Ten', 'media/1.png', '103'),
('Product Eleven', 'media/1.png', '104'),
('Product Twelve', 'media/1.png', '105'),
('Product Thirteen', 'media/1.png', '106'),
('Product Fourteen', 'media/1.png', '107'),
('Product Fifteen', 'media/1.png', '101'),
('Product Sixteen', 'media/1.png', '102'),
('Product Seventeen', 'media/1.png', '103'),
('Product Eighteen', 'media/1.png', '104'),
('Product Nineteen', 'media/1.png', '105'),
('Product Twenty', 'media/2.png', '106')
;