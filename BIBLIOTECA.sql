/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.32-MariaDB : Database - biblioteca
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`biblioteca` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `biblioteca`;

/*Table structure for table `book` */

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `ID_BOOK` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `AUTHOR` varchar(255) DEFAULT NULL,
  `STOCK` int(11) DEFAULT NULL,
  `IMAGE` blob DEFAULT NULL,
  `ISBN1` int(11) DEFAULT NULL,
  `ID_GENRE1` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_BOOK`),
  KEY `ISBN1` (`ISBN1`),
  KEY `ID_GENRE1` (`ID_GENRE1`),
  CONSTRAINT `book_ibfk_1` FOREIGN KEY (`ISBN1`) REFERENCES `editorial` (`ISBN`),
  CONSTRAINT `book_ibfk_2` FOREIGN KEY (`ID_GENRE1`) REFERENCES `genre` (`ID_GENRE`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `book` */

LOCK TABLES `book` WRITE;

insert  into `book`(`ID_BOOK`,`NAME`,`DESCRIPTION`,`AUTHOR`,`STOCK`,`IMAGE`,`ISBN1`,`ID_GENRE1`) values (1,'El gran Gatsby','Una novela clásica de F. Scott Fitzgerald.','F. Scott Fitzgerald',9,'uploads/The_Great_Gatsby_Cover_1925_Retouched.jpg',1,1),(2,'Cien años de soledad','Una novela mágica de Gabriel García Márquez.','Gabriel García Márquez',8,'uploads/cien_anos_de_soledad.jpg',2,2),(3,'Don Quijote de la Mancha','La famosa novela de Miguel de Cervantes.','Miguel de Cervantes',15,'uploads/don_quijote.jpg',3,3),(4,'1984','Una novela distópica de George Orwell.','George Orwell',12,'uploads/1984.jpg',4,4),(5,'Matar a un ruiseñor','Una novela de Harper Lee sobre la justicia y la moral.','Harper Lee',7,'uploads/matar_a_un_ruiseñor.jpg',5,5),(6,'Orgullo y prejuicio','Una novela clásica de Jane Austen.','Jane Austen',14,'uploads/orgullo_prejuicio.jpg',6,6),(7,'El código Da Vinci','Un thriller de Dan Brown.','Dan Brown',9,'uploads/portada_el-codigo-da-vinci_dan-brown_201709150030.jpg',7,7),(8,'Los pilares de la Tierra','Una novela histórica de Ken Follett.','Ken Follett',11,'uploads/los_pilares.jpg',8,8),(9,'Harry Potter y la piedra filosofal','La primera novela de la serie de J.K. Rowling.','J.K. Rowling',18,'uploads/harry.jpg',9,9),(10,'El Hobbit','Una novela de fantasía de J.R.R. Tolkien.','J.R.R. Tolkien',13,'uploads/el_hobbit.jpg',10,10),(11,'La sombra del viento','Un thriller literario de Carlos Ruiz Zafón.','Carlos Ruiz Zafón',10,'uploads/la_sombra_del_viento.jpg',11,11),(12,'El alquimista','Una novela de Paulo Coelho sobre la búsqueda de sueños.','Paulo Coelho',14,'uploads/el_alquimista.jpg',12,12),(13,'Crónica de una muerte anunciada','Una novela de Gabriel García Márquez.','Gabriel García Márquez',9,'uploads/cronica_de_una.jpg',13,13),(14,'El nombre de la rosa','Un thriller histórico de Umberto Eco.','Umberto Eco',12,'uploads/el_nombre_rosa.jpg',14,14),(15,'Los juegos del hambre','Una novela distópica de Suzanne Collins.','Suzanne Collins',16,'uploads/los_juegos.jpg',15,15),(16,'El tiempo entre costuras','Una novela histórica de María Dueñas.','María Dueñas',8,'uploads/el_tiempo.jpg',16,16),(17,'El abrazo de la sirena.','Una novela romántica de Ana Alcolea.','Ana Alcolea',11,'uploads/el abrazo.jpg',17,17),(18,'El gran sueño','Un thriller de Harlan Coben.','Harlan Coben',13,'uploads/el gran sueño.jpg',18,18),(19,'El hombre en el castillo','Una novela de Philip K. Dick sobre un mundo alternativo.','Philip K. Dick',10,'uploads/el hombre en el castillo.jpg',19,19),(20,'La chica del tren','Un thriller psicológico de Paula Hawkins.','Paula Hawkins',14,'uploads/la chica del tren.jpg',20,20),(21,'La cabaña','Una novela de William P. Young sobre la fe.','William P. Young',9,'uploads/la cabaña.jpg',21,21),(22,'Nunca me abandones','Una novela de Kazuo Ishiguro.','Kazuo Ishiguro',12,'uploads/nunca me abandones.jpg',22,22),(23,'La carretera','Una novela post-apocalíptica de Cormac McCarthy.','Cormac McCarthy',15,'uploads/la carretera.jpg',23,23),(24,'El psicoanalista','Un thriller de John Katzenbach.','John Katzenbach',11,'uploads/el pisico.jpg',24,24),(25,'El mar en calma','Una novela de Paul Auster.','Paul Auster',8,'uploads/el mar en calma.jpg',25,25),(26,'En busca del tiempo perdido','Una novela de Marcel Proust.','Marcel Proust',7,'uploads/en busca.jpg',26,26),(27,'El hombre invisible','Una novela de H.G. Wells.','H.G. Wells',13,'uploads/el hombre invisible.jpg',27,27),(28,'Viaje al centro de la Tierra','Una novela de Julio Verne.','Julio Verne',14,'uploads/viaje al centro.jpg',28,28),(29,'Drácula','Una novela de Bram Stoker.','Bram Stoker',12,'uploads/dracula.jpg',29,29),(30,'Frankenstein','Una novela de Mary Shelley.','Mary Shelley',10,'uploads/franke.jpg',30,30),(31,'Cumbres borrascosas','Una novela de Emily Brontë.','Emily Brontë',11,'uploads/Cumbres borrascosas.jpg',31,31),(32,'Jane Eyre','Una novela de Charlotte Brontë.','Charlotte Brontë',14,'uploads/Jane Eyre.jpg',32,32),(33,'El retrato de Dorian Gray','Una novela de Oscar Wilde.','Oscar Wilde',9,'uploads/el retrato.jpg',33,33),(35,'El viejo y el mar','Una novela de Ernest Hemingway.','Ernest Hemingway',11,'uploads/el viejo y el mar.jpg',35,35),(36,'En el camino','Una novela de Jack Kerouac.','Jack Kerouac',8,'uploads/en el camino.jpg',36,36),(37,'La jungla de cristal','Una novela de Roderick Thorp.','Roderick Thorp',13,'uploads/la jungla.jpg',37,37),(38,'El perfume','Una novela de Patrick Süskind.','Patrick Süskind',15,'uploads/el perfume.jpg',38,38),(39,'El lobo estepario','Una novela de Hermann Hesse.','Hermann Hesse',12,'uploads/el lobo.jpg',39,39),(40,'El castillo','Una novela de Franz Kafka.','Franz Kafka',9,'uploads/el castillo.jpg',40,40),(43,'La casa de los espíritus','Una novela de Isabel Allende.','Isabel Allende',8,'uploads/la casa.jpg',43,43),(44,'El jardín secreto','Una novela de Frances Hodgson Burnett.','Frances Hodgson Burnett',7,'uploads/el jardin.jpg',44,44),(45,'Siddhartha','Una novela de Hermann Hesse.','Hermann Hesse',13,'uploads/sidd.jpg',45,45),(51,'Este dolor no es mío.','La evidencia científica muestra que los traumas pueden ser heredados.','Mark Wolynn',1,'uploads/este_dolor_no_es_mio.jpg',40,6),(52,'El principito','nuevo','Antoine de Saint-Exupéry',2,'uploads/viaje al centro.jpg',6,7);

UNLOCK TABLES;

/*Table structure for table `editorial` */

DROP TABLE IF EXISTS `editorial`;

CREATE TABLE `editorial` (
  `ISBN` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  PRIMARY KEY (`ISBN`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `editorial` */

LOCK TABLES `editorial` WRITE;

insert  into `editorial`(`ISBN`,`NAME`) values (1,'Penguin Random House'),(2,'HarperCollins'),(3,'Simon & Schuster'),(4,'Macmillan Publishers'),(5,'Hachette Livre'),(6,'Scholastic Corporation'),(7,'Bloomsbury Publishing'),(8,'Pearson Education'),(9,'Wiley'),(10,'Cengage Learning'),(11,'Springer Nature'),(12,'McGraw-Hill Education'),(13,'Elsevier'),(14,'Cambridge University Press'),(15,'Oxford University Press'),(16,'John Wiley & Sons'),(17,'Thames & Hudson'),(18,'Routledge'),(19,'Faber & Faber'),(20,'Harlequin Enterprises'),(21,'Kensington Publishing'),(22,'Chronicle Books'),(23,'Sterling Publishing'),(24,'Workman Publishing'),(25,'Abrams Books'),(26,'Grove Atlantic'),(27,'Sourcebooks'),(28,'Andrews McMeel Publishing'),(29,'Arcadia Publishing'),(30,'Basic Books'),(31,'Crown Publishing Group'),(32,'DK Publishing'),(33,'G.P. Putnam\'s Sons'),(34,'Little, Brown and Company'),(35,'Random House Children\'s Books'),(36,'Tor Books'),(37,'Vintage Books'),(38,'Zondervan'),(39,'Anchor Books'),(40,'Ballantine Books'),(41,'Bantam Books'),(42,'Delacorte Press'),(43,'Del Rey Books'),(44,'Doubleday'),(45,'Golden Books'),(46,'Knopf Doubleday Publishing Group'),(47,'New American Library'),(48,'Pantheon Books'),(49,'Picador'),(50,'St. Martin\'s Press');

UNLOCK TABLES;

/*Table structure for table `favorites` */

DROP TABLE IF EXISTS `favorites`;

CREATE TABLE `favorites` (
  `ID_BOOK` int(10) NOT NULL,
  `ID_USER` int(10) NOT NULL,
  PRIMARY KEY (`ID_BOOK`,`ID_USER`),
  KEY `ID_USER` (`ID_USER`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`ID_BOOK`) REFERENCES `book` (`ID_BOOK`),
  CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `favorites` */

LOCK TABLES `favorites` WRITE;

insert  into `favorites`(`ID_BOOK`,`ID_USER`) values (1,49);

UNLOCK TABLES;

/*Table structure for table `genre` */

DROP TABLE IF EXISTS `genre`;

CREATE TABLE `genre` (
  `ID_GENRE` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_GENRE`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `genre` */

LOCK TABLES `genre` WRITE;

insert  into `genre`(`ID_GENRE`,`NAME`) values (1,'Ficción'),(2,'No Ficción'),(3,'Misterio'),(4,'Suspense'),(5,'Romántica'),(6,'Ciencia Ficción'),(7,'Fantasía'),(8,'Histórica'),(9,'Terror'),(10,'Biografía'),(11,'Autobiografía'),(12,'Autoayuda'),(13,'Salud'),(14,'Viajes'),(15,'Infantil'),(16,'Juvenil'),(17,'Aventura'),(18,'Clásicos'),(19,'Poesía'),(20,'Drama'),(21,'Filosofía'),(22,'Ciencia'),(23,'Psicología'),(24,'Educación'),(25,'Negocios'),(26,'Economía'),(27,'Política'),(28,'Derecho'),(29,'Religión'),(30,'Espiritualidad'),(31,'Arte'),(32,'Música'),(33,'Fotografía'),(34,'Cocina'),(35,'Novelas Gráficas'),(36,'Cuentos Cortos'),(37,'Ensayos'),(38,'Memorias'),(39,'Antología'),(40,'Sátira'),(41,'Humor'),(42,'Deportes'),(43,'Crimen Real'),(44,'Western'),(45,'Distópica'),(46,'Realismo Mágico'),(47,'Fantasía Urbana'),(48,'Romántica Paranormal'),(49,'Ficción Histórica'),(50,'Ficción Literaria'),(51,'Horror');

UNLOCK TABLES;

/*Table structure for table `loans` */

DROP TABLE IF EXISTS `loans`;

CREATE TABLE `loans` (
  `ID_LOAN` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USER` int(11) DEFAULT NULL,
  `ID_BOOK` int(11) DEFAULT NULL,
  `LOAN_DATE` datetime DEFAULT current_timestamp(),
  `RETURN_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_LOAN`),
  KEY `ID_USER` (`ID_USER`),
  KEY `ID_BOOK` (`ID_BOOK`),
  CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID_USER`),
  CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`ID_BOOK`) REFERENCES `book` (`ID_BOOK`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `loans` */

LOCK TABLES `loans` WRITE;

insert  into `loans`(`ID_LOAN`,`ID_USER`,`ID_BOOK`,`LOAN_DATE`,`RETURN_DATE`) values (1,49,1,'2024-08-12 01:53:34','2024-08-13 01:53:00');

UNLOCK TABLES;

/*Table structure for table `user_types` */

DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `user_types` (
  `ID_USER_TYPE` int(10) NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_USER_TYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_types` */

LOCK TABLES `user_types` WRITE;

insert  into `user_types`(`ID_USER_TYPE`,`NAME`) values (1,'Administrador'),(2,'Bibliotecario'),(3,'Miembro'),(4,'Invitado'),(5,'Personal');

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `ID_USER` int(11) NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(50) DEFAULT NULL,
  `LAST_NAME` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `ADDRESS` varchar(200) DEFAULT NULL,
  `ID_USER_TYPE1` int(10) DEFAULT 3,
  `PASSWORD` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_USER`),
  KEY `ID_USER_TYPE1` (`ID_USER_TYPE1`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_USER_TYPE1`) REFERENCES `user_types` (`ID_USER_TYPE`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

insert  into `users`(`ID_USER`,`FIRST_NAME`,`LAST_NAME`,`EMAIL`,`PHONE`,`ADDRESS`,`ID_USER_TYPE1`,`PASSWORD`) values (1,'Juan','Pérez','juan.perez@example.com','555-1234','Calle Falsa 123, Ciudad',3,''),(2,'Ana','García','ana.garcia@example.com','555-5678','Avenida Siempre Viva 456, Ciudad',3,''),(3,'Luis','Martínez','luis.martinez@example.com','555-8765','Boulevard de la Esperanza 789, Ciudad',3,''),(4,'Laura','López','laura.lopez@example.com','555-4321','Calle del Sol 101, Ciudad',3,''),(5,'Carlos','Hernández','carlos.hernandez@example.com','555-3456','Plaza Mayor 202, Ciudad',3,''),(6,'María','González','maria.gonzalez@example.com','555-6543','Calle del Mar 303, Ciudad',3,''),(7,'Pedro','Sánchez','pedro.sanchez@example.com','555-7890','Calle de la Luna 404, Ciudad',3,''),(8,'Isabel','Ramírez','isabel.ramirez@example.com','555-0987','Calle del Río 505, Ciudad',3,''),(9,'José','Morales','jose.morales@example.com','555-2345','Calle de la Paz 606, Ciudad',3,''),(10,'Carmen','Fernández','carmen.fernandez@example.com','555-6789','Calle del Campo 707, Ciudad',3,''),(11,'Fernando','Jiménez','fernando.jimenez@example.com','555-3457','Avenida del Norte 808, Ciudad',3,''),(12,'Patricia','Torres','patricia.torres@example.com','555-4568','Calle de la Estrella 909, Ciudad',3,''),(13,'Javier','Mendoza','javier.mendoza@example.com','555-5679','Calle de la Nieve 1010, Ciudad',3,''),(14,'Marta','Vargas','marta.vargas@example.com','555-6781','Calle de la Primavera 1111, Ciudad',3,''),(15,'Ricardo','Salazar','ricardo.salazar@example.com','555-7891','Calle del Viento 1212, Ciudad',3,''),(16,'Elena','Paredes','elena.paredes@example.com','555-8901','Calle del Olivo 1313, Ciudad',3,''),(17,'Andrés','Ríos','andres.rios@example.com','555-9012','Calle de la Tierra 1414, Ciudad',3,''),(18,'Sofia','Gutiérrez','sofia.gutierrez@example.com','555-0123','Calle del Jardín 1515, Ciudad',3,''),(19,'Roberto','Cruz','roberto.cruz@example.com','555-1235','Calle de la Montaña 1616, Ciudad',3,''),(20,'Julia','Ponce','julia.ponce@example.com','555-2346','Calle del Marfil 1717, Ciudad',3,''),(21,'David','Lara','david.lara@example.com','555-3458','Calle del Océano 1818, Ciudad',3,''),(22,'Beatriz','Herrera','beatriz.herrera@example.com','555-4569','Calle de la Luna 1919, Ciudad',3,''),(23,'Manuel','Ruiz','manuel.ruiz@example.com','555-5670','Calle del Estadio 2020, Ciudad',3,''),(24,'Rosa','Gallegos','rosa.gallegos@example.com','555-6782','Calle del Sol 2121, Ciudad',3,''),(25,'Óscar','Cano','oscar.cano@example.com','555-7892','Calle del Valle 2222, Ciudad',3,''),(26,'Natalia','Serrano','natalia.serrano@example.com','555-8902','Calle de la Aurora 2323, Ciudad',3,''),(27,'Ricardo','Moreno','ricardo.moreno@example.com','555-9013','Calle del Bosque 2424, Ciudad',3,''),(28,'Lorena','Orozco','lorena.orozco@example.com','555-0124','Calle del Norte 2525, Ciudad',3,''),(29,'Samuel','Márquez','samuel.marquez@example.com','555-1236','Calle del Centro 2626, Ciudad',3,''),(30,'Angela','Ramos','angela.ramos@example.com','555-2347','Calle de la Victoria 2727, Ciudad',3,''),(31,'Jorge','Téllez','jorge.tellez@example.com','555-3459','Calle del Atlas 2828, Ciudad',3,''),(32,'Paola','García','paola.garcia@example.com','555-4560','Calle de los Ángeles 2929, Ciudad',3,''),(33,'Martín','Jurado','martin.jurado@example.com','555-5671','Calle del Horizonte 3030, Ciudad',3,''),(34,'Valeria','Salinas','valeria.salinas@example.com','555-6783','Calle del Arco 3131, Ciudad',3,''),(35,'Héctor','Pacheco','hector.pacheco@example.com','555-7893','Calle de la Tranquilidad 3232, Ciudad',3,''),(36,'Claudia','Guerrero','claudia.guerrero@example.com','555-8903','Calle del Atajo 3333, Ciudad',3,''),(37,'Andrés','Pineda','andres.pineda@example.com','555-9014','Calle de la Alhambra 3434, Ciudad',3,''),(38,'Silvia','Ramírez','silvia.ramirez@example.com','555-0125','Calle de los Cedros 3535, Ciudad',3,''),(39,'Luis','Pizarro','luis.pizarro@example.com','555-1237','Calle de la Fortaleza 3636, Ciudad',3,''),(40,'Daniela','Alonso','daniela.alonso@example.com','555-2348','Calle del Río 3737, Ciudad',3,''),(41,'Gustavo','Rivera','gustavo.rivera@example.com','555-3450','Calle de la Nube 3838, Ciudad',3,''),(42,'Cecilia','Vélez','cecilia.velez@example.com','555-4561','Calle del Refugio 3939, Ciudad',3,''),(43,'Arturo','Gómez','arturo.gomez@example.com','555-5672','Calle de la Laguna 4040, Ciudad',3,''),(44,'Diana','Córdoba','diana.cordoba@example.com','555-6784','Calle de la Marea 4141, Ciudad',3,''),(45,'Felipe','Santos','felipe.santos@example.com','555-7894','Calle del Desierto 4242, Ciudad',3,''),(46,'Verónica','Campos','veronica.campos@example.com','555-8904','Calle de la Cumbre 4343, Ciudad',3,''),(47,'Mauricio','Escobar','mauricio.escobar@example.com','555-9015','Calle de la Esperanza 4444, Ciudad',3,''),(49,'Iris Jaqueline','Cruz','iris123456@gmail.com','722 345 3048','1697772431-5',3,'$2y$10$gyz8FwTFcGLNwFv4ZLFXy.WTvp4PBBSg52jmiIwN8L/hLdOfj.3OG'),(50,'Administrador','Biblioteca','admin12345@gmail.com','7221231234','biblioteca s/n',3,'$2y$10$mdNpeyl5W2VLMAE7lsaX7edSWzdFpiBcadI3NKi.LxNslLmkTFMMy');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
