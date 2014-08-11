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
('Product Two', 'media/2.png', '102'),
('Product Tree', 'media/3.png', '103'),
('Product Four', 'media/4.png', '104'),
('Product Five', 'media/5.png', '105'),
('Product Six', 'media/6.png', '106'),
('Product Seven', 'media/7.png', '107'),
('Product Eight', 'media8.png', '101'),
('Product Nine', 'media/9.png', '102'),
('Product Ten', 'media/10.png', '103'),
('Product Eleven', 'media/11.png', '104'),
('Product Twelve', 'media/12.png', '105'),
('Product Thirteen', 'media/13.png', '106'),
('Product Fourteen', 'media/14.png', '107'),
('Product Fifteen', 'media/15.png', '101'),
('Product Sixteen', 'media/16.png', '102'),
('Product Seventeen', 'media/17.png', '103'),
('Product Eighteen', 'media/18.png', '104'),
('Product Nineteen', 'media/19.png', '105'),
('Product Twenty', 'media/20.png', '106')
;