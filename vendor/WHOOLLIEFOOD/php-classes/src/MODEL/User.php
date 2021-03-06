<?php 

namespace WHOOLLIEFOOD\MODEL;

use \WHOOLLIEFOOD\DB\Sql;

class User{

	const SESSION = "User";

	public static function login($login, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tbEmployees a INNER JOIN tbUsers b ON (a.idLogin = b.idUser) WHERE b.desLogin = :LOGIN", array(
			":LOGIN"=>$login
        ));

		if(count($results) === 0){

            return json_encode([
                'login' => 'false',
                'message' => 'Credenciais incorretas!',
            ]);
			
		}

		$data = $results[0];

		if(sha1($password) == $data["desPassword"]){

			$_SESSION[User::SESSION] = $data;

			return json_encode([
                'login' => 'true',
                'message' => 'Logado com sucesso!',
            ]);

		} else {

			return json_encode([
                'login' => 'false',
                'message' => 'Credenciais incorretas!',
            ]);

		}

	}

	public static function verifyLogin(){

		if(!isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION] || !(int)$_SESSION[User::SESSION]["idUser"] > 0){
			echo json_encode([
                'login' => 'false',
                'message' => 'Não logado!',
			]);
			exit;
		}
	}

	public static function logout(){

		$_SESSION[User::SESSION] = NULL;

	}

}

?>