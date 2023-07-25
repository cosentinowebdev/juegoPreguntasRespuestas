-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-07-2023 a las 21:27:13
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `juego`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categories`
--

CREATE TABLE `Categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) DEFAULT NULL,
  `CategoryColor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Categories`
--

INSERT INTO `Categories` (`CategoryID`, `CategoryName`, `CategoryColor`) VALUES
(1, 'Programación', '#ed333b'),
(2, 'Historia Argentina', '#0000ff'),
(3, 'Geografia', '#00FF00'),
(12, 'Literatura', '#865e3c');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Questions`
--

CREATE TABLE `Questions` (
  `QuestionID` int(11) NOT NULL,
  `QuestionText` varchar(255) DEFAULT NULL,
  `CorrectAnswer` varchar(255) DEFAULT NULL,
  `Answer1` varchar(255) DEFAULT NULL,
  `Answer2` varchar(255) DEFAULT NULL,
  `Answer3` varchar(255) DEFAULT NULL,
  `CorrectCount` int(11) DEFAULT NULL,
  `IncorrectCount` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `StateID` int(11) DEFAULT NULL,
  `Difficulty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Questions`
--

INSERT INTO `Questions` (`QuestionID`, `QuestionText`, `CorrectAnswer`, `Answer1`, `Answer2`, `Answer3`, `CorrectCount`, `IncorrectCount`, `CategoryID`, `StateID`, `Difficulty`) VALUES
(1, '¿Qué es PHP?', 'Un lenguaje de programación', 'Un sistema operativo', 'Un gestor de bases de datos', 'Un framework', 3, 1, 1, 1, 'Easy'),
(2, '¿Cuál de los siguientes no es un lenguaje de programación?', 'HTML', 'Java', 'Python', 'C++', 8, 1, 1, 1, 'Easy'),
(3, '¿Qué significa CSS?', 'Cascading Style Sheets', 'Common Style Sheets', 'Creative Style Sheets', 'Computer Style Sheets', 7, 2, 1, 1, 'Easy'),
(4, '¿Cuál es el símbolo utilizado para denotar una clase en CSS?', '.', '#', '@', '$', 6, 1, 1, 1, 'Easy'),
(5, '¿Cuál de los siguientes es un lenguaje de programación orientado a objetos?', 'Java', 'SQL', 'HTML', 'CSS', 59, 2, 1, 1, 'Easy'),
(6, '¿Cuál es el resultado de sumar 2 y 3 en el lenguaje de programación JavaScript?', '5', '2', '3', '23', 5, 3, 1, 1, 'Easy'),
(7, '¿Qué es un bucle \"for\" en programación?', 'Una estructura de control', 'Un tipo de dato', 'Una función', 'Un operador', 5, 3, 1, 1, 'Easy'),
(8, '¿Cuál de los siguientes no es un tipo de dato en JavaScript?', 'Float', 'String', 'Boolean', 'Number', 3, 0, 1, 1, 'Easy'),
(9, '¿Qué significa HTML?', 'Hypertext Markup Language', 'Hyperlink Text Manipulation Language', 'Home Tool Markup Language', 'Hyper Transfer Mode Language', 1, 1, 1, 1, 'Easy'),
(10, '¿Cuál es el resultado de la operación lógica AND entre true y false?', 'false', 'true', 'null', 'undefined', 2, 0, 1, 1, 'Easy'),
(11, '¿Cuál es el resultado de 5 modulo 2?', '1', '2', '0', '5', 0, 9, 1, 1, 'Easy'),
(12, '¿Cuál de los siguientes no es un framework de desarrollo web?', 'Photoshop', '', 'Angular', 'Vue', 7, 3, 1, 1, 'Easy'),
(13, '¿Cuál de los siguientes no es un tipo de dato primitivo en Java?', 'String', 'int', 'boolean', 'double', 0, 4, 1, 1, 'Easy'),
(14, '¿Qué significa SQL?', 'Structured Query Language', 'Simple Query Language', 'System Query Language', 'Structured Query Logic', 0, 5, 1, 1, 'Easy'),
(15, '¿Cuál es el resultado de la operación 4 + \"4\" en JavaScript?', '\"44\"', '8', 'NaN', '\"8\"', 1, 4, 1, 1, 'Easy'),
(16, '¿Cuál de los siguientes es un sistema operativo de código abierto?', 'Linux', 'Windows', 'MacOS', 'iOS', 4, 20, 1, 1, 'Easy'),
(17, '¿Qué es un repositorio en el contexto de Git?', 'Un lugar donde se almacenan los archivos de un proyecto', 'Una función que permite realizar cálculos', 'Una estructura de control', 'Una biblioteca de funciones', 1, 6, 1, 1, 'Easy'),
(18, '¿Cuál de los siguientes no es un tipo de dato en PHP?', 'Void', 'String', 'Integer', 'Boolean', 1, 1, 1, 1, 'Easy'),
(19, '¿Qué significa API?', 'Application Programming Interface', 'Automated Program Interaction', 'Advanced Program Instructions', 'Application Performance Index', 4, 1, 1, 1, 'Easy'),
(20, '¿Cuál de los siguientes es un lenguaje de programación interpretado?', 'Python', 'C++', 'Java', 'C#', 3, 0, 1, 1, 'Easy'),
(21, '¿En qué año se produjo la Revolución de Mayo en Argentina?', '1810', '1820', '1830', '1840', 6, 2, 2, 1, 'Easy'),
(22, '¿Quién fue el primer presidente de Argentina?', 'Bernardino Rivadavia', 'Juan Manuel de Rosas', 'Bartolomé Mitre', 'Justo José de Urquiza', 3, 1, 2, 1, 'Easy'),
(23, '¿Qué batalla marcó el fin del dominio español en Argentina?', 'Batalla de Tucumán', 'Batalla de Cepeda', 'Batalla de Chacabuco', 'Batalla de Caseros', 0, 3, 2, 1, 'Easy'),
(24, '¿En qué año se sancionó la Constitución Nacional de Argentina?', '1853', '1863', '1873', '1883', 0, 8, 2, 1, 'Easy'),
(25, '¿Quién fue el prócer argentino conocido como \"El Padre de la Patria\"?', 'Manuel Belgrano', 'José de San Martín', 'Juan Manuel de Rosas', 'Domingo Faustino Sarmiento', 0, 2, 2, 1, 'Easy'),
(26, '¿En qué año se produjo la guerra de Malvinas entre Argentina y el Reino Unido?', '1982', '1972', '1992', '1962', 3, 1, 2, 1, 'Easy'),
(27, '¿Quién fue el general argentino que lideró la Campaña del Desierto?', 'Julio Argentino Roca', 'Bartolomé Mitre', 'Domingo Faustino Sarmiento', 'Juan Manuel de Rosas', 5, 1, 2, 1, 'Easy'),
(28, '¿En qué año se independizó Argentina?', '1816', '1826', '1836', '1846', 2, 6, 2, 1, 'Easy'),
(29, '¿Quién fue el presidente argentino que gobernó durante la conocida \"Década Infame\"?', 'Agustín P. Justo', 'Arturo Frondizi', 'Hipólito Yrigoyen', 'Roberto M. Ortiz', 0, 2, 2, 1, 'Easy'),
(30, '¿Qué presidente argentino fue derrocado por el golpe militar de 1976?', 'Isabel Perón', 'Juan Domingo Perón', 'Raúl Alfonsín', 'Néstor Kirchner', 4, 1, 2, 1, 'Easy'),
(31, '¿Cuál es el país más grande del mundo en términos de superficie?', 'Rusia', 'Canadá', 'China', 'Estados Unidos', 2, 3, 3, 1, 'Easy'),
(32, '¿Cuál es el río más largo del mundo?', 'El río Amazonas', 'El río Nilo', 'El río Misisipi', 'El río Yangtsé', 0, 6, 3, 1, 'Easy'),
(33, '¿Cuál es la montaña más alta del mundo?', 'El Monte Everest', 'El Monte Kilimanjaro', 'El Monte Aconcagua', 'El Monte McKinley', 4, 0, 3, 1, 'Easy'),
(34, '¿Cuál es la capital de Australia?', 'Canberra', 'Sídney', 'Melbourne', 'Brisbane', 0, 4, 3, 1, 'Easy'),
(35, '¿Cuál es el océano más grande del mundo?', 'El Océano Pacífico', 'El Océano Atlántico', 'El Océano Índico', 'El Océano Ártico', 3, 2, 3, 1, 'Easy'),
(36, '¿En qué continente se encuentra el desierto del Sahara?', 'África', 'Asia', 'América', 'Europa', 2, 5, 3, 1, 'Easy'),
(37, '¿Cuál es el país más poblado del mundo?', 'China', 'India', 'Estados Unidos', 'Brasil', 1, 7, 3, 1, 'Easy'),
(38, '¿Cuál es el país más pequeño del mundo en términos de superficie?', 'El Vaticano', 'Mónaco', 'Nauru', 'San Marino', 2, 8, 3, 1, 'Easy'),
(39, '¿En qué país se encuentra la Gran Muralla China?', 'China', 'India', 'Japón', 'Corea del Sur', 8, 1, 3, 1, 'Easy'),
(40, '¿Cuál es la isla más grande del mundo?', 'Groenlandia', 'Madagascar', 'Borneo', 'Nueva Guinea', 4, 2, 3, 1, 'Easy'),
(45, 'una pregunta', 'correcta', 'incorrecta', 'incorrecta', 'incorrecta', NULL, NULL, 2, 3, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ReportedQuestion`
--

CREATE TABLE `ReportedQuestion` (
  `ReportID` int(11) NOT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ReportReason` varchar(255) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ReportedQuestion`
--

INSERT INTO `ReportedQuestion` (`ReportID`, `QuestionID`, `UserID`, `ReportReason`, `Status`) VALUES
(1, 1, 3, 'alog', 'fixed'),
(2, 39, 3, 'algo', 'fixed'),
(3, 21, 5, 'algo', 'pending'),
(4, 16, 5, 'algo', 'fixed');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `States`
--

CREATE TABLE `States` (
  `StateID` int(11) NOT NULL,
  `StateName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `States`
--

INSERT INTO `States` (`StateID`, `StateName`) VALUES
(1, 'Habilitada'),
(2, 'Deshabilitada'),
(3, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User`
--

CREATE TABLE `User` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `BirthYear` int(11) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `ProfilePicture` text DEFAULT NULL,
  `QrPicture` text DEFAULT NULL,
  `AccountStatus` varchar(20) DEFAULT NULL,
  `Rol` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `User`
--

INSERT INTO `User` (`UserID`, `FullName`, `BirthYear`, `Gender`, `Country`, `City`, `Email`, `Password`, `Username`, `ProfilePicture`, `QrPicture`, `AccountStatus`, `Rol`) VALUES
(1, 'John Doe', 1990, 'Non-Binary', 'United States', 'New York', 'johndoe@example.com', 'password123', 'johndoe123', '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', NULL, 'Active', 'user'),
(2, 'Jane Smith', 1985, 'Female', 'Canada', 'Toronto', 'janesmith@example.com', 'password456', 'janesmith789', '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', NULL, 'Active', 'admin'),
(3, 'rodrigo', 1993, 'Male', 'Argentina', 'Moron', 'rodrigojcosentino@gmail.com', 'rodrigo', 'rodrigo', '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', 'Active', 'admin');
INSERT INTO `User` (`UserID`, `FullName`, `BirthYear`, `Gender`, `Country`, `City`, `Email`, `Password`, `Username`, `ProfilePicture`, `QrPicture`, `AccountStatus`, `Rol`) VALUES
(4, 'rodrigo1', 1999, 'Male', 'Argentina', 'Provincia de Buenos Aires , Morón', 'yanina.tahiel@gmail.com', 'admin', 'admin', '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', 'Active', 'user'),
(5, 'algo', 1993, 'Non-Binary', 'Argentina', 'Provincia de Buenos Aires , La Matanza', 'yaninaceo@gmail.com', 'yanina', 'yanina', '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', 'Active', 'user');
INSERT INTO `User` (`UserID`, `FullName`, `BirthYear`, `Gender`, `Country`, `City`, `Email`, `Password`, `Username`, `ProfilePicture`, `QrPicture`, `AccountStatus`, `Rol`) VALUES
(6, 'algo2', 1993, 'Non-Binary', 'Argentina', 'Provincia de Buenos Aires , Morón', 'rodrigocosentino@outlook.com', 'rodrigo', 'rodrigo2', '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', 'Active', 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserGames`
--

CREATE TABLE `UserGames` (
  `GameID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL,
  `Result` varchar(20) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NumQuestions` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `UserGames`
--

INSERT INTO `UserGames` (`GameID`, `UserID`, `Score`, `Result`, `Timestamp`, `NumQuestions`) VALUES
(1, 3, 1, 'finish', '2023-06-15 19:16:14', 2),
(2, 3, 2, 'finish', '2023-06-15 22:56:25', 3),
(3, 3, 0, 'finish', '2023-06-25 22:57:36', 1),
(4, 3, 3, 'finish', '2023-06-25 23:06:09', 4),
(5, 3, 2, 'finish', '2023-06-25 23:07:09', 3),
(6, 3, 0, 'finish', '2023-06-25 23:10:39', 1),
(7, 3, 0, 'finish', '2023-06-25 23:14:24', 1),
(8, 3, 1, 'finish', '2023-06-25 23:14:48', 2),
(9, 3, 4, 'finish', '2023-06-17 07:34:32', 5),
(10, 3, 0, 'finish', '2023-07-09 21:25:34', 1),
(11, 3, 0, 'finish', '2023-07-09 21:25:47', 1),
(12, 3, 1, 'finish', '2023-07-09 21:25:58', 2),
(13, 3, 5, 'finish', '2023-07-09 21:26:33', 6),
(14, 3, 60, 'finish', '2023-07-09 22:33:05', 61),
(15, 3, 5, 'finish', '2023-07-09 22:48:25', 6),
(16, 3, 2, 'finish', '2023-07-10 18:23:17', 3),
(17, 1, 1, 'finish', '2023-07-10 00:06:31', 2),
(18, 3, 10, 'finish', '2023-07-10 18:25:01', 11),
(19, 3, 0, 'finish', '2023-07-10 18:45:51', 1),
(20, 3, 0, 'finish', '2023-07-10 18:46:16', 1),
(21, 3, 4, 'finish', '2023-07-10 18:46:53', 5),
(22, 1, 0, 'finish', '2023-07-10 18:47:24', 1),
(23, 1, 5, 'finish', '2023-07-10 18:48:01', 6),
(24, 3, 1, 'finish', '2023-07-10 19:05:19', 2),
(25, 3, 0, 'finish', '2023-07-10 19:05:25', 1),
(26, 3, 5, 'finish', '2023-07-10 19:05:57', 6),
(27, 3, 2, 'finish', '2023-07-10 19:06:11', 3),
(28, 3, 0, 'finish', '2023-07-10 19:06:18', 1),
(29, 3, 0, 'finish', '2023-07-10 19:06:27', 1),
(30, 1, 3, 'finish', '2023-07-10 19:06:56', 4),
(31, 1, 2, 'finish', '2023-07-10 19:07:18', 3),
(32, 1, 7, 'finish', '2023-07-10 19:08:03', 8),
(33, 4, 2, 'finish', '2023-07-10 19:42:45', 3),
(34, 4, 5, 'finish', '2023-07-10 19:43:12', 6),
(35, 4, 0, 'finish', '2023-07-10 19:43:28', 1),
(36, 4, 0, 'finish', '2023-07-10 19:43:33', 1),
(37, 4, 0, 'finish', '2023-07-10 19:43:38', 1),
(38, 4, 0, 'finish', '2023-07-10 19:43:43', 1),
(39, 4, 0, 'finish', '2023-07-10 19:43:47', 1),
(40, 4, 0, 'finish', '2023-07-10 19:43:55', 1),
(41, 3, 1, 'finish', '2023-07-24 19:30:31', 2),
(42, 3, 0, 'finish', '2023-07-24 19:32:29', 1),
(43, 3, 3, 'finish', '2023-07-24 20:14:49', 4),
(44, 3, 0, 'finish', '2023-07-24 20:15:08', 1),
(45, 3, 1, 'finish', '2023-07-24 22:27:19', 2),
(46, 3, 0, 'finish', '2023-07-24 23:13:49', 1),
(47, 3, 0, 'finish', '2023-07-24 23:14:03', 1),
(48, 3, 0, 'finish', '2023-07-24 23:15:42', 1),
(49, 3, 2, 'finish', '2023-07-24 23:24:06', 3),
(50, 3, 1, 'finish', '2023-07-24 23:24:50', 2),
(51, 3, 1, 'finish', '2023-07-24 23:25:14', 2),
(52, 5, 1, 'finish', '2023-07-25 00:01:28', 2),
(53, 5, 0, 'finish', '2023-07-25 00:01:44', 1),
(54, 5, 0, 'finish', '2023-07-25 00:02:02', 1),
(55, 5, 0, 'finish', '2023-07-25 00:02:10', 1),
(56, 5, 1, 'finish', '2023-07-25 00:02:22', 2),
(57, 5, 1, 'finish', '2023-07-25 00:03:45', 2),
(58, 5, 0, 'finish', '2023-07-25 00:04:30', 1),
(59, 5, 0, 'finish', '2023-07-25 00:06:48', 1),
(60, 5, 0, 'finish', '2023-07-25 00:09:12', 1),
(61, 3, 0, 'finish', '2023-07-25 00:45:29', 1),
(62, 5, 2, 'finish', '2023-07-25 02:46:48', 3),
(63, 5, 1, 'finish', '2023-07-25 02:47:18', 2),
(64, 5, 2, 'finish', '2023-07-25 02:47:48', 3),
(65, 5, 0, 'finish', '2023-07-25 04:07:23', 1),
(66, 5, 0, 'finish', '2023-07-25 04:09:35', 1),
(67, 5, 0, 'finish', '2023-07-25 04:11:12', 1),
(68, 5, 1, 'finish', '2023-07-25 04:12:11', 2),
(69, 5, 0, 'finish', '2023-07-25 04:13:18', 1),
(70, 5, 0, 'finish', '2023-07-25 04:15:02', 1),
(71, 5, 0, 'finish', '2023-07-25 04:15:07', 1),
(72, 5, 1, 'finish', '2023-07-25 04:29:47', 2),
(73, 5, 1, 'finish', '2023-07-25 04:36:49', 2),
(74, 5, 2, 'finish', '2023-07-25 04:37:31', 3),
(75, 5, 1, 'finish', '2023-07-25 17:37:58', 3),
(76, 3, 0, 'finish', '2023-07-25 17:19:56', 2),
(77, 3, 0, 'finish', '2023-07-25 17:22:44', 2),
(78, 3, 0, 'finish', '2023-07-25 17:23:15', 2),
(79, 3, 0, 'finish', '2023-07-25 17:24:34', 1),
(80, 3, 1, 'finish', '2023-07-25 17:24:51', 2),
(81, 3, 0, 'finish', '2023-07-25 17:38:13', 1),
(82, 3, 4, 'finish', '2023-07-25 17:38:42', 5),
(83, 3, 0, 'finish', '2023-07-25 18:04:01', 1),
(84, 3, 1, 'finish', '2023-07-25 18:04:43', 2),
(85, 5, 0, 'finish', '2023-07-25 18:05:24', 1),
(86, 3, 0, 'finish', '2023-07-25 18:06:20', 1),
(87, 3, 1, 'finish', '2023-07-25 18:07:04', 2),
(88, 5, 0, 'finish', '2023-07-25 18:08:43', 1),
(89, 5, 2, 'finish', '2023-07-25 18:10:56', 3),
(90, 5, 0, 'finish', '2023-07-25 18:11:54', 1),
(91, 5, 4, 'finish', '2023-07-25 18:19:52', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserQuestions`
--

CREATE TABLE `UserQuestions` (
  `UserQuestionID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `GameID` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `UserQuestions`
--

INSERT INTO `UserQuestions` (`UserQuestionID`, `UserID`, `QuestionID`, `GameID`, `timestamp`, `time`) VALUES
(1, 3, 2, NULL, '2023-07-25 15:24:25', 10),
(2, 3, 4, 2, '2023-07-25 15:24:25', 10),
(3, 3, 19, 2, '2023-07-25 15:24:25', 10),
(4, 3, 13, 2, '2023-07-25 15:24:25', 10),
(5, 3, 3, NULL, '2023-07-25 15:24:25', 10),
(6, 3, 14, 3, '2023-07-25 15:24:25', 10),
(7, 3, 4, 1, '2023-07-25 15:24:25', 10),
(8, 3, 21, 1, '2023-07-25 15:24:25', 10),
(9, 3, 7, 1, '2023-07-25 15:24:25', 10),
(10, 3, 12, 1, '2023-07-25 15:24:25', 10),
(11, 3, 5, 1, '2023-07-25 15:24:25', 10),
(12, 3, 21, 1, '2023-07-25 15:24:25', 10),
(13, 3, 7, 1, '2023-07-25 15:24:25', 10),
(14, 3, 1, 6, '2023-07-25 15:24:25', 10),
(15, 3, 1, 7, '2023-07-25 15:24:25', 10),
(16, 3, 2, 8, '2023-07-25 15:24:25', 10),
(17, 3, 34, 8, '2023-07-25 15:24:25', 10),
(18, 3, 22, 9, '2023-07-25 15:24:25', 10),
(19, 3, 2, 9, '2023-07-25 15:24:25', 10),
(20, 3, 35, 9, '2023-07-25 15:24:25', 10),
(21, 3, 12, 9, '2023-07-25 15:24:25', 10),
(22, 3, 15, 9, '2023-07-25 15:24:25', 10),
(23, 3, 5, 10, '2023-07-25 15:24:25', 10),
(24, 3, 3, 10, '2023-07-25 15:24:25', 10),
(25, 3, 36, 10, '2023-07-25 15:24:25', 10),
(26, 3, 32, 11, '2023-07-25 15:24:25', 10),
(27, 3, 33, 12, '2023-07-25 15:24:25', 10),
(28, 3, 11, 12, '2023-07-25 15:24:25', 10),
(29, 3, 27, 13, '2023-07-25 15:24:25', 10),
(30, 3, 40, 13, '2023-07-25 15:24:25', 10),
(31, 3, 17, 13, '2023-07-25 15:24:25', 10),
(32, 3, 38, 13, '2023-07-25 15:24:25', 10),
(33, 3, 26, 13, '2023-07-25 15:24:25', 10),
(34, 3, 9, 13, '2023-07-25 15:24:25', 10),
(35, 3, 23, 14, '2023-07-25 15:24:25', 10),
(36, 3, 39, 14, '2023-07-25 15:24:25', 10),
(37, 3, 6, 14, '2023-07-25 15:24:25', 10),
(38, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(39, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(40, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(41, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(42, 3, 5, 14, '2023-07-25 15:24:25', 10),
(43, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(44, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(45, 3, 6, 14, '2023-07-25 15:24:25', 10),
(46, 3, 7, 14, '2023-07-25 15:24:25', 10),
(47, 3, 4, 14, '2023-07-25 15:24:25', 10),
(48, 3, 6, 14, '2023-07-25 15:24:25', 10),
(49, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(50, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(51, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(52, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(53, 3, NULL, 14, '2023-07-25 15:24:25', 10),
(54, 3, 7, 14, '2023-07-25 15:24:25', 10),
(55, 3, 4, 14, '2023-07-25 15:24:25', 10),
(56, 3, 6, 14, '2023-07-25 15:24:25', 10),
(57, 3, 5, 14, '2023-07-25 15:24:25', 10),
(58, 3, 5, 14, '2023-07-25 15:24:25', 10),
(59, 3, 6, 14, '2023-07-25 15:24:25', 10),
(60, 3, 7, 14, '2023-07-25 15:24:25', 10),
(61, 3, 4, 14, '2023-07-25 15:24:25', 10),
(62, 3, 4, 14, '2023-07-25 15:24:25', 10),
(63, 3, 7, 14, '2023-07-25 15:24:25', 10),
(64, 3, 6, 14, '2023-07-25 15:24:25', 10),
(65, 3, 5, 14, '2023-07-25 15:24:25', 10),
(66, 3, 5, 14, '2023-07-25 15:24:25', 10),
(67, 3, 6, 14, '2023-07-25 15:24:25', 10),
(68, 3, 7, 14, '2023-07-25 15:24:25', 10),
(69, 3, 4, 14, '2023-07-25 15:24:25', 10),
(70, 3, 5, 14, '2023-07-25 15:24:25', 10),
(71, 3, 4, 14, '2023-07-25 15:24:25', 10),
(72, 3, 7, 15, '2023-07-25 15:24:25', 10),
(73, 3, 6, 15, '2023-07-25 15:24:25', 10),
(74, 3, 7, 15, '2023-07-25 15:24:25', 10),
(75, 3, 4, 15, '2023-07-25 15:24:25', 10),
(76, 3, 5, 15, '2023-07-25 15:24:25', 10),
(77, 3, 6, 15, '2023-07-25 15:24:25', 10),
(78, 3, 4, 15, '2023-07-25 15:24:25', 10),
(79, 3, 5, 15, '2023-07-25 15:24:25', 10),
(80, 3, 6, 15, '2023-07-25 15:24:25', 10),
(81, 3, 7, 15, '2023-07-25 15:24:25', 10),
(82, 3, 4, 15, '2023-07-25 15:24:25', 10),
(83, 3, 5, 15, '2023-07-25 15:24:25', 10),
(84, 3, 7, 15, '2023-07-25 15:24:25', 10),
(85, 3, 6, 15, '2023-07-25 15:24:25', 10),
(86, 3, 4, 15, '2023-07-25 15:24:25', 10),
(87, 3, 5, 15, '2023-07-25 15:24:25', 10),
(88, 3, 6, 15, '2023-07-25 15:24:25', 10),
(89, 3, 7, 15, '2023-07-25 15:24:25', 10),
(90, 3, 7, 15, '2023-07-25 15:24:25', 10),
(91, 3, 5, 15, '2023-07-25 15:24:25', 10),
(92, 3, 6, 15, '2023-07-25 15:24:25', 10),
(93, 3, 4, 15, '2023-07-25 15:24:25', 10),
(94, 3, 7, 15, '2023-07-25 15:24:25', 10),
(95, 3, 6, 15, '2023-07-25 15:24:25', 10),
(96, 3, 5, 15, '2023-07-25 15:24:25', 10),
(97, 3, 4, 15, '2023-07-25 15:24:25', 10),
(98, 3, 7, 15, '2023-07-25 15:24:25', 10),
(99, 3, 6, 15, '2023-07-25 15:24:25', 10),
(100, 3, 5, 15, '2023-07-25 15:24:25', 10),
(101, 3, 4, 15, '2023-07-25 15:24:25', 10),
(102, 3, 4, 15, '2023-07-25 15:24:25', 10),
(103, 3, 7, 15, '2023-07-25 15:24:25', 10),
(104, 3, 6, 15, '2023-07-25 15:24:25', 10),
(105, 3, 5, 15, '2023-07-25 15:24:25', 10),
(106, 3, 5, 15, '2023-07-25 15:24:25', 10),
(107, 3, 6, 15, '2023-07-25 15:24:25', 10),
(108, 3, 4, 16, '2023-07-25 15:24:25', 10),
(109, 3, 7, 16, '2023-07-25 15:24:25', 10),
(110, 3, 39, 16, '2023-07-25 15:24:25', 10),
(111, 1, 4, 17, '2023-07-25 15:24:25', 10),
(112, 1, 7, 17, '2023-07-25 15:24:25', 10),
(113, 3, 1, 16, '2023-07-25 15:24:25', 10),
(114, 3, 3, 16, '2023-07-25 15:24:25', 10),
(115, 3, 3, 16, '2023-07-25 15:24:25', 10),
(116, 3, 39, 18, '2023-07-25 15:24:25', 10),
(117, 3, 39, 18, '2023-07-25 15:24:25', 10),
(118, 3, 2, 18, '2023-07-25 15:24:25', 10),
(119, 3, 39, 18, '2023-07-25 15:24:25', 10),
(120, 3, 39, 18, '2023-07-25 15:24:25', 10),
(121, 3, 3, 18, '2023-07-25 15:24:25', 10),
(122, 3, 3, 18, '2023-07-25 15:24:25', 10),
(123, 3, 3, 18, '2023-07-25 15:24:25', 10),
(124, 3, 1, 18, '2023-07-25 15:24:25', 10),
(125, 3, 39, 18, '2023-07-25 15:24:25', 10),
(126, 3, 2, 18, '2023-07-25 15:24:25', 10),
(127, 3, 26, 19, '2023-07-25 15:24:25', 10),
(128, 3, 11, 20, '2023-07-25 15:24:25', 10),
(129, 3, 30, 21, '2023-07-25 15:24:25', 10),
(130, 3, 28, 21, '2023-07-25 15:24:25', 10),
(131, 3, 19, 21, '2023-07-25 15:24:25', 10),
(132, 3, 20, 21, '2023-07-25 15:24:25', 10),
(133, 3, 32, 21, '2023-07-25 15:24:25', 10),
(134, 1, 34, 22, '2023-07-25 15:24:25', 10),
(135, 1, 18, 23, '2023-07-25 15:24:25', 10),
(136, 1, 27, 23, '2023-07-25 15:24:25', 10),
(137, 1, 20, 23, '2023-07-25 15:24:25', 10),
(138, 1, 31, 23, '2023-07-25 15:24:25', 10),
(139, 1, 26, 23, '2023-07-25 15:24:25', 10),
(140, 1, 37, 23, '2023-07-25 15:24:25', 10),
(141, 3, 22, 24, '2023-07-25 15:24:25', 10),
(142, 3, 37, 24, '2023-07-25 15:24:25', 10),
(143, 3, 28, 25, '2023-07-25 15:24:25', 10),
(144, 3, 27, 26, '2023-07-25 15:24:25', 10),
(145, 3, 3, 26, '2023-07-25 15:24:25', 10),
(146, 3, 3, 26, '2023-07-25 15:24:25', 10),
(147, 3, 33, 26, '2023-07-25 15:24:25', 10),
(148, 3, 16, 26, '2023-07-25 15:24:25', 10),
(149, 3, 1, 26, '2023-07-25 15:24:25', 10),
(150, 3, 40, 27, '2023-07-25 15:24:25', 10),
(151, 3, 38, 27, '2023-07-25 15:24:25', 10),
(152, 3, 24, 27, '2023-07-25 15:24:25', 10),
(153, 3, 25, 28, '2023-07-25 15:24:25', 10),
(154, 3, 14, 29, '2023-07-25 15:24:25', 10),
(155, 1, 8, 30, '2023-07-25 15:24:25', 10),
(156, 1, 21, 30, '2023-07-25 15:24:25', 10),
(157, 1, 36, 30, '2023-07-25 15:24:25', 10),
(158, 1, 17, 30, '2023-07-25 15:24:25', 10),
(159, 1, 3, 31, '2023-07-25 15:24:25', 10),
(160, 1, 9, 31, '2023-07-25 15:24:25', 10),
(161, 1, 29, 31, '2023-07-25 15:24:25', 10),
(162, 1, 22, 32, '2023-07-25 15:24:25', 10),
(163, 1, 12, 32, '2023-07-25 15:24:25', 10),
(164, 1, 1, 32, '2023-07-25 15:24:25', 10),
(165, 1, 19, 32, '2023-07-25 15:24:25', 10),
(166, 1, 2, 32, '2023-07-25 15:24:25', 10),
(167, 1, 5, 32, '2023-07-25 15:24:25', 10),
(168, 1, 33, 32, '2023-07-25 15:24:25', 10),
(169, 1, 11, 32, '2023-07-25 15:24:25', 10),
(170, 4, 21, 33, '2023-07-25 15:24:25', 10),
(171, 4, 4, 33, '2023-07-25 15:24:25', 10),
(172, 4, 24, 33, '2023-07-25 15:24:25', 10),
(173, 4, 40, 34, '2023-07-25 15:24:25', 10),
(174, 4, 2, 34, '2023-07-25 15:24:25', 10),
(175, 4, 19, 34, '2023-07-25 15:24:25', 10),
(176, 4, 39, 34, '2023-07-25 15:24:25', 10),
(177, 4, 30, 34, '2023-07-25 15:24:25', 10),
(178, 4, 32, 34, '2023-07-25 15:24:25', 10),
(179, 4, 12, 35, '2023-07-25 15:24:25', 10),
(180, 4, 37, 36, '2023-07-25 15:24:25', 10),
(181, 4, 31, 37, '2023-07-25 15:24:25', 10),
(182, 4, 35, 38, '2023-07-25 15:24:25', 10),
(183, 4, 28, 39, '2023-07-25 15:24:25', 10),
(184, 4, 15, 40, '2023-07-25 15:24:25', 10),
(185, 3, 8, 41, '2023-07-25 15:24:25', 10),
(186, 3, 31, 41, '2023-07-25 15:24:25', 10),
(187, 3, 24, 41, '2023-07-25 15:24:25', 10),
(188, 3, 25, 41, '2023-07-25 15:24:25', 10),
(189, 3, 32, 41, '2023-07-25 15:24:25', 10),
(190, 3, 29, 41, '2023-07-25 15:24:25', 10),
(191, 3, 38, 41, '2023-07-25 15:24:25', 10),
(192, 3, 40, 41, '2023-07-25 15:24:25', 10),
(193, 3, 32, 41, '2023-07-25 15:24:25', 10),
(194, 3, 24, 41, '2023-07-25 15:24:25', 10),
(195, 3, 39, 41, '2023-07-25 15:24:25', 10),
(196, 3, 23, 41, '2023-07-25 15:24:25', 10),
(197, 3, 11, 41, '2023-07-25 15:24:25', 10),
(198, 3, 8, 41, '2023-07-25 15:24:25', 10),
(199, 3, 20, 41, '2023-07-25 15:24:25', 10),
(200, 3, 38, 41, '2023-07-25 15:24:25', 10),
(201, 3, 38, 41, '2023-07-25 15:24:25', 10),
(202, 3, 20, 41, '2023-07-25 15:24:25', 10),
(203, 3, 23, 41, '2023-07-25 15:24:25', 10),
(204, 3, 12, 41, '2023-07-25 15:24:25', 10),
(205, 3, 27, 41, '2023-07-25 15:24:25', 10),
(206, 3, 24, 41, '2023-07-25 15:24:25', 10),
(207, 3, 32, 42, '2023-07-25 15:24:25', 10),
(208, 3, 40, 42, '2023-07-25 15:24:25', 10),
(209, 3, 21, 42, '2023-07-25 15:24:25', 10),
(210, 3, 10, 43, '2023-07-25 15:24:25', 10),
(211, 3, 16, 43, '2023-07-25 15:24:25', 10),
(212, 3, 35, 43, '2023-07-25 15:24:25', 10),
(213, 3, 29, 43, '2023-07-25 15:24:25', 10),
(214, 3, 35, 43, '2023-07-25 15:24:25', 10),
(215, 3, 30, 43, '2023-07-25 15:24:25', 10),
(216, 3, 34, 43, '2023-07-25 15:24:25', 10),
(217, 3, 37, 43, '2023-07-25 15:24:25', 10),
(218, 3, 16, 43, '2023-07-25 15:24:25', 10),
(219, 3, 34, 43, '2023-07-25 15:24:25', 10),
(220, 3, 1, 43, '2023-07-25 15:24:25', 10),
(221, 3, 22, 43, '2023-07-25 15:24:25', 10),
(222, 3, 23, 43, '2023-07-25 15:24:25', 10),
(223, 3, 28, 43, '2023-07-25 15:24:25', 10),
(224, 3, 33, 43, '2023-07-25 15:24:25', 10),
(225, 3, 16, 43, '2023-07-25 15:24:25', 10),
(226, 3, 8, 43, '2023-07-25 15:24:25', 10),
(227, 3, 28, 43, '2023-07-25 15:24:25', 10),
(228, 3, 10, 43, '2023-07-25 15:24:25', 10),
(229, 3, 18, 43, '2023-07-25 15:24:25', 10),
(230, 3, 31, 43, '2023-07-25 15:24:25', 10),
(231, 3, 17, 43, '2023-07-25 15:24:25', 10),
(232, 3, 39, 43, '2023-07-25 15:24:25', 10),
(233, 3, 15, 43, '2023-07-25 15:24:25', 10),
(234, 3, 13, 43, '2023-07-25 15:24:25', 10),
(235, 3, 14, 43, '2023-07-25 15:24:25', 10),
(236, 3, 25, 44, '2023-07-25 15:24:25', 10),
(237, 3, 30, 45, '2023-07-25 15:24:25', 10),
(238, 3, 19, 45, '2023-07-25 15:24:25', 10),
(239, 3, 12, 45, '2023-07-25 15:24:25', 10),
(240, 3, 9, 45, '2023-07-25 15:24:25', 10),
(241, 3, 27, 45, '2023-07-25 15:24:25', 10),
(242, 3, 11, 45, '2023-07-25 15:24:25', 10),
(243, 3, 20, 45, '2023-07-25 15:24:25', 10),
(244, 3, 32, 45, '2023-07-25 15:24:25', 10),
(245, 3, 35, 45, '2023-07-25 15:24:25', 10),
(246, 3, 36, 45, '2023-07-25 15:24:25', 10),
(247, 3, 2, 46, '2023-07-25 15:24:25', 10),
(248, 3, 12, 46, '2023-07-25 15:24:25', 10),
(249, 3, 1, 46, '2023-07-25 15:24:25', 10),
(250, 3, 12, 46, '2023-07-25 15:24:25', 10),
(251, 3, 38, 47, '2023-07-25 15:24:25', 10),
(252, 3, 28, 48, '2023-07-25 15:24:25', 10),
(253, 3, 36, 49, '2023-07-25 15:24:25', 10),
(254, 3, 8, 49, '2023-07-25 15:24:25', 10),
(255, 3, 17, 49, '2023-07-25 15:24:25', 10),
(256, 3, 3, 50, '2023-07-25 15:24:25', 10),
(257, 3, 40, 50, '2023-07-25 15:24:25', 10),
(258, 3, 20, 50, '2023-07-25 15:24:25', 10),
(259, 3, 40, 50, '2023-07-25 15:24:25', 10),
(260, 3, 35, 50, '2023-07-25 15:24:25', 10),
(261, 3, 39, 50, '2023-07-25 15:24:25', 10),
(262, 3, 9, 50, '2023-07-25 15:24:25', 10),
(263, 3, 21, 50, '2023-07-25 15:24:25', 10),
(264, 3, 17, 50, '2023-07-25 15:24:25', 10),
(265, 3, 21, 51, '2023-07-25 15:24:25', 10),
(266, 3, 13, 51, '2023-07-25 15:24:25', 10),
(267, 3, 36, 51, '2023-07-25 15:24:25', 10),
(268, 3, 38, 51, '2023-07-25 15:24:25', 10),
(269, 5, 2, 52, '2023-07-25 15:24:25', 10),
(270, 5, 23, 52, '2023-07-25 15:24:25', 10),
(271, 5, 21, 53, '2023-07-25 15:24:25', 10),
(272, 5, 13, 54, '2023-07-25 15:24:25', 10),
(273, 5, 24, 55, '2023-07-25 15:24:25', 10),
(274, 5, 4, 56, '2023-07-25 15:24:25', 10),
(275, 5, 37, 56, '2023-07-25 15:24:25', 10),
(276, 5, 28, 57, '2023-07-25 15:24:25', 10),
(277, 5, 16, 57, '2023-07-25 15:24:25', 10),
(278, 5, 25, 57, '2023-07-25 15:24:25', 10),
(279, 5, 11, 57, '2023-07-25 15:24:25', 10),
(280, 5, 35, 57, '2023-07-25 15:24:25', 10),
(281, 5, 36, 57, '2023-07-25 15:24:25', 10),
(282, 5, 19, 57, '2023-07-25 15:24:25', 10),
(283, 5, 39, 57, '2023-07-25 15:24:25', 10),
(284, 5, 10, 57, '2023-07-25 15:24:25', 10),
(285, 5, 7, 57, '2023-07-25 15:24:25', 10),
(286, 5, 38, 57, '2023-07-25 15:24:25', 10),
(287, 5, 15, 57, '2023-07-25 15:24:25', 10),
(288, 5, 40, 57, '2023-07-25 15:24:25', 10),
(289, 5, 17, 58, '2023-07-25 15:24:25', 10),
(290, 5, 22, 59, '2023-07-25 15:24:25', 10),
(291, 5, 5, 60, '2023-07-25 15:24:25', 10),
(292, 3, 39, 61, '2023-07-25 15:24:25', 10),
(293, 5, 26, 62, '2023-07-25 15:24:25', 10),
(294, 5, 12, 62, '2023-07-25 15:24:25', 10),
(295, 5, 14, 62, '2023-07-25 15:24:25', 10),
(296, 5, 6, 63, '2023-07-25 15:24:25', 10),
(297, 5, 32, 63, '2023-07-25 15:24:25', 10),
(298, 5, 20, 64, '2023-07-25 15:24:25', 10),
(299, 5, 30, 64, '2023-07-25 15:24:25', 10),
(300, 5, 27, 64, '2023-07-25 15:24:25', 10),
(301, 5, 18, 65, '2023-07-25 15:24:25', 10),
(302, 5, 9, 65, '2023-07-25 15:24:25', 10),
(303, 5, 8, 65, '2023-07-25 15:24:25', 10),
(304, 5, 33, 65, '2023-07-25 15:24:25', 10),
(305, 5, 1, 65, '2023-07-25 15:24:25', 10),
(306, 5, 29, 65, '2023-07-25 15:24:25', 10),
(307, 5, 3, 66, '2023-07-25 15:24:25', 10),
(308, 5, 31, 66, '2023-07-25 15:24:25', 10),
(309, 5, 34, 66, '2023-07-25 15:24:25', 10),
(310, 5, 13, 66, '2023-07-25 15:24:25', 10),
(311, 5, 33, 66, '2023-07-25 15:24:25', 10),
(312, 5, 39, 66, '2023-07-25 15:24:25', 10),
(313, 5, 21, 66, '2023-07-25 15:24:25', 10),
(314, 5, 26, 66, '2023-07-25 15:24:25', 10),
(315, 5, 34, 66, '2023-07-25 15:24:25', 10),
(316, 5, 30, 66, '2023-07-25 15:24:25', 10),
(317, 5, 28, 66, '2023-07-25 15:24:25', 10),
(318, 5, 36, 66, '2023-07-25 15:24:25', 10),
(319, 5, 31, 66, '2023-07-25 15:24:25', 10),
(320, 5, 29, 66, '2023-07-25 15:24:25', 10),
(321, 5, 17, 66, '2023-07-25 15:24:25', 10),
(322, 5, 10, 66, '2023-07-25 15:24:25', 10),
(323, 5, 9, 66, '2023-07-25 15:24:25', 10),
(324, 5, 19, 66, '2023-07-25 15:24:25', 10),
(325, 5, 27, 66, '2023-07-25 15:24:25', 10),
(326, 5, 24, 66, '2023-07-25 15:24:25', 10),
(327, 5, 37, 66, '2023-07-25 15:24:25', 10),
(328, 5, 38, 66, '2023-07-25 15:24:25', 10),
(329, 5, 4, 66, '2023-07-25 15:24:25', 10),
(330, 5, 18, 66, '2023-07-25 15:24:25', 10),
(331, 5, 35, 66, '2023-07-25 15:24:25', 10),
(332, 5, 25, 66, '2023-07-25 15:24:25', 10),
(333, 5, 15, 66, '2023-07-25 15:24:25', 10),
(334, 5, 32, 66, '2023-07-25 15:24:25', 10),
(335, 5, 2, 66, '2023-07-25 15:24:25', 10),
(336, 5, 8, 66, '2023-07-25 15:24:25', 10),
(337, 5, 20, 66, '2023-07-25 15:24:25', 10),
(338, 5, 5, 66, '2023-07-25 15:24:25', 10),
(339, 5, 6, 66, '2023-07-25 15:24:25', 10),
(340, 5, 3, 66, '2023-07-25 15:24:25', 10),
(341, 5, 7, 66, '2023-07-25 15:24:25', 10),
(342, 5, 1, 66, '2023-07-25 15:24:25', 10),
(343, 5, 40, 66, '2023-07-25 15:24:25', 10),
(344, 5, 22, 66, '2023-07-25 15:24:25', 10),
(345, 5, 11, 66, '2023-07-25 15:24:25', 10),
(346, 5, 16, 66, '2023-07-25 15:24:25', 10),
(347, 5, 12, 66, '2023-07-25 15:24:25', 10),
(348, 5, 14, 66, '2023-07-25 15:24:25', 10),
(349, 5, 23, 66, '2023-07-25 15:24:25', 10),
(350, 5, 26, 66, '2023-07-25 15:24:25', 10),
(351, 5, 28, 66, '2023-07-25 15:24:25', 10),
(352, 5, 37, 66, '2023-07-25 15:24:25', 10),
(353, 5, 8, 66, '2023-07-25 15:24:25', 10),
(354, 5, 3, 66, '2023-07-25 15:24:25', 10),
(355, 5, 13, 66, '2023-07-25 15:24:25', 10),
(356, 5, 35, 66, '2023-07-25 15:24:25', 10),
(357, 5, 21, 66, '2023-07-25 15:24:25', 10),
(358, 5, 2, 66, '2023-07-25 15:24:25', 10),
(359, 5, 10, 66, '2023-07-25 15:24:25', 10),
(360, 5, 18, 66, '2023-07-25 15:24:25', 10),
(361, 5, 24, 66, '2023-07-25 15:24:25', 10),
(362, 5, 23, 66, '2023-07-25 15:24:25', 10),
(363, 5, 22, 66, '2023-07-25 15:24:25', 10),
(364, 5, 11, 66, '2023-07-25 15:24:25', 10),
(365, 5, 31, 66, '2023-07-25 15:24:25', 10),
(366, 5, 19, 66, '2023-07-25 15:24:25', 10),
(367, 5, 9, 66, '2023-07-25 15:24:25', 10),
(368, 5, 29, 66, '2023-07-25 15:24:25', 10),
(369, 5, 39, 66, '2023-07-25 15:24:25', 10),
(370, 5, 4, 66, '2023-07-25 15:24:25', 10),
(371, 5, 38, 66, '2023-07-25 15:24:25', 10),
(372, 5, 7, 66, '2023-07-25 15:24:25', 10),
(373, 5, 6, 66, '2023-07-25 15:24:25', 10),
(374, 5, 30, 66, '2023-07-25 15:24:25', 10),
(375, 5, 25, 66, '2023-07-25 15:24:25', 10),
(376, 5, 20, 66, '2023-07-25 15:24:25', 10),
(377, 5, 15, 66, '2023-07-25 15:24:25', 10),
(378, 5, 1, 66, '2023-07-25 15:24:25', 10),
(379, 5, 27, 66, '2023-07-25 15:24:25', 10),
(380, 5, 33, 66, '2023-07-25 15:24:25', 10),
(381, 5, 12, 66, '2023-07-25 15:24:25', 10),
(382, 5, 40, 66, '2023-07-25 15:24:25', 10),
(383, 5, 32, 66, '2023-07-25 15:24:25', 10),
(384, 5, 17, 66, '2023-07-25 15:24:25', 10),
(385, 5, 34, 66, '2023-07-25 15:24:25', 10),
(386, 5, 5, 66, '2023-07-25 15:24:25', 10),
(387, 5, 14, 66, '2023-07-25 15:24:25', 10),
(388, 5, 36, 66, '2023-07-25 15:24:25', 10),
(389, 5, 16, 66, '2023-07-25 15:24:25', 10),
(390, 5, 39, 66, '2023-07-25 15:24:25', 10),
(391, 5, 2, 66, '2023-07-25 15:24:25', 10),
(392, 5, 32, 66, '2023-07-25 15:24:25', 10),
(393, 5, 31, 67, '2023-07-25 15:24:25', 10),
(394, 5, 24, 67, '2023-07-25 15:24:25', 10),
(395, 5, 12, 68, '2023-07-25 15:24:25', 10),
(396, 5, 7, 68, '2023-07-25 15:24:25', 10),
(397, 5, 9, 69, '2023-07-25 15:24:25', 10),
(398, 5, 11, 69, '2023-07-25 15:24:25', 10),
(399, 5, 28, 70, '2023-07-25 15:24:25', 10),
(400, 5, 19, 71, '2023-07-25 15:24:25', 10),
(401, 5, 22, NULL, '2023-07-25 15:24:25', 10),
(402, 5, 3, NULL, '2023-07-25 15:24:25', 10),
(403, 5, 20, NULL, '2023-07-25 15:24:25', 10),
(404, 5, 33, NULL, '2023-07-25 15:24:25', 10),
(405, 5, 29, NULL, '2023-07-25 15:24:25', 10),
(406, 5, 26, NULL, '2023-07-25 15:24:25', 10),
(407, 5, 21, NULL, '2023-07-25 15:24:25', 10),
(408, 5, 36, NULL, '2023-07-25 15:24:25', 10),
(409, 5, 4, NULL, '2023-07-25 15:24:25', 10),
(410, 5, 27, NULL, '2023-07-25 15:24:25', 10),
(411, 5, 1, NULL, '2023-07-25 15:24:25', 10),
(412, 5, 15, 72, '2023-07-25 15:24:25', 10),
(413, 5, 23, 72, '2023-07-25 15:24:25', 10),
(414, 5, 16, 72, '2023-07-25 15:24:25', 10),
(415, 5, 25, 72, '2023-07-25 15:24:25', 10),
(416, 5, 30, 73, '2023-07-25 15:24:25', 10),
(417, 5, 34, 73, '2023-07-25 15:24:25', 10),
(418, 5, 37, 73, '2023-07-25 15:24:25', 10),
(419, 5, 35, 73, '2023-07-25 15:24:25', 10),
(420, 5, 10, 74, '2023-07-25 15:24:25', 10),
(421, 5, 13, 74, '2023-07-25 15:24:25', 10),
(422, 5, 17, 74, '2023-07-25 15:24:25', 10),
(423, 5, 8, 74, '2023-07-25 15:24:25', 10),
(424, 5, 14, 74, '2023-07-25 15:24:25', 10),
(425, 5, 6, 75, '2023-07-25 15:32:15', 10),
(426, 3, 34, 76, '2023-07-25 17:19:45', 10),
(427, 3, 26, 77, '2023-07-25 17:22:24', 10),
(428, 3, 13, 77, '2023-07-25 17:22:33', 10),
(429, 3, 33, 78, '2023-07-25 17:23:02', 10),
(430, 3, 39, 78, '2023-07-25 17:23:03', 10),
(431, 3, 15, 78, '2023-07-25 17:23:04', 10),
(432, 3, 28, 79, '2023-07-25 17:24:23', 10),
(433, 3, 12, 80, '2023-07-25 17:24:45', 10),
(434, 3, 18, 80, '2023-07-25 17:24:49', 10),
(435, 5, 38, 75, '2023-07-25 17:37:50', 10),
(436, 3, 35, 81, '2023-07-25 17:38:06', 10),
(437, 3, 39, 82, '2023-07-25 17:38:16', 10),
(438, 3, 30, 82, '2023-07-25 17:38:20', 10),
(439, 3, 31, 82, '2023-07-25 17:38:28', 10),
(440, 3, 2, 82, '2023-07-25 17:38:34', 10),
(441, 3, 3, 82, '2023-07-25 17:38:38', 10),
(442, 3, 11, 83, '2023-07-25 18:03:55', 10),
(443, 3, 35, 84, '2023-07-25 18:04:33', 10),
(444, 3, 30, 84, '2023-07-25 18:04:40', 10),
(445, 5, 18, 85, '2023-07-25 18:05:13', 10),
(446, 3, 7, 86, '2023-07-25 18:06:09', 10),
(447, 3, 4, 87, '2023-07-25 18:06:52', 10),
(448, 3, 11, 87, '2023-07-25 18:06:59', 10),
(449, 5, 5, 88, '2023-07-25 18:08:33', 10),
(450, 5, 40, 89, '2023-07-25 18:10:32', 10),
(451, 5, 39, 89, '2023-07-25 18:10:39', 10),
(452, 5, 31, 89, '2023-07-25 18:10:45', 10),
(453, 5, 17, 90, '2023-07-25 18:11:44', 10),
(454, 5, 12, 91, '2023-07-25 18:19:26', 10),
(455, 5, 33, 91, '2023-07-25 18:19:33', 10),
(456, 5, 27, 91, '2023-07-25 18:19:40', 10),
(457, 5, 15, 91, '2023-07-25 18:19:45', 10),
(458, 5, 24, 91, '2023-07-25 18:19:49', 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indices de la tabla `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `StateID` (`StateID`);

--
-- Indices de la tabla `ReportedQuestion`
--
ALTER TABLE `ReportedQuestion`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `QuestionID` (`QuestionID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indices de la tabla `States`
--
ALTER TABLE `States`
  ADD PRIMARY KEY (`StateID`);

--
-- Indices de la tabla `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`);

--
-- Indices de la tabla `UserGames`
--
ALTER TABLE `UserGames`
  ADD PRIMARY KEY (`GameID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indices de la tabla `UserQuestions`
--
ALTER TABLE `UserQuestions`
  ADD PRIMARY KEY (`UserQuestionID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `QuestionID` (`QuestionID`),
  ADD KEY `GameID` (`GameID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Categories`
--
ALTER TABLE `Categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `Questions`
--
ALTER TABLE `Questions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `ReportedQuestion`
--
ALTER TABLE `ReportedQuestion`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `User`
--
ALTER TABLE `User`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `UserGames`
--
ALTER TABLE `UserGames`
  MODIFY `GameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `UserQuestions`
--
ALTER TABLE `UserQuestions`
  MODIFY `UserQuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Questions`
--
ALTER TABLE `Questions`
  ADD CONSTRAINT `Questions_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `Categories` (`CategoryID`),
  ADD CONSTRAINT `Questions_ibfk_2` FOREIGN KEY (`StateID`) REFERENCES `States` (`StateID`);

--
-- Filtros para la tabla `ReportedQuestion`
--
ALTER TABLE `ReportedQuestion`
  ADD CONSTRAINT `ReportedQuestion_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `Questions` (`QuestionID`),
  ADD CONSTRAINT `ReportedQuestion_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`);

--
-- Filtros para la tabla `UserGames`
--
ALTER TABLE `UserGames`
  ADD CONSTRAINT `UserGames_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`);

--
-- Filtros para la tabla `UserQuestions`
--
ALTER TABLE `UserQuestions`
  ADD CONSTRAINT `UserQuestions_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`),
  ADD CONSTRAINT `UserQuestions_ibfk_2` FOREIGN KEY (`QuestionID`) REFERENCES `Questions` (`QuestionID`),
  ADD CONSTRAINT `UserQuestions_ibfk_3` FOREIGN KEY (`GameID`) REFERENCES `UserGames` (`GameID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
