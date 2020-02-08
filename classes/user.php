<?php
//Definition der Klasse User
class User {
	// The constructor gets called when the class gets created
	public function __construct(Array $properties=array()){
		foreach($properties as $key => $value){
		  $this->{$key} = $value;
		}
	  }
}
?>