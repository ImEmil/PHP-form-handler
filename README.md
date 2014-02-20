PHP-form-handler
================

A class that handles form requests &amp; parameters
====================================================

	<?php

		$form = new formHandler("post", "submitbtn");	// Form METHOD, button name

		if($form->submit())
		{
			$values = $form->store( array("postname", "postemail") )->required(true);
			//			        input name, input name

			$form->output();
		}

	?>

	<form method="post">
	
		<input type="text" name="postname" placeholder="Name">
		<input type="email" name="postemail" placeholder="Email">
		
		<button name="submitbtn" type="submit">Skicka</button>
		<!-- Pay   ^^^^^^  attention to the button name -->
		
	</form>
