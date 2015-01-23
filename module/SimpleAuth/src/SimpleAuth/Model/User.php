<?php
namespace SimpleAuth\Model;

class User
{
	protected $who;			// usually username
	protected $what;		// usually password
	/**
	 * @param $array = array['who'=>xxx, 'what'=>xxx]
	 */
	public function __construct($array = NULL)
	{
		if (is_array($array) && isset($array['who']) && isset($array['what'])) {
			$this->setWho($array['who']);
			$this->setWhat($array['what']);
		}
	}
	public function getWho()
	{
		return $this->who;
	}
	public function getWhat()
	{
		return $this->what;
	}
	public function setWho($who)
	{
		$this->who = $who;
	}
	public function setWhat($what)
	{
		$this->what = $what;
	}	
}
