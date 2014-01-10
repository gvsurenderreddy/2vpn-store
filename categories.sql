-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 10 Janvier 2014 à 14:11
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `magento`
--
CREATE DATABASE IF NOT EXISTS `magento` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `magento`;

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_anc_categs_index_idx`
--

DROP TABLE IF EXISTS `catalog_category_anc_categs_index_idx`;
CREATE TABLE IF NOT EXISTS `catalog_category_anc_categs_index_idx` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `path` varchar(255) DEFAULT NULL COMMENT 'Path',
  KEY `IDX_CATALOG_CATEGORY_ANC_CATEGS_INDEX_IDX_CATEGORY_ID` (`category_id`),
  KEY `IDX_CATALOG_CATEGORY_ANC_CATEGS_INDEX_IDX_PATH_CATEGORY_ID` (`path`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Category Anchor Indexer Index Table';

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_anc_categs_index_tmp`
--

DROP TABLE IF EXISTS `catalog_category_anc_categs_index_tmp`;
CREATE TABLE IF NOT EXISTS `catalog_category_anc_categs_index_tmp` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `path` varchar(255) DEFAULT NULL COMMENT 'Path',
  KEY `IDX_CATALOG_CATEGORY_ANC_CATEGS_INDEX_TMP_CATEGORY_ID` (`category_id`),
  KEY `IDX_CATALOG_CATEGORY_ANC_CATEGS_INDEX_TMP_PATH_CATEGORY_ID` (`path`,`category_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='Catalog Category Anchor Indexer Temp Table';

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_anc_products_index_idx`
--

DROP TABLE IF EXISTS `catalog_category_anc_products_index_idx`;
CREATE TABLE IF NOT EXISTS `catalog_category_anc_products_index_idx` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `position` int(10) unsigned DEFAULT NULL COMMENT 'Position',
  KEY `IDX_CAT_CTGR_ANC_PRDS_IDX_IDX_CTGR_ID_PRD_ID_POSITION` (`category_id`,`product_id`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Category Anchor Product Indexer Index Table';

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_anc_products_index_tmp`
--

DROP TABLE IF EXISTS `catalog_category_anc_products_index_tmp`;
CREATE TABLE IF NOT EXISTS `catalog_category_anc_products_index_tmp` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `position` int(10) unsigned DEFAULT NULL COMMENT 'Position',
  KEY `IDX_CAT_CTGR_ANC_PRDS_IDX_TMP_CTGR_ID_PRD_ID_POSITION` (`category_id`,`product_id`,`position`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='Catalog Category Anchor Product Indexer Temp Table';

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_entity`
--

DROP TABLE IF EXISTS `catalog_category_entity`;
CREATE TABLE IF NOT EXISTS `catalog_category_entity` (
  `entity_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Entity ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_set_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attriute Set ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Parent Category ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Creation Time',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Update Time',
  `path` varchar(255) NOT NULL COMMENT 'Tree Path',
  `position` int(11) NOT NULL COMMENT 'Position',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT 'Tree Level',
  `children_count` int(11) NOT NULL COMMENT 'Child Count',
  PRIMARY KEY (`entity_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_LEVEL` (`level`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_PATH_ENTITY_ID` (`path`,`entity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Category Table' AUTO_INCREMENT=16 ;

--
-- Contenu de la table `catalog_category_entity`
--

INSERT INTO `catalog_category_entity` (`entity_id`, `entity_type_id`, `attribute_set_id`, `parent_id`, `created_at`, `updated_at`, `path`, `position`, `level`, `children_count`) VALUES
(1, 3, 0, 0, '2013-12-13 12:33:46', '2013-12-13 12:33:46', '1', 0, 0, 14),
(2, 3, 3, 1, '2013-12-13 12:33:46', '2013-12-13 12:33:46', '1/2', 1, 1, 13),
(3, 3, 3, 2, '2013-12-20 13:47:39', '2013-12-20 14:41:29', '1/2/3', 2, 2, 5),
(4, 3, 3, 3, '2013-12-20 13:53:46', '2013-12-20 13:53:46', '1/2/3/4', 1, 3, 0),
(5, 3, 3, 2, '2013-12-20 13:55:05', '2013-12-20 13:55:05', '1/2/5', 1, 2, 5),
(6, 3, 3, 5, '2013-12-20 13:55:32', '2013-12-20 13:55:32', '1/2/5/6', 1, 3, 0),
(7, 3, 3, 5, '2013-12-20 15:13:36', '2013-12-20 15:13:36', '1/2/5/7', 4, 3, 0),
(8, 3, 3, 5, '2013-12-21 20:11:58', '2013-12-21 20:53:40', '1/2/5/8', 3, 3, 0),
(9, 3, 3, 5, '2013-12-21 20:12:21', '2013-12-21 20:12:21', '1/2/5/9', 2, 3, 0),
(10, 3, 3, 5, '2013-12-21 20:13:04', '2013-12-21 20:53:49', '1/2/5/10', 5, 3, 0),
(11, 3, 3, 3, '2013-12-21 20:14:14', '2013-12-21 20:14:33', '1/2/3/11', 2, 3, 0),
(12, 3, 3, 3, '2013-12-21 20:14:58', '2013-12-21 20:14:58', '1/2/3/12', 4, 3, 0),
(13, 3, 3, 3, '2013-12-21 20:16:41', '2013-12-21 20:16:51', '1/2/3/13', 3, 3, 0),
(14, 3, 3, 3, '2013-12-21 20:17:17', '2013-12-21 20:17:17', '1/2/3/14', 5, 3, 0),
(15, 3, 3, 2, '2013-12-21 20:17:55', '2013-12-21 20:17:55', '1/2/15', 3, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_entity_datetime`
--

DROP TABLE IF EXISTS `catalog_category_entity_datetime`;
CREATE TABLE IF NOT EXISTS `catalog_category_entity_datetime` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute ID',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity ID',
  `value` datetime DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `UNQ_CAT_CTGR_ENTT_DTIME_ENTT_TYPE_ID_ENTT_ID_ATTR_ID_STORE_ID` (`entity_type_id`,`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_DATETIME_ENTITY_ID` (`entity_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_DATETIME_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_DATETIME_STORE_ID` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Category Datetime Attribute Backend Table' AUTO_INCREMENT=37 ;

--
-- Contenu de la table `catalog_category_entity_datetime`
--

INSERT INTO `catalog_category_entity_datetime` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(1, 3, 59, 0, 3, NULL),
(2, 3, 60, 0, 3, NULL),
(5, 3, 59, 0, 4, NULL),
(6, 3, 60, 0, 4, NULL),
(7, 3, 59, 0, 5, NULL),
(8, 3, 60, 0, 5, NULL),
(9, 3, 59, 0, 6, NULL),
(10, 3, 60, 0, 6, NULL),
(13, 3, 59, 0, 7, NULL),
(14, 3, 60, 0, 7, NULL),
(15, 3, 59, 0, 8, NULL),
(16, 3, 60, 0, 8, NULL),
(17, 3, 59, 0, 9, NULL),
(18, 3, 60, 0, 9, NULL),
(19, 3, 59, 0, 10, NULL),
(20, 3, 60, 0, 10, NULL),
(21, 3, 59, 0, 11, NULL),
(22, 3, 60, 0, 11, NULL),
(27, 3, 59, 0, 12, NULL),
(28, 3, 60, 0, 12, NULL),
(29, 3, 59, 0, 13, NULL),
(30, 3, 60, 0, 13, NULL),
(33, 3, 59, 0, 14, NULL),
(34, 3, 60, 0, 14, NULL),
(35, 3, 59, 0, 15, NULL),
(36, 3, 60, 0, 15, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_entity_decimal`
--

DROP TABLE IF EXISTS `catalog_category_entity_decimal`;
CREATE TABLE IF NOT EXISTS `catalog_category_entity_decimal` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute ID',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity ID',
  `value` decimal(12,4) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `UNQ_CAT_CTGR_ENTT_DEC_ENTT_TYPE_ID_ENTT_ID_ATTR_ID_STORE_ID` (`entity_type_id`,`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_DECIMAL_ENTITY_ID` (`entity_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_DECIMAL_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_DECIMAL_STORE_ID` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Category Decimal Attribute Backend Table' AUTO_INCREMENT=14 ;

--
-- Contenu de la table `catalog_category_entity_decimal`
--

INSERT INTO `catalog_category_entity_decimal` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(1, 3, 70, 0, 3, NULL),
(2, 3, 70, 0, 4, NULL),
(3, 3, 70, 0, 5, NULL),
(4, 3, 70, 0, 6, NULL),
(5, 3, 70, 0, 7, NULL),
(6, 3, 70, 0, 8, NULL),
(7, 3, 70, 0, 9, NULL),
(8, 3, 70, 0, 10, NULL),
(9, 3, 70, 0, 11, NULL),
(10, 3, 70, 0, 12, NULL),
(11, 3, 70, 0, 13, NULL),
(12, 3, 70, 0, 14, NULL),
(13, 3, 70, 0, 15, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_entity_int`
--

DROP TABLE IF EXISTS `catalog_category_entity_int`;
CREATE TABLE IF NOT EXISTS `catalog_category_entity_int` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute ID',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity ID',
  `value` int(11) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `UNQ_CAT_CTGR_ENTT_INT_ENTT_TYPE_ID_ENTT_ID_ATTR_ID_STORE_ID` (`entity_type_id`,`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_INT_ENTITY_ID` (`entity_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_INT_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_INT_STORE_ID` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Category Integer Attribute Backend Table' AUTO_INCREMENT=93 ;

--
-- Contenu de la table `catalog_category_entity_int`
--

INSERT INTO `catalog_category_entity_int` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(1, 3, 67, 0, 1, 1),
(2, 3, 67, 1, 1, 1),
(3, 3, 42, 0, 2, 1),
(4, 3, 67, 0, 2, 1),
(5, 3, 42, 1, 2, 1),
(6, 3, 67, 1, 2, 1),
(7, 3, 42, 0, 3, 1),
(8, 3, 67, 0, 3, 1),
(9, 3, 50, 0, 3, NULL),
(10, 3, 51, 0, 3, 0),
(11, 3, 68, 0, 3, 0),
(12, 3, 69, 0, 3, 0),
(14, 3, 42, 0, 4, 1),
(15, 3, 67, 0, 4, 1),
(16, 3, 50, 0, 4, NULL),
(17, 3, 51, 0, 4, 0),
(18, 3, 68, 0, 4, 0),
(19, 3, 69, 0, 4, 0),
(20, 3, 42, 0, 5, 1),
(21, 3, 67, 0, 5, 1),
(22, 3, 50, 0, 5, NULL),
(23, 3, 51, 0, 5, 0),
(24, 3, 68, 0, 5, 0),
(25, 3, 69, 0, 5, 0),
(26, 3, 42, 0, 6, 1),
(27, 3, 67, 0, 6, 1),
(28, 3, 50, 0, 6, NULL),
(29, 3, 51, 0, 6, 0),
(30, 3, 68, 0, 6, 0),
(31, 3, 69, 0, 6, 0),
(33, 3, 42, 0, 7, 1),
(34, 3, 67, 0, 7, 1),
(35, 3, 50, 0, 7, NULL),
(36, 3, 51, 0, 7, 0),
(37, 3, 68, 0, 7, 0),
(38, 3, 69, 0, 7, 0),
(39, 3, 42, 0, 8, 1),
(40, 3, 67, 0, 8, 1),
(41, 3, 50, 0, 8, NULL),
(42, 3, 51, 0, 8, 0),
(43, 3, 68, 0, 8, 0),
(44, 3, 69, 0, 8, 0),
(45, 3, 42, 0, 9, 1),
(46, 3, 67, 0, 9, 1),
(47, 3, 50, 0, 9, NULL),
(48, 3, 51, 0, 9, 0),
(49, 3, 68, 0, 9, 0),
(50, 3, 69, 0, 9, 0),
(51, 3, 42, 0, 10, 1),
(52, 3, 67, 0, 10, 1),
(53, 3, 50, 0, 10, NULL),
(54, 3, 51, 0, 10, 0),
(55, 3, 68, 0, 10, 0),
(56, 3, 69, 0, 10, 0),
(57, 3, 42, 0, 11, 1),
(58, 3, 67, 0, 11, 1),
(59, 3, 50, 0, 11, NULL),
(60, 3, 51, 0, 11, 0),
(61, 3, 68, 0, 11, 0),
(62, 3, 69, 0, 11, 0),
(67, 3, 42, 0, 12, 1),
(68, 3, 67, 0, 12, 1),
(69, 3, 50, 0, 12, NULL),
(70, 3, 51, 0, 12, 0),
(71, 3, 68, 0, 12, 0),
(72, 3, 69, 0, 12, 0),
(73, 3, 42, 0, 13, 1),
(74, 3, 67, 0, 13, 1),
(75, 3, 50, 0, 13, NULL),
(76, 3, 51, 0, 13, 0),
(77, 3, 68, 0, 13, 0),
(78, 3, 69, 0, 13, 0),
(81, 3, 42, 0, 14, 1),
(82, 3, 67, 0, 14, 1),
(83, 3, 50, 0, 14, NULL),
(84, 3, 51, 0, 14, 0),
(85, 3, 68, 0, 14, 0),
(86, 3, 69, 0, 14, 0),
(87, 3, 42, 0, 15, 1),
(88, 3, 67, 0, 15, 1),
(89, 3, 50, 0, 15, NULL),
(90, 3, 51, 0, 15, 0),
(91, 3, 68, 0, 15, 0),
(92, 3, 69, 0, 15, 0);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_entity_text`
--

DROP TABLE IF EXISTS `catalog_category_entity_text`;
CREATE TABLE IF NOT EXISTS `catalog_category_entity_text` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute ID',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity ID',
  `value` text COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `UNQ_CAT_CTGR_ENTT_TEXT_ENTT_TYPE_ID_ENTT_ID_ATTR_ID_STORE_ID` (`entity_type_id`,`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_TEXT_ENTITY_ID` (`entity_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_TEXT_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_TEXT_STORE_ID` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Category Text Attribute Backend Table' AUTO_INCREMENT=93 ;

--
-- Contenu de la table `catalog_category_entity_text`
--

INSERT INTO `catalog_category_entity_text` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(1, 3, 65, 0, 1, NULL),
(2, 3, 65, 1, 1, NULL),
(3, 3, 65, 0, 2, NULL),
(4, 3, 65, 1, 2, NULL),
(5, 3, 44, 0, 3, 'Profitez d''un moment de détente dans l''eau chaude'),
(6, 3, 47, 0, 3, NULL),
(7, 3, 48, 0, 3, NULL),
(8, 3, 62, 0, 3, NULL),
(9, 3, 65, 0, 3, NULL),
(14, 3, 44, 0, 4, 'Des milliers de bulles pour un bain amusant'),
(15, 3, 47, 0, 4, NULL),
(16, 3, 48, 0, 4, NULL),
(17, 3, 62, 0, 4, NULL),
(18, 3, 65, 0, 4, NULL),
(19, 3, 44, 0, 5, 'Plongez vous dans des odeurs qui vous apaiseront'),
(20, 3, 47, 0, 5, NULL),
(21, 3, 48, 0, 5, NULL),
(22, 3, 62, 0, 5, NULL),
(23, 3, 65, 0, 5, NULL),
(24, 3, 44, 0, 6, NULL),
(25, 3, 47, 0, 6, NULL),
(26, 3, 48, 0, 6, NULL),
(27, 3, 62, 0, 6, NULL),
(28, 3, 65, 0, 6, NULL),
(33, 3, 44, 0, 7, NULL),
(34, 3, 47, 0, 7, NULL),
(35, 3, 48, 0, 7, NULL),
(36, 3, 62, 0, 7, NULL),
(37, 3, 65, 0, 7, NULL),
(38, 3, 44, 0, 8, NULL),
(39, 3, 47, 0, 8, NULL),
(40, 3, 48, 0, 8, NULL),
(41, 3, 62, 0, 8, NULL),
(42, 3, 65, 0, 8, NULL),
(43, 3, 44, 0, 9, NULL),
(44, 3, 47, 0, 9, NULL),
(45, 3, 48, 0, 9, NULL),
(46, 3, 62, 0, 9, NULL),
(47, 3, 65, 0, 9, NULL),
(48, 3, 44, 0, 10, NULL),
(49, 3, 47, 0, 10, NULL),
(50, 3, 48, 0, 10, NULL),
(51, 3, 62, 0, 10, NULL),
(52, 3, 65, 0, 10, NULL),
(53, 3, 44, 0, 11, NULL),
(54, 3, 47, 0, 11, NULL),
(55, 3, 48, 0, 11, NULL),
(56, 3, 62, 0, 11, NULL),
(57, 3, 65, 0, 11, NULL),
(68, 3, 44, 0, 12, NULL),
(69, 3, 47, 0, 12, NULL),
(70, 3, 48, 0, 12, NULL),
(71, 3, 62, 0, 12, NULL),
(72, 3, 65, 0, 12, NULL),
(73, 3, 44, 0, 13, NULL),
(74, 3, 47, 0, 13, NULL),
(75, 3, 48, 0, 13, NULL),
(76, 3, 62, 0, 13, NULL),
(77, 3, 65, 0, 13, NULL),
(83, 3, 44, 0, 14, NULL),
(84, 3, 47, 0, 14, NULL),
(85, 3, 48, 0, 14, NULL),
(86, 3, 62, 0, 14, NULL),
(87, 3, 65, 0, 14, NULL),
(88, 3, 44, 0, 15, NULL),
(89, 3, 47, 0, 15, NULL),
(90, 3, 48, 0, 15, NULL),
(91, 3, 62, 0, 15, NULL),
(92, 3, 65, 0, 15, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_entity_varchar`
--

DROP TABLE IF EXISTS `catalog_category_entity_varchar`;
CREATE TABLE IF NOT EXISTS `catalog_category_entity_varchar` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value ID',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type ID',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute ID',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity ID',
  `value` varchar(255) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `UNQ_CAT_CTGR_ENTT_VCHR_ENTT_TYPE_ID_ENTT_ID_ATTR_ID_STORE_ID` (`entity_type_id`,`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_VARCHAR_ENTITY_ID` (`entity_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_VARCHAR_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_CATALOG_CATEGORY_ENTITY_VARCHAR_STORE_ID` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Catalog Category Varchar Attribute Backend Table' AUTO_INCREMENT=127 ;

--
-- Contenu de la table `catalog_category_entity_varchar`
--

INSERT INTO `catalog_category_entity_varchar` (`value_id`, `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`) VALUES
(1, 3, 41, 0, 1, 'Root Catalog'),
(2, 3, 41, 1, 1, 'Root Catalog'),
(3, 3, 43, 1, 1, 'root-catalog'),
(4, 3, 41, 0, 2, 'Default Category'),
(5, 3, 41, 1, 2, 'Default Category'),
(6, 3, 49, 1, 2, 'PRODUCTS'),
(7, 3, 43, 1, 2, 'default-category'),
(8, 3, 41, 0, 3, 'Tout pour un bain relaxant'),
(9, 3, 46, 0, 3, NULL),
(10, 3, 49, 0, 3, 'PRODUCTS'),
(11, 3, 58, 0, 3, NULL),
(12, 3, 61, 0, 3, NULL),
(13, 3, 43, 0, 3, 'tout-pour-un-bain-relaxant'),
(17, 3, 41, 0, 4, 'Bains moussants'),
(18, 3, 43, 0, 4, 'bains-moussants'),
(19, 3, 46, 0, 4, NULL),
(20, 3, 49, 0, 4, 'PRODUCTS'),
(21, 3, 58, 0, 4, NULL),
(22, 3, 61, 0, 4, NULL),
(23, 3, 41, 0, 5, 'Des senteurs qui enivrent'),
(24, 3, 46, 0, 5, NULL),
(25, 3, 49, 0, 5, 'PRODUCTS'),
(26, 3, 58, 0, 5, NULL),
(27, 3, 61, 0, 5, NULL),
(28, 3, 43, 0, 5, 'des-senteurs-qui-enivrent'),
(29, 3, 41, 0, 6, 'Diffuseurs d''huiles essentielles'),
(30, 3, 43, 0, 6, 'diffuseurs-d-huiles-essentielles'),
(31, 3, 46, 0, 6, NULL),
(32, 3, 49, 0, 6, 'PRODUCTS'),
(33, 3, 58, 0, 6, NULL),
(34, 3, 61, 0, 6, NULL),
(35, 3, 57, 1, 5, 'des-senteurs-qui-enivrent.html'),
(36, 3, 57, 0, 5, 'des-senteurs-qui-enivrent.html'),
(37, 3, 57, 1, 6, 'des-senteurs-qui-enivrent/diffuseurs-d-huiles-essentielles.html'),
(38, 3, 57, 0, 6, 'des-senteurs-qui-enivrent/diffuseurs-d-huiles-essentielles.html'),
(39, 3, 57, 1, 3, 'tout-pour-un-bain-relaxant.html'),
(40, 3, 57, 0, 3, 'tout-pour-un-bain-relaxant.html'),
(41, 3, 57, 1, 4, 'tout-pour-un-bain-relaxant/bains-moussants.html'),
(42, 3, 57, 0, 4, 'tout-pour-un-bain-relaxant/bains-moussants.html'),
(46, 3, 41, 0, 7, 'Huiles essentielles'),
(47, 3, 43, 0, 7, 'huiles-essentielles'),
(48, 3, 46, 0, 7, NULL),
(49, 3, 49, 0, 7, 'PRODUCTS'),
(50, 3, 58, 0, 7, NULL),
(51, 3, 61, 0, 7, NULL),
(52, 3, 57, 1, 7, 'des-senteurs-qui-enivrent/huiles-essentielles.html'),
(53, 3, 57, 0, 7, 'des-senteurs-qui-enivrent/huiles-essentielles.html'),
(54, 3, 41, 0, 8, 'Bougies parfumées'),
(55, 3, 43, 0, 8, 'bougies-parfumees'),
(56, 3, 46, 0, 8, NULL),
(57, 3, 49, 0, 8, 'PRODUCTS'),
(58, 3, 58, 0, 8, NULL),
(59, 3, 61, 0, 8, NULL),
(60, 3, 57, 1, 8, 'des-senteurs-qui-enivrent/bougies-parfumees.html'),
(61, 3, 57, 0, 8, 'des-senteurs-qui-enivrent/bougies-parfumees.html'),
(62, 3, 41, 0, 9, 'Encens'),
(63, 3, 43, 0, 9, 'encens'),
(64, 3, 46, 0, 9, NULL),
(65, 3, 49, 0, 9, 'PRODUCTS'),
(66, 3, 58, 0, 9, NULL),
(67, 3, 61, 0, 9, NULL),
(68, 3, 57, 1, 9, 'des-senteurs-qui-enivrent/encens.html'),
(69, 3, 57, 0, 9, 'des-senteurs-qui-enivrent/encens.html'),
(70, 3, 41, 0, 10, 'Bougeoirs, porte-encens, brûle-parfums'),
(71, 3, 43, 0, 10, 'bougeoirs-porte-encens-brule-parfums'),
(72, 3, 46, 0, 10, NULL),
(73, 3, 49, 0, 10, 'PRODUCTS'),
(74, 3, 58, 0, 10, NULL),
(75, 3, 61, 0, 10, NULL),
(76, 3, 57, 1, 10, 'des-senteurs-qui-enivrent/bougeoirs-porte-encens-brule-parfums.html'),
(77, 3, 57, 0, 10, 'des-senteurs-qui-enivrent/bougeoirs-porte-encens-brule-parfums.html'),
(78, 3, 41, 0, 11, 'Huiles de bains, gâteaux pétillants'),
(79, 3, 43, 0, 11, 'huiles-de-bains-gateaux-petillants'),
(80, 3, 46, 0, 11, NULL),
(81, 3, 49, 0, 11, 'PRODUCTS'),
(82, 3, 58, 0, 11, NULL),
(83, 3, 61, 0, 11, NULL),
(84, 3, 57, 1, 11, 'tout-pour-un-bain-relaxant/huiles-de-bains-gateaux-petillants.html'),
(85, 3, 57, 0, 11, 'tout-pour-un-bain-relaxant/huiles-de-bains-gateaux-petillants.html'),
(92, 3, 41, 0, 12, 'Sels de bain'),
(93, 3, 43, 0, 12, 'sels-de-bain'),
(94, 3, 46, 0, 12, NULL),
(95, 3, 49, 0, 12, 'PRODUCTS'),
(96, 3, 58, 0, 12, NULL),
(97, 3, 61, 0, 12, NULL),
(98, 3, 57, 1, 12, 'tout-pour-un-bain-relaxant/sels-de-bain.html'),
(99, 3, 57, 0, 12, 'tout-pour-un-bain-relaxant/sels-de-bain.html'),
(100, 3, 41, 0, 13, 'Crème de douche et de bain, savon noir'),
(101, 3, 46, 0, 13, NULL),
(102, 3, 49, 0, 13, 'PRODUCTS'),
(103, 3, 58, 0, 13, NULL),
(104, 3, 61, 0, 13, NULL),
(105, 3, 43, 0, 13, 'creme-de-douche-et-de-bain-savon-noir'),
(109, 3, 57, 1, 13, 'tout-pour-un-bain-relaxant/creme-de-douche-et-de-bain-savon-noir.html'),
(110, 3, 57, 0, 13, 'tout-pour-un-bain-relaxant/creme-de-douche-et-de-bain-savon-noir.html'),
(111, 3, 41, 0, 14, 'Accessoires'),
(112, 3, 43, 0, 14, 'accessoires'),
(113, 3, 46, 0, 14, NULL),
(114, 3, 49, 0, 14, 'PRODUCTS'),
(115, 3, 58, 0, 14, NULL),
(116, 3, 61, 0, 14, NULL),
(117, 3, 57, 1, 14, 'tout-pour-un-bain-relaxant/accessoires.html'),
(118, 3, 57, 0, 14, 'tout-pour-un-bain-relaxant/accessoires.html'),
(119, 3, 41, 0, 15, 'La librairie'),
(120, 3, 43, 0, 15, 'la-librairie'),
(121, 3, 46, 0, 15, NULL),
(122, 3, 49, 0, 15, 'PRODUCTS'),
(123, 3, 58, 0, 15, NULL),
(124, 3, 61, 0, 15, NULL),
(125, 3, 57, 1, 15, 'la-librairie.html'),
(126, 3, 57, 0, 15, 'la-librairie.html');

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_flat_store_1`
--

DROP TABLE IF EXISTS `catalog_category_flat_store_1`;
CREATE TABLE IF NOT EXISTS `catalog_category_flat_store_1` (
  `entity_id` int(10) unsigned NOT NULL COMMENT 'entity_id',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'parent_id',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'created_at',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'updated_at',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT 'path',
  `position` int(11) NOT NULL COMMENT 'position',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT 'level',
  `children_count` int(11) NOT NULL COMMENT 'children_count',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store Id',
  `all_children` text COMMENT 'All Children',
  `available_sort_by` text COMMENT 'Available Product Listing Sort By',
  `children` text COMMENT 'Children',
  `custom_apply_to_products` int(11) DEFAULT NULL COMMENT 'Apply To Products',
  `custom_design` varchar(255) DEFAULT NULL COMMENT 'Custom Design',
  `custom_design_from` datetime DEFAULT NULL COMMENT 'Active From',
  `custom_design_to` datetime DEFAULT NULL COMMENT 'Active To',
  `custom_layout_update` text COMMENT 'Custom Layout Update',
  `custom_use_parent_settings` int(11) DEFAULT NULL COMMENT 'Use Parent Category Settings',
  `default_sort_by` varchar(255) DEFAULT NULL COMMENT 'Default Product Listing Sort By',
  `description` text COMMENT 'Description',
  `display_mode` varchar(255) DEFAULT NULL COMMENT 'Display Mode',
  `filter_price_range` decimal(12,4) DEFAULT NULL COMMENT 'Layered Navigation Price Step',
  `image` varchar(255) DEFAULT NULL COMMENT 'Image',
  `include_in_menu` int(11) DEFAULT NULL COMMENT 'Include in Navigation Menu',
  `is_active` int(11) DEFAULT NULL COMMENT 'Is Active',
  `is_anchor` int(11) DEFAULT NULL COMMENT 'Is Anchor',
  `landing_page` int(11) DEFAULT NULL COMMENT 'CMS Block',
  `meta_description` text COMMENT 'Meta Description',
  `meta_keywords` text COMMENT 'Meta Keywords',
  `meta_title` varchar(255) DEFAULT NULL COMMENT 'Page Title',
  `name` varchar(255) DEFAULT NULL COMMENT 'Name',
  `page_layout` varchar(255) DEFAULT NULL COMMENT 'Page Layout',
  `path_in_store` text COMMENT 'Path In Store',
  `thumbnail` varchar(255) DEFAULT NULL COMMENT 'Thumbnail Image',
  `url_key` varchar(255) DEFAULT NULL COMMENT 'URL Key',
  `url_path` varchar(255) DEFAULT NULL COMMENT 'Url Path',
  PRIMARY KEY (`entity_id`),
  KEY `IDX_CATALOG_CATEGORY_FLAT_STORE_1_STORE_ID` (`store_id`),
  KEY `IDX_CATALOG_CATEGORY_FLAT_STORE_1_PATH` (`path`),
  KEY `IDX_CATALOG_CATEGORY_FLAT_STORE_1_LEVEL` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Category Flat (Store 1)';

--
-- Contenu de la table `catalog_category_flat_store_1`
--

INSERT INTO `catalog_category_flat_store_1` (`entity_id`, `parent_id`, `created_at`, `updated_at`, `path`, `position`, `level`, `children_count`, `store_id`, `all_children`, `available_sort_by`, `children`, `custom_apply_to_products`, `custom_design`, `custom_design_from`, `custom_design_to`, `custom_layout_update`, `custom_use_parent_settings`, `default_sort_by`, `description`, `display_mode`, `filter_price_range`, `image`, `include_in_menu`, `is_active`, `is_anchor`, `landing_page`, `meta_description`, `meta_keywords`, `meta_title`, `name`, `page_layout`, `path_in_store`, `thumbnail`, `url_key`, `url_path`) VALUES
(1, 0, '2013-12-13 12:33:46', '2013-12-13 12:33:46', '1', 0, 0, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Root Catalog', NULL, NULL, NULL, 'root-catalog', NULL),
(2, 1, '2013-12-13 12:33:46', '2013-12-13 12:33:46', '1/2', 1, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PRODUCTS', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 'Default Category', NULL, NULL, NULL, 'default-category', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_product`
--

DROP TABLE IF EXISTS `catalog_category_product`;
CREATE TABLE IF NOT EXISTS `catalog_category_product` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position',
  PRIMARY KEY (`category_id`,`product_id`),
  KEY `IDX_CATALOG_CATEGORY_PRODUCT_PRODUCT_ID` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Product To Category Linkage Table';

--
-- Contenu de la table `catalog_category_product`
--

INSERT INTO `catalog_category_product` (`category_id`, `product_id`, `position`) VALUES
(3, 14, 1),
(3, 15, 1),
(3, 16, 1),
(3, 17, 1),
(3, 18, 1),
(5, 1, 1),
(5, 5, 1),
(5, 9, 1),
(5, 10, 1),
(5, 11, 1),
(5, 12, 1),
(5, 19, 1),
(5, 20, 1),
(5, 21, 1),
(6, 1, 1),
(6, 5, 1),
(6, 9, 1),
(7, 10, 1),
(7, 11, 1),
(7, 12, 1),
(8, 22, 0),
(9, 20, 1),
(9, 21, 1),
(10, 19, 1),
(10, 22, 0),
(13, 14, 1),
(14, 15, 1),
(14, 16, 1),
(14, 17, 1),
(14, 18, 1);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_product_index`
--

DROP TABLE IF EXISTS `catalog_category_product_index`;
CREATE TABLE IF NOT EXISTS `catalog_category_product_index` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `position` int(11) DEFAULT NULL COMMENT 'Position',
  `is_parent` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Parent',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `visibility` smallint(5) unsigned NOT NULL COMMENT 'Visibility',
  PRIMARY KEY (`category_id`,`product_id`,`store_id`),
  KEY `IDX_CAT_CTGR_PRD_IDX_PRD_ID_STORE_ID_CTGR_ID_VISIBILITY` (`product_id`,`store_id`,`category_id`,`visibility`),
  KEY `15D3C269665C74C2219037D534F4B0DC` (`store_id`,`category_id`,`visibility`,`is_parent`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Category Product Index';

--
-- Contenu de la table `catalog_category_product_index`
--

INSERT INTO `catalog_category_product_index` (`category_id`, `product_id`, `position`, `is_parent`, `store_id`, `visibility`) VALUES
(2, 7, 0, 1, 1, 1),
(2, 8, 0, 1, 1, 1),
(2, 22, 0, 0, 1, 4),
(2, 1, 20005, 0, 1, 4),
(2, 5, 20005, 0, 1, 4),
(2, 9, 20005, 0, 1, 4),
(2, 10, 20005, 0, 1, 4),
(2, 11, 20005, 0, 1, 4),
(2, 12, 20005, 0, 1, 4),
(2, 19, 20005, 0, 1, 4),
(2, 20, 20005, 0, 1, 4),
(2, 21, 20005, 0, 1, 4),
(2, 14, 30007, 0, 1, 4),
(2, 15, 30007, 0, 1, 4),
(2, 16, 30007, 0, 1, 4),
(2, 17, 30007, 0, 1, 4),
(2, 18, 30007, 0, 1, 4),
(3, 14, 1, 1, 1, 4),
(3, 15, 1, 1, 1, 4),
(3, 16, 1, 1, 1, 4),
(3, 17, 1, 1, 1, 4),
(3, 18, 1, 1, 1, 4),
(5, 1, 1, 1, 1, 4),
(5, 5, 1, 1, 1, 4),
(5, 9, 1, 1, 1, 4),
(5, 10, 1, 1, 1, 4),
(5, 11, 1, 1, 1, 4),
(5, 12, 1, 1, 1, 4),
(5, 19, 1, 1, 1, 4),
(5, 20, 1, 1, 1, 4),
(5, 21, 1, 1, 1, 4),
(6, 1, 1, 1, 1, 4),
(6, 5, 1, 1, 1, 4),
(6, 9, 1, 1, 1, 4),
(7, 10, 1, 1, 1, 4),
(7, 11, 1, 1, 1, 4),
(7, 12, 1, 1, 1, 4),
(8, 22, 0, 1, 1, 4),
(9, 20, 1, 1, 1, 4),
(9, 21, 1, 1, 1, 4),
(10, 22, 0, 1, 1, 4),
(10, 19, 1, 1, 1, 4),
(13, 14, 1, 1, 1, 4),
(14, 15, 1, 1, 1, 4),
(14, 16, 1, 1, 1, 4),
(14, 17, 1, 1, 1, 4),
(14, 18, 1, 1, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_product_index_enbl_idx`
--

DROP TABLE IF EXISTS `catalog_category_product_index_enbl_idx`;
CREATE TABLE IF NOT EXISTS `catalog_category_product_index_enbl_idx` (
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `visibility` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Visibility',
  KEY `IDX_CAT_CTGR_PRD_IDX_ENBL_IDX_PRD_ID_VISIBILITY` (`product_id`,`visibility`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Category Product Enabled Indexer Index Table';

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_product_index_enbl_tmp`
--

DROP TABLE IF EXISTS `catalog_category_product_index_enbl_tmp`;
CREATE TABLE IF NOT EXISTS `catalog_category_product_index_enbl_tmp` (
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `visibility` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Visibility',
  KEY `IDX_CAT_CTGR_PRD_IDX_ENBL_TMP_PRD_ID_VISIBILITY` (`product_id`,`visibility`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='Catalog Category Product Enabled Indexer Temp Table';

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_product_index_idx`
--

DROP TABLE IF EXISTS `catalog_category_product_index_idx`;
CREATE TABLE IF NOT EXISTS `catalog_category_product_index_idx` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position',
  `is_parent` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Parent',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `visibility` smallint(5) unsigned NOT NULL COMMENT 'Visibility',
  KEY `IDX_CAT_CTGR_PRD_IDX_IDX_PRD_ID_CTGR_ID_STORE_ID` (`product_id`,`category_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog Category Product Indexer Index Table';

-- --------------------------------------------------------

--
-- Structure de la table `catalog_category_product_index_tmp`
--

DROP TABLE IF EXISTS `catalog_category_product_index_tmp`;
CREATE TABLE IF NOT EXISTS `catalog_category_product_index_tmp` (
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Category ID',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position',
  `is_parent` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Parent',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store ID',
  `visibility` smallint(5) unsigned NOT NULL COMMENT 'Visibility',
  KEY `IDX_CAT_CTGR_PRD_IDX_TMP_PRD_ID_CTGR_ID_STORE_ID` (`product_id`,`category_id`,`store_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='Catalog Category Product Indexer Temp Table';

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `catalog_category_entity_datetime`
--
ALTER TABLE `catalog_category_entity_datetime`
  ADD CONSTRAINT `FK_CATALOG_CATEGORY_ENTITY_DATETIME_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_DTIME_ATTR_ID_EAV_ATTR_ATTR_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_DTIME_ENTT_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `catalog_category_entity_decimal`
--
ALTER TABLE `catalog_category_entity_decimal`
  ADD CONSTRAINT `FK_CATALOG_CATEGORY_ENTITY_DECIMAL_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_DEC_ATTR_ID_EAV_ATTR_ATTR_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_DEC_ENTT_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `catalog_category_entity_int`
--
ALTER TABLE `catalog_category_entity_int`
  ADD CONSTRAINT `FK_CATALOG_CATEGORY_ENTITY_INT_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_INT_ATTR_ID_EAV_ATTR_ATTR_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_INT_ENTT_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `catalog_category_entity_text`
--
ALTER TABLE `catalog_category_entity_text`
  ADD CONSTRAINT `FK_CATALOG_CATEGORY_ENTITY_TEXT_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_TEXT_ATTR_ID_EAV_ATTR_ATTR_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_TEXT_ENTT_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `catalog_category_entity_varchar`
--
ALTER TABLE `catalog_category_entity_varchar`
  ADD CONSTRAINT `FK_CATALOG_CATEGORY_ENTITY_VARCHAR_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_VCHR_ATTR_ID_EAV_ATTR_ATTR_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_ENTT_VCHR_ENTT_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `catalog_category_flat_store_1`
--
ALTER TABLE `catalog_category_flat_store_1`
  ADD CONSTRAINT `FK_CATALOG_CATEGORY_FLAT_STORE_1_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_FLAT_STORE_1_ENTT_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`entity_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `catalog_category_product`
--
ALTER TABLE `catalog_category_product`
  ADD CONSTRAINT `FK_CAT_CTGR_PRD_CTGR_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`category_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_PRD_PRD_ID_CAT_PRD_ENTT_ENTT_ID` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `catalog_category_product_index`
--
ALTER TABLE `catalog_category_product_index`
  ADD CONSTRAINT `FK_CATALOG_CATEGORY_PRODUCT_INDEX_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_PRD_IDX_CTGR_ID_CAT_CTGR_ENTT_ENTT_ID` FOREIGN KEY (`category_id`) REFERENCES `catalog_category_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAT_CTGR_PRD_IDX_PRD_ID_CAT_PRD_ENTT_ENTT_ID` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
