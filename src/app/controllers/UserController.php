<?php

class UserController extends Controller{
	function render($f3){

		$f3->set('content','form-login.htm');

	}


	function beforeroute(){
	}


	function authenticate() {

		$username = $this->f3->get('POST.username');
		$password = $this->f3->get('POST.password');

		$user = new User($this->db);
		$user->getByName($username);

		if($user->dry()) {
			$this->f3->reroute('/login');
		}

		if(password_verify($password, $user->password)) {
			$this->f3->set('SESSION.user.username', $user->username);
			$this->f3->set('SESSION.user.display_name', $user->display_name);
			$this->f3->set('SESSION.user.email', $user->email);
			$this->f3->set('SESSION.user.picture', $user->picture);
			$this->f3->set('SESSION.user.language', $user->language);
			$this->f3->set('SESSION.user.created_at', $user->created_at);
			$this->f3->set('SESSION.user.updated_at', $user->updated_at);
			$this->f3->set('SESSION.user.logged_in', 1);
			$this->f3->reroute('/');
		} else {
			$this->f3->reroute('/login');
		}
	}


}