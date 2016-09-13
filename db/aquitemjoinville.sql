-- phpMyAdmin SQL Dump
-- version 3.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Set 12, 2016 as 10:00 PM
-- Versão do Servidor: 5.0.51
-- Versão do PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `aquitemjoinville`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_ads`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_ads` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` int(10) unsigned default '0',
  `userid` int(10) unsigned default NULL,
  `name` text,
  `ad_zip` text,
  `ad_city` text,
  `ad_phone` text,
  `email` text,
  `ad_kindof` text,
  `ad_headline` text,
  `ad_text` text,
  `ad_state` text,
  `ad_price` text,
  `date_created` date default NULL,
  `date_recall` date default NULL,
  `recall_mail_sent` tinyint(1) default '0',
  `views` int(10) unsigned default '0',
  `published` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_adsmanager_ads`
--

INSERT INTO `jos_adsmanager_ads` (`id`, `category`, `userid`, `name`, `ad_zip`, `ad_city`, `ad_phone`, `email`, `ad_kindof`, `ad_headline`, `ad_text`, `ad_state`, `ad_price`, `date_created`, `date_recall`, `recall_mail_sent`, `views`, `published`) VALUES
(1, 1, 63, 'Leonardo', '7897', 'Joinville', '45464', 'leo.lima.web@gmail.com', '0', 'Bicicleta', 'Caloi 100 R$ 200,00', '0', '200', '2008-11-03', '2016-09-07', 1, 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_categories`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(10) unsigned default '0',
  `name` varchar(50) default NULL,
  `description` varchar(250) default NULL,
  `ordering` int(11) default '0',
  `published` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `jos_adsmanager_categories`
--

INSERT INTO `jos_adsmanager_categories` (`id`, `parent`, `name`, `description`, `ordering`, `published`) VALUES
(1, 0, 'Imóveis', '', 1, 1),
(2, 0, 'Veículos', '', 2, 1),
(3, 0, 'Diversos', '', 3, 1),
(4, 0, 'Animais', '', 4, 1),
(5, 0, 'Instrumentos Musicais', '', 5, 1),
(6, 0, 'Acessórios Automotivos', '', 6, 1),
(7, 0, 'Som Automotivo', '', 7, 1),
(8, 0, 'Náuticos', '', 8, 1),
(9, 0, 'Telefonia', '', 9, 1),
(10, 0, 'Informática', '', 10, 1),
(11, 0, 'Empregos', '', 11, 1),
(12, 0, 'Para Ler, Pensar e Sentir', '', 12, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_columns`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_columns` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `catsid` varchar(255) NOT NULL default ',-1,',
  `published` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `jos_adsmanager_columns`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_config`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_config` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `version` text NOT NULL,
  `ads_per_page` int(10) unsigned NOT NULL default '20',
  `max_image_size` int(10) unsigned NOT NULL default '102400',
  `max_width` int(4) NOT NULL default '450',
  `max_height` int(4) NOT NULL default '300',
  `max_width_t` int(4) NOT NULL default '150',
  `max_height_t` int(4) NOT NULL default '100',
  `root_allowed` tinyint(4) NOT NULL default '1',
  `nb_images` int(4) NOT NULL default '2',
  `show_contact` tinyint(4) NOT NULL default '1',
  `send_email_on_new` tinyint(4) NOT NULL default '1',
  `send_email_on_update` tinyint(4) NOT NULL default '1',
  `auto_publish` tinyint(4) NOT NULL default '1',
  `tag` text NOT NULL,
  `fronttext` text NOT NULL,
  `comprofiler` tinyint(4) NOT NULL default '0',
  `email_display` tinyint(4) NOT NULL default '0',
  `rules_text` text NOT NULL,
  `display_expand` tinyint(4) NOT NULL default '1',
  `display_last` tinyint(4) NOT NULL default '2',
  `display_fullname` tinyint(4) NOT NULL default '2',
  `expiration` tinyint(1) NOT NULL default '1',
  `ad_duration` int(4) NOT NULL default '30',
  `recall` tinyint(1) NOT NULL default '1',
  `recall_time` int(4) NOT NULL default '7',
  `recall_text` text NOT NULL,
  `image_display` varchar(50) NOT NULL default 'default',
  `cat_max_width` int(4) NOT NULL default '150',
  `cat_max_height` int(4) NOT NULL default '150',
  `cat_max_width_t` int(4) NOT NULL default '30',
  `cat_max_height_t` int(4) NOT NULL default '30',
  `submission_type` int(4) NOT NULL default '30',
  `nb_ads_by_user` int(4) NOT NULL default '-1',
  `allow_attachement` tinyint(1) NOT NULL default '0',
  `allow_contact_by_pms` tinyint(1) NOT NULL default '0',
  `show_rss` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_adsmanager_config`
--

INSERT INTO `jos_adsmanager_config` (`id`, `version`, `ads_per_page`, `max_image_size`, `max_width`, `max_height`, `max_width_t`, `max_height_t`, `root_allowed`, `nb_images`, `show_contact`, `send_email_on_new`, `send_email_on_update`, `auto_publish`, `tag`, `fronttext`, `comprofiler`, `email_display`, `rules_text`, `display_expand`, `display_last`, `display_fullname`, `expiration`, `ad_duration`, `recall`, `recall_time`, `recall_text`, `image_display`, `cat_max_width`, `cat_max_height`, `cat_max_width_t`, `cat_max_height_t`, `submission_type`, `nb_ads_by_user`, `allow_attachement`, `allow_contact_by_pms`, `show_rss`) VALUES
(1, '1.0.1', 20, 2048000, 400, 300, 150, 100, 1, 2, 0, 1, 1, 1, 'aquitemjoinville.com.br', '<p align="center">\r\n<b>Classificados</b>\r\n</p>\r\n<p align="left">\r\nO melhor lugar para comprar.\r\n</p>\r\n', 0, 0, 'Informe aos usu&aacute;rios sobre as regras dos classificados aqui.\r\n', 2, 1, 0, 1, 30, 1, 7, 'Add This Text to recall message\r\n', 'default', 150, 150, 30, 30, 0, -1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_fields`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_fields` (
  `fieldid` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `display_title` tinyint(1) NOT NULL default '0',
  `description` mediumtext NOT NULL,
  `type` varchar(50) NOT NULL default '',
  `maxlength` int(11) default NULL,
  `size` int(11) default NULL,
  `required` tinyint(4) default '0',
  `ordering` int(11) default NULL,
  `cols` int(11) default NULL,
  `rows` int(11) default NULL,
  `columnid` int(11) NOT NULL default '-1',
  `columnorder` int(11) NOT NULL default '0',
  `pos` tinyint(4) NOT NULL default '1',
  `posorder` tinyint(4) NOT NULL default '1',
  `profile` tinyint(1) NOT NULL default '0',
  `cb_field` int(11) NOT NULL default '-1',
  `editable` tinyint(1) NOT NULL default '1',
  `searchable` tinyint(1) NOT NULL default '1',
  `sort` tinyint(1) NOT NULL default '0',
  `sort_direction` varchar(4) NOT NULL default 'DESC',
  `catsid` varchar(255) NOT NULL default ',-1,',
  `published` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`fieldid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `jos_adsmanager_fields`
--

INSERT INTO `jos_adsmanager_fields` (`fieldid`, `name`, `title`, `display_title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `editable`, `searchable`, `sort`, `sort_direction`, `catsid`, `published`) VALUES
(1, 'name', 'ADSMANAGER_FORM_NAME', 0, '', 'text', 50, 35, 1, 0, 0, 0, -1, 5, 5, 1, 1, 41, 1, 1, 0, 'DESC', ',-1,', 1),
(2, 'email', 'ADSMANAGER_FORM_EMAIL', 0, '', 'emailaddress', 50, 35, 1, 1, 0, 0, -1, 10, 5, 4, 1, 50, 1, 1, 0, 'DESC', ',-1,', 1),
(3, 'ad_city', 'ADSMANAGER_FORM_CITY', 0, '', 'text', 50, 35, 0, 4, 0, 0, 3, 1, 5, 3, 1, 59, 1, 1, 1, 'ASC', ',-1,', 1),
(4, 'ad_zip', 'ADSMANAGER_FORM_ZIP', 0, '', 'text', 8, 8, 0, 3, 0, 0, -1, 0, 5, 2, 1, -1, 1, 1, 0, 'ASC', ',-1,', 1),
(5, 'ad_headline', 'ADSMANAGER_FORM_AD_HEADLINE', 0, '', 'text', 60, 35, 1, 5, 0, 0, -1, 0, 1, 1, 0, -1, 1, 1, 0, 'DESC', ',-1,', 1),
(6, 'ad_text', 'ADSMANAGER_FORM_AD_TEXT', 0, '', 'textarea', 500, 0, 1, 6, 40, 20, -1, 0, 3, 1, 0, -1, 1, 1, 0, 'DESC', ',-1,', 1),
(7, 'ad_phone', 'ADSMANAGER_FORM_PHONE1', 0, '', 'number', 50, 35, 0, 2, 0, 0, -1, 0, 5, 1, 1, -1, 1, 1, 0, 'DESC', ',-1,', 1),
(8, 'ad_kindof', 'ADSMANAGER_FORM_KINDOF', 0, '', 'select', 0, 0, 0, 7, 0, 0, 5, 0, 2, 1, 0, -1, 1, 1, 0, 'DESC', ',-1,', 0),
(9, 'ad_state', 'ADSMANAGER_FORM_STATE', 0, '', 'select', 0, 0, 0, 8, 0, 0, 5, 0, 2, 1, 0, -1, 1, 1, 0, 'DESC', ',-1,', 0),
(10, 'ad_price', 'ADSMANAGER_FORM_AD_PRICE', 0, '', 'price', 10, 7, 1, 9, 0, 0, -1, 0, 4, 1, 0, -1, 1, 1, 1, 'DESC', ',-1,', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_field_values`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_field_values` (
  `fieldvalueid` int(11) NOT NULL auto_increment,
  `fieldid` int(11) NOT NULL default '0',
  `fieldtitle` varchar(50) NOT NULL default '',
  `fieldvalue` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `sys` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`fieldvalueid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=290 ;

--
-- Extraindo dados da tabela `jos_adsmanager_field_values`
--

INSERT INTO `jos_adsmanager_field_values` (`fieldvalueid`, `fieldid`, `fieldtitle`, `fieldvalue`, `ordering`, `sys`) VALUES
(228, 8, 'ADSMANAGER_KINDOF2', 1, 1, 0),
(229, 8, 'ADSMANAGER_KINDOF1', 2, 2, 0),
(225, 9, 'ADSMANAGER_STATE_0', 4, 4, 0),
(227, 8, 'ADSMANAGER_KINDOFALL', 0, 0, 0),
(224, 9, 'ADSMANAGER_STATE_1', 3, 3, 0),
(222, 9, 'ADSMANAGER_STATE_3', 1, 1, 0),
(223, 9, 'ADSMANAGER_STATE_2', 2, 2, 0),
(289, 7, '', 0, 0, 0),
(285, 2, '', 0, 0, 0),
(284, 1, '', 0, 0, 0),
(221, 9, 'ADSMANAGER_STATE_4', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_positions`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_positions` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `jos_adsmanager_positions`
--

INSERT INTO `jos_adsmanager_positions` (`id`, `name`, `title`) VALUES
(1, 'top', 'ADSMANAGER_POSITION_TOP'),
(2, 'subtitle', 'ADSMANAGER_POSITION_SUBTITLE'),
(3, 'description', 'ADSMANAGER_POSITION_DESCRIPTION'),
(4, 'description2', 'ADSMANAGER_POSITION_DESCRIPTION2'),
(5, 'contact', 'ADSMANAGER_POSITION_CONTACT'),
(6, 'description3', 'ADSMANAGER_POSITION_DESCRIPTION3');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_adsmanager_profile`
--

CREATE TABLE IF NOT EXISTS `jos_adsmanager_profile` (
  `userid` int(11) NOT NULL default '0',
  `name` text,
  `ad_city` text NOT NULL,
  `email` text NOT NULL,
  `ad_zip` text NOT NULL,
  `ad_phone` text NOT NULL,
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_adsmanager_profile`
--

INSERT INTO `jos_adsmanager_profile` (`userid`, `name`, `ad_city`, `email`, `ad_zip`, `ad_phone`) VALUES
(62, NULL, '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_banner`
--

CREATE TABLE IF NOT EXISTS `jos_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default 'banner',
  `name` varchar(50) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_banner`
--

INSERT INTO `jos_banner` (`bid`, `cid`, `type`, `name`, `imptotal`, `impmade`, `clicks`, `imageurl`, `clickurl`, `date`, `showBanner`, `checked_out`, `checked_out_time`, `editor`, `custombannercode`) VALUES
(1, 1, '', 'BreakFast', 0, 209, 1, 'breakfast.jpg', 'http://www.google.com.br', '2008-10-24 18:04:03', 1, 0, '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_bannerclient`
--

CREATE TABLE IF NOT EXISTS `jos_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_bannerclient`
--

INSERT INTO `jos_bannerclient` (`cid`, `name`, `contact`, `email`, `extrainfo`, `checked_out`, `checked_out_time`, `editor`) VALUES
(1, 'Osni Martins', 'Osni Martins', 'osni@osni.com.br', '', 0, '00:00:00', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_bannerfinish`
--

CREATE TABLE IF NOT EXISTS `jos_bannerfinish` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `impressions` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(50) NOT NULL default '',
  `datestart` datetime default NULL,
  `dateend` datetime default NULL,
  PRIMARY KEY  (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_bannerfinish`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_categories`
--

CREATE TABLE IF NOT EXISTS `jos_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `title` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_section` (`section`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `jos_categories`
--

INSERT INTO `jos_categories` (`id`, `parent_id`, `title`, `name`, `image`, `section`, `image_position`, `description`, `published`, `checked_out`, `checked_out_time`, `editor`, `ordering`, `access`, `count`, `params`) VALUES
(1, 0, 'Sistemas de Busca', 'Sistemas de Busca', '', 'com_weblinks', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 2, 0, 0, ''),
(2, 0, 'Cinemas', 'Cinemas', '', 'com_weblinks', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, ''),
(3, 0, 'AquiTemJoinville', 'AquiTemJoinville', '', 'com_contact_details', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_components`
--

CREATE TABLE IF NOT EXISTS `jos_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Extraindo dados da tabela `jos_components`
--

INSERT INTO `jos_components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`) VALUES
(1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, ''),
(2, 'Administar Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, ''),
(3, 'Administar Clientes', '', 0, 1, 'option=com_banners&task=listclients', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, ''),
(4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/globe2.png', 0, ''),
(5, 'Weblink Itens', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, ''),
(6, 'Weblink Categorias', '', 0, 4, 'option=categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, ''),
(7, 'Contatos', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/user.png', 1, ''),
(8, 'Administrar Contatos', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, ''),
(9, 'Categoria Contatos', '', 0, 7, 'option=categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, ''),
(10, 'Primeira Página', 'option=com_frontpage', 0, 0, '', 'Gerir Artigos da Primeira Página', 'com_frontpage', 0, 'js/ThemeOffice/component.png', 1, ''),
(11, 'Enquetes', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, ''),
(12, 'Notícias Externas', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, ''),
(13, 'Administrar Notícias Externas', '', 0, 12, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, ''),
(14, 'Administrar Categorias', '', 0, 12, 'option=categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, ''),
(15, 'Login', 'option=com_login', 0, 0, '', '', 'com_login', 0, '', 1, ''),
(16, 'Pesquisar', 'option=com_search', 0, 0, '', '', 'com_search', 0, '', 1, ''),
(17, 'Difusão de Notícias', '', 0, 0, 'option=com_syndicate&hidemainmenu=1', 'Gerir configuração de Difusão dos Sinais Noticiosos', 'com_syndicate', 0, 'js/ThemeOffice/component.png', 0, ''),
(18, 'E-mail em Massa', '', 0, 0, 'option=com_massmail&hidemainmenu=1', 'Enviar e-mail para múltiplos destinatários', 'com_massmail', 0, 'js/ThemeOffice/mass_email.png', 0, ''),
(19, 'swMenuFree', 'option=com_swmenufree', 0, 0, 'option=com_swmenufree', 'swMenuFree', 'com_swmenufree', 0, 'js/ThemeOffice/component.png', 0, ''),
(20, 'eWeather', 'option=com_eweather', 0, 0, 'option=com_eweather', 'eWeather', 'com_eweather', 0, '../administrator/components/com_eweather/mn_img/eweather.png', 0, ''),
(21, 'Locations', '', 0, 20, 'option=com_eweather&task=allLocations', 'Locations', 'com_eweather', 0, '../administrator/components/com_eweather/mn_img/location.png', 0, ''),
(22, 'Configuration', '', 0, 20, 'option=com_eweather&task=showConfig', 'Configuration', 'com_eweather', 1, '../administrator/components/com_eweather/mn_img/settings.png', 0, ''),
(23, 'Info', '', 0, 20, 'option=com_eweather&task=about', 'Info', 'com_eweather', 2, '../administrator/components/com_eweather/mn_img/info.png', 0, ''),
(24, 'JCE Admin', 'option=com_jce', 0, 0, 'option=com_jce', 'JCE Admin', 'com_jce', 0, 'js/ThemeOffice/component.png', 0, ''),
(25, 'JCE Configuration', '', 0, 24, 'option=com_jce&task=config', 'JCE Configuration', 'com_jce', 0, 'js/ThemeOffice/controlpanel.png', 0, ''),
(26, 'JCE Languages', '', 0, 24, 'option=com_jce&task=lang', 'JCE Languages', 'com_jce', 1, 'js/ThemeOffice/language.png', 0, ''),
(27, 'JCE Plugins', '', 0, 24, 'option=com_jce&task=showplugins', 'JCE Plugins', 'com_jce', 2, 'js/ThemeOffice/add_section.png', 0, ''),
(28, 'JCE Layout', '', 0, 24, 'option=com_jce&task=editlayout', 'JCE Layout', 'com_jce', 3, 'js/ThemeOffice/content.png', 0, ''),
(29, 'JoomlaPack', 'option=com_joomlapack', 0, 0, 'option=com_joomlapack', 'JoomlaPack', 'com_joomlapack', 0, 'js/ThemeOffice/component.png', 0, ''),
(30, 'Control Panel', '', 0, 29, 'option=com_joomlapack&act=main', 'Control Panel', 'com_joomlapack', 0, 'js/ThemeOffice/component.png', 0, ''),
(31, 'Options', '', 0, 29, 'option=com_joomlapack&act=config', 'Options', 'com_joomlapack', 1, 'js/ThemeOffice/component.png', 0, ''),
(32, 'Backup Now', '', 0, 29, 'option=com_joomlapack&act=pack', 'Backup Now', 'com_joomlapack', 2, 'js/ThemeOffice/component.png', 0, ''),
(33, 'Manage Backup Files', '', 0, 29, 'option=com_joomlapack&act=backupadmin', 'Manage Backup Files', 'com_joomlapack', 3, 'js/ThemeOffice/component.png', 0, ''),
(34, 'Backup Log', '', 0, 29, 'option=com_joomlapack&act=log', 'Backup Log', 'com_joomlapack', 4, 'js/ThemeOffice/component.png', 0, ''),
(35, 'AdsManager', 'option=com_adsmanager', 0, 0, 'option=com_adsmanager', 'AdsManager', 'com_adsmanager', 0, 'js/ThemeOffice/component.png', 0, ''),
(36, 'Configuration', '', 0, 35, 'option=com_adsmanager&act=configuration', 'Configuration', 'com_adsmanager', 0, 'js/ThemeOffice/component.png', 0, ''),
(37, 'Fields', '', 0, 35, 'option=com_adsmanager&act=fields', 'Fields', 'com_adsmanager', 1, 'js/ThemeOffice/component.png', 0, ''),
(38, 'Columns', '', 0, 35, 'option=com_adsmanager&act=columns', 'Columns', 'com_adsmanager', 2, 'js/ThemeOffice/component.png', 0, ''),
(39, 'Ad Display', '', 0, 35, 'option=com_adsmanager&act=positions', 'Ad Display', 'com_adsmanager', 3, 'js/ThemeOffice/component.png', 0, ''),
(40, 'Categories', '', 0, 35, 'option=com_adsmanager&act=categories', 'Categories', 'com_adsmanager', 4, 'js/ThemeOffice/component.png', 0, ''),
(41, 'Ads', '', 0, 35, 'option=com_adsmanager&act=ads', 'Ads', 'com_adsmanager', 5, 'js/ThemeOffice/component.png', 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_contact_details`
--

CREATE TABLE IF NOT EXISTS `jos_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `con_position` varchar(50) default NULL,
  `address` text,
  `suburb` varchar(50) default NULL,
  `state` varchar(20) default NULL,
  `country` varchar(50) default NULL,
  `postcode` varchar(10) default NULL,
  `telephone` varchar(25) default NULL,
  `fax` varchar(25) default NULL,
  `misc` mediumtext,
  `image` varchar(100) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(100) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_contact_details`
--

INSERT INTO `jos_contact_details` (`id`, `name`, `con_position`, `address`, `suburb`, `state`, `country`, `postcode`, `telephone`, `fax`, `misc`, `image`, `imagepos`, `email_to`, `default_con`, `published`, `checked_out`, `checked_out_time`, `ordering`, `params`, `user_id`, `catid`, `access`) VALUES
(1, 'AquiTemJoinville.com.br', '', 'Rua Sem Nome, sn', 'Joinville', 'Santa Catarina', 'Brasil', '89000-000', '(47) 333333333', '', '', '', NULL, 'contato@aquitemjoinville.com.br', 0, 1, 0, '0000-00-00 00:00:00', 1, 'menu_image=-1\npageclass_sfx=\nprint=\nback_button=\nname=1\nposition=1\nemail=0\nstreet_address=1\nsuburb=1\nstate=1\ncountry=1\npostcode=1\ntelephone=1\nfax=1\nmisc=1\nimage=1\nvcard=0\nemail_description=1\nemail_description_text=\nemail_form=1\nemail_copy=1\ndrop_down=0\ncontact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=', 0, 3, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_content`
--

CREATE TABLE IF NOT EXISTS `jos_content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `title_alias` varchar(100) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(100) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_mask` (`mask`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_content`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_content_frontpage`
--

CREATE TABLE IF NOT EXISTS `jos_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_content_frontpage`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_content_rating`
--

CREATE TABLE IF NOT EXISTS `jos_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_content_rating`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_aro`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_aro` (
  `aro_id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`aro_id`),
  UNIQUE KEY `jos_gacl_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `jos_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `jos_core_acl_aro`
--

INSERT INTO `jos_core_acl_aro` (`aro_id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'Leonardo', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_aro_groups`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_groups` (
  `group_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  KEY `parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Extraindo dados da tabela `jos_core_acl_aro_groups`
--

INSERT INTO `jos_core_acl_aro_groups` (`group_id`, `parent_id`, `name`, `lft`, `rgt`) VALUES
(17, 0, 'ROOT', 1, 22),
(28, 17, 'USERS', 2, 21),
(29, 28, 'Public Frontend', 3, 12),
(18, 29, 'Registered', 4, 11),
(19, 18, 'Author', 5, 10),
(20, 19, 'Editor', 6, 9),
(21, 20, 'Publisher', 7, 8),
(30, 28, 'Public Backend', 13, 20),
(23, 30, 'Manager', 14, 19),
(24, 23, 'Administrator', 15, 18),
(25, 24, 'Super Administrator', 16, 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_aro_sections`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_sections` (
  `section_id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`section_id`),
  UNIQUE KEY `value_aro_sections` (`value`),
  UNIQUE KEY `jos_gacl_value_aro_sections` (`value`),
  KEY `hidden_aro_sections` (`hidden`),
  KEY `jos_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `jos_core_acl_aro_sections`
--

INSERT INTO `jos_core_acl_aro_sections` (`section_id`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', 1, 'Users', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_groups_aro_map`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_core_acl_groups_aro_map`
--

INSERT INTO `jos_core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 11),
(25, '', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_log_items`
--

CREATE TABLE IF NOT EXISTS `jos_core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_core_log_items`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_log_searches`
--

CREATE TABLE IF NOT EXISTS `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_core_log_searches`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_eweather_cache`
--

CREATE TABLE IF NOT EXISTS `jos_eweather_cache` (
  `id` mediumint(9) NOT NULL auto_increment,
  `lastupdate` int(11) default NULL,
  `locid` varchar(15) NOT NULL default '',
  `feed` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_eweather_cache`
--

INSERT INTO `jos_eweather_cache` (`id`, `lastupdate`, `locid`, `feed`) VALUES
(1, 1234320578, 'BRXX0130', '<?xml version="1.0" encoding="ISO-8859-1"?><!-- This document is intended only for use by authorized licensees of The  --><!-- Weather Channel. Unauthorized use is prohibited.  Copyright 1995-2009, --><!-- The Weather Channel Interactive, Inc.  All Rights Reserved.            --><weather ver="2.0"><head><locale>en_US</locale><form>MEDIUM</form><ut>C</ut><ud>km</ud><us>km/h</us><up>mb</up><ur>mm</ur></head><loc id="BRXX0130"><dnam>Joinville, Brazil</dnam><tm>12:44 AM</tm><lat>-26.32</lat><lon>-48.84</lon><sunr>5:57 AM</sunr><suns>8:01 PM</suns><zone>-2</zone></loc><cc><lsup>2/10/09 11:00 PM Local Time</lsup><obst>Navegantes, BRAZIL</obst><tmp>26</tmp><flik>29</flik><t>Mostly Cloudy</t><icon>27</icon><bar><r>1012.9</r><d>steady</d></bar><wind><s>23</s><gust>N/A</gust><d>70</d><t>ENE</t></wind><hmid>89</hmid><vis>6.0</vis><uv><i>0</i><t>Low</t></uv><dewp>24</dewp><moon><icon>16</icon><t>Waning Gibbous</t></moon></cc><dayf><lsup>2/10/09 7:26 PM Local Time</lsup><day d="0" t="Tuesday" dt="Feb 10"><hi>N/A</hi><low>23</low><sunr>5:57 AM</sunr><suns>8:02 PM</suns><part p="d"><icon>44</icon><t>N/A</t><wind><s>N/A</s><gust>N/A</gust><d>N/A</d><t>N/A</t></wind><bt>N/A</bt><ppcp>80</ppcp><hmid>N/A</hmid></part><part p="n"><icon>4</icon><t>T-Storms</t><wind><s>8</s><gust>N/A</gust><d>47</d><t>NE</t></wind><bt>T-Storms</bt><ppcp>80</ppcp><hmid>96</hmid></part></day><day d="1" t="Wednesday" dt="Feb 11"><hi>31</hi><low>23</low><sunr>6:58 AM</sunr><suns>8:01 PM</suns><part p="d"><icon>38</icon><t>Scattered T-Storms</t><wind><s>13</s><gust>N/A</gust><d>357</d><t>N</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>80</hmid></part><part p="n"><icon>4</icon><t>T-Storms</t><wind><s>10</s><gust>N/A</gust><d>291</d><t>WNW</t></wind><bt>T-Storms</bt><ppcp>80</ppcp><hmid>95</hmid></part></day><day d="2" t="Thursday" dt="Feb 12"><hi>27</hi><low>21</low><sunr>6:58 AM</sunr><suns>8:01 PM</suns><part p="d"><icon>4</icon><t>T-Storms</t><wind><s>16</s><gust>N/A</gust><d>166</d><t>SSE</t></wind><bt>T-Storms</bt><ppcp>90</ppcp><hmid>83</hmid></part><part p="n"><icon>4</icon><t>T-Storms</t><wind><s>10</s><gust>N/A</gust><d>157</d><t>SSE</t></wind><bt>T-Storms</bt><ppcp>90</ppcp><hmid>85</hmid></part></day><day d="3" t="Friday" dt="Feb 13"><hi>27</hi><low>19</low><sunr>6:59 AM</sunr><suns>8:00 PM</suns><part p="d"><icon>28</icon><t>Mostly Cloudy</t><wind><s>13</s><gust>N/A</gust><d>142</d><t>SE</t></wind><bt>M Cloudy</bt><ppcp>10</ppcp><hmid>81</hmid></part><part p="n"><icon>27</icon><t>Mostly Cloudy</t><wind><s>5</s><gust>N/A</gust><d>152</d><t>SSE</t></wind><bt>M Cloudy</bt><ppcp>10</ppcp><hmid>83</hmid></part></day><day d="4" t="Saturday" dt="Feb 14"><hi>29</hi><low>19</low><sunr>7:00 AM</sunr><suns>7:59 PM</suns><part p="d"><icon>30</icon><t>Partly Cloudy</t><wind><s>14</s><gust>N/A</gust><d>127</d><t>SE</t></wind><bt>P Cloudy</bt><ppcp>10</ppcp><hmid>75</hmid></part><part p="n"><icon>29</icon><t>Partly Cloudy</t><wind><s>6</s><gust>N/A</gust><d>133</d><t>SE</t></wind><bt>P Cloudy</bt><ppcp>10</ppcp><hmid>80</hmid></part></day><day d="5" t="Sunday" dt="Feb 15"><hi>28</hi><low>21</low><sunr>7:00 AM</sunr><suns>6:58 PM</suns><part p="d"><icon>30</icon><t>Partly Cloudy</t><wind><s>14</s><gust>N/A</gust><d>130</d><t>SE</t></wind><bt>P Cloudy</bt><ppcp>10</ppcp><hmid>80</hmid></part><part p="n"><icon>45</icon><t>Scattered Showers</t><wind><s>8</s><gust>N/A</gust><d>148</d><t>SSE</t></wind><bt>Sct Showers</bt><ppcp>30</ppcp><hmid>84</hmid></part></day><day d="6" t="Monday" dt="Feb 16"><hi>27</hi><low>21</low><sunr>6:01 AM</sunr><suns>6:57 PM</suns><part p="d"><icon>38</icon><t>Scattered T-Storms</t><wind><s>13</s><gust>N/A</gust><d>129</d><t>SE</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>87</hmid></part><part p="n"><icon>47</icon><t>Scattered T-Storms</t><wind><s>5</s><gust>N/A</gust><d>136</d><t>SE</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>89</hmid></part></day><day d="7" t="Tuesday" dt="Feb 17"><hi>27</hi><low>21</low><sunr>6:02 AM</sunr><suns>6:57 PM</suns><part p="d"><icon>38</icon><t>Scattered T-Storms</t><wind><s>11</s><gust>N/A</gust><d>264</d><t>W</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>87</hmid></part><part p="n"><icon>47</icon><t>Scattered T-Storms</t><wind><s>5</s><gust>N/A</gust><d>156</d><t>SSE</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>91</hmid></part></day><day d="8" t="Wednesday" dt="Feb 18"><hi>28</hi><low>21</low><sunr>6:02 AM</sunr><suns>6:56 PM</suns><part p="d"><icon>38</icon><t>Scattered T-Storms</t><wind><s>13</s><gust>N/A</gust><d>114</d><t>ESE</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>85</hmid></part><part p="n"><icon>47</icon><t>Scattered T-Storms</t><wind><s>6</s><gust>N/A</gust><d>128</d><t>SE</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>89</hmid></part></day><day d="9" t="Thursday" dt="Feb 19"><hi>28</hi><low>22</low><sunr>6:03 AM</sunr><suns>6:55 PM</suns><part p="d"><icon>38</icon><t>Scattered T-Storms</t><wind><s>13</s><gust>N/A</gust><d>123</d><t>ESE</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>86</hmid></part><part p="n"><icon>47</icon><t>Scattered T-Storms</t><wind><s>6</s><gust>N/A</gust><d>121</d><t>ESE</t></wind><bt>Sct T-Storms</bt><ppcp>60</ppcp><hmid>87</hmid></part></day></dayf></weather>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_eweather_locations`
--

CREATE TABLE IF NOT EXISTS `jos_eweather_locations` (
  `id` int(4) NOT NULL auto_increment,
  `city` varchar(50) default NULL,
  `country` varchar(50) NOT NULL default '0',
  `region` varchar(50) NOT NULL default '0',
  `loc_id` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=705 ;

--
-- Extraindo dados da tabela `jos_eweather_locations`
--

INSERT INTO `jos_eweather_locations` (`id`, `city`, `country`, `region`, `loc_id`) VALUES
(1, 'Adamantina', 'Brazil', 'South America', 'BRXX0001'),
(2, 'Alagoinhas', 'Brazil', 'South America', 'BRXX0002'),
(3, 'Alegrete', 'Brazil', 'South America', 'BRXX0003'),
(4, 'Altamira', 'Brazil', 'South America', 'BRXX0005'),
(5, 'Americana', 'Brazil', 'South America', 'BRXX0006'),
(6, 'Anapolis', 'Brazil', 'South America', 'BRXX0007'),
(7, 'Anastacio', 'Brazil', 'South America', 'BRXX0008'),
(8, 'Andradina', 'Brazil', 'South America', 'BRXX0009'),
(9, 'Apucarana', 'Brazil', 'South America', 'BRXX0010'),
(10, 'Aracaju', 'Brazil', 'South America', 'BRXX0011'),
(11, 'Aracati', 'Brazil', 'South America', 'BRXX0012'),
(12, 'Aracatuba', 'Brazil', 'South America', 'BRXX0013'),
(13, 'Aracruz', 'Brazil', 'South America', 'BRXX0014'),
(14, 'Arapiraca', 'Brazil', 'South America', 'BRXX0015'),
(15, 'Arapongas', 'Brazil', 'South America', 'BRXX0016'),
(16, 'Araucaria', 'Brazil', 'South America', 'BRXX0017'),
(17, 'Araxa', 'Brazil', 'South America', 'BRXX0018'),
(18, 'Aripuana', 'Brazil', 'South America', 'BRXX0019'),
(19, 'Auriflama', 'Brazil', 'South America', 'BRXX0020'),
(20, 'Avare', 'Brazil', 'South America', 'BRXX0021'),
(21, 'Bage', 'Brazil', 'South America', 'BRXX0022'),
(22, 'Balsamo', 'Brazil', 'South America', 'BRXX0023'),
(23, 'Balsas', 'Brazil', 'South America', 'BRXX0024'),
(24, 'Bandeirantes', 'Brazil', 'South America', 'BRXX0025'),
(25, 'Barbacena', 'Brazil', 'South America', 'BRXX0026'),
(26, 'Barcelos', 'Brazil', 'South America', 'BRXX0027'),
(27, 'Barra do Garcas', 'Brazil', 'South America', 'BRXX0028'),
(28, 'Barra Mansa', 'Brazil', 'South America', 'BRXX0029'),
(29, 'Barreiras', 'Brazil', 'South America', 'BRXX0030'),
(30, 'Bauru', 'Brazil', 'South America', 'BRXX0031'),
(31, 'Belem', 'Brazil', 'South America', 'BRXX0032'),
(32, 'Belo Horizonte', 'Brazil', 'South America', 'BRXX0033'),
(33, 'Bento Goncalves', 'Brazil', 'South America', 'BRXX0034'),
(34, 'Biguacu', 'Brazil', 'South America', 'BRXX0035'),
(35, 'Birigui', 'Brazil', 'South America', 'BRXX0036'),
(36, 'Blumenau', 'Brazil', 'South America', 'BRXX0037'),
(37, 'Boa Vista', 'Brazil', 'South America', 'BRXX0038'),
(38, 'Bom Despacho', 'Brazil', 'South America', 'BRXX0039'),
(39, 'Bom Jesus da Lapa', 'Brazil', 'South America', 'BRXX0040'),
(40, 'Botucatu', 'Brazil', 'South America', 'BRXX0041'),
(41, 'Braganca Paulista', 'Brazil', 'South America', 'BRXX0042'),
(42, 'Brasilia', 'Brazil', 'South America', 'BRXX0043'),
(43, 'Brusque', 'Brazil', 'South America', 'BRXX0044'),
(44, 'Cabo Frio', 'Brazil', 'South America', 'BRXX0045'),
(45, 'Caceres', 'Brazil', 'South America', 'BRXX0046'),
(46, 'Cachoeiro de Itap', 'Brazil', 'South America', 'BRXX0048'),
(47, 'Campina Grande', 'Brazil', 'South America', 'BRXX0049'),
(48, 'Campinas', 'Brazil', 'South America', 'BRXX0050'),
(49, 'Campo Grande', 'Brazil', 'South America', 'BRXX0051'),
(50, 'Campo Largo', 'Brazil', 'South America', 'BRXX0052'),
(51, 'Campo Mourao', 'Brazil', 'South America', 'BRXX0053'),
(52, 'Campos', 'Brazil', 'South America', 'BRXX0054'),
(53, 'Campos do Jordao', 'Brazil', 'South America', 'BRXX0055'),
(54, 'Canoas', 'Brazil', 'South America', 'BRXX0056'),
(55, 'Canoinhas', 'Brazil', 'South America', 'BRXX0057'),
(56, 'Canto do Buriti', 'Brazil', 'South America', 'BRXX0058'),
(57, 'Caraguatatuba', 'Brazil', 'South America', 'BRXX0059'),
(58, 'Carapina', 'Brazil', 'South America', 'BRXX0060'),
(59, 'Caratinga', 'Brazil', 'South America', 'BRXX0061'),
(60, 'Caravelas', 'Brazil', 'South America', 'BRXX0062'),
(61, 'Cascavel', 'Brazil', 'South America', 'BRXX0063'),
(62, 'Castro', 'Brazil', 'South America', 'BRXX0064'),
(63, 'Catalao', 'Brazil', 'South America', 'BRXX0065'),
(64, 'Catanduva', 'Brazil', 'South America', 'BRXX0066'),
(65, 'Caxias', 'Brazil', 'South America', 'BRXX0067'),
(66, 'Caxias do Sul', 'Brazil', 'South America', 'BRXX0068'),
(67, 'Chapeco', 'Brazil', 'South America', 'BRXX0069'),
(68, 'Colatina', 'Brazil', 'South America', 'BRXX0070'),
(69, 'Colombo', 'Brazil', 'South America', 'BRXX0071'),
(70, 'Conselheiro Lafai', 'Brazil', 'South America', 'BRXX0072'),
(71, 'Cornelio Procopio', 'Brazil', 'South America', 'BRXX0073'),
(72, 'Corumba', 'Brazil', 'South America', 'BRXX0074'),
(73, 'Coxim', 'Brazil', 'South America', 'BRXX0075'),
(74, 'Criciuma', 'Brazil', 'South America', 'BRXX0076'),
(75, 'Cruzeta', 'Brazil', 'South America', 'BRXX0077'),
(76, 'Cuiaba', 'Brazil', 'South America', 'BRXX0078'),
(77, 'Curitiba', 'Brazil', 'South America', 'BRXX0079'),
(78, 'Curitibanos', 'Brazil', 'South America', 'BRXX0080'),
(79, 'Curvelo', 'Brazil', 'South America', 'BRXX0081'),
(80, 'Diadema', 'Brazil', 'South America', 'BRXX0082'),
(81, 'Diamantina', 'Brazil', 'South America', 'BRXX0083'),
(82, 'Divinopolis', 'Brazil', 'South America', 'BRXX0084'),
(83, 'Dourados', 'Brazil', 'South America', 'BRXX0085'),
(84, 'Dracena', 'Brazil', 'South America', 'BRXX0086'),
(85, 'Duque de Caxias', 'Brazil', 'South America', 'BRXX0087'),
(86, 'Farroupilha', 'Brazil', 'South America', 'BRXX0088'),
(87, 'Feira de Santana', 'Brazil', 'South America', 'BRXX0089'),
(88, 'Fernandopolis', 'Brazil', 'South America', 'BRXX0090'),
(89, 'Florianopolis', 'Brazil', 'South America', 'BRXX0091'),
(90, 'Formosa', 'Brazil', 'South America', 'BRXX0092'),
(91, 'Fortaleza', 'Brazil', 'South America', 'BRXX0093'),
(92, 'Foz do Iguacu', 'Brazil', 'South America', 'BRXX0094'),
(93, 'Franca', 'Brazil', 'South America', 'BRXX0095'),
(94, 'Garanhuns', 'Brazil', 'South America', 'BRXX0096'),
(95, 'Garopaba', 'Brazil', 'South America', 'BRXX0097'),
(96, 'Gaspar', 'Brazil', 'South America', 'BRXX0098'),
(97, 'Goiania', 'Brazil', 'South America', 'BRXX0099'),
(98, 'Governador Valada', 'Brazil', 'South America', 'BRXX0100'),
(99, 'Gramado', 'Brazil', 'South America', 'BRXX0101'),
(100, 'Guaiba', 'Brazil', 'South America', 'BRXX0102'),
(101, 'Guarapari', 'Brazil', 'South America', 'BRXX0103'),
(102, 'Guarapuava', 'Brazil', 'South America', 'BRXX0104'),
(103, 'Guararapes', 'Brazil', 'South America', 'BRXX0105'),
(104, 'Guaratuba', 'Brazil', 'South America', 'BRXX0106'),
(105, 'Guarulhos', 'Brazil', 'South America', 'BRXX0107'),
(106, 'Hidrolandia', 'Brazil', 'South America', 'BRXX0108'),
(107, 'Iguape', 'Brazil', 'South America', 'BRXX0109'),
(108, 'Indaial', 'Brazil', 'South America', 'BRXX0110'),
(109, 'Inhumas', 'Brazil', 'South America', 'BRXX0111'),
(110, 'Ipatinga', 'Brazil', 'South America', 'BRXX0112'),
(111, 'Irati', 'Brazil', 'South America', 'BRXX0113'),
(112, 'Itaberaba', 'Brazil', 'South America', 'BRXX0114'),
(113, 'Itajai', 'Brazil', 'South America', 'BRXX0115'),
(114, 'Itaperuna', 'Brazil', 'South America', 'BRXX0116'),
(115, 'Itapeva', 'Brazil', 'South America', 'BRXX0117'),
(116, 'Itaquari', 'Brazil', 'South America', 'BRXX0118'),
(117, 'Itaqui', 'Brazil', 'South America', 'BRXX0119'),
(118, 'Itauna', 'Brazil', 'South America', 'BRXX0120'),
(119, 'Itu', 'Brazil', 'South America', 'BRXX0121'),
(120, 'Ituiutaba', 'Brazil', 'South America', 'BRXX0122'),
(121, 'Jacareacanga', 'Brazil', 'South America', 'BRXX0123'),
(122, 'Jaciara', 'Brazil', 'South America', 'BRXX0124'),
(123, 'Janauba', 'Brazil', 'South America', 'BRXX0125'),
(124, 'Jaragua do Sul', 'Brazil', 'South America', 'BRXX0126'),
(125, 'Ji-Parana', 'Brazil', 'South America', 'BRXX0127'),
(126, 'Joao Pessoa', 'Brazil', 'South America', 'BRXX0128'),
(127, 'Joinville', 'Brazil', 'South America', 'BRXX0130'),
(128, 'Juiz de Fora', 'Brazil', 'South America', 'BRXX0131'),
(129, 'Labrea', 'Brazil', 'South America', 'BRXX0133'),
(130, 'Limeira', 'Brazil', 'South America', 'BRXX0134'),
(131, 'Linhares', 'Brazil', 'South America', 'BRXX0135'),
(132, 'Santana do Livram', 'Brazil', 'South America', 'BRXX0136'),
(133, 'Londrina', 'Brazil', 'South America', 'BRXX0137'),
(134, 'Lorena', 'Brazil', 'South America', 'BRXX0138'),
(135, 'Lourenco', 'Brazil', 'South America', 'BRXX0139'),
(136, 'Luziania', 'Brazil', 'South America', 'BRXX0140'),
(137, 'Barra de Macae', 'Brazil', 'South America', 'BRXX0141'),
(138, 'Macapa', 'Brazil', 'South America', 'BRXX0142'),
(139, 'Maceio', 'Brazil', 'South America', 'BRXX0143'),
(140, 'Mafra', 'Brazil', 'South America', 'BRXX0144'),
(141, 'Mage', 'Brazil', 'South America', 'BRXX0145'),
(142, 'Manaus', 'Brazil', 'South America', 'BRXX0146'),
(143, 'Manhuacu', 'Brazil', 'South America', 'BRXX0147'),
(144, 'Manicore', 'Brazil', 'South America', 'BRXX0148'),
(145, 'Maraba', 'Brazil', 'South America', 'BRXX0149'),
(146, 'Marilia', 'Brazil', 'South America', 'BRXX0150'),
(147, 'Maringa', 'Brazil', 'South America', 'BRXX0151'),
(148, 'Maua', 'Brazil', 'South America', 'BRXX0152'),
(149, 'Mazagao', 'Brazil', 'South America', 'BRXX0153'),
(150, 'Medianeira', 'Brazil', 'South America', 'BRXX0154'),
(151, 'Montes Claros', 'Brazil', 'South America', 'BRXX0155'),
(152, 'Morrinhos', 'Brazil', 'South America', 'BRXX0156'),
(153, 'Mossoro', 'Brazil', 'South America', 'BRXX0157'),
(154, 'Natal', 'Brazil', 'South America', 'BRXX0158'),
(155, 'Niteroi', 'Brazil', 'South America', 'BRXX0159'),
(156, 'Nova Iguacu', 'Brazil', 'South America', 'BRXX0161'),
(157, 'Nova Lima', 'Brazil', 'South America', 'BRXX0162'),
(158, 'Novo Hamburgo', 'Brazil', 'South America', 'BRXX0163'),
(159, 'Olinda', 'Brazil', 'South America', 'BRXX0164'),
(160, 'Osasco', 'Brazil', 'South America', 'BRXX0165'),
(161, 'Ourinhos', 'Brazil', 'South America', 'BRXX0166'),
(162, 'Pacajus', 'Brazil', 'South America', 'BRXX0167'),
(163, 'Palmares', 'Brazil', 'South America', 'BRXX0168'),
(164, 'Palmas', 'Brazil', 'South America', 'BRXX0169'),
(165, 'Paracatu', 'Brazil', 'South America', 'BRXX0170'),
(166, 'Paraguacu Paulist', 'Brazil', 'South America', 'BRXX0171'),
(167, 'Paranagua', 'Brazil', 'South America', 'BRXX0172'),
(168, 'Parintins', 'Brazil', 'South America', 'BRXX0173'),
(169, 'Passo Fundo', 'Brazil', 'South America', 'BRXX0174'),
(170, 'Pauini', 'Brazil', 'South America', 'BRXX0175'),
(171, 'Pelotas', 'Brazil', 'South America', 'BRXX0176'),
(172, 'Penapolis', 'Brazil', 'South America', 'BRXX0177'),
(173, 'Peruibe', 'Brazil', 'South America', 'BRXX0178'),
(174, 'Petrolina', 'Brazil', 'South America', 'BRXX0179'),
(175, 'Petropolis', 'Brazil', 'South America', 'BRXX0180'),
(176, 'Piracicaba', 'Brazil', 'South America', 'BRXX0181'),
(177, 'Pirapora', 'Brazil', 'South America', 'BRXX0182'),
(178, 'Pocos de Caldas', 'Brazil', 'South America', 'BRXX0183'),
(179, 'Ponta Grossa', 'Brazil', 'South America', 'BRXX0184'),
(180, 'Ponta Pora', 'Brazil', 'South America', 'BRXX0185'),
(181, 'Porto Alegre', 'Brazil', 'South America', 'BRXX0186'),
(182, 'Porto Artur', 'Brazil', 'South America', 'BRXX0187'),
(183, 'Porto Feliz', 'Brazil', 'South America', 'BRXX0188'),
(184, 'Porto Nacional', 'Brazil', 'South America', 'BRXX0189'),
(185, 'Porto Velho', 'Brazil', 'South America', 'BRXX0190'),
(186, 'Presidente Pruden', 'Brazil', 'South America', 'BRXX0192'),
(187, 'Primavera do Lest', 'Brazil', 'South America', 'BRXX0193'),
(188, 'Quixeramobim', 'Brazil', 'South America', 'BRXX0194'),
(189, 'Recife', 'Brazil', 'South America', 'BRXX0195'),
(190, 'Registro', 'Brazil', 'South America', 'BRXX0196'),
(191, 'Resende', 'Brazil', 'South America', 'BRXX0197'),
(192, 'Ribeirao Preto', 'Brazil', 'South America', 'BRXX0198'),
(193, 'Rio Branco', 'Brazil', 'South America', 'BRXX0199'),
(194, 'Rio de Janeiro', 'Brazil', 'South America', 'BRXX0201'),
(195, 'Rio Grande', 'Brazil', 'South America', 'BRXX0202'),
(196, 'Rio Grande da Ser', 'Brazil', 'South America', 'BRXX0203'),
(197, 'Rio Largo', 'Brazil', 'South America', 'BRXX0204'),
(198, 'Rio Verde', 'Brazil', 'South America', 'BRXX0205'),
(199, 'Rolandia', 'Brazil', 'South America', 'BRXX0206'),
(200, 'Rondonopolis', 'Brazil', 'South America', 'BRXX0207'),
(201, 'Rosairo', 'Brazil', 'South America', 'BRXX0208'),
(202, 'Rosario Oeste', 'Brazil', 'South America', 'BRXX0209'),
(203, 'Rozendo', 'Brazil', 'South America', 'BRXX0210'),
(204, 'Sabara', 'Brazil', 'South America', 'BRXX0211'),
(205, 'Salto do Urubupun', 'Brazil', 'South America', 'BRXX0212'),
(206, 'Santa Isabel', 'Brazil', 'South America', 'BRXX0214'),
(207, 'Santa Maria', 'Brazil', 'South America', 'BRXX0215'),
(208, 'Santarem', 'Brazil', 'South America', 'BRXX0216'),
(209, 'Santo Andre', 'Brazil', 'South America', 'BRXX0217'),
(210, 'Santos Dumont', 'Brazil', 'South America', 'BRXX0219'),
(211, 'Sao Bernardo do C', 'Brazil', 'South America', 'BRXX0220'),
(212, 'Sao Caetano', 'Brazil', 'South America', 'BRXX0221'),
(213, 'Sao Carlos', 'Brazil', 'South America', 'BRXX0222'),
(214, 'Sao Felix do Xing', 'Brazil', 'South America', 'BRXX0223'),
(215, 'Sao Gabriel da Ca', 'Brazil', 'South America', 'BRXX0224'),
(216, 'Sao Joao de Barra', 'Brazil', 'South America', 'BRXX0225'),
(217, 'Sao Joaquim', 'Brazil', 'South America', 'BRXX0226'),
(218, 'Sao Jose do Rio P', 'Brazil', 'South America', 'BRXX0227'),
(219, 'Sao Jose Dos Camp', 'Brazil', 'South America', 'BRXX0228'),
(220, 'Sao Jose dos Pinh', 'Brazil', 'South America', 'BRXX0229'),
(221, 'Sao Leopoldo', 'Brazil', 'South America', 'BRXX0230'),
(222, 'Sao Luis', 'Brazil', 'South America', 'BRXX0231'),
(223, 'Sao Paulo', 'Brazil', 'South America', 'BRXX0232'),
(224, 'Sao Vicente', 'Brazil', 'South America', 'BRXX0233'),
(225, 'Serra', 'Brazil', 'South America', 'BRXX0234'),
(226, 'Sete Lagoas', 'Brazil', 'South America', 'BRXX0235'),
(227, 'Sinop', 'Brazil', 'South America', 'BRXX0236'),
(228, 'Sorocaba', 'Brazil', 'South America', 'BRXX0237'),
(229, 'Tabatinga', 'Brazil', 'South America', 'BRXX0238'),
(230, 'Tangara', 'Brazil', 'South America', 'BRXX0239'),
(231, 'Tarauaca', 'Brazil', 'South America', 'BRXX0240'),
(232, 'Tatui', 'Brazil', 'South America', 'BRXX0241'),
(233, 'Taubate', 'Brazil', 'South America', 'BRXX0242'),
(234, 'Tefe', 'Brazil', 'South America', 'BRXX0243'),
(235, 'Terenos', 'Brazil', 'South America', 'BRXX0244'),
(236, 'Teresina', 'Brazil', 'South America', 'BRXX0245'),
(237, 'Tijucas', 'Brazil', 'South America', 'BRXX0246'),
(238, 'Tres Lagoas', 'Brazil', 'South America', 'BRXX0247'),
(239, 'Trindade', 'Brazil', 'South America', 'BRXX0248'),
(240, 'Tubarao', 'Brazil', 'South America', 'BRXX0249'),
(241, 'Tupa', 'Brazil', 'South America', 'BRXX0250'),
(242, 'Ubatuba', 'Brazil', 'South America', 'BRXX0251'),
(243, 'Uberaba', 'Brazil', 'South America', 'BRXX0252'),
(244, 'Uberlandia', 'Brazil', 'South America', 'BRXX0253'),
(245, 'Uruguaiana', 'Brazil', 'South America', 'BRXX0254'),
(246, 'Varzea Grande', 'Brazil', 'South America', 'BRXX0255'),
(247, 'Vera Cruz', 'Brazil', 'South America', 'BRXX0256'),
(248, 'Viamao', 'Brazil', 'South America', 'BRXX0257'),
(249, 'Vilhena', 'Brazil', 'South America', 'BRXX0258'),
(250, 'Vitoria', 'Brazil', 'South America', 'BRXX0259'),
(251, 'Vitoria da Conqui', 'Brazil', 'South America', 'BRXX0260'),
(252, 'Votuporanga', 'Brazil', 'South America', 'BRXX0261'),
(253, 'Angra dos Reis', 'Brazil', 'South America', 'BRXX0263'),
(254, 'Araguari', 'Brazil', 'South America', 'BRXX0264'),
(255, 'Araraquara', 'Brazil', 'South America', 'BRXX0265'),
(256, 'Arvoredo', 'Brazil', 'South America', 'BRXX0266'),
(257, 'Assis', 'Brazil', 'South America', 'BRXX0267'),
(258, 'Bertioga', 'Brazil', 'South America', 'BRXX0268'),
(259, 'Buzios', 'Brazil', 'South America', 'BRXX0269'),
(260, 'Cacapava', 'Brazil', 'South America', 'BRXX0270'),
(261, 'Camboriu', 'Brazil', 'South America', 'BRXX0271'),
(262, 'Carapicuiba', 'Brazil', 'South America', 'BRXX0272'),
(263, 'Caruaru', 'Brazil', 'South America', 'BRXX0273'),
(264, 'Castanhal', 'Brazil', 'South America', 'BRXX0274'),
(265, 'Cianorte', 'Brazil', 'South America', 'BRXX0275'),
(266, 'Concordia', 'Brazil', 'South America', 'BRXX0276'),
(267, 'Cruz Alta', 'Brazil', 'South America', 'BRXX0277'),
(268, 'Currais Novos', 'Brazil', 'South America', 'BRXX0278'),
(269, 'Erexim', 'Brazil', 'South America', 'BRXX0279'),
(270, 'Gravatai', 'Brazil', 'South America', 'BRXX0280'),
(271, 'Guaruja', 'Brazil', 'South America', 'BRXX0281'),
(272, 'Ilhabela', 'Brazil', 'South America', 'BRXX0282'),
(273, 'Ilheus', 'Brazil', 'South America', 'BRXX0283'),
(274, 'Itabaiana', 'Brazil', 'South America', 'BRXX0284'),
(275, 'Itabuna', 'Brazil', 'South America', 'BRXX0285'),
(276, 'Itanhaem', 'Brazil', 'South America', 'BRXX0286'),
(277, 'Itapetininga', 'Brazil', 'South America', 'BRXX0287'),
(278, 'Muribeca dos Guar', 'Brazil', 'South America', 'BRXX0288'),
(279, 'Jequie', 'Brazil', 'South America', 'BRXX0289'),
(280, 'Juazeiro do Norte', 'Brazil', 'South America', 'BRXX0290'),
(281, 'Lages', 'Brazil', 'South America', 'BRXX0291'),
(282, 'Laguna', 'Brazil', 'South America', 'BRXX0292'),
(283, 'Lins', 'Brazil', 'South America', 'BRXX0293'),
(284, 'Maracanau', 'Brazil', 'South America', 'BRXX0294'),
(285, 'Maresias', 'Brazil', 'South America', 'BRXX0295'),
(286, 'Mogi Das Cruzes', 'Brazil', 'South America', 'BRXX0296'),
(287, 'Mogi-Guacu', 'Brazil', 'South America', 'BRXX0297'),
(288, 'Mongagua', 'Brazil', 'South America', 'BRXX0298'),
(289, 'Nilopolis', 'Brazil', 'South America', 'BRXX0299'),
(290, 'Parati', 'Brazil', 'South America', 'BRXX0300'),
(291, 'Patos de Minas', 'Brazil', 'South America', 'BRXX0302'),
(292, 'Patrocinio', 'Brazil', 'South America', 'BRXX0303'),
(293, 'Paulista', 'Brazil', 'South America', 'BRXX0304'),
(294, 'Pedra Azul', 'Brazil', 'South America', 'BRXX0305'),
(295, 'Porto Seguro', 'Brazil', 'South America', 'BRXX0306'),
(296, 'Santa Branca', 'Brazil', 'South America', 'BRXX0307'),
(297, 'Santa Cruz do Sul', 'Brazil', 'South America', 'BRXX0308'),
(298, 'Sao Joao del Rei', 'Brazil', 'South America', 'BRXX0309'),
(299, 'Sao Mateus', 'Brazil', 'South America', 'BRXX0310'),
(300, 'Sao Sebastiao', 'Brazil', 'South America', 'BRXX0311'),
(301, 'Sobral', 'Brazil', 'South America', 'BRXX0312'),
(302, 'Sumare', 'Brazil', 'South America', 'BRXX0313'),
(303, 'Teofilo Otoni', 'Brazil', 'South America', 'BRXX0314'),
(304, 'Teresopolis', 'Brazil', 'South America', 'BRXX0315'),
(305, 'Timon', 'Brazil', 'South America', 'BRXX0316'),
(306, 'Umuarama', 'Brazil', 'South America', 'BRXX0317'),
(307, 'Varginha', 'Brazil', 'South America', 'BRXX0318'),
(308, 'Vila Velha', 'Brazil', 'South America', 'BRXX0319'),
(309, 'Volta Redonda', 'Brazil', 'South America', 'BRXX0320'),
(310, 'Ilheus Aeroporto', 'Brazil', 'South America', 'BRXX0323'),
(311, 'Santa Marta', 'Brazil', 'South America', 'BRXX0327'),
(312, 'Boraciia', 'Brazil', 'South America', 'BRXX0333'),
(313, 'Juquia', 'Brazil', 'South America', 'BRXX0336'),
(314, 'Alta Floresta', 'Brazil', 'South America', 'BRXX0339'),
(315, 'Imperatriz', 'Brazil', 'South America', 'BRXX0340'),
(316, 'Santana do Piragu', 'Brazil', 'South America', 'BRXX0341'),
(317, 'Poa', 'Brazil', 'South America', 'BRXX0342'),
(318, 'Paulinia', 'Brazil', 'South America', 'BRXX0343'),
(319, 'Sao Roque', 'Brazil', 'South America', 'BRXX0344'),
(320, 'Cabreuva', 'Brazil', 'South America', 'BRXX0345'),
(321, 'Abaete', 'Brazil', 'South America', 'BRXX0346'),
(322, 'Afua', 'Brazil', 'South America', 'BRXX0347'),
(323, 'Aguai', 'Brazil', 'South America', 'BRXX0348'),
(324, 'Aguas de Sao Pedr', 'Brazil', 'South America', 'BRXX0349'),
(325, 'Aguas Formosas', 'Brazil', 'South America', 'BRXX0350'),
(326, 'Aimores', 'Brazil', 'South America', 'BRXX0351'),
(327, 'Alpinopolis', 'Brazil', 'South America', 'BRXX0352'),
(328, 'Alvaraes', 'Brazil', 'South America', 'BRXX0353'),
(329, 'Alvares Machado', 'Brazil', 'South America', 'BRXX0354'),
(330, 'Andira', 'Brazil', 'South America', 'BRXX0355'),
(331, 'Apiai', 'Brazil', 'South America', 'BRXX0356'),
(332, 'Araguaina', 'Brazil', 'South America', 'BRXX0357'),
(333, 'Aruja', 'Brazil', 'South America', 'BRXX0358'),
(334, 'Bambui', 'Brazil', 'South America', 'BRXX0359'),
(335, 'Barra de Sao Fran', 'Brazil', 'South America', 'BRXX0360'),
(336, 'Barra do Pirai', 'Brazil', 'South America', 'BRXX0361'),
(337, 'Boa Esperanca', 'Brazil', 'South America', 'BRXX0362'),
(338, 'Bocaiuva', 'Brazil', 'South America', 'BRXX0363'),
(339, 'Jau', 'Brazil', 'South America', 'BRXX0364'),
(340, 'Caete', 'Brazil', 'South America', 'BRXX0365'),
(341, 'Capao Bonito', 'Brazil', 'South America', 'BRXX0366'),
(342, 'Capao da Canoa', 'Brazil', 'South America', 'BRXX0367'),
(343, 'Caparao', 'Brazil', 'South America', 'BRXX0368'),
(344, 'Caracarai', 'Brazil', 'South America', 'BRXX0369'),
(345, 'Cerqueira Cesar', 'Brazil', 'South America', 'BRXX0370'),
(346, 'Cesario Lange', 'Brazil', 'South America', 'BRXX0371'),
(347, 'Cipo', 'Brazil', 'South America', 'BRXX0372'),
(348, 'Codajas', 'Brazil', 'South America', 'BRXX0373'),
(349, 'Cristalandia', 'Brazil', 'South America', 'BRXX0374'),
(350, 'Cubatao', 'Brazil', 'South America', 'BRXX0375'),
(351, 'Curuca', 'Brazil', 'South America', 'BRXX0376'),
(352, 'Espirito Santo do', 'Brazil', 'South America', 'BRXX0377'),
(353, 'Feijo', 'Brazil', 'South America', 'BRXX0378'),
(354, 'Filadelfia', 'Brazil', 'South America', 'BRXX0379'),
(355, 'Francisco Sa', 'Brazil', 'South America', 'BRXX0380'),
(356, 'Grao Mogol', 'Brazil', 'South America', 'BRXX0381'),
(357, 'Guaira', 'Brazil', 'South America', 'BRXX0382'),
(358, 'Guaratingueta', 'Brazil', 'South America', 'BRXX0383'),
(359, 'Gurupa', 'Brazil', 'South America', 'BRXX0384'),
(360, 'Humaita', 'Brazil', 'South America', 'BRXX0385'),
(361, 'Ibiai', 'Brazil', 'South America', 'BRXX0386'),
(362, 'Ibiuna', 'Brazil', 'South America', 'BRXX0387'),
(363, 'Iepe', 'Brazil', 'South America', 'BRXX0388'),
(364, 'Ipero', 'Brazil', 'South America', 'BRXX0389'),
(365, 'Ipiiba', 'Brazil', 'South America', 'BRXX0390'),
(366, 'Irai', 'Brazil', 'South America', 'BRXX0391'),
(367, 'Irece', 'Brazil', 'South America', 'BRXX0392'),
(368, 'Itaborai', 'Brazil', 'South America', 'BRXX0393'),
(369, 'Itaguai', 'Brazil', 'South America', 'BRXX0394'),
(370, 'Itai', 'Brazil', 'South America', 'BRXX0395'),
(371, 'Itapolis', 'Brazil', 'South America', 'BRXX0396'),
(372, 'Ivai', 'Brazil', 'South America', 'BRXX0397'),
(373, 'Jacarei', 'Brazil', 'South America', 'BRXX0398'),
(374, 'Januaria', 'Brazil', 'South America', 'BRXX0399'),
(375, 'Joao Neiva', 'Brazil', 'South America', 'BRXX0400'),
(376, 'Jose Bonifacio', 'Brazil', 'South America', 'BRXX0402'),
(377, 'Jurua', 'Brazil', 'South America', 'BRXX0403'),
(378, 'Lindoia', 'Brazil', 'South America', 'BRXX0404'),
(379, 'Lucelia', 'Brazil', 'South America', 'BRXX0405'),
(380, 'Morro do Chapeu', 'Brazil', 'South America', 'BRXX0406'),
(381, 'Mairipora', 'Brazil', 'South America', 'BRXX0407'),
(382, 'Mancio Lima', 'Brazil', 'South America', 'BRXX0408'),
(383, 'Marataizes', 'Brazil', 'South America', 'BRXX0409'),
(384, 'Marica', 'Brazil', 'South America', 'BRXX0410'),
(385, 'Martinopolis', 'Brazil', 'South America', 'BRXX0411'),
(386, 'Matao', 'Brazil', 'South America', 'BRXX0412'),
(387, 'Maues', 'Brazil', 'South America', 'BRXX0413'),
(388, 'Mirandopolis', 'Brazil', 'South America', 'BRXX0414'),
(389, 'Muriae', 'Brazil', 'South America', 'BRXX0415'),
(390, 'Nazare Paulista', 'Brazil', 'South America', 'BRXX0416'),
(391, 'Nova Venecia', 'Brazil', 'South America', 'BRXX0417'),
(392, 'Novo Airao', 'Brazil', 'South America', 'BRXX0418'),
(393, 'Obidos', 'Brazil', 'South America', 'BRXX0419'),
(394, 'Olimpia', 'Brazil', 'South America', 'BRXX0420'),
(395, 'Oriximina', 'Brazil', 'South America', 'BRXX0421'),
(396, 'Orlandia', 'Brazil', 'South America', 'BRXX0422'),
(397, 'Para de Minas', 'Brazil', 'South America', 'BRXX0423'),
(398, 'Parana', 'Brazil', 'South America', 'BRXX0424'),
(399, 'Paulinia', 'Brazil', 'South America', 'BRXX0425'),
(400, 'Pirajai', 'Brazil', 'South America', 'BRXX0426'),
(401, 'Pirajui', 'Brazil', 'South America', 'BRXX0427'),
(402, 'Poco Fundo', 'Brazil', 'South America', 'BRXX0428'),
(403, 'Pompeia', 'Brazil', 'South America', 'BRXX0429'),
(404, 'Pompeu', 'Brazil', 'South America', 'BRXX0430'),
(405, 'Ponte Alta do Bom', 'Brazil', 'South America', 'BRXX0431'),
(406, 'Presidente Medici', 'Brazil', 'South America', 'BRXX0432'),
(407, 'Propria', 'Brazil', 'South America', 'BRXX0433'),
(408, 'Regente Feijo', 'Brazil', 'South America', 'BRXX0434'),
(409, 'Ribeirao Pires', 'Brazil', 'South America', 'BRXX0436'),
(410, 'Santo Antonio de ', 'Brazil', 'South America', 'BRXX0437'),
(411, 'Sao Caetano de Od', 'Brazil', 'South America', 'BRXX0438'),
(412, 'Sao Luiz Gonzaga', 'Brazil', 'South America', 'BRXX0439'),
(413, 'Sao Jose do Rio P', 'Brazil', 'South America', 'BRXX0440'),
(414, 'Sao Joao da Boa V', 'Brazil', 'South America', 'BRXX0441'),
(415, 'Salesopolis', 'Brazil', 'South America', 'BRXX0442'),
(416, 'Santa Barbara', 'Brazil', 'South America', 'BRXX0443'),
(417, 'Santo Anastacio', 'Brazil', 'South America', 'BRXX0444'),
(418, 'Sao Fidelis', 'Brazil', 'South America', 'BRXX0445'),
(419, 'Sao Francisco', 'Brazil', 'South America', 'BRXX0446'),
(420, 'Sao Goncalo', 'Brazil', 'South America', 'BRXX0447'),
(421, 'Sao Joao da Barra', 'Brazil', 'South America', 'BRXX0448'),
(422, 'Sao Joao da Ponte', 'Brazil', 'South America', 'BRXX0449'),
(423, 'Sao Joaquim da Ba', 'Brazil', 'South America', 'BRXX0450'),
(424, 'Sao Luis do Parai', 'Brazil', 'South America', 'BRXX0451'),
(425, 'Sao Miguel Arcanj', 'Brazil', 'South America', 'BRXX0452'),
(426, 'Sao Pedro da Alde', 'Brazil', 'South America', 'BRXX0453'),
(427, 'Sao Romao', 'Brazil', 'South America', 'BRXX0454'),
(428, 'Sao Roque', 'Brazil', 'South America', 'BRXX0455'),
(429, 'Sao Simao', 'Brazil', 'South America', 'BRXX0456'),
(430, 'Sarapui', 'Brazil', 'South America', 'BRXX0457'),
(431, 'Senador Jose Porf', 'Brazil', 'South America', 'BRXX0458'),
(432, 'Sertaozinho', 'Brazil', 'South America', 'BRXX0459'),
(433, 'Silvianopolis', 'Brazil', 'South America', 'BRXX0460'),
(434, 'Senhor do Bonfim', 'Brazil', 'South America', 'BRXX0461'),
(435, 'Santo Antonio da ', 'Brazil', 'South America', 'BRXX0462'),
(436, 'Taboao da Serra', 'Brazil', 'South America', 'BRXX0463'),
(437, 'Tapaua', 'Brazil', 'South America', 'BRXX0464'),
(438, 'Tapirai', 'Brazil', 'South America', 'BRXX0465'),
(439, 'Tiete', 'Brazil', 'South America', 'BRXX0466'),
(440, 'Timoteo', 'Brazil', 'South America', 'BRXX0467'),
(441, 'Tocantinopolis', 'Brazil', 'South America', 'BRXX0468'),
(442, 'Tres Marias', 'Brazil', 'South America', 'BRXX0469'),
(443, 'Tres Pontas', 'Brazil', 'South America', 'BRXX0470'),
(444, 'Tres Rios', 'Brazil', 'South America', 'BRXX0471'),
(445, 'Uba', 'Brazil', 'South America', 'BRXX0472'),
(446, 'Unai', 'Brazil', 'South America', 'BRXX0473'),
(447, 'Urupes', 'Brazil', 'South America', 'BRXX0474'),
(448, 'Vargem Grande do ', 'Brazil', 'South America', 'BRXX0475'),
(449, 'Varzea Paulista', 'Brazil', 'South America', 'BRXX0476'),
(450, 'Vicosa', 'Brazil', 'South America', 'BRXX0477'),
(451, 'Visconde do Rio B', 'Brazil', 'South America', 'BRXX0478'),
(452, 'Agudos', 'Brazil', 'South America', 'BRXX0479'),
(453, 'Alegre', 'Brazil', 'South America', 'BRXX0480'),
(454, 'Alenquer', 'Brazil', 'South America', 'BRXX0481'),
(455, 'Alfenas', 'Brazil', 'South America', 'BRXX0482'),
(456, 'Almeirim', 'Brazil', 'South America', 'BRXX0483'),
(457, 'Almenara', 'Brazil', 'South America', 'BRXX0484'),
(458, 'Amparo', 'Brazil', 'South America', 'BRXX0485'),
(459, 'Ananindeua', 'Brazil', 'South America', 'BRXX0486'),
(460, 'Angatuba', 'Brazil', 'South America', 'BRXX0487'),
(461, 'Aparecida', 'Brazil', 'South America', 'BRXX0488'),
(462, 'Araguatins', 'Brazil', 'South America', 'BRXX0489'),
(463, 'Araruama', 'Brazil', 'South America', 'BRXX0490'),
(464, 'Arinos', 'Brazil', 'South America', 'BRXX0491'),
(465, 'Ariquemes', 'Brazil', 'South America', 'BRXX0492'),
(466, 'Atibaia', 'Brazil', 'South America', 'BRXX0493'),
(467, 'Baixo Guandu', 'Brazil', 'South America', 'BRXX0494'),
(468, 'Barra do Corda', 'Brazil', 'South America', 'BRXX0495'),
(469, 'Barretos', 'Brazil', 'South America', 'BRXX0496'),
(470, 'Barueri', 'Brazil', 'South America', 'BRXX0497'),
(471, 'Bebedouro', 'Brazil', 'South America', 'BRXX0498'),
(472, 'Belford Roxo', 'Brazil', 'South America', 'BRXX0499'),
(473, 'Belo Monte', 'Brazil', 'South America', 'BRXX0500'),
(474, 'Benjamin Constant', 'Brazil', 'South America', 'BRXX0502'),
(475, 'Betim', 'Brazil', 'South America', 'BRXX0503'),
(476, 'Boca do Acre', 'Brazil', 'South America', 'BRXX0504'),
(477, 'Boituva', 'Brazil', 'South America', 'BRXX0505'),
(478, 'Bom Jardim', 'Brazil', 'South America', 'BRXX0506'),
(479, 'Bom Jesus', 'Brazil', 'South America', 'BRXX0508'),
(480, 'Bom Jesus', 'Brazil', 'South America', 'BRXX0509'),
(481, 'Borba', 'Brazil', 'South America', 'BRXX0510'),
(482, 'Botelhos', 'Brazil', 'South America', 'BRXX0511'),
(483, 'Brotas', 'Brazil', 'South America', 'BRXX0512'),
(484, 'Buri', 'Brazil', 'South America', 'BRXX0513'),
(485, 'Buritis', 'Brazil', 'South America', 'BRXX0514'),
(486, 'Buritizeiro', 'Brazil', 'South America', 'BRXX0515'),
(487, 'Caapiranga', 'Brazil', 'South America', 'BRXX0516'),
(488, 'Cacoal', 'Brazil', 'South America', 'BRXX0517'),
(489, 'Caetite', 'Brazil', 'South America', 'BRXX0518'),
(490, 'Caieiras', 'Brazil', 'South America', 'BRXX0519'),
(491, 'Campestre', 'Brazil', 'South America', 'BRXX0520'),
(492, 'Campo Belo', 'Brazil', 'South America', 'BRXX0521'),
(493, 'Campos Novos', 'Brazil', 'South America', 'BRXX0522'),
(494, 'Canavieiras', 'Brazil', 'South America', 'BRXX0523'),
(495, 'Cantagalo', 'Brazil', 'South America', 'BRXX0524'),
(496, 'Canutama', 'Brazil', 'South America', 'BRXX0525'),
(497, 'Capanema', 'Brazil', 'South America', 'BRXX0526'),
(498, 'Capela do Alto', 'Brazil', 'South America', 'BRXX0527'),
(499, 'Capelinha', 'Brazil', 'South America', 'BRXX0528'),
(500, 'Capivari', 'Brazil', 'South America', 'BRXX0529'),
(501, 'Carangola', 'Brazil', 'South America', 'BRXX0530'),
(502, 'Carbonita', 'Brazil', 'South America', 'BRXX0531'),
(503, 'Carinhanha', 'Brazil', 'South America', 'BRXX0532'),
(504, 'Carmo da Cachoeir', 'Brazil', 'South America', 'BRXX0533'),
(505, 'Carmo do Rio Clar', 'Brazil', 'South America', 'BRXX0534'),
(506, 'Carolina', 'Brazil', 'South America', 'BRXX0535'),
(507, 'Carvoeiro', 'Brazil', 'South America', 'BRXX0536'),
(508, 'Casa Branca', 'Brazil', 'South America', 'BRXX0537'),
(509, 'Castelo', 'Brazil', 'South America', 'BRXX0538'),
(510, 'Cataguases', 'Brazil', 'South America', 'BRXX0539'),
(511, 'Cerquilho', 'Brazil', 'South America', 'BRXX0540'),
(512, 'Coelho da Rocha', 'Brazil', 'South America', 'BRXX0541'),
(513, 'Congonhas', 'Brazil', 'South America', 'BRXX0542'),
(514, 'Contagem', 'Brazil', 'South America', 'BRXX0543'),
(515, 'Cordeiro', 'Brazil', 'South America', 'BRXX0544'),
(516, 'Corinto', 'Brazil', 'South America', 'BRXX0545'),
(517, 'Coronel Fabrician', 'Brazil', 'South America', 'BRXX0546'),
(518, 'Cotia', 'Brazil', 'South America', 'BRXX0547'),
(519, 'Cruzeiro', 'Brazil', 'South America', 'BRXX0548'),
(520, 'Cruzeiro do Sul', 'Brazil', 'South America', 'BRXX0549'),
(521, 'Diamantino', 'Brazil', 'South America', 'BRXX0550'),
(522, 'Duartina', 'Brazil', 'South America', 'BRXX0551'),
(523, 'Ecoporanga', 'Brazil', 'South America', 'BRXX0552'),
(524, 'Embu', 'Brazil', 'South America', 'BRXX0553'),
(525, 'Encruzilhada do S', 'Brazil', 'South America', 'BRXX0554'),
(526, 'Espinosa', 'Brazil', 'South America', 'BRXX0555'),
(527, 'Floriano', 'Brazil', 'South America', 'BRXX0556'),
(528, 'Fonte Boa', 'Brazil', 'South America', 'BRXX0557'),
(529, 'Formoso', 'Brazil', 'South America', 'BRXX0558'),
(530, 'Francisco Morato', 'Brazil', 'South America', 'BRXX0559'),
(531, 'Franco da Rocha', 'Brazil', 'South America', 'BRXX0560'),
(532, 'General Salgado', 'Brazil', 'South America', 'BRXX0561'),
(533, 'Guapiara', 'Brazil', 'South America', 'BRXX0562'),
(534, 'Guarus', 'Brazil', 'South America', 'BRXX0563'),
(535, 'Gurupi', 'Brazil', 'South America', 'BRXX0564'),
(536, 'Ibitinga', 'Brazil', 'South America', 'BRXX0565'),
(537, 'Imperatriz', 'Brazil', 'South America', 'BRXX0566'),
(538, 'Indaiatuba', 'Brazil', 'South America', 'BRXX0567'),
(539, 'Inhapim', 'Brazil', 'South America', 'BRXX0568'),
(540, 'Ipameri', 'Brazil', 'South America', 'BRXX0569'),
(541, 'Itabaianinha', 'Brazil', 'South America', 'BRXX0570'),
(542, 'Itabira', 'Brazil', 'South America', 'BRXX0571'),
(543, 'Itacoatiara', 'Brazil', 'South America', 'BRXX0572'),
(544, 'Itaituba', 'Brazil', 'South America', 'BRXX0573'),
(545, 'Itamarandiba', 'Brazil', 'South America', 'BRXX0574'),
(546, 'Itapecerica da Se', 'Brazil', 'South America', 'BRXX0576'),
(547, 'Itapiranga', 'Brazil', 'South America', 'BRXX0577'),
(548, 'Itatiaia', 'Brazil', 'South America', 'BRXX0578'),
(549, 'Itatiba', 'Brazil', 'South America', 'BRXX0579'),
(550, 'Itupeva', 'Brazil', 'South America', 'BRXX0580'),
(551, 'Ituverava', 'Brazil', 'South America', 'BRXX0581'),
(552, 'Jaboticabal', 'Brazil', 'South America', 'BRXX0582'),
(553, 'Jacarezinho', 'Brazil', 'South America', 'BRXX0583'),
(554, 'Jales', 'Brazil', 'South America', 'BRXX0585'),
(555, 'Jaru', 'Brazil', 'South America', 'BRXX0586'),
(556, 'Jequitinhonha', 'Brazil', 'South America', 'BRXX0587'),
(557, 'Jumirim', 'Brazil', 'South America', 'BRXX0588'),
(558, 'Juquitiba', 'Brazil', 'South America', 'BRXX0589'),
(559, 'Juruti', 'Brazil', 'South America', 'BRXX0590'),
(560, 'Lagoa Santa', 'Brazil', 'South America', 'BRXX0591'),
(561, 'Lagoa Vermelha', 'Brazil', 'South America', 'BRXX0592'),
(562, 'Laranjal Paulista', 'Brazil', 'South America', 'BRXX0593'),
(563, 'Lavras', 'Brazil', 'South America', 'BRXX0594'),
(564, 'Leme', 'Brazil', 'South America', 'BRXX0595'),
(565, 'Machado', 'Brazil', 'South America', 'BRXX0596'),
(566, 'Macuco', 'Brazil', 'South America', 'BRXX0597'),
(567, 'Mairinque', 'Brazil', 'South America', 'BRXX0598'),
(568, 'Malacacheta', 'Brazil', 'South America', 'BRXX0599'),
(569, 'Manacapuru', 'Brazil', 'South America', 'BRXX0600'),
(570, 'Manga', 'Brazil', 'South America', 'BRXX0601'),
(571, 'Mangaratiba', 'Brazil', 'South America', 'BRXX0602'),
(572, 'Mantena', 'Brazil', 'South America', 'BRXX0603'),
(573, 'Marambaia', 'Brazil', 'South America', 'BRXX0604'),
(574, 'Mariana', 'Brazil', 'South America', 'BRXX0605'),
(575, 'Medina', 'Brazil', 'South America', 'BRXX0606'),
(576, 'Mesquita', 'Brazil', 'South America', 'BRXX0607'),
(577, 'Minas Novas', 'Brazil', 'South America', 'BRXX0608'),
(578, 'Mirassol', 'Brazil', 'South America', 'BRXX0609'),
(579, 'Mococa', 'Brazil', 'South America', 'BRXX0610'),
(580, 'Monte Alegre', 'Brazil', 'South America', 'BRXX0611'),
(581, 'Monte Azul', 'Brazil', 'South America', 'BRXX0612'),
(582, 'Moura', 'Brazil', 'South America', 'BRXX0613'),
(583, 'Mutum', 'Brazil', 'South America', 'BRXX0614'),
(584, 'Nanuque', 'Brazil', 'South America', 'BRXX0615'),
(585, 'Natividade', 'Brazil', 'South America', 'BRXX0616'),
(586, 'Neves', 'Brazil', 'South America', 'BRXX0617'),
(587, 'Xavantina', 'Brazil', 'South America', 'BRXX0618'),
(588, 'Novo Cruzeiro', 'Brazil', 'South America', 'BRXX0619'),
(589, 'Novo Horizonte', 'Brazil', 'South America', 'BRXX0620'),
(590, 'Oiapoque', 'Brazil', 'South America', 'BRXX0621'),
(591, 'Oswaldo Cruz', 'Brazil', 'South America', 'BRXX0622'),
(592, 'Ouro Preto', 'Brazil', 'South America', 'BRXX0623'),
(593, 'Ouro Preto do Oes', 'Brazil', 'South America', 'BRXX0624'),
(594, 'Paraibuna', 'Brazil', 'South America', 'BRXX0625'),
(595, 'Paulistana', 'Brazil', 'South America', 'BRXX0626'),
(596, 'Paulo Afonso', 'Brazil', 'South America', 'BRXX0627'),
(597, 'Pederneiras', 'Brazil', 'South America', 'BRXX0628'),
(598, 'Pedro Afonso', 'Brazil', 'South America', 'BRXX0629'),
(599, 'Penedo', 'Brazil', 'South America', 'BRXX0631'),
(600, 'Pereira Barreto', 'Brazil', 'South America', 'BRXX0632'),
(601, 'Perus', 'Brazil', 'South America', 'BRXX0633'),
(602, 'Picos', 'Brazil', 'South America', 'BRXX0634'),
(603, 'Piedade', 'Brazil', 'South America', 'BRXX0635'),
(604, 'Piedade do Rio Gr', 'Brazil', 'South America', 'BRXX0636'),
(605, 'Pilar do Sul', 'Brazil', 'South America', 'BRXX0637'),
(606, 'Pimenta Bueno', 'Brazil', 'South America', 'BRXX0638'),
(607, 'Pindamonhangaba', 'Brazil', 'South America', 'BRXX0639'),
(608, 'Pirapozinho', 'Brazil', 'South America', 'BRXX0640'),
(609, 'Pirassununga', 'Brazil', 'South America', 'BRXX0641'),
(610, 'Pirituba', 'Brazil', 'South America', 'BRXX0642'),
(611, 'Pitangui', 'Brazil', 'South America', 'BRXX0643'),
(612, 'Ponte Nova', 'Brazil', 'South America', 'BRXX0644'),
(613, 'Porangaba', 'Brazil', 'South America', 'BRXX0645'),
(614, 'Porteirinha', 'Brazil', 'South America', 'BRXX0646'),
(615, 'Porto Acre', 'Brazil', 'South America', 'BRXX0647'),
(616, 'Porto de Moz', 'Brazil', 'South America', 'BRXX0648'),
(617, 'Porto Ferreira', 'Brazil', 'South America', 'BRXX0649'),
(618, 'Prainha', 'Brazil', 'South America', 'BRXX0650'),
(619, 'Presidente Vences', 'Brazil', 'South America', 'BRXX0651'),
(620, 'Queimados', 'Brazil', 'South America', 'BRXX0652'),
(621, 'Rancharia', 'Brazil', 'South America', 'BRXX0653'),
(622, 'Raul Soares', 'Brazil', 'South America', 'BRXX0654'),
(623, 'Remanso', 'Brazil', 'South America', 'BRXX0655'),
(624, 'Rio Bananal', 'Brazil', 'South America', 'BRXX0656'),
(625, 'Rio das Ostras', 'Brazil', 'South America', 'BRXX0657'),
(626, 'Rio Pardo de Mina', 'Brazil', 'South America', 'BRXX0658'),
(627, 'Rolim de Moura', 'Brazil', 'South America', 'BRXX0659'),
(628, 'Salinas', 'Brazil', 'South America', 'BRXX0660'),
(629, 'Salto', 'Brazil', 'South America', 'BRXX0661'),
(630, 'Salto de Pirapora', 'Brazil', 'South America', 'BRXX0662'),
(631, 'Salvaterra', 'Brazil', 'South America', 'BRXX0663'),
(632, 'Santa Cruz', 'Brazil', 'South America', 'BRXX0664'),
(633, 'Santa Leopoldina', 'Brazil', 'South America', 'BRXX0665'),
(634, 'Santa Luzia', 'Brazil', 'South America', 'BRXX0666'),
(635, 'Saquarema', 'Brazil', 'South America', 'BRXX0667'),
(636, 'Serra Negra', 'Brazil', 'South America', 'BRXX0668'),
(637, 'Soure', 'Brazil', 'South America', 'BRXX0669'),
(638, 'Suzano', 'Brazil', 'South America', 'BRXX0670'),
(639, 'Taguatinga', 'Brazil', 'South America', 'BRXX0671'),
(640, 'Taquarituba', 'Brazil', 'South America', 'BRXX0672'),
(641, 'Teodoro Sampaio', 'Brazil', 'South America', 'BRXX0673'),
(642, 'Tiradentes', 'Brazil', 'South America', 'BRXX0674'),
(643, 'Torres', 'Brazil', 'South America', 'BRXX0675'),
(644, 'Tracuateua', 'Brazil', 'South America', 'BRXX0676'),
(645, 'Trancoso', 'Brazil', 'South America', 'BRXX0677'),
(646, 'Turmalina', 'Brazil', 'South America', 'BRXX0678'),
(647, 'Valinhos', 'Brazil', 'South America', 'BRXX0679'),
(648, 'Vassouras', 'Brazil', 'South America', 'BRXX0680'),
(649, 'Vespasiano', 'Brazil', 'South America', 'BRXX0681'),
(650, 'Vinhedo', 'Brazil', 'South America', 'BRXX0682'),
(651, 'Viseu', 'Brazil', 'South America', 'BRXX0683'),
(652, 'Votorantim', 'Brazil', 'South America', 'BRXX0684'),
(653, 'New Xavantina', 'Brazil', 'South America', 'BRXX0685'),
(654, 'Acucena', 'Brazil', 'South America', 'BRXX0686'),
(655, 'Aeroporto de Conf', 'Brazil', 'South America', 'BRXX0687'),
(656, 'Aeroporto do Gale', 'Brazil', 'South America', 'BRXX0688'),
(657, 'Aluminio', 'Brazil', 'South America', 'BRXX0689'),
(658, 'Aracoiaba da Serr', 'Brazil', 'South America', 'BRXX0690'),
(659, 'Aracuai', 'Brazil', 'South America', 'BRXX0691'),
(660, 'Aragarcas', 'Brazil', 'South America', 'BRXX0692'),
(661, 'Araguacu', 'Brazil', 'South America', 'BRXX0693'),
(662, 'Augustinopolis', 'Brazil', 'South America', 'BRXX0694'),
(663, 'Bom Jesus de Itab', 'Brazil', 'South America', 'BRXX0695'),
(664, 'Brasilia de Minas', 'Brazil', 'South America', 'BRXX0696'),
(665, 'Calcoene', 'Brazil', 'South America', 'BRXX0697'),
(666, 'Campina do Monte ', 'Brazil', 'South America', 'BRXX0698'),
(667, 'Campo Limpo Pauli', 'Brazil', 'South America', 'BRXX0699'),
(668, 'Codisburgo', 'Brazil', 'South America', 'BRXX0700'),
(669, 'Colorado do Oeste', 'Brazil', 'South America', 'BRXX0701'),
(670, 'Conceicao do Arag', 'Brazil', 'South America', 'BRXX0702'),
(671, 'Coracao de Jesus', 'Brazil', 'South America', 'BRXX0703'),
(672, 'Embu-Guacu', 'Brazil', 'South America', 'BRXX0704'),
(673, 'Ferraz de Vasconc', 'Brazil', 'South America', 'BRXX0705'),
(674, 'Figueiropolis', 'Brazil', 'South America', 'BRXX0706'),
(675, 'Formoso do Aragua', 'Brazil', 'South America', 'BRXX0707'),
(676, 'Garca', 'Brazil', 'South America', 'BRXX0708'),
(677, 'Igarape-Acu', 'Brazil', 'South America', 'BRXX0709'),
(678, 'Itaguacu', 'Brazil', 'South America', 'BRXX0710'),
(679, 'Ivinhema', 'Brazil', 'South America', 'BRXX0711'),
(680, 'Joacaba', 'Brazil', 'South America', 'BRXX0712'),
(681, 'Lencois Paulista', 'Brazil', 'South America', 'BRXX0713'),
(682, 'Miracema do Tocan', 'Brazil', 'South America', 'BRXX0714'),
(683, 'Miranorte', 'Brazil', 'South America', 'BRXX0715'),
(684, 'Moji-Mirim', 'Brazil', 'South America', 'BRXX0716'),
(685, 'Novo Aripuana', 'Brazil', 'South America', 'BRXX0717'),
(686, 'Placido Castro', 'Brazil', 'South America', 'BRXX0718'),
(687, 'Santa Vitoria do ', 'Brazil', 'South America', 'BRXX0719'),
(688, 'Santana do Parnai', 'Brazil', 'South America', 'BRXX0720'),
(689, 'Sao Gabriel da Pa', 'Brazil', 'South America', 'BRXX0721'),
(690, 'Sao Joao de Merit', 'Brazil', 'South America', 'BRXX0722'),
(691, 'Sao Lourenco da S', 'Brazil', 'South America', 'BRXX0723'),
(692, 'Tangara da Serra', 'Brazil', 'South America', 'BRXX0724'),
(693, 'Tres Coracoes', 'Brazil', 'South America', 'BRXX0725'),
(694, 'Vera', 'Brazil', 'South America', 'BRXX0726'),
(695, 'Cariacica', 'Brazil', 'South America', 'BRXX0727'),
(696, 'Iuna', 'Brazil', 'South America', 'BRXX0728'),
(697, 'Santa Teresa', 'Brazil', 'South America', 'BRXX0729'),
(698, 'Amapa', 'Brazil', 'South America', 'BRXX0730'),
(699, 'Icoraci', 'Brazil', 'South America', 'BRXX0731'),
(700, 'Guanambi', 'Brazil', 'South America', 'BRXX0732'),
(701, 'Itaparica', 'Brazil', 'South America', 'BRXX0733'),
(702, 'Santa Cruz Cabral', 'Brazil', 'South America', 'BRXX0734'),
(703, 'Abreu e Lima', 'Brazil', 'South America', 'BRXX0735'),
(704, 'Camaragibe', 'Brazil', 'South America', 'BRXX0736');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_eweather_prefs`
--

CREATE TABLE IF NOT EXISTS `jos_eweather_prefs` (
  `id` int(11) NOT NULL auto_increment,
  `region` varchar(100) NOT NULL default '',
  `country` varchar(100) NOT NULL default '',
  `loc_id` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=275 ;

--
-- Extraindo dados da tabela `jos_eweather_prefs`
--

INSERT INTO `jos_eweather_prefs` (`id`, `region`, `country`, `loc_id`) VALUES
(1, 'Africa', 'Algeria', 'AGXX'),
(2, 'Africa', 'Angola', 'AOXX'),
(3, 'Africa', 'Ascension Islands', 'SHXX'),
(4, 'Africa', 'Benin', 'BNXX'),
(5, 'Africa', 'Botswana', 'BCXX'),
(6, 'Africa', 'Burkina Faso', 'UVXX'),
(7, 'Africa', 'Burundi', 'BYXX'),
(8, 'Africa', 'Cameroon', 'CMXX'),
(9, 'Africa', 'Canary Islands', 'SPXX'),
(10, 'Africa', 'Central African Republic', 'CTXX'),
(11, 'Africa', 'Chad', 'CDXX'),
(12, 'Africa', 'Comoros', 'CNXX'),
(13, 'Africa', 'Congo', 'CGXX'),
(14, 'Africa', 'Djibouti', 'DJXX'),
(15, 'Africa', 'Egypt', 'EGXX'),
(16, 'Africa', 'Equatorial Guinea', 'EKXX'),
(17, 'Africa', 'Eritrea', 'ERXX'),
(18, 'Africa', 'Ethiopia', 'ETXX'),
(19, 'Africa', 'Gabon', 'GBXX'),
(20, 'Africa', 'Ghana', 'GHXX'),
(21, 'Africa', 'Guinea', 'GVXX'),
(22, 'Africa', 'Guinea-Bissau', 'PUXX'),
(23, 'Africa', 'Ivory Coast', 'IVXX'),
(24, 'Africa', 'Kenya', 'KEXX'),
(25, 'Africa', 'Lesotho', 'LTXX'),
(26, 'Africa', 'Liberia', 'LIXX'),
(27, 'Africa', 'Libya', 'LYXX'),
(28, 'Africa', 'Madagascar', 'MAXX'),
(29, 'Africa', 'Malawi', 'MIXX'),
(30, 'Africa', 'Mali', 'MLXX'),
(31, 'Africa', 'Marocco', 'MOXX'),
(32, 'Africa', 'Mauritania', 'MRXX'),
(33, 'Africa', 'Mauritius', 'MPXX'),
(34, 'Africa', 'Mozambique', 'MZXX'),
(35, 'Africa', 'Namibia', 'WAXX'),
(36, 'Africa', 'Nigeria', 'NIXX'),
(37, 'Africa', 'Reunion Islands', 'REXX'),
(38, 'Africa', 'Rwanda', 'RWXX'),
(39, 'Africa', 'Sao Tome and Principe', 'TPXX'),
(40, 'Africa', 'Senegal', 'SGXX'),
(41, 'Africa', 'Seychelles', 'SEXX'),
(42, 'Africa', 'Sierra Leone', 'SLXX'),
(43, 'Africa', 'Somalia', 'SOXX'),
(44, 'Africa', 'South Africa', 'SFXX'),
(45, 'Africa', 'St. Helena', 'SHXX'),
(46, 'Africa', 'Sudan', 'SUX'),
(47, 'Africa', 'Swaziland', 'WZXX'),
(48, 'Africa', 'Tanzania', 'TZXX'),
(49, 'Africa', 'The Gambia', 'GAXX'),
(50, 'Africa', 'Togo', 'TOXX'),
(51, 'Africa', 'Tunisia', 'TSXX'),
(52, 'Africa', 'Uganda', 'UGXX'),
(53, 'Africa', 'Zaire', ''),
(54, 'Africa', 'Zambia', 'ZAXX'),
(55, 'Africa', 'Zimbabwe', 'ZIXX'),
(56, 'Asia', 'Afghanistan', 'AFXX'),
(57, 'Asia', 'Armenia', 'AMXX'),
(58, 'Asia', 'Azerbaijan', 'AJXX'),
(59, 'Asia', 'Baharain', 'BAXX'),
(60, 'Asia', 'Bangladesh', 'BGXX'),
(61, 'Asia', 'Bhutan', 'BTXX'),
(62, 'Asia', 'Brunei', 'BXXX'),
(63, 'Asia', 'Cambodia', ''),
(64, 'Asia', 'China', ''),
(65, 'Asia', 'Georgia', ''),
(66, 'Asia', 'India', ''),
(67, 'Asia', 'Indian Ocean Islands', ''),
(68, 'Asia', 'Indonesia', 'IDXX'),
(69, 'Asia', 'Japan', ''),
(70, 'Asia', 'Kazakhstan', ''),
(71, 'Asia', 'Kyrgyzstan', ''),
(72, 'Asia', 'Laos', ''),
(73, 'Asia', 'Macao', ''),
(74, 'Asia', 'Malaysia', ''),
(75, 'Asia', 'Maldives', 'MVXX'),
(76, 'Asia', 'Mongolia', ''),
(77, 'Asia', 'Myanmar', ''),
(78, 'Asia', 'Nepal', 'NPXX'),
(79, 'Asia', 'North Korea', ''),
(80, 'Asia', 'Oman', ''),
(81, 'Asia', 'Pakistan', ''),
(82, 'Asia', 'Philippines', ''),
(83, 'Asia', 'Phillipines', ''),
(84, 'Asia', 'Qatar', 'QAXX'),
(85, 'Asia', 'Russia', ''),
(86, 'Asia', 'Singapore', ''),
(87, 'Asia', 'South Korea', ''),
(88, 'Asia', 'Sri Lanka', ''),
(89, 'Asia', 'Taiwan', ''),
(90, 'Asia', 'Tajikistan', ''),
(91, 'Asia', 'Thailand', ''),
(92, 'Asia', 'Turkmenistan', ''),
(93, 'Asia', 'Uzbekistan', ''),
(94, 'Asia', 'Vietnam', ''),
(95, 'Australia/New Zealand', 'Australia', ''),
(96, 'Australia/New Zealand', 'New Zealand', ''),
(97, 'Canada', 'Canada', 'CAXX'),
(98, 'Caribbean', 'Antigua', ''),
(99, 'Caribbean', 'Aruba', ''),
(100, 'Caribbean', 'Bahamas', ''),
(101, 'Caribbean', 'Barbados', ''),
(102, 'Caribbean', 'Bonaire', ''),
(103, 'Caribbean', 'Caymen Islands', ''),
(104, 'Caribbean', 'Cuba', ''),
(105, 'Caribbean', 'Curacao', ''),
(106, 'Caribbean', 'Dominican Republic', ''),
(107, 'Caribbean', 'Guadaloupe', 'GPXX'),
(108, 'Caribbean', 'Haiti', 'HAXX'),
(109, 'Caribbean', 'Jamaica', 'JMXX'),
(110, 'Caribbean', 'Martinique', 'MBXX'),
(111, 'Caribbean', 'Puerto Rico', ''),
(112, 'Caribbean', 'St. Barthelemy', ''),
(113, 'Caribbean', 'St. Kitts and Nevis', ''),
(114, 'Caribbean', 'St. Lucia', ''),
(115, 'Caribbean', 'St. Maarten', ''),
(116, 'Caribbean', 'St. Martin', ''),
(117, 'Caribbean', 'St. Vincent and Grenadines', ''),
(118, 'Caribbean', 'Trinidad and Tobago', ''),
(119, 'Caribbean', 'Virgin Islands (U.S.)', ''),
(120, 'Central America', 'Anguilla', 'AVXX'),
(121, 'Central America', 'Belize', 'BHXX'),
(122, 'Central America', 'Bermuda', 'BDXX'),
(123, 'Central America', 'Costa Rica', ''),
(124, 'Central America', 'Dominica', 'DOXX'),
(125, 'Central America', 'El Salvador', 'ESXX'),
(126, 'Central America', 'Grenada', 'GJXX'),
(127, 'Central America', 'Guatemala', ''),
(128, 'Central America', 'Honduras', ''),
(129, 'Central America', 'Mexico', ''),
(130, 'Central America', 'Montserrat', 'RPXX'),
(131, 'Central America', 'Nicaragua', 'NUXX'),
(132, 'Central America', 'Panama', 'PMXX'),
(133, 'Central America', 'Tortola', ''),
(134, 'Central America', 'Turk Islands', ''),
(135, 'East Europe', 'Albania', ''),
(136, 'East Europe', 'Belarus', ''),
(137, 'East Europe', 'Bosnia', ''),
(138, 'East Europe', 'Bulgaria', ''),
(139, 'East Europe', 'Croatia', ''),
(140, 'East Europe', 'Czech Republic', 'EZXX'),
(141, 'East Europe', 'Estonia', ''),
(142, 'East Europe', 'Finland', 'FIXX'),
(143, 'East Europe', 'Greece', 'GRXX'),
(144, 'East Europe', 'Hungary', 'HUXX'),
(145, 'East Europe', 'Latvia', ''),
(146, 'East Europe', 'Lithuania', ''),
(147, 'East Europe', 'Macedonia', ''),
(148, 'East Europe', 'Moldova', ''),
(149, 'East Europe', 'Poland', 'PLXX'),
(150, 'East Europe', 'Romania', ''),
(151, 'East Europe', 'Serbia', ''),
(152, 'East Europe', 'Slovakia', ''),
(153, 'East Europe', 'Slovenia', ''),
(154, 'East Europe', 'Ukraine', ''),
(155, 'Middle East', 'Cyprus', ''),
(156, 'Middle East', 'Iran', ''),
(157, 'Middle East', 'Iraq', ''),
(158, 'Middle East', 'Israel', ''),
(159, 'Middle East', 'Jordan', ''),
(160, 'Middle East', 'Kuwait', ''),
(161, 'Middle East', 'Lebanon', ''),
(162, 'Middle East', 'Saudi Arabia', ''),
(163, 'Middle East', 'Syria', ''),
(164, 'Middle East', 'Turkey', 'TUXX'),
(165, 'Middle East', 'United Arab Emirates', 'AEXX'),
(166, 'Middle East', 'Yemen', ''),
(167, 'South America', 'Argentina', ''),
(168, 'South America', 'Bolivia', ''),
(169, 'South America', 'Brazil', 'BRXX'),
(170, 'South America', 'Chile', ''),
(171, 'South America', 'Colombia', ''),
(172, 'South America', 'Ecuador', ''),
(173, 'South America', 'Falkland Islands', 'FKXX'),
(174, 'South America', 'French Guiana', 'CAYX'),
(175, 'South America', 'Guyana', 'GYXX'),
(176, 'South America', 'Paraguay', ''),
(177, 'South America', 'Peru', ''),
(178, 'South America', 'Suriname', 'NSXX'),
(179, 'South America', 'Uruguay', ''),
(180, 'South America', 'Venezuela', ''),
(181, 'United States', 'USA Alabama', 'USAL'),
(182, 'United States', 'USA Alaska', 'USAK'),
(183, 'United States', 'USA Arizona', 'USAZ'),
(184, 'United States', 'USA Arkansas', 'USAR'),
(185, 'United States', 'USA California', 'USCA'),
(186, 'United States', 'USA Colorado', 'USCO'),
(187, 'United States', 'USA Connecticut', 'USCT'),
(188, 'United States', 'USA DC', 'USDC'),
(189, 'United States', 'USA Delaware', 'USDE'),
(190, 'United States', 'USA Florida', 'USFL'),
(191, 'United States', 'USA Georgia', 'USGA'),
(192, 'United States', 'USA Hawaii', 'USHI'),
(193, 'United States', 'USA Idaho', 'USID'),
(194, 'United States', 'USA Illinois', 'USIL'),
(195, 'United States', 'USA Indiana', 'USIN'),
(196, 'United States', 'USA Iowa', 'USIA'),
(197, 'United States', 'USA Kansas', 'USKS'),
(198, 'United States', 'USA Kentucky', 'USKY'),
(199, 'United States', 'USA Louisiana', 'USLA'),
(200, 'United States', 'USA Maine', 'USME'),
(201, 'United States', 'USA Maryland', 'USMD'),
(202, 'United States', 'USA Massachusetts', 'USMA'),
(203, 'United States', 'USA Michigan', 'USMI'),
(204, 'United States', 'USA Minnesota', 'USMN'),
(205, 'United States', 'USA Mississippi', 'USMS'),
(206, 'United States', 'USA Missouri', 'USMO'),
(207, 'United States', 'USA Montana', 'USMT'),
(208, 'United States', 'USA Nebraska', 'USNE'),
(209, 'United States', 'USA Nevada', 'USNV'),
(210, 'United States', 'USA New Hampshire', 'USNH'),
(211, 'United States', 'USA New Jersey', 'USNJ'),
(212, 'United States', 'USA New Mexico', 'USNM'),
(213, 'United States', 'USA New York', 'USNY'),
(214, 'United States', 'USA North Carolina', 'USNC'),
(215, 'United States', 'USA North Dakota', 'USND'),
(216, 'United States', 'USA Ohio', 'USOH'),
(217, 'United States', 'USA Oklahoma', 'USOK'),
(218, 'United States', 'USA Oregon', 'USOR'),
(219, 'United States', 'USA Pennsylvania', 'USPA'),
(220, 'United States', 'USA Rhodeisland', 'USRI'),
(221, 'United States', 'USA South Carolina', 'USSC'),
(222, 'United States', 'USA South Dakota', 'USSD'),
(223, 'United States', 'USA Tennessee', 'USTN'),
(224, 'United States', 'USA Texas', 'USTX'),
(225, 'United States', 'USA Utah', 'USUT'),
(226, 'United States', 'USA Vermont', 'USVT'),
(227, 'United States', 'USA Virginia', 'USVA'),
(228, 'United States', 'USA Washington', 'USWA'),
(229, 'United States', 'USA West Virginia', 'USWV'),
(230, 'United States', 'USA Wisconsin', 'USWI'),
(231, 'United States', 'USA Wyoming', 'USWY'),
(232, 'West Europe', 'Andorra', ''),
(233, 'West Europe', 'Austria', 'AUXX'),
(234, 'West Europe', 'Azores', ''),
(235, 'West Europe', 'Belgium', 'BEXX'),
(236, 'West Europe', 'Cape Verde', 'CVXX'),
(237, 'West Europe', 'Denmark', 'DAXX'),
(238, 'West Europe', 'France', 'FRXX'),
(239, 'West Europe', 'Germany', 'GMXX'),
(240, 'West Europe', 'Greenland', ''),
(241, 'West Europe', 'Iceland', ''),
(242, 'West Europe', 'Ireland', 'EIXX'),
(243, 'West Europe', 'Italy', 'ITXX'),
(244, 'West Europe', 'Liechtenstein', 'LSXX'),
(245, 'West Europe', 'Luxembourg', 'LUXX'),
(246, 'West Europe', 'Madeira Islands', ''),
(247, 'West Europe', 'Malta', 'MTXX'),
(248, 'West Europe', 'Monaco', ''),
(249, 'West Europe', 'Netherlands', 'NLXX'),
(250, 'West Europe', 'Norway', 'NOXX'),
(251, 'West Europe', 'Portugal', 'POXX'),
(252, 'West Europe', 'Spain', 'SPXX'),
(253, 'West Europe', 'Sweden', 'SWXX'),
(254, 'West Europe', 'Switzerland', 'SZXX'),
(255, 'West Europe', 'United Kingdom', 'UKXX'),
(256, 'West Europe', 'Vatican City', ''),
(257, 'Pacific Islands', 'Cook Islands', ''),
(258, 'Pacific Islands', 'Fiji', ''),
(259, 'Pacific Islands', 'French Polynesia', 'FPXX'),
(260, 'Pacific Islands', 'Guam', ''),
(261, 'Pacific Islands', 'Kiribati', ''),
(262, 'Pacific Islands', 'Marshall Islands', ''),
(263, 'Pacific Islands', 'Micronesia', ''),
(264, 'Pacific Islands', 'Nauru', ''),
(265, 'Pacific Islands', 'New Caledonia', ''),
(266, 'Pacific Islands', 'Palau', ''),
(267, 'Pacific Islands', 'Papua New Guinea', ''),
(268, 'Pacific Islands', 'Solomon Islands', ''),
(269, 'Pacific Islands', 'Tonga', ''),
(270, 'Pacific Islands', 'Tuvalu', ''),
(271, 'Pacific Islands', 'Vanuatu', ''),
(272, 'Pacific Islands', 'Western Samoa', ''),
(273, 'Antarctica', 'Antarctica', ''),
(274, 'Africa', 'Niger', 'NGXX');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_eweather_profiles`
--

CREATE TABLE IF NOT EXISTS `jos_eweather_profiles` (
  `id` int(11) NOT NULL auto_increment,
  `uid` varchar(10) NOT NULL default '',
  `locid` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_eweather_profiles`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_groups`
--

CREATE TABLE IF NOT EXISTS `jos_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_groups`
--

INSERT INTO `jos_groups` (`id`, `name`) VALUES
(0, 'Público'),
(1, 'Registrado'),
(2, 'Especial');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jce_langs`
--

CREATE TABLE IF NOT EXISTS `jos_jce_langs` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(100) NOT NULL default '',
  `lang` varchar(100) NOT NULL default '',
  `published` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `jos_jce_langs`
--

INSERT INTO `jos_jce_langs` (`id`, `Name`, `lang`, `published`) VALUES
(1, 'English', 'en', 0),
(2, 'Brazilian Portuguese', 'pt_br', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jce_plugins`
--

CREATE TABLE IF NOT EXISTS `jos_jce_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `plugin` varchar(100) NOT NULL default '',
  `type` varchar(100) NOT NULL default 'plugin',
  `icon` varchar(255) NOT NULL default '',
  `layout_icon` varchar(255) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '18',
  `row` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `editable` tinyint(3) NOT NULL default '0',
  `elements` varchar(255) NOT NULL default '',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `plugin` (`plugin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Extraindo dados da tabela `jos_jce_plugins`
--

INSERT INTO `jos_jce_plugins` (`id`, `name`, `plugin`, `type`, `icon`, `layout_icon`, `access`, `row`, `ordering`, `published`, `editable`, `elements`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Context Menu', 'contextmenu', 'plugin', '', '', 18, 0, 0, 0, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Directionality', 'directionality', 'plugin', 'ltr,rtl', 'directionality', 18, 3, 8, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(3, 'Emotions', 'emotions', 'plugin', 'emotions', 'emotions', 18, 4, 12, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Fullscreen', 'fullscreen', 'plugin', 'fullscreen', 'fullscreen', 18, 4, 6, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'Paste', 'paste', 'plugin', 'pasteword,pastetext', 'paste', 18, 1, 16, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(6, 'Preview', 'preview', 'plugin', 'preview', 'preview', 18, 4, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(7, 'Tables', 'table', 'plugin', 'tablecontrols', 'buttons', 18, 2, 8, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(8, 'Print', 'print', 'plugin', 'print', 'print', 18, 4, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(9, 'Search Replace', 'searchreplace', 'plugin', 'search,replace', 'searchreplace', 18, 1, 17, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(10, 'Styles', 'style', 'plugin', 'styleprops', 'styleprops', 18, 4, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(11, 'Non-Breaking', 'nonbreaking', 'plugin', 'nonbreaking', 'nonbreaking', 18, 4, 8, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(12, 'Visual Characters', 'visualchars', 'plugin', 'visualchars', 'visualchars', 18, 4, 9, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(13, 'XHTML Xtras', 'xhtmlxtras', 'plugin', 'cite,abbr,acronym,del,ins,attribs', 'xhtmlxtras', 18, 4, 10, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Image Manager', 'imgmanager', 'plugin', '', 'imgmanager', 18, 4, 13, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(15, 'Advanced Link', 'advlink', 'plugin', '', 'advlink', 18, 4, 14, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Spell Checker', 'spellchecker', 'plugin', 'spellchecker', 'spellchecker', 18, 4, 15, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(17, 'Layers', 'layer', 'plugin', 'insertlayer,moveforward,movebackward,absolute', 'layer', 18, 4, 11, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(18, 'Font ForeColour', 'forecolor', 'command', 'forecolor', 'forecolor', 18, 3, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Bold', 'bold', 'command', 'bold', 'bold', 18, 1, 5, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(20, 'Italic', 'italic', 'command', 'italic', 'italic', 18, 1, 6, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Underline', 'underline', 'command', 'underline', 'underline', 18, 1, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Font BackColour', 'backcolor', 'command', 'backcolor', 'backcolor', 18, 3, 5, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Unlink', 'unlink', 'command', 'unlink', 'unlink', 18, 2, 11, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'Font Select', 'fontselect', 'command', 'fontselect', 'fontselect', 18, 3, 2, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'Font Size Select', 'fontsizeselect', 'command', 'fontsizeselect', 'fontsizeselect', 18, 3, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(26, 'Style Select', 'styleselect', 'command', 'styleselect', 'styleselect', 18, 3, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(27, 'New Document', 'newdocument', 'command', 'newdocument', 'newdocument', 18, 1, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'Help', 'help', 'command', 'help', 'help', 18, 1, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(29, 'StrikeThrough', 'strikethrough', 'command', 'strikethrough', 'strikethrough', 18, 1, 12, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(30, 'Indent', 'indent', 'command', 'indent', 'indent', 18, 1, 11, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(31, 'Outdent', 'outdent', 'command', 'outdent', 'outdent', 18, 1, 10, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'Undo', 'undo', 'command', 'undo', 'undo', 18, 1, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'Redo', 'redo', 'command', 'redo', 'redo', 18, 1, 2, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(34, 'Horizontal Rule', 'hr', 'command', 'hr', 'hr', 18, 2, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(35, 'HTML', 'html', 'command', 'code', 'code', 18, 1, 13, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(36, 'Numbered List', 'numlist', 'command', 'numlist', 'numlist', 18, 1, 9, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(37, 'Bullet List', 'bullist', 'command', 'bullist', 'bullist', 18, 1, 8, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(38, 'Clipboard Actions', 'clipboard', 'command', 'cut,copy,paste', 'clipboard', 18, 1, 16, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(39, 'Subscript', 'sub', 'command', 'sub', 'sub', 18, 2, 2, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(40, 'Superscript', 'sup', 'command', 'sup', 'sup', 18, 2, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(41, 'Visual Aid', 'visualaid', 'command', 'visualaid', 'visualaid', 18, 3, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(42, 'Character Map', 'charmap', 'command', 'charmap', 'charmap', 18, 3, 6, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(43, 'Justify Full', 'full', 'command', 'justifyfull', 'justifyfull', 18, 2, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(44, 'Justify Center', 'center', 'command', 'justifycenter', 'justifycenter', 18, 2, 5, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(45, 'Justify Left', 'left', 'command', 'justifyleft', 'justifyleft', 18, 2, 6, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(46, 'Justify Right', 'right', 'command', 'justifyright', 'justifyright', 18, 2, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(47, 'Remove Format', 'removeformat', 'command', 'removeformat', 'removeformat', 18, 1, 15, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(48, 'Anchor', 'anchor', 'command', 'anchor', 'anchor', 18, 2, 9, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(49, 'Format Select', 'formatselect', 'command', 'formatselect', 'formatselect', 18, 3, 9, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(50, 'Image', 'image', 'command', 'image', 'image', 18, 4, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', ''),
(51, 'Link', 'link', 'command', 'link', 'link', 18, 4, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jp_exclusion`
--

CREATE TABLE IF NOT EXISTS `jos_jp_exclusion` (
  `id` bigint(20) NOT NULL auto_increment,
  `class` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_jp_exclusion`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jp_inclusion`
--

CREATE TABLE IF NOT EXISTS `jos_jp_inclusion` (
  `id` bigint(20) NOT NULL auto_increment,
  `class` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_jp_inclusion`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jp_packvars`
--

CREATE TABLE IF NOT EXISTS `jos_jp_packvars` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) default NULL,
  `value2` longtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_jp_packvars`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_mambots`
--

CREATE TABLE IF NOT EXISTS `jos_mambots` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `jos_mambots`
--

INSERT INTO `jos_mambots` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'MOS: Imagem', 'mosimage', 'content', 0, -10000, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'MOS: Paginação', 'mospaging', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(3, 'Inclusão de Plugins Antigos', 'legacybots', 'content', 0, 1, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'SEF em Artigos', 'mossef', 'content', 0, 3, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'MOS: Votação', 'mosvote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(6, 'Procurar Conteúdo', 'content.searchbot', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(7, 'Procurar Weblinks', 'weblinks.searchbot', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(8, 'Suporte de Código', 'moscode', 'content', 0, 2, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(9, 'Editor não WYSIWYG', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(10, 'Editor WYSIWYG TinyMCE', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced'),
(11, 'MOS: Botão de Imagem', 'mosimage.btn', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(12, 'MOS: Botão de Quebra de Página', 'mospage.btn', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(13, 'Procurar Contatos', 'contacts.searchbot', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Procurar Categorias', 'categories.searchbot', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(15, 'Procurar Seções', 'sections.searchbot', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Proteção de Email', 'mosemailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(17, 'GeSHi', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(18, 'Procurar Notícias Externas', 'newsfeeds.searchbot', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Posicionador de Módulos', 'mosloadposition', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(20, 'JCE Editor Mambot', 'jce', 'editors', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_menu`
--

CREATE TABLE IF NOT EXISTS `jos_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(25) default NULL,
  `name` varchar(100) default NULL,
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `jos_menu`
--

INSERT INTO `jos_menu` (`id`, `menutype`, `name`, `link`, `type`, `published`, `parent`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `pollid`, `browserNav`, `access`, `utaccess`, `params`) VALUES
(1, 'mainmenu', 'PRINCIPAL', 'index.php?option=com_frontpage', 'components', 1, 0, 10, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1\npageclass_sfx=\nheader=Welcome to the Frontpage\npage_title=0\nback_button=0\nleading=1\nintro=2\ncolumns=2\nlink=1\norderby_pri=\norderby_sec=front\npagination=2\npagination_results=1\nimage=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nitem_title=1\nlink_titles=\nreadmore=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=0\nprint=0\nemail=0\nunpublished=0'),
(2, 'mainmenu', 'FALE CONCOSCO', 'index.php?option=com_contact', 'components', 1, 0, 7, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, ''),
(3, 'mainmenu', 'PUBLICIDADE', 'http://www.google.com', 'url', 1, 0, 0, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'menu_image=-1'),
(4, 'mainmenu', ' ', '', 'separator', -2, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 3, 0, 0, 'menu_image=-1'),
(5, 'menulateral', 'LINKS ÚTEIS', 'index.php?option=com_weblinks', 'components', 1, 0, 4, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, ''),
(6, 'menulateral', 'CLASSIFICADOS', 'index.php?option=com_adsmanager', 'components', 1, 0, 35, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_messages`
--

CREATE TABLE IF NOT EXISTS `jos_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` varchar(230) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_messages`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_messages_cfg`
--

CREATE TABLE IF NOT EXISTS `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_messages_cfg`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_modules`
--

CREATE TABLE IF NOT EXISTS `jos_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(10) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Extraindo dados da tabela `jos_modules`
--

INSERT INTO `jos_modules` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`) VALUES
(1, 'Enquete', '', 1, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_poll', 0, 0, 1, '', 0, 0),
(2, 'Menu Usuários', '', 4, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu', 1, 0),
(3, 'Menu Lateral', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'class_sfx=\r\nmoduleclass_sfx=\r\nmenutype=menulateral\r\nmenu_style=vert_indent\r\nfull_active_id=0\r\ncache=0\r\nmenu_images=0\r\nmenu_images_align=0\r\nexpand_menu=0\r\nactivate_parent=0\r\nindent_image=0\r\nindent_image1=\r\nindent_image2=\r\nindent_image3=\r\nindent_image4=\r\nindent_image5=\r\nindent_image6=\r\nspacer=\r\nend_spacer=', 1, 0),
(4, 'Login', '', 6, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_login', 0, 0, 1, '', 1, 0),
(5, 'Difusão de Notícias', '', 7, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_rssfeed', 0, 0, 1, '', 1, 0),
(6, 'Últimas Notícias', '', 2, 'user1', 0, '0000-00-00 00:00:00', 0, 'mod_latestnews', 0, 0, 1, '', 1, 0),
(7, 'Estatísticas', '', 8, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 0, 1, 'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=', 0, 0),
(8, 'Usuários On-line', '', 6, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_whosonline', 0, 0, 1, 'online=1\nusers=1\nmoduleclass_sfx=', 0, 0),
(9, 'Popular', '', 6, 'user2', 0, '0000-00-00 00:00:00', 1, 'mod_mostread', 0, 0, 1, '', 0, 0),
(10, 'Escolher Tema', '', 9, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_templatechooser', 0, 0, 1, 'show_preview=1', 0, 0),
(11, 'Arquivo', '', 10, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, '', 1, 0),
(12, 'Seções', '', 11, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, '', 1, 0),
(13, 'Flash de Notícias', '', 1, 'top', 0, '0000-00-00 00:00:00', 0, 'mod_newsflash', 0, 0, 1, 'catid=3\r\nstyle=random\r\nitems=\r\nmoduleclass_sfx=', 0, 0),
(14, 'Itens Relacionados', '', 12, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, '', 0, 0),
(15, 'Busca', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_search', 0, 0, 1, 'moduleclass_sfx=\ncache=0\nset_itemid=\nwidth=17\ntext=\nbutton=1\nbutton_pos=right\nbutton_text=OK', 0, 0),
(16, 'Imagens Aleatórias', '', 7, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_random_image', 0, 0, 1, '', 0, 0),
(17, 'Top Menu', '', 1, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0', 1, 0),
(18, 'Banners', '', 1, 'banner', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 0, 'banner_cids=\nmoduleclass_sfx=\n', 1, 0),
(19, 'Componente', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_components', 0, 99, 1, '', 1, 1),
(20, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 99, 1, '', 0, 1),
(21, 'Últimos', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 99, 1, '', 0, 1),
(22, 'Menus', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 99, 1, '', 0, 1),
(23, 'Mensagens Não Lidas', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 99, 1, '', 1, 1),
(24, 'Usuários Online', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 99, 1, '', 1, 1),
(25, 'Menu Completo', '', 3, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_fullmenu', 0, 99, 1, '', 1, 1),
(26, 'Caminho de Navegação', '', 1, 'pathway', 0, '0000-00-00 00:00:00', 1, 'mod_pathway', 0, 99, 1, '', 1, 1),
(27, 'Barra', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 99, 1, '', 1, 1),
(28, 'Mensagem de Sistema', '', 1, 'inset', 0, '0000-00-00 00:00:00', 1, 'mod_mosmsg', 0, 99, 1, '', 1, 1),
(29, 'Ícones Rápidos', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 99, 1, '', 1, 1),
(30, 'Outro Menu', '', 5, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_mainmenu', 0, 0, 0, 'menutype=othermenu\nmenu_style=vert_indent\ncache=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nclass_sfx=\nmoduleclass_sfx=\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=', 0, 0),
(31, 'Wrapper', '', 13, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_wrapper', 0, 0, 1, '', 0, 0),
(32, 'Logado', '', 0, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 99, 1, '', 0, 1),
(33, 'Data', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_date2', 0, 0, 0, 'moduleclass_sfx=-fundolaranja\npretext=Joinville&nbsp;-&nbsp;\nposttext=\nalign=3\nmethod=1\nshowdate=0\npredate=\npostdate=.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\nshowtime=1\npretime=\nposttime=\norder=0\nseplines=0\ndateorder=w,d,m,y\nISO8601=0\nzone=-3\ndst=0\ndston=March 14, 1999 2:59:59\ndstoff=November 7, 1999 2:59:59\nmilitary=0\nhours=0\nminutes=1\nseconds=1\nampm=1\namtext=am\npmtext=pm\nsepweek1=\nsepweek2=,\nsepday1=&nbsp;\nsepday2=&nbsp;de&nbsp;\nsepmonth1=\nsepmonth2=\nsepyear1=&nbsp;de&nbsp;\nsepyear2=\nsephour1=\nsephour2=\nsepminute1=:\nsepminute2=:\nsepsecond1=\nsepsecond2=\nsepampm1=\nsepampm2=\nsuntext=Domingo\nmontext=Segunda-feira\ntuetext=Terça-feira\nwedtext=Quarta-feira\nthutext=Quinta-feira\nfritext=Sexta-feira\nsattext=Sábado\nmonthformat=0\njantext=Janeiro\nfebtext=Fevereiro\nmartext=Março\naprtext=Abril\nmaytext=Maio\njuntext=Junho\njultext=Julho\naugtext=Agosto\nseptext=Setembro\nocttext=Outubro\nnovtext=Novembro\ndectext=Dezembro\nsuffixes=1\nd1=1\nd2=2\nd3=3\nd4=4\nd5=5\nd6=6\nd7=7\nd8=8\nd9=9\nd10=10\nd11=11\nd12=12\nd13=13\nd14=14\nd15=15\nd16=16\nd17=17\nd18=18\nd19=19th\nd20=20th\nd21=21st\nd22=22nd\nd23=23rd\nd24=24th\nd25=25th\nd26=26th\nd27=27th\nd28=28th\nd29=29th\nd30=30th\nd31=31st', 0, 0),
(34, 'MenuHorizontal', '', 2, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_swmenufree', 0, 0, 0, 'menutype=mainmenu\nmenustyle=transmenu\nmoduleID=34\nlevels=0\nparentid=0\nparent_level=0\nhybrid=0\nactive_menu=0\ntables=0\ncssload=1\nsub_indicator=0\nselectbox_hack=0\npadding_hack=0\nauto_position=0\nshow_shadow=0\ncache=0\ncache_time=1 hour\nmoduleclass_sfx=\neditor_hack=0\ntemplate=All\nlanguage=\ncomponent=All\n', 0, 0),
(35, 'Login Horizontal', '', 1, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_jb_login', 0, 0, 0, 'moduleclass_sfx=\nlogin=\nlogout=\nbr1=no\nbr2=no\nbr3=no\nbr4=no\nbr5=no\nlogin_message=0\nlogout_message=0\ngreeting=1\nname=1', 0, 0),
(37, 'Previsão do Tempo', '', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_eweather', 0, 0, 1, 'moduleclass_sfx=', 0, 0),
(39, 'Anuncio Saraiva', '<img src="images/stories/saraiva.jpg" alt="saraiva.jpg" title="saraiva.jpg" style="margin: 5px; float: left; width: 197px; height: 297px" width="197" height="297" />\r\n', 2, 'right', 0, '0000-00-00 00:00:00', 1, '', 0, 0, 0, 'moduleclass_sfx=\ncache=0\nfirebots=1\nrssurl=\nrsstitle=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=0\nrsscache=3600', 0, 0),
(40, 'Anuncio Aupex', '<img src="images/stories/aupex.jpg" alt="aupex.jpg" title="aupex.jpg" style="margin: 5px; float: left; width: 195px; height: 329px" width="195" height="329" />\r\n', 3, 'right', 0, '0000-00-00 00:00:00', 1, '', 0, 0, 0, 'moduleclass_sfx=\ncache=0\nfirebots=1\nrssurl=\nrsstitle=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=0\nrsscache=3600', 0, 0),
(41, 'Anuncio Quimiville', '<img src="images/stories/quimijoinville.jpg" alt="quimijoinville.jpg" title="quimijoinville.jpg" style="margin: 5px; float: left; width: 196px; height: 320px" width="196" height="320" />\r\n', 4, 'right', 0, '0000-00-00 00:00:00', 1, '', 0, 0, 0, 'moduleclass_sfx=\ncache=0\nfirebots=1\nrssurl=\nrsstitle=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=0\nrsscache=3600', 0, 0),
(42, 'Anuncio Contrachama', '<img src="images/stories/contrachama.jpg" alt="contrachama.jpg" title="contrachama.jpg" style="margin: 5px; float: left; width: 196px; height: 116px" width="196" height="116" />\r\n', 5, 'right', 0, '0000-00-00 00:00:00', 1, '', 0, 0, 0, 'moduleclass_sfx=\ncache=0\nfirebots=1\nrssurl=\nrsstitle=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=0\nrsscache=3600', 0, 0),
(43, 'Indique Este Site', '', 14, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_hwdrecommend', 0, 0, 1, 'mod_width=100%\nmod_bgcolor=\nmod_fontcolor=ffffff\nmod_fonttitlesize=100%\nmod_fontbodysize=85%\nroundradius=6\ntoogle_text=\nshow_form=block\nform_orientation=vertical\npersonal_message=0\nfrom_address=webmaster\nshow_copyright=0\nmoduleclass_sfx=', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_modules_menu`
--

CREATE TABLE IF NOT EXISTS `jos_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_modules_menu`
--

INSERT INTO `jos_modules_menu` (`moduleid`, `menuid`) VALUES
(1, 1),
(2, 0),
(3, 0),
(4, 1),
(5, 1),
(6, 1),
(6, 2),
(6, 4),
(6, 27),
(6, 36),
(8, 1),
(9, 1),
(9, 2),
(9, 4),
(9, 27),
(9, 36),
(10, 1),
(13, 0),
(15, 0),
(17, 0),
(18, 0),
(30, 0),
(33, 0),
(34, 0),
(35, 0),
(37, 0),
(38, 0),
(39, 0),
(40, 0),
(41, 0),
(42, 0),
(43, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_newsfeeds`
--

CREATE TABLE IF NOT EXISTS `jos_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_newsfeeds`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_polls`
--

CREATE TABLE IF NOT EXISTS `jos_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_polls`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_poll_data`
--

CREATE TABLE IF NOT EXISTS `jos_poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(4) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_poll_data`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_poll_date`
--

CREATE TABLE IF NOT EXISTS `jos_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_poll_date`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_poll_menu`
--

CREATE TABLE IF NOT EXISTS `jos_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_poll_menu`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_sections`
--

CREATE TABLE IF NOT EXISTS `jos_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_sections`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_session`
--

CREATE TABLE IF NOT EXISTS `jos_session` (
  `username` varchar(50) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_session`
--

INSERT INTO `jos_session` (`username`, `time`, `session_id`, `guest`, `userid`, `usertype`, `gid`) VALUES
('admin', '1226031117', 'f5f99a0f67de82ed5d7a78b192fde604', 1, 62, 'Super Administrator', 0),
('', '1473727727', '0d86577832af3dcfa2658d7f61fd2277', 1, 0, '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_stats_agents`
--

CREATE TABLE IF NOT EXISTS `jos_stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_stats_agents`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_swmenufree_config`
--

CREATE TABLE IF NOT EXISTS `jos_swmenufree_config` (
  `id` int(11) NOT NULL default '0',
  `main_top` smallint(8) default '0',
  `main_left` smallint(8) default '0',
  `main_height` smallint(8) default '20',
  `sub_border_over` varchar(30) default '0',
  `main_width` smallint(8) default '100',
  `sub_width` smallint(8) default '100',
  `main_back` varchar(7) default '#4682B4',
  `main_over` varchar(7) default '#5AA7E5',
  `sub_back` varchar(7) default '#4682B4',
  `sub_over` varchar(7) default '#5AA7E5',
  `sub_border` varchar(30) default '#FFFFFF',
  `main_font_size` smallint(8) default '0',
  `sub_font_size` smallint(8) default '0',
  `main_border_over` varchar(30) default '0',
  `sub_font_color` varchar(7) default '#000000',
  `main_border` varchar(30) default '#FFFFFF',
  `main_font_color` varchar(7) default '#000000',
  `sub_font_color_over` varchar(7) default '#FFFFFF',
  `main_font_color_over` varchar(7) default '#FFFFFF',
  `main_align` varchar(8) default 'left',
  `sub_align` varchar(8) default 'left',
  `sub_height` smallint(7) default '20',
  `position` varchar(10) default 'absolute',
  `orientation` varchar(20) default NULL,
  `font_family` varchar(50) default 'Arial',
  `font_weight` varchar(10) default 'normal',
  `font_weight_over` varchar(10) default 'normal',
  `level2_sub_top` int(11) default '0',
  `level2_sub_left` int(11) default '0',
  `level1_sub_top` int(11) NOT NULL default '0',
  `level1_sub_left` int(11) NOT NULL default '0',
  `main_back_image` varchar(100) default NULL,
  `main_back_image_over` varchar(100) default NULL,
  `sub_back_image` varchar(100) default NULL,
  `sub_back_image_over` varchar(100) default NULL,
  `specialA` varchar(50) default '80',
  `main_padding` varchar(40) default '0px 0px 0px 0px',
  `sub_padding` varchar(40) default '0px 0px 0px 0px',
  `specialB` varchar(100) default '50',
  `sub_font_family` varchar(50) default 'Arial',
  `extra` mediumtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_swmenufree_config`
--

INSERT INTO `jos_swmenufree_config` (`id`, `main_top`, `main_left`, `main_height`, `sub_border_over`, `main_width`, `sub_width`, `main_back`, `main_over`, `sub_back`, `sub_over`, `sub_border`, `main_font_size`, `sub_font_size`, `main_border_over`, `sub_font_color`, `main_border`, `main_font_color`, `sub_font_color_over`, `main_font_color_over`, `main_align`, `sub_align`, `sub_height`, `position`, `orientation`, `font_family`, `font_weight`, `font_weight_over`, `level2_sub_top`, `level2_sub_left`, `level1_sub_top`, `level1_sub_left`, `main_back_image`, `main_back_image_over`, `sub_back_image`, `sub_back_image_over`, `specialA`, `main_padding`, `sub_padding`, `specialB`, `sub_font_family`, `extra`) VALUES
(1, 0, 0, 0, '1px dashed ', 0, 0, '', '', '#FFCC99', '#FF6600', '0px solid #FFFFFF', 12, 12, '1px none #FFC819', '#000000', '0px none #FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', 'left', 'left', 0, 'left', 'horizontal/down', 'Arial, Helvetica, sans-serif', 'bold', 'bold', 0, 0, 0, 0, '', '', '', '', '85', '5px 5px 5px 5px', '5px 5px 5px 5px', '300', 'Arial, Helvetica, sans-serif', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_templates_menu`
--

CREATE TABLE IF NOT EXISTS `jos_templates_menu` (
  `template` varchar(50) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`template`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_templates_menu`
--

INSERT INTO `jos_templates_menu` (`template`, `menuid`, `client_id`) VALUES
('aquitemjoinville', 0, 0),
('joomla_admin', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_template_positions`
--

CREATE TABLE IF NOT EXISTS `jos_template_positions` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(10) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `jos_template_positions`
--

INSERT INTO `jos_template_positions` (`id`, `position`, `description`) VALUES
(1, 'left', ''),
(2, 'right', ''),
(3, 'top', ''),
(4, 'bottom', ''),
(5, 'inset', ''),
(6, 'banner', ''),
(7, 'header', ''),
(8, 'footer', ''),
(9, 'newsflash', ''),
(10, 'legals', ''),
(11, 'pathway', ''),
(12, 'toolbar', ''),
(13, 'cpanel', ''),
(14, 'user1', ''),
(15, 'user2', ''),
(16, 'user3', ''),
(17, 'user4', ''),
(18, 'user5', ''),
(19, 'user6', ''),
(20, 'user7', ''),
(21, 'user8', ''),
(22, 'user9', ''),
(23, 'advert1', ''),
(24, 'advert2', ''),
(25, 'advert3', ''),
(26, 'icon', ''),
(27, 'debug', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_users`
--

CREATE TABLE IF NOT EXISTS `jos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Extraindo dados da tabela `jos_users`
--

INSERT INTO `jos_users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'leonardo@devhouse.com.br', 'f04857dd85d64bc691d7c51312a67720:aHU6Ea4F2Jakru0V', 'Super Administrator', 0, 1, 25, '2008-10-24 14:28:10', '2008-11-03 14:54:17', '', 'expired=\nexpired_time='),
(63, 'Leonardo', 'Leonardo', 'leo.lima.web@gmail.com', '8962761629e4ec7a8e6c72b3c316ffdf:063nRF86jnjLwdPm', '', 0, 0, 18, '2008-11-03 15:37:06', '2008-11-03 15:37:06', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_usertypes`
--

CREATE TABLE IF NOT EXISTS `jos_usertypes` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `mask` varchar(11) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `jos_usertypes`
--

INSERT INTO `jos_usertypes` (`id`, `name`, `mask`) VALUES
(0, 'superadministrator', ''),
(1, 'administrator', ''),
(2, 'editor', ''),
(3, 'user', ''),
(4, 'author', ''),
(5, 'publisher', ''),
(6, 'manager', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_weblinks`
--

CREATE TABLE IF NOT EXISTS `jos_weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `jos_weblinks`
--

INSERT INTO `jos_weblinks` (`id`, `catid`, `sid`, `title`, `url`, `description`, `date`, `hits`, `published`, `checked_out`, `checked_out_time`, `ordering`, `archived`, `approved`, `params`) VALUES
(1, 1, 0, 'Google', 'http://www.google.com.br', 'Melhor sistema de busca do mundo.', '2008-10-24 19:14:03', 1, 1, 0, '0000-00-00 00:00:00', 1, 0, 1, 'target=1'),
(2, 1, 0, 'AltaVista', 'http://br.altavista.com/', 'Famoso sistema de busca antes da era google.', '2008-10-24 19:21:40', 0, 1, 0, '0000-00-00 00:00:00', 5, 0, 1, 'target=1'),
(3, 1, 0, 'Yahoo', 'http://br.yahoo.com/', 'Alternativa ao google.', '2008-10-24 19:21:35', 0, 1, 0, '0000-00-00 00:00:00', 4, 0, 1, 'target=1'),
(4, 1, 0, 'MSN', 'http://br.msn.com/', 'Sistema de Busca da Microsoft', '2008-10-24 19:21:22', 0, 1, 0, '0000-00-00 00:00:00', 3, 0, 1, 'target=1'),
(5, 1, 0, 'Cadê', 'http://cade.search.yahoo.com/', 'Sistema de busca brasileiro que foi comprado pelo yahoo.', '2008-10-24 19:21:17', 0, 1, 0, '0000-00-00 00:00:00', 2, 0, 1, 'target=1'),
(6, 2, 0, 'GNC Cinemas', 'http://gnccinemas.com.br ', 'Cinema de Joinville - Shopping Müller', '2008-10-24 19:21:11', 0, 1, 0, '0000-00-00 00:00:00', 1, 0, 1, 'target=1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
