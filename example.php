<?php
/*

                                                   +-+-+-+-+-+-+
                                                   |I|m|E|m|i|l|
                                                   +-+-+-+-+-+-+
                                         
*/



	spl_autoload_register( function($class) {
		require_once("classes/class.{$class}.php");
	});
	/*
						[[[[[[[[ PLEASE NOTE!!! ]]]]]]]]
	If you are using an older version than 5.1.2 i suggest you to remove the following function:
	spl_autoload_register( function($class) {
		require_once("classes/class.{$class}.php");
	});

	and replace it with this: require_once("classes/class.formhandler.php");
	*/
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title> Form Controller v1 </title>
	<link href="style.css" rel="stylesheet" type="text/css">
	
</head>
<body>
	
	<main>

	<?php
	
		$form = new formHandler("post", "submitbtn");	// Form METHOD, button name
		
		if($form->submit())
		{
			$values = $form->store( array("postname", "postemail") )->required(true); # ->prepare();
			//			        input name, input name
			$form->isEmail($values[1]); // This will check if the second value in the array is an valid email
			$form->output();
		}
	?>

	<form method="post">
	
		<input type="text" name="postname" placeholder="Name">
		<input type="email" name="postemail" placeholder="Email">
		
		<button name="submitbtn" type="submit">Skicka</button>
		<!-- Pay   ^^^^^^  attention to the button name -->
		
	</form>

</main>

</body>
</html>
