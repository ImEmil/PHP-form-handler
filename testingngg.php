<form method="post" action="#">
	<input type="text" name="firstname" placeholder="firstname">
	<input type="text" name="username" placeholder="username">
	<button name="testButton">Submit</button>
</form>
<?php
class postForm
{
	private $buttonName = null;
	private $inputs     = [];

	public function __construct($buttonName)
	{
		$this->buttonName = $buttonName;
	}

	public function submit(Closure $closureFunction = null)
	{
		if(is_null($closureFunction))
			return isset($_POST[$this->buttonName]);
		else
		{
			if(isset($_POST[$this->buttonName]))
				$closureFunction();
		}
	}

	public function inputs($returnType = "array")
	{
		foreach($_POST as $field => $value)
		{
			$this->inputs[$field] = htmlspecialchars($value, ENT_QUOTES, 'utf-8');
		}

		if(strtolower($returnType) == "object")
			return (object) $this->inputs;
		else
			return $this->inputs;
	}

	public function __get($field)
	{
		return isset($this->inputs[$field]) ? $this->inputs[$field] : false;
	}
}

class formHandler
{
	private $method     = null;
	private $buttonName = null;
	private $inputs     = [];

	public function __construct($method, $postButtonName = null)
	{
		$this->method     = $method;
		$this->buttonName = $postButtonName;
	}

	public function __get($field)
	{
		return isset($this->inputs[$field]) ? $this->inputs[$field] : false;
	}

	public function submit(Closure $closureFunction = null)
	{
		$data = $this->method == "get" ? $_GET : $_POST[$this->buttonName];

		if(is_null($closureFunction))
			return isset($data);
		else
		{
			if(isset($data))
				$closureFunction();
		}
	}

	public function store()
	{
		foreach((is_null($this->buttonName)  ? $_GET : $_POST) as $field => $value)
		{
			$this->inputs[$field] = htmlspecialchars($value, ENT_QUOTES, 'utf-8');
		}
	}

	public function inputs($returnType = "array")
	{
		if(strtolower($returnType) == "object")
			return (object) $this->inputs;
		else
			return $this->inputs;
	}
}
$form = new formHandler("get");

if($form->submit())
{
	$form->store();

	if($form->id)
		var_dump($form->id);
	else
		var_dump("No ID has been set");
}



$form = new postForm("testButton");

$form->submit(function() use($form)
{
	$inputObject = $form->inputs("object");
	$inputArray  = $form->inputs("array");

	echo "closure form submit <hr>";

	echo $inputArray["firstname"];
	echo "<br>";
	echo $inputObject->firstname;
	echo "<br>";
	echo $form->firstname;
	echo "<br>";

	if($form->username)
		echo "Username has been submitted: " . $form->username;
	else
		echo "No username has been submitted!";
});

if($form->submit())
{
	$inputObject = $form->inputs("object");
	$inputArray  = $form->inputs("array");

	echo "if form submit <hr>";

	echo $inputArray["firstname"];
	echo "<br>";
	echo $inputObject->firstname;
	echo "<br>";
	echo $form->firstname;
	echo "<br>";

	if($form->username)
		echo "Username has been submitted: " . $form->username;
	else
		echo "No username has been submitted!";
}
