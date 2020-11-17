update `qb_shop_field` set `field_type`='text NOT NULL',`type`='shop_array',about='库存为0,将不能购买,售出,库存会自动减少,一般留空' WHERE name ='type1';

ALTER TABLE  `qb_shop_content1` CHANGE  `type1`  `type1` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '商品属性1';
