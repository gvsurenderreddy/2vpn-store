<?php

$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('vouchers')};
CREATE TABLE {$this->getTable('vouchers')} (
  `voucher_id` int(11) unsigned NOT NULL auto_increment,
  `amount` FLOAT DEFAULT '0.0',
  `description` varchar(500) NOT NULL default '',
  `dateFrom` DATE,
  `dateTo` DATE,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`voucher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('storelocator_vouchers')};
CREATE TABLE {$this->getTable('storelocator_vouchers')} (
  `store_id` int(11) unsigned,
  `voucher_id` int(11) unsigned,
  `created_time` datetime NULL,
  `update_time` datetime NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");
$installer->endSetup();

?>