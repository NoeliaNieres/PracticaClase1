<?php
require_once"AccesoDatos.php";
class Usuario
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
  	public $email;
  	public $clave;
  	
//--------------------------------------------------------------------------------//
//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetIdUsuario()
	{
		return $this->id;
	}
	public function GetEmail()
	{
		return $this->email;
	}
	public function GetClave()
	{
		return $this->clave;
	}
	public function SetIdUsuario($valor)
	{
		$this->idUsu = $valor;
	}
	public function SetEmail($valor)
	{
		$this->email = $valor;
	}
	public function SetClave($valor)
	{
		$this->clave = $valor;
	}
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($id=NULL)
	{
		if($idUsu != NULL){
			$obj = Usuario::TraerUnUsuario($idUsu);
			
			$this->idUsu = $obj->$idUsu;
			$this->nombre = $obj->nombre;
			$this->email = $obj->email;
		}
	}
//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->email."-".$this->clave;
	}
//--------------------------------------------------------------------------------//
//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnUsuario($idParametro) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE id=:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
					
	}
	public static function TraerUnUsuarioPorSucursal($idSucursal) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE id=:id");
		$consulta->bindValue(':id', $idSucursal, PDO::PARAM_INT);
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
					
	}
	
	public static function TraerTodosLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios ");
		$consulta->execute();			
		$arrUsuarios= $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");	
		return $arrUsuarios;
	}
	public static function AutenticarUsuario($mailUsuario, $nombreUsuario, $claveUsuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE email=:email AND clave=:clave");
		$consulta->bindValue(':email', $mailUsuario, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $claveUsuario, PDO::PARAM_STR);
		$consulta->execute();			
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
	}
	public static function VerificarExistente($mailUsuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE email=:email");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasPersonas() ");
		$consulta->bindValue(':email', $mailUsuario, PDO::PARAM_STR);
		$consulta->execute();			
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
	}
	
	public static function BorrarUsuario($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id=:id");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL BorrarPersona(:id)");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
	
	public static function ModificarUsuario($usuario)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				UPDATE usuarios 
				SET email=:email,
				clave=:clave,
				id=:id
				WHERE id=:id");
			//$consulta =$objetoAccesoDato->RetornarConsulta("CALL ModificarUsuario(:id,:nombre,:nombre,:email,:clave,:cargo)");
			$consulta->bindValue(':id',$usuario->idUsu, PDO::PARAM_INT);
			$consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
			$consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);

			//$consulta->bindValue(':foto', $usuario->foto, PDO::PARAM_STR);
			return $consulta->execute();
	}
//--------------------------------------------------------------------------------//
//--------------------------------------------------------------------------------//
	public static function InsertarUsuario($usuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (email,clave) values(:nombre,:email,:clave,:cargo,:habilitado,:idSuc)");

		$consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);

		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	
//--------------------------------------------------------------------------------//
}