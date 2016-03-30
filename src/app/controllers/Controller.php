<?php

class Controller {
    
    protected $f3;
    protected $db;

    function beforeroute(){
        if($this->f3->get('SESSION.user') === null ) {
            $this->f3->reroute('/login');
            exit;
        }
    }

    function afterroute(){
        //echo '- After routing';
    }


	function __construct() {

		$f3=Base::instance();
		$this->f3=$f3;

		$db=new DB\SQL(
			$f3->get('db'),
			$f3->get('dbusername'),
			$f3->get('dbpassword'),
			array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
		);

		$this->db=$db;
	}


}