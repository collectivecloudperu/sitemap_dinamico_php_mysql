<?php
$mysqli = new mysqli("localhost", "miusuario", "password", "mibasededatos");
/* check connection */
if (mysqli_connect_errno()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}

/* Defino mi archivo como XML */ 
header("Content-Type: text/xml");

/* Inicio la estrucutra de mi archivo XML */
echo "<?xml version='1.0' encoding='iso-8859-1' ?>" .
"<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

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
		<loc>http://www.midominio.com/partners.php</loc>
		<changefreq>weekly</changefreq>
		<priority>"."0.8"."</priority>
	  </url>";
	  
echo "<url>
		<loc>http://www.midominio.com/contactenos.php</loc>
		<changefreq>weekly</changefreq>
		<priority>"."0.8"."</priority>
	  </url>";

/* Establezco la URL para los postres */
echo "<url>
		<loc>http://www.midominio.com/postres/peruanos/</loc>
		<changefreq>weekly</changefreq>
		<priority>"."0.8"."</priority>
	  </url>"; 

echo "<url>
		<loc>http://www.midominio.com./postres/franceses/</loc>
		<changefreq>weekly</changefreq>
		<priority>"."0.8"."</priority>
	  </url>";

echo "<url>
		<loc>http://www.midominio.com/postres/italianos/</loc>
		<changefreq>weekly</changefreq>
		<priority>"."0.8"."</priority>
	  </url>"; 	  

/* Hago un Multi Query para desde la tabla correspondiente del postre */
$query  = "SELECT name, 'peruanos' AS tipo FROM postresperuanos;";
$query .= "SELECT name, 'franceses' AS tipo FROM postresfranceses;";
$query .= "SELECT name, 'italianos' AS tipo FROM postresitalianos";

/* Ejecuto el multi query */
if ($mysqli->multi_query($query)) {
do {
/* Almaceno el primer resultado */
if ($result = $mysqli->store_result()) {
 
while ($row = $result->fetch_row()) {

/* Defino las url que mostrare en mi archivo sitemap */
$loc_postresperuanos = "http://www.midominio.com/postres/peruanos/" . $row[0];
$loc_postresfranceses = "http://www.midominio.com/postres/franceses/" . $row[0];
$loc_postresitalianos = "http://www.midominio.com/postres/italianos/" . $row[0];


/* Imprimo la estructura de cada URL en mi archivo sitemap */

if($row[1]=="peruanos") {
	echo
"<url>".
	"<loc>".xmlentities($loc_postresperuanos)."</loc>".
	"<changefreq>".weekly."</changefreq>".
	"<priority>"."0.8"."</priority>
</url>";
	
}

else if ($row[1] == "franceses" ) {
	echo
"<url>".
	"<loc>".xmlentities($loc_postresfranceses)."</loc>" .
	"<changefreq>".weekly."</changefreq>".
	"<priority>"."0.8"."</priority>
</url>";	
} 

else if ($row[1] == "italianos" ) { 
	echo
"<url>".
	"<loc>".xmlentities($loc_postresitalianos)."</loc>".
	"<changefreq>".weekly."</changefreq>".
	"<priority>"."0.8"."</priority>
</url>";

}

}
 
$result->close();
}

if ($mysqli->more_results()) {
printf("\n");
}
} while ($mysqli->next_result());
 
}
 
echo "</urlset>";

/* Reemplazo caracteres especiales */
function xmlentities($text) {
$search = array('&', '<', '>', '"', '\'', ' ');
$replace = array('&amp;', '&lt;', '&gt;', '&quot;', '&apos;', '-');
return str_replace($search, $replace, $text);
}

/* Cierro la Conexión a la base de datos */
$mysqli->close();