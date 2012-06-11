
CREATE TABLE IF NOT EXISTS `nh_projects` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `num_points` int(4) NOT NULL,
  `id` text COLLATE utf8_unicode_ci NOT NULL,
  `f_deltah` text COLLATE utf8_unicode_ci NOT NULL,
  `b_deltah` text COLLATE utf8_unicode_ci NOT NULL,
  `f_l` text COLLATE utf8_unicode_ci NOT NULL,
  `b_l` text COLLATE utf8_unicode_ci NOT NULL,
  `H` text COLLATE utf8_unicode_ci NOT NULL,
  `wl` int(11) NOT NULL,
  `max_dhi` int(11) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

CREATE TABLE IF NOT EXISTS `nh_users` (
  `uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;