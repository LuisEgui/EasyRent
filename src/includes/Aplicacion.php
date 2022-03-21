<?php

/**
 * Clase que mantiene el estado global de la aplicación.
 */
class Aplicacion
{
	private static $instancia;
	
	/**
	 * Devuele una instancia de {@see Aplicacion}.
	 * 
	 * @return Applicacion Obtiene la única instancia de la <code>Aplicacion</code>
	 */
	public static function getInstance() {
		if (  !self::$instancia instanceof self) {
			self::$instancia = new static();
		}
		return self::$instancia;
	}

	/**
	 * @var array Almacena los datos de configuración de la BD
	 */
	private $bdDatosConexion;
	
	/**
	 * Almacena si la Aplicacion ya ha sido inicializada.
	 * 
	 * @var boolean
	 */
	private $inicializada = false;
	
	/**
	 * @var \mysqli Conexión de BD.
	 */
	private $conn;
	
	/**
	 * Evita que se pueda instanciar la clase directamente.
	 */
	private function __construct()
	{
	}
	
	/**
	 * Inicializa la aplicación.
     *
     * Opciones de conexión a la BD:
     * <table>
     *   <thead>
     *     <tr>
     *       <th>Opción</th>
     *       <th>Descripción</th>
     *     </tr>
     *   </thead>
     *   <tbody>
     *     <tr>
     *       <td>host</td>
     *       <td>IP / dominio donde se encuentra el servidor de BD.</td>
     *     </tr>
     *     <tr>
     *       <td>bd</td>
     *       <td>Nombre de la BD que queremos utilizar.</td>
     *     </tr>
     *     <tr>
     *       <td>user</td>
     *       <td>Nombre de usuario con el que nos conectamos a la BD.</td>
     *     </tr>
     *     <tr>
     *       <td>pass</td>
     *       <td>Contraseña para el usuario de la BD.</td>
     *     </tr>
     *   </tbody>
     * </table>
	 * 
	 * @param array $bdDatosConexion datos de configuración de la BD
	 */
	public function init($bdDatosConexion)
	{
        if ( ! $this->inicializada ) {
    	    $this->bdDatosConexion = $bdDatosConexion;
    		$this->inicializada = true;
    		session_start();
        }
	}
	
	/**
	 * Cierre de la aplicación.
	 */
	public function shutdown()
	{
	    $this->compruebaInstanciaInicializada();
	    if ($this->conn !== null && ! $this->conn->connect_errno) {
	        $this->conn->close();
	    }
	}
	
	/**
	 * Comprueba si la aplicación está inicializada. Si no lo está muestra un mensaje y termina la ejecución.
	 */
	private function compruebaInstanciaInicializada() {
	    if (! $this->inicializada ) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	/**
	 * Devuelve una conexión a la BD. Se encarga de que exista como mucho una conexión a la BD por petición.
	 * 
	 * @return \mysqli Conexión a MySQL.
	 */
	public function getConexionBd()
	{
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['user'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bdPort = $this->bdDatosConexion['port'];
			$bd = $this->bdDatosConexion['bd'];
			
			$conn = new mysqli($bdHost, $bdUser, $bdPass, $bd, $bdPort);
			if ( $conn->connect_errno ) {
				echo "Error de conexión a la BD ({$conn->connect_errno}):  {$conn->connect_error}";
				exit();
			}
			if (!$conn->set_charset("utf8mb4")) {
				echo "Error al configurar la BD ({$conn->errno}):  {$conn->error}";
				exit();
			}
			$this->conn = $conn;
            printf("Conexion realizada con exito");
		}
		return $this->conn;
	}
}