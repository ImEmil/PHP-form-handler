PHP-form-handler
================

A class that handles form requests &amp; parameters
====================================================
So why is this better?
1. Less code
2. Faster
3. Better error handling
4. Secure


(1) Without the form handler

	<?php
		if(isset($_POST["submitbtn"]))
		{
		
		$name = trim(strip_tags(htmlspecialchars($_POST["postname"], ENT_QUOTES, 'utf-8')));
		$email = trim(strip_tags(htmlspecialchars($_POST["postemail"], ENT_QUOTES, 'utf-8')));
		
			if(empty($name) OR empty($email))
			{
				exit("Error: Data is missing!");
			}
			
			echo "<p> {$name} </p> \n\t <p> {$email} </p>";
		}
	?>
	
	<form method="post">
	
		<input type="text" name="postname" placeholder="Name">
		<input type="email" name="postemail" placeholder="Email">
		
		<button name="submitbtn" type="submit">Skicka</button>
		<!-- Pay   ^^^^^^  attention to the button name -->
		
	</form>

==================================================
(2) Using the form handler
	<?php
		require_once("path/class.formhandler.php);
		
		$form = new formHandler("post", "submitbtn");	// Form METHOD, button name

		if($form->submit())
		{
			$values = $form->store( array("postname", "postemail") )->required(true);
			$form->output();
		}

	?>

	<form method="post">
	
		<input type="text" name="postname" placeholder="Name">
		<input type="email" name="postemail" placeholder="Email">
		
		<button name="submitbtn" type="submit">Skicka</button>
		<!-- Pay   ^^^^^^  attention to the button name -->
		
	</form>
