<?php
class formHandler
{
	const invalidMSG		 = "<div class=\"error\"> Invalid data! </div>";
	const isEmptyMSG		 = "<div class=\"error\"> Saknar data! </div>";
	const defultRedirectPage = "index.php";

	public $stored, $options = [];

	public function __construct($method, $name, $options = null)
	{
		$this->options["method"] = ($method == "post" ? $_POST : $_GET);
		$this->options["name"]   = $name;
	}

	public function __get($key)
	{
		return isset($this->stored[$key]) ? $this->stored[$key] : null;
	}

	public function store($exec = null)
	{
		foreach($this->options["method"] as $key => $val)
		{
			$this->stored[$key] = $this->filter($val);
		}

		if(!is_null($exec))
			$exec();
	}

	public function submit()
	{
		return isset($this->options["method"][$this->options["name"]]) ? true : false;
	}

	public static function refresh($url, $delay)
	{
		if(is_null($url))
			$url = self::defultRedirectPage;
		else
			$url = $url;

		return "<meta http-equiv=\"refresh\" content=\"{$delay};url={$url}\"> \n\t";
	}

	private function filter($str)
    {
    	return trim(htmlspecialchars($str, ENT_QUOTES, 'utf-8'));
    }

    final public function isEmail($email)
	{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			exit(self::refresh($_SERVER['HTTP_REFERER'], $this->delay) . self::invalidMSG);
		}
		return $this;
	}

	final public function isNumeric($number)
	{
		if(!is_numeric($number))
		{
			exit(self::refresh($_SERVER['HTTP_REFERER'], $this->delay) . self::invalidMSG);
		}
		return $this;
	}
}

/* Användning */
/*

$form = new formHandler("post", "submit button name");

if($form->submit())
{
	$form->store();
	
	if(!empty($form->username))
	{
	  echo "HEJ " . $form->username;
	}
	else
	  echo "Användarnamnet saknas lel";
}


*/
