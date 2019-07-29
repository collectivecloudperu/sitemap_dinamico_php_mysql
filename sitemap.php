<?php

	// Datos de conexión a la Base de Datos
	$servidor = "localhost";
	$usuario = "usuario";
	$password = "password";
	$db = "basededatos";

	// Creo la conexión
	$conexion = new mysqli($servidor, $usuario, $password, $db);

	// Soporte para caracteres y símbolos extraños
	$conexion->set_charset("utf8");

	// Validamos la conexión a la Base de Datos
	if ($conexion->connect_error) {
	    die("Erro en la Conexión a la Base de Datos: " . $conexion->connect_error);
	}

	// Pido el campo 'url' de todos los postres o registros de la tabla 'postres' en la Base de Datos 
	$sql = "SELECT url FROM postres";

	// Llamo los resultados con los postres o registros
	$resultados = $conexion->query($sql);

	// Defino mi archivo como XML */ 
	header("Content-Type: text/xml");

	// Inicio la estrucutra de mi archivo XML */
	echo "<?xml version='1.0' encoding='iso-8859-1' ?>" .
	"<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";	

	// Voy a Imprimir Manualmente 4 URLs que serian la página Principal, Nosotros, Servicios y Contacto 

	// NOTA: En donde dice www.midominio.com debes de colocar el nombre de tu dominio

	echo "<url>
			<loc>http://www.midominio.com</loc>
			<changefreq>weekly</changefreq>
			<priority>"."0.8"."</priority>
		 </url>";

	echo "<url>
			<loc>http://www.midominio.com/nosotros.php</loc>
			<changefreq>weekly</changefreq>
			<priority>"."0.8"."</priority>
		  </url>";
	  
	echo "<url>
			<loc>http://www.midominio.com/servicios.php</loc>
			<changefreq>weekly</changefreq>
			<priority>"."0.8"."</priority>
		  </url>";
		  
	echo "<url>
			<loc>http://www.midominio.com/contacto.php</loc>
			<changefreq>weekly</changefreq>
			<priority>"."0.8"."</priority>
		  </url>";

	// Acá imprimo las URLs de los registros dinámicamente con $row["url"] 
	
	// NOTA: El nombre de la carpeta /postres/ la he escrito manualmente, tu puedes colocarle el nombre que desees 

	if ($resultados->num_rows > 0) {

	    while($row = $resultados->fetch_assoc()) {

	    	echo "<url>
			<loc>http://www.midominio.com/postres/". $row["url"]. "</loc>
			<changefreq>weekly</changefreq>
			<priority>"."0.8"."</priority>
		      </url>";
	    }

	} 

	// Si no hay registros en la Base de Datos enviamos el siguiente mensaje
	else {
	    echo "0 resultados";
	}

	
 	// Cierre de la etiqueta del archivo XML del Sitemap
	echo "</urlset>";

	// Cierro la conexión a la Base de Datos por seguridad 
	$conexion->close(); 
	
