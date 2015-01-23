<?php
namespace ServiceManagerDemo\Model;

class DemoModel
{
    public static $output = array();
    protected $test       = 'DEFAULT VALUE IN MODEL';
    protected $control    = 'CONTROL';

    public function setOutput($info)
    {
        self::$output[] = $info;
    }
    
    public function getOutput()
    {
        return self::$output;
    }
    
	/**
	 * @return the unknown_type
	 */
	public function getTest() {
		return $this->test;
	}
	
	/**
	 * @param unknown_type $test
	 */
	public function setTest($test) {
		$this->test = $test;
		return $this;
	}

	/**
	 * @return the unknown_type
	 */
	public function getControl() {
		return $this->control;
	}
	
	/**
	 * @param unknown_type $control
	 */
	public function setControl($control) {
		$this->control = $control;
		return $this;
	}
    
}