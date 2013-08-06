<?php

class Blog_Model_Exception extends Exception
{
	public function __construct($error_id)
	{
		$this->setCode($error_id);
		switch ($error_id)
		{
			case Blog_Model_Category::E_ID_NOT_VALID_NUMBER:
				$this->setMessage('Given id for category is not a valid number.');
				break;
			case Blog_Model_Category::E_BLOGS_NOT_VALID_ARRAY:
				$this->setMessage('Given blogs for category is not a valid array.');
				break;
			case Blog_Model_Category::E_LABELS_NOT_VALID_ARRAY:
				$this->setMessage('Given labels for category is not a valid array.');
				break;
		}
	}
}