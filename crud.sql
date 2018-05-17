CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `sobre_nome` varchar(150) NOT NULL,
  `imagem` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- Dumping data for table `users`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobre_nome`, `imagem`) VALUES
(18, 'Joze', 'Abreu', '1.jpg'),
(19, 'John', 'da Silva', '4.jpg'),
(20, 'Catarina', 'Ferrari', '3.jpg'),
(21, 'Ivone', 'Cerquera', '5.jpg'),
(22, 'Clara', 'Mendes', '7.jpg'),
(23, 'Christine', 'Sport', '11.jpg'),
(24, 'Alana', 'da Cruz', '12.jpg'),
(25, 'Renata', 'Rubia', '13.jpg'),
(26, 'Marcelo', 'Ricardo', '14.jpg'),
(70, 'Cintia', 'Toledo', '18211.jpg'),
(73, 'Daniel', 'Fraustino', '8288.jpg'),
(69, 'Franklin', 'Araujo', '22610.jpg'),
(66, 'Margarete', 'Souza', '14365.jpg'),
(71, 'Maria', 'da Gloria', '9248.jpg'),
(68, 'Roberto', 'Carlos', '27282.jpg');