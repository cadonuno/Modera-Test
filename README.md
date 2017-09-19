# Modera Test by Ricardo Pereira

#Web
The Web folder contains the first and third tasks aswell as documantation for the second task, it assumes bootstrap and jQuery are used.

#Webservices
The Webservices folder contains the Webservices for manipulating data, it uses Symfony Framework and has only the files I created myself.

#Database
I used a MySQL database with a single categories table:

CREATE TABLE `categories` (
 `node_id` int(11) NOT NULL AUTO_INCREMENT,
 `parent_id` int(11) NOT NULL,
 `node_name` varchar(100) NOT NULL,
 `position` int(11) DEFAULT NULL,
 PRIMARY KEY (`node_id`),
 UNIQUE KEY `node_id` (`node_id`),
 KEY `node_id_2` (`node_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1

The use of MySQL was due to it's ease of use and setup as it comes bundled with Wamp Server.
