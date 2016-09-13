<?php
/**
* @version $Id: install.eweather.php,v 1.1.0 2006/05/02 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage Admin eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

// no direct access
//defined('_VALID_MOS') or die ('Direct Access to this location is not allowed.');

  function com_install(){
    global $database, $mosConfig_absolute_path;

    $sql[] = "DROP TABLE IF EXISTS `#__eweather_cache`;";
    $sql[] = "CREATE TABLE IF NOT EXISTS `#__eweather_cache` ("
            ."  `id` mediumint(9) NOT NULL auto_increment,"
            ."  `lastupdate` int(11) default NULL,"
            ."  `locid` varchar(15) NOT NULL default '',"
            ."  `feed` text NOT NULL,"
            ."  PRIMARY KEY  (`id`)"
            .") TYPE=MyISAM PACK_KEYS=0;";

    $sql[] = "DROP TABLE IF EXISTS `#__eweather_locations`;";
    $sql[] = "CREATE TABLE IF NOT EXISTS `#__eweather_locations` ("
            ."  `id` int(4) NOT NULL auto_increment,"
            ."  `city` varchar(50) default NULL,"
            ."  `country` varchar(50) NOT NULL default '0',"
            ."  `region` varchar(50) NOT NULL default '0',"
            ."  `loc_id` varchar(10) NOT NULL default '',"
            ."  PRIMARY KEY  (`id`)"
            .") TYPE=MyISAM PACK_KEYS=0;";

    $sql[] = "DROP TABLE IF EXISTS `#__eweather_profiles`;";
    $sql[] = "CREATE TABLE IF NOT EXISTS `#__eweather_profiles` ("
            ."  `id` int(11) NOT NULL auto_increment,"
            ."  `uid` varchar(10) NOT NULL default '',"
            ."  `locid` varchar(15) NOT NULL default '',"
            ."  PRIMARY KEY  (`id`)"
            .") TYPE=MyISAM;";

    $sql[] = "DROP TABLE IF EXISTS `#__eweather_prefs`;";
    $sql[] = "CREATE TABLE IF NOT EXISTS `#__eweather_prefs` ("
            ."  `id` int(11) NOT NULL auto_increment,"
            ."  `region` varchar(100) NOT NULL default '',"
            ."  `country` varchar(100) NOT NULL default '',"
            ."  `loc_id` varchar(5) NOT NULL default '',"
            ."  PRIMARY KEY  (`id`)"
            .") TYPE=MyISAM;";

    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (1, 'Africa', 'Algeria', 'AGXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (2, 'Africa', 'Angola', 'AOXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (3, 'Africa', 'Ascension Islands', 'SHXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (4, 'Africa', 'Benin', 'BNXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (5, 'Africa', 'Botswana', 'BCXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (6, 'Africa', 'Burkina Faso', 'UVXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (7, 'Africa', 'Burundi', 'BYXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (8, 'Africa', 'Cameroon', 'CMXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (9, 'Africa', 'Canary Islands', 'SPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (10, 'Africa', 'Central African Republic', 'CTXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (11, 'Africa', 'Chad', 'CDXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (12, 'Africa', 'Comoros', 'CNXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (13, 'Africa', 'Congo', 'CGXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (14, 'Africa', 'Djibouti', 'DJXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (15, 'Africa', 'Egypt', 'EGXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (16, 'Africa', 'Equatorial Guinea', 'EKXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (17, 'Africa', 'Eritrea', 'ERXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (18, 'Africa', 'Ethiopia', 'ETXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (19, 'Africa', 'Gabon', 'GBXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (20, 'Africa', 'Ghana', 'GHXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (21, 'Africa', 'Guinea', 'GVXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (22, 'Africa', 'Guinea-Bissau', 'PUXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (23, 'Africa', 'Ivory Coast', 'IVXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (24, 'Africa', 'Kenya', 'KEXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (25, 'Africa', 'Lesotho', 'LTXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (26, 'Africa', 'Liberia', 'LIXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (27, 'Africa', 'Libya', 'LYXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (28, 'Africa', 'Madagascar', 'MAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (29, 'Africa', 'Malawi', 'MIXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (30, 'Africa', 'Mali', 'MLXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (31, 'Africa', 'Marocco', 'MOXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (32, 'Africa', 'Mauritania', 'MRXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (33, 'Africa', 'Mauritius', 'MPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (34, 'Africa', 'Mozambique', 'MZXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (35, 'Africa', 'Namibia', 'WAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (36, 'Africa', 'Nigeria', 'NIXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (37, 'Africa', 'Reunion Islands', 'REXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (38, 'Africa', 'Rwanda', 'RWXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (39, 'Africa', 'Sao Tome and Principe', 'TPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (40, 'Africa', 'Senegal', 'SGXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (41, 'Africa', 'Seychelles', 'SEXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (42, 'Africa', 'Sierra Leone', 'SLXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (43, 'Africa', 'Somalia', 'SOXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (44, 'Africa', 'South Africa', 'SFXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (45, 'Africa', 'St. Helena', 'SHXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (46, 'Africa', 'Sudan', 'SUX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (47, 'Africa', 'Swaziland', 'WZXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (48, 'Africa', 'Tanzania', 'TZXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (49, 'Africa', 'The Gambia', 'GAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (50, 'Africa', 'Togo', 'TOXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (51, 'Africa', 'Tunisia', 'TSXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (52, 'Africa', 'Uganda', 'UGXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (53, 'Africa', 'Zaire', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (54, 'Africa', 'Zambia', 'ZAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (55, 'Africa', 'Zimbabwe', 'ZIXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (56, 'Asia', 'Afghanistan', 'AFXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (57, 'Asia', 'Armenia', 'AMXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (58, 'Asia', 'Azerbaijan', 'AJXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (59, 'Asia', 'Baharain', 'BAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (60, 'Asia', 'Bangladesh', 'BGXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (61, 'Asia', 'Bhutan', 'BTXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (62, 'Asia', 'Brunei', 'BXXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (63, 'Asia', 'Cambodia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (64, 'Asia', 'China', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (65, 'Asia', 'Georgia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (66, 'Asia', 'India', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (67, 'Asia', 'Indian Ocean Islands', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (68, 'Asia', 'Indonesia', 'IDXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (69, 'Asia', 'Japan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (70, 'Asia', 'Kazakhstan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (71, 'Asia', 'Kyrgyzstan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (72, 'Asia', 'Laos', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (73, 'Asia', 'Macao', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (74, 'Asia', 'Malaysia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (75, 'Asia', 'Maldives', 'MVXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (76, 'Asia', 'Mongolia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (77, 'Asia', 'Myanmar', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (78, 'Asia', 'Nepal', 'NPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (79, 'Asia', 'North Korea', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (80, 'Asia', 'Oman', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (81, 'Asia', 'Pakistan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (82, 'Asia', 'Philippines', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (83, 'Asia', 'Phillipines', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (84, 'Asia', 'Qatar', 'QAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (85, 'Asia', 'Russia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (86, 'Asia', 'Singapore', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (87, 'Asia', 'South Korea', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (88, 'Asia', 'Sri Lanka', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (89, 'Asia', 'Taiwan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (90, 'Asia', 'Tajikistan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (91, 'Asia', 'Thailand', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (92, 'Asia', 'Turkmenistan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (93, 'Asia', 'Uzbekistan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (94, 'Asia', 'Vietnam', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (95, 'Australia/New Zealand', 'Australia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (96, 'Australia/New Zealand', 'New Zealand', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (97, 'Canada', 'Canada', 'CAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (98, 'Caribbean', 'Antigua', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (99, 'Caribbean', 'Aruba', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (100, 'Caribbean', 'Bahamas', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (101, 'Caribbean', 'Barbados', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (102, 'Caribbean', 'Bonaire', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (103, 'Caribbean', 'Caymen Islands', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (104, 'Caribbean', 'Cuba', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (105, 'Caribbean', 'Curacao', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (106, 'Caribbean', 'Dominican Republic', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (107, 'Caribbean', 'Guadaloupe', 'GPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (108, 'Caribbean', 'Haiti', 'HAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (109, 'Caribbean', 'Jamaica', 'JMXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (110, 'Caribbean', 'Martinique', 'MBXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (111, 'Caribbean', 'Puerto Rico', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (112, 'Caribbean', 'St. Barthelemy', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (113, 'Caribbean', 'St. Kitts and Nevis', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (114, 'Caribbean', 'St. Lucia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (115, 'Caribbean', 'St. Maarten', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (116, 'Caribbean', 'St. Martin', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (117, 'Caribbean', 'St. Vincent and Grenadines', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (118, 'Caribbean', 'Trinidad and Tobago', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (119, 'Caribbean', 'Virgin Islands (U.S.)', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (120, 'Central America', 'Anguilla', 'AVXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (121, 'Central America', 'Belize', 'BHXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (122, 'Central America', 'Bermuda', 'BDXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (123, 'Central America', 'Costa Rica', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (124, 'Central America', 'Dominica', 'DOXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (125, 'Central America', 'El Salvador', 'ESXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (126, 'Central America', 'Grenada', 'GJXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (127, 'Central America', 'Guatemala', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (128, 'Central America', 'Honduras', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (129, 'Central America', 'Mexico', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (130, 'Central America', 'Montserrat', 'RPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (131, 'Central America', 'Nicaragua', 'NUXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (132, 'Central America', 'Panama', 'PMXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (133, 'Central America', 'Tortola', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (134, 'Central America', 'Turk Islands', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (135, 'East Europe', 'Albania', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (136, 'East Europe', 'Belarus', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (137, 'East Europe', 'Bosnia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (138, 'East Europe', 'Bulgaria', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (139, 'East Europe', 'Croatia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (140, 'East Europe', 'Czech Republic', 'EZXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (141, 'East Europe', 'Estonia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (142, 'East Europe', 'Finland', 'FIXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (143, 'East Europe', 'Greece', 'GRXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (144, 'East Europe', 'Hungary', 'HUXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (145, 'East Europe', 'Latvia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (146, 'East Europe', 'Lithuania', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (147, 'East Europe', 'Macedonia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (148, 'East Europe', 'Moldova', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (149, 'East Europe', 'Poland', 'PLXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (150, 'East Europe', 'Romania', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (151, 'East Europe', 'Serbia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (152, 'East Europe', 'Slovakia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (153, 'East Europe', 'Slovenia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (154, 'East Europe', 'Ukraine', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (155, 'Middle East', 'Cyprus', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (156, 'Middle East', 'Iran', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (157, 'Middle East', 'Iraq', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (158, 'Middle East', 'Israel', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (159, 'Middle East', 'Jordan', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (160, 'Middle East', 'Kuwait', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (161, 'Middle East', 'Lebanon', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (162, 'Middle East', 'Saudi Arabia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (163, 'Middle East', 'Syria', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (164, 'Middle East', 'Turkey', 'TUXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (165, 'Middle East', 'United Arab Emirates', 'AEXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (166, 'Middle East', 'Yemen', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (167, 'South America', 'Argentina', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (168, 'South America', 'Bolivia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (169, 'South America', 'Brazil', 'BRXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (170, 'South America', 'Chile', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (171, 'South America', 'Colombia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (172, 'South America', 'Ecuador', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (173, 'South America', 'Falkland Islands', 'FKXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (174, 'South America', 'French Guiana', 'CAYX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (175, 'South America', 'Guyana', 'GYXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (176, 'South America', 'Paraguay', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (177, 'South America', 'Peru', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (178, 'South America', 'Suriname', 'NSXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (179, 'South America', 'Uruguay', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (180, 'South America', 'Venezuela', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (181, 'United States', 'USA Alabama', 'USAL');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (182, 'United States', 'USA Alaska', 'USAK');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (183, 'United States', 'USA Arizona', 'USAZ');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (184, 'United States', 'USA Arkansas', 'USAR');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (185, 'United States', 'USA California', 'USCA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (186, 'United States', 'USA Colorado', 'USCO');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (187, 'United States', 'USA Connecticut', 'USCT');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (188, 'United States', 'USA DC', 'USDC');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (189, 'United States', 'USA Delaware', 'USDE');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (190, 'United States', 'USA Florida', 'USFL');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (191, 'United States', 'USA Georgia', 'USGA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (192, 'United States', 'USA Hawaii', 'USHI');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (193, 'United States', 'USA Idaho', 'USID');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (194, 'United States', 'USA Illinois', 'USIL');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (195, 'United States', 'USA Indiana', 'USIN');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (196, 'United States', 'USA Iowa', 'USIA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (197, 'United States', 'USA Kansas', 'USKS');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (198, 'United States', 'USA Kentucky', 'USKY');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (199, 'United States', 'USA Louisiana', 'USLA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (200, 'United States', 'USA Maine', 'USME');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (201, 'United States', 'USA Maryland', 'USMD');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (202, 'United States', 'USA Massachusetts', 'USMA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (203, 'United States', 'USA Michigan', 'USMI');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (204, 'United States', 'USA Minnesota', 'USMN');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (205, 'United States', 'USA Mississippi', 'USMS');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (206, 'United States', 'USA Missouri', 'USMO');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (207, 'United States', 'USA Montana', 'USMT');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (208, 'United States', 'USA Nebraska', 'USNE');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (209, 'United States', 'USA Nevada', 'USNV');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (210, 'United States', 'USA New Hampshire', 'USNH');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (211, 'United States', 'USA New Jersey', 'USNJ');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (212, 'United States', 'USA New Mexico', 'USNM');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (213, 'United States', 'USA New York', 'USNY');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (214, 'United States', 'USA North Carolina', 'USNC');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (215, 'United States', 'USA North Dakota', 'USND');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (216, 'United States', 'USA Ohio', 'USOH');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (217, 'United States', 'USA Oklahoma', 'USOK');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (218, 'United States', 'USA Oregon', 'USOR');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (219, 'United States', 'USA Pennsylvania', 'USPA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (220, 'United States', 'USA Rhodeisland', 'USRI');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (221, 'United States', 'USA South Carolina', 'USSC');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (222, 'United States', 'USA South Dakota', 'USSD');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (223, 'United States', 'USA Tennessee', 'USTN');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (224, 'United States', 'USA Texas', 'USTX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (225, 'United States', 'USA Utah', 'USUT');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (226, 'United States', 'USA Vermont', 'USVT');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (227, 'United States', 'USA Virginia', 'USVA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (228, 'United States', 'USA Washington', 'USWA');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (229, 'United States', 'USA West Virginia', 'USWV');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (230, 'United States', 'USA Wisconsin', 'USWI');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (231, 'United States', 'USA Wyoming', 'USWY');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (232, 'West Europe', 'Andorra', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (233, 'West Europe', 'Austria', 'AUXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (234, 'West Europe', 'Azores', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (235, 'West Europe', 'Belgium', 'BEXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (236, 'West Europe', 'Cape Verde', 'CVXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (237, 'West Europe', 'Denmark', 'DAXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (238, 'West Europe', 'France', 'FRXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (239, 'West Europe', 'Germany', 'GMXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (240, 'West Europe', 'Greenland', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (241, 'West Europe', 'Iceland', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (242, 'West Europe', 'Ireland', 'EIXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (243, 'West Europe', 'Italy', 'ITXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (244, 'West Europe', 'Liechtenstein', 'LSXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (245, 'West Europe', 'Luxembourg', 'LUXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (246, 'West Europe', 'Madeira Islands', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (247, 'West Europe', 'Malta', 'MTXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (248, 'West Europe', 'Monaco', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (249, 'West Europe', 'Netherlands', 'NLXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (250, 'West Europe', 'Norway', 'NOXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (251, 'West Europe', 'Portugal', 'POXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (252, 'West Europe', 'Spain', 'SPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (253, 'West Europe', 'Sweden', 'SWXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (254, 'West Europe', 'Switzerland', 'SZXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (255, 'West Europe', 'United Kingdom', 'UKXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (256, 'West Europe', 'Vatican City', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (257, 'Pacific Islands', 'Cook Islands', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (258, 'Pacific Islands', 'Fiji', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (259, 'Pacific Islands', 'French Polynesia', 'FPXX');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (260, 'Pacific Islands', 'Guam', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (261, 'Pacific Islands', 'Kiribati', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (262, 'Pacific Islands', 'Marshall Islands', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (263, 'Pacific Islands', 'Micronesia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (264, 'Pacific Islands', 'Nauru', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (265, 'Pacific Islands', 'New Caledonia', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (266, 'Pacific Islands', 'Palau', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (267, 'Pacific Islands', 'Papua New Guinea', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (268, 'Pacific Islands', 'Solomon Islands', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (269, 'Pacific Islands', 'Tonga', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (270, 'Pacific Islands', 'Tuvalu', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (271, 'Pacific Islands', 'Vanuatu', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (272, 'Pacific Islands', 'Western Samoa', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (273, 'Antarctica', 'Antarctica', '');";
    $sql[] = "INSERT INTO `#__eweather_prefs` VALUES (274, 'Africa', 'Niger', 'NGXX');";

    foreach ($sql as $query){
        $database->setQuery($query);
        $database->query();
    }

    $database -> setQuery("SELECT id FROM #__components WHERE name= 'eWeather'");
    $id = $database -> loadResult();
    $database->setQuery( "UPDATE #__components SET admin_menu_img = '../administrator/components/com_eweather/mn_img/eweather.png' WHERE id='$id'");
    $database->query();
    $database->setQuery( "UPDATE #__components SET admin_menu_img = '../administrator/components/com_eweather/mn_img/info.png' WHERE parent='$id' AND name = 'Info'");
    $database->query();
    $database->setQuery( "UPDATE #__components SET admin_menu_img = '../administrator/components/com_eweather/mn_img/location.png' WHERE parent='$id' AND name = 'Locations'");
    $database->query();
    $database->setQuery( "UPDATE #__components SET admin_menu_img = '../administrator/components/com_eweather/mn_img/settings.png' WHERE parent='$id' AND name = 'Configuration'");
    $database->query();
  }

?>
<table width="100%" border="0">
   <tr>
     <td width="10%" valign="top">
        <img src="components/com_ebackup/images/logo.png" alt="" />
     </td>
     <td width="90%">
        <p>
           <strong>eWeather</strong> Component <em>for Joomla! CMS and Mambo 4.5.x</em> <br />
           &copy; 2006 by Mambobaer<br>
           All rights reserved.
           <br />
           <br />
           This eWeather Component has been released under the
           <a href="index2.php?option=com_admisc&amp;task=license">GNU/GPL</a>.<br/>
           <strong>Note:</strong>&nbsp;This package works only on Joomla! 1.0.x and Mambo 4.5.x
        </p>
     </td>
   </tr>
   <tr>
     <td valign="top">
        <strong>Installation</strong><br /><br />
     </td>
     <td>&nbsp;
     </td>
   </tr>
   <tr>
      <td valign="top">
         <strong>Information:</strong><br /><br />
      </td>
      <td>
         <p>
<strong>NO WARRANTY</strong><br />
BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW<br />
EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY<br />
OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS <br />
FOR A PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU. SHOULD THE<br />
PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING, REPAIR OR CORRECTION.<br />
<br />
IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY <br />
MODIFY AND/OR REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL<br />
OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF DATA OR DATA <br />
BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER<br />
PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.<br />
         </p>
      </td>
   </tr>
   <tr>
      <td>&nbsp;
      </td>
      <td>
         <p>
            Thank you for using eWeather Component!
         </p>
         <p>
            <em>MamboBaer.de</em>
         </p>
      </td>
   </tr>
</table>
</center>
