<?php
class formHandler {
	const invalidMSG		 = "<div class=\"error\"> Invalid data! </div>";
	const isEmptyMSG		 = "<div class=\"error\"> Saknar data! </div>";
	const defultRedirectPage = "index.php";

	public $method 	= array();
	public $name	= '';
	public $delay	= 0;
	public $stored 	= array();
	public $data	= array();

	# START OF FUNCTIONS 
	public function __construct($method, $name, $delay)
	{
		$this->name  = $name;
		$this->delay = $delay;

		if($method == "get")
		{
			$this->method = $_GET;
		}

		if($method == "post")
		{
			$this->method = $_POST;
		}
	}

	public function __destruct()
	{
		$this->name = null;
		$this->method = null;
	}

	public static function refresh($url, $delay)
	{
		if(is_null($url)):
			$url = self::defultRedirectPage;
		else:
			$url = $url;
		endif;
		return "<meta http-equiv=\"refresh\" content=\"{$delay};url={$url}\"> \n\t";
	}

	public static function filter($string)
	{
		return trim(strip_tags(htmlspecialchars($string, ENT_QUOTES, 'utf-8')));
	}

	public function submit()
	{
		return(isset($this->method[$this->name]) ? true : false);
	}

	public function output()
	{
		foreach($this->stored as $display)
		{
			print(sprintf("<p> %s </p> \n\t", formHandler::filter($display)));
			// use var_dump(display); for debug purpose, you can also use echo $display OR print_r($display)
		}
	}

	public function prepare()
	{
		foreach($this->stored as $val => $data)
		{
			$this->data[] = formHandler::filter($data);
		}

		return $this->data;
	}

	public function required($bool)
	{
		try
		{
			if($bool === true)
			{
				foreach($this->stored as $field)
				{
					$field = formHandler::filter($field);
					if (empty($field))
					{
						throw new Exception(self::isEmptyMSG); 
					}
				}
			}
		}

		catch (Exception $e)
		{
			exit(self::refresh($_SERVER['HTTP_REFERER'], $this->delay) . $e->getMessage());
		}

		return $this;
	}

	public function store($var)
	{
		foreach($var as $val)
		{
			$this->stored[$val] = formHandler::filter($this->method[$val]);
		}
		return $this;
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
	# END OF FUNCTIONS 
}
# FORMHANDLER CLASS (END)
