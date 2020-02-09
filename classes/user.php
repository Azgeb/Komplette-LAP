<?php
//Definition der Klasse User
class User {

	public $id;
	public $email;
	public $firstname;
	public $lastname;
	public $userRole;


	public function createUserFromDB($sqlResult){
		$GLOBALS['id'] = $sqlResult['id'];
		$GLOBALS['email'] = $sqlResult['email'];
		$GLOBALS['firstname'] = $sqlResult['firstname'];
		$GLOBALS['lastname'] = $sqlResult['lastname'];
		$GLOBALS['userRole'] = $sqlResult['user_role'];

		
	}
}
?>