<?php

class DB
{
	private static $instance = null;
	private $db;

	private function __construct()
	{
		$this->db = new Mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

		if (mysqli_connect_error())
		{
			die('Sorry, cannot connect to database' . mysqli_connect_error());
		}
	}

	public static function getConnection()
	{
		if (!isset(self::$instance))
		{
			self::$instance = new DB();
		}
		return self::$instance;
	}

	public function select($sql)
	{
		$resultSet = array();
		$result = $this->db->query($sql);
        if($result)
        {
        	if ($result->num_rows > 0)
		    {
			   while ($row = $result->fetch_assoc())
		      {
				 $resultSet[] = $row;
			  }
			  return $resultSet;
		   }
        }
		
		return false;
	}

	public function selectFirstRow($sql)
	{
		$resultSet = array();
		$result = $this->db->query($sql);

		if($result)
		{
			if ($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc())
				{
					$resultSet[] = $row;
				}
				return $resultSet[0];
			}
		}

		return false;
	}

	public function insert($sql)
	{
		$result = $this->db->query($sql);

		if ($this->db->affected_rows > 0)
		{
			return $result;
		}
		return false;
	}

	public function update($sql)
	{
		$result = $this->db->query($sql);

		if ($this->db->affected_rows > 0)
		{
			return $result;
		}
		return false;
	}

	public function delete($sql)
	{
		$result = $this->db->query($sql);

		if ($this->db->affected_rows > 0)
		{
			return $result;
		}
		return false;
	}
}

?>