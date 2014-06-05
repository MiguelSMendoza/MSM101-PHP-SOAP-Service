<?php
require_once ( 'phpwsdl/class.phpwsdl.php' );
ini_set('soap.wsdl_cache_enabled',0);	// Disable caching in PHP
$PhpWsdlAutoRun=true;					// With this global variable PhpWsdl will autorun in quick mode, too
PhpWsdl::RunQuickMode ();
/**
 * Entity that stores information about a Client
 * 
 * @pw_element integer $ID ID that identifies Client
 * @pw_element string $Name Name of Client
 * @pw_element string $Surname Surname of Client
 * @pw_element integer $Age Age of Client
 * @pw_complex Client  
 */
class Client
{
	/** @var integer */
	public $ID;

    /** @var string */
	public $Name;

	/** @var string */
	public $Surname;
	
	/** @var integer */
	public $Age;
	
}
/**
 * 
 * @pw_complex ClientArray An array of Clients
 */
 


 /**
 * Ejemplo de Servicio SOAP para Curso de Desarrollo de Aplicaciones Android
 * 
 * @service SOAPWebService
 */
class SOAPWebservice {
	static $dbhost = "HOST";
	static $dbuser = "USER";
	static $dbpassword = "PASSWORD";
	static $dbname = "DBNAME";
		
	/**
	 *
	 * @return ClientArray
	 **/
	function getClients()
	{
		$results = array();
		
		$db = mysql_connect(self::$dbhost, self::$dbuser, self::$dbpassword) or die("Connection Error: " . mysql_error());
		mysql_select_db(self::$dbname) or die("Error al conectar a la base de datos.".self::$dbhost);
		
		$Sql ="SELECT _id,Name,Surname,Age FROM Clients";
		$result = mysql_query($Sql, $db) or die("No se puede ejecutar la consulta: ".mysql_error());
		$i=0;
		while($row = mysql_fetch_array( $result )) {
			$results[$i] = new Client();
			$results[$i]->ID = $row['_id'];
			$results[$i]->Name = $row['Name'];
			$results[$i]->Surname = $row['Surname'];
			$results[$i]->Age = $row['Age'];
			$i++;
		} 
		
		return $results;
	}

	/**
	 *
	 * @param string $Name
	 * @param string $Surname
	 * @param string $Age
	 * @return integer
	 **/
	function newClient($Name, $Surname, $Age)
	{
		$db = mysql_connect(self::$dbhost, self::$dbuser, self::$dbpassword) or die("Connection Error: " . mysql_error());
		mysql_select_db(self::$dbname) or die("Error al conectar a la base de datos.".self::$dbhost);
		$i=0;
		$nombre = mysql_real_escape_string($Name);
		$apellido = mysql_real_escape_string($Surname);
		$edad = mysql_real_escape_string($Age);
		$Sql = "INSERT INTO Clients (Name, Surname, Age) VALUES ('".$nombre."', '".$apellido."', ".$edad.")";
		$query = mysql_query($Sql, $db) or die("No se puede ejecutar la consulta: ".mysql_error().$Sql);
		$i = 1;
		return $i;
	}

	/**
	 * @param string $ID
	 * @param string $Name
	 * @param string $Surname
	 * @param string $Age
	 * @return integer
	 **/
	function updateClient($ID, $Name, $Surname, $Age)
	{
		$db = mysql_connect(self::$dbhost, self::$dbuser, self::$dbpassword) or die("Connection Error: " . mysql_error());
		mysql_select_db(self::$dbname) or die("Error al conectar a la base de datos.".self::$dbhost);
		$i=0;
		$iden = mysql_real_escape_string($ID);
		$nombre = mysql_real_escape_string($Name);
		$apellido = mysql_real_escape_string($Surname);
		$edad = mysql_real_escape_string($Age);
		$Sql = "UPDATE Clients  SET Name = '".$nombre."', Surname = '".$apellido."', Age =".$edad." WHERE _id = ".$iden;
		$query = mysql_query($Sql, $db) or die("No se puede ejecutar la consulta: ".mysql_error());
		$i= mysql_num_rows($query);
		return $i;
	}

}

//$myService = new SOAPWebservice($NAMESPACE, $DESCRIPTION, array('uri'=>$NAMESPACE, 'encoding'=>SOAP_ENCODED));
//$myService->handle();

?>