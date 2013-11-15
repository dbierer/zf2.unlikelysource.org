<?php
namespace QandA\Model;
use Zend\Session\Container;
class Data
{
    protected $data = array();
    protected $session;

    public function __construct($config)
    {
        $this->session = new Container('storage');
        if (!file_exists($config['q-and-a']['data-file'])) {
            throw new \Exception('Unable to open Q and A data file.  Please check your configuration file.');
        }
        $question   = 'N/A';
        $key        = md5($question);
        $rawData    = file($config['q-and-a']['data-file']);
        foreach ($rawData as $item) {
            // look for question
            if ($config['q-and-a']['question'] == substr($item, 0, 2)) {
                $question = trim(substr($item, 2));
                $key      = md5($question);
                $this->data[$key][] = $question;
            } else {
                $this->data[$key][] = trim($item);
            }
        }
        unset($rawData);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getQuestions()
    {
        $results = array();
        foreach ($this->data as $key => $value) {
            $results[$key] = $value[0];
        }
        asort($results);
        return $results;
    }

    public function getAnswers($question)
    {
        if (isset($this->data[$question])) {
            return $this->data[$question];
        } else {
            return '';
        }
    }

    public function setSession($data)
    {
        $this->session->data = $data;
    }

    public function getSession()
    {
        if (isset($this->session->data)) {
            return $this->session->data;
        } else {
            throw new \Exception('Unable to retrieve session data');
        }
    }

    public function search($item)
    {
        $results = array();
        foreach ($this->data as $ques => $ans) {
            foreach ($ans as $value) {
                if (stripos($value, $item) !== FALSE) {
                    if (!isset($results[$ques])) {
                        $results[$ques] = $this->data[$ques][0];
                        break;
                    }
                }
            }
        }
        asort($results);
        return $results;
    }
}