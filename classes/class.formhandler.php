<?php
/*

                                                   +-+-+-+-+-+-+
                                                   |I|m|E|m|i|l|
                                                   +-+-+-+-+-+-+
                                         
*/

# FormHandler Class START
class formHandler {
	
	const invalidMSG = "<div class=\"error\"> Some data was invalid! </div>";

	public $method = array(), $name = '', $stored = array(), $data = array();

	# START OF FUNCTIONS 
	public function __construct($method, $name)
	{
		$this->name = $name;

		if($method == "get")
		{
			$this->method = $_GET;
		}

		if($method == "post")
		{
			$this->method = $_POST;
		}
	}

	public static function refresh($url, $delay)
	{
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
						throw new Exception(" <div class=\"error\"> Some data was missing! </div> "); 
					}
				}
			}
		}

		catch (Exception $e)
		{
			exit(self::refresh($_SERVER['HTTP_REFERER'], 2) . $e->getMessage());
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

	final function isEmail($email)
	{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			exit(self::refresh($_SERVER['HTTP_REFERER'], 2) . self::invalidMSG);
		}
		return $this;
	}

	final function isNumeric($number)
	{
		if(!is_numeric($number))
		{
			exit(self::refresh($_SERVER['HTTP_REFERER'], 2) . self::invalidMSG);
		}
		return $this;
	}
	# END OF FUNCTIONS 
}
# FORMHANDLER CLASS (END)
