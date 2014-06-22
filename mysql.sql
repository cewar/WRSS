--
-- Estructura de tabla para la tabla `zy_accounts_config`
--

CREATE TABLE IF NOT EXISTS `zy_accounts_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `word` varchar(1000) NOT NULL,
  `type` int(11) NOT NULL,
  `origenRss` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

--
-- Volcado de datos para la tabla `zy_accounts_config`
--

INSERT INTO `zy_accounts_config` (`id`, `user`, `word`, `type`, `origenRss`) VALUES
(109, 1, '', 4, 2),
(110, 1, '', 4, 3),
(111, 1, '', 4, 4);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zy_rss`
--

CREATE TABLE IF NOT EXISTS `zy_rss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rss` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `zy_rss`
--

INSERT INTO `zy_rss` (`id`, `rss`, `titulo`) VALUES
(1, 'http://cdn01.ib.infobae.com/adjuntos/162/rss/Infobae.xml', 'Infobae Ahora'),
(2, 'http://cdn01.ib.infobae.com/adjuntos/162/rss/tecno.xml', 'Infoabe Tecno'),
(3, 'http://cdn01.ib.infobae.com/adjuntos/162/rss/tendencias.xml', 'Infobae Tendencias'),
(4, 'http://cdn01.ib.infobae.com/adjuntos/162/rss/economia.xml', 'Infobae Economia'),
(5, 'http://cdn01.ib.infobae.com/adjuntos/162/rss/sociedad.xml', 'Infobae Sociedad');

-- --------------------------------------------------------
