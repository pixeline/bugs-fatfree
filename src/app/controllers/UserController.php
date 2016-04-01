<?php

class UserController extends Controller{
	
	function render($f3){
		print_r($f3->get('SESSION'));
		if(!empty($f3->get('SESSION.message'))){
			$f3->set('message', $f3->get('SESSION.message') );
			$f3->set('SESSION.message', '');
		}
		$f3->set('content', 'form-login.htm');
	}

	function beforeroute(){}

	function authenticate($f3) {

		$username = $f3->get('POST.username');
		$password = $f3->get('POST.password');

		$user = new User($this->db);
		$user->getByName($username);

		if($user->dry()) {
			$f3->reroute('/login');
		}

		if(password_verify($password, $user->password)) {
			$f3->set('SESSION.user.username', $user->username);
			$f3->set('SESSION.user.display_name', $user->display_name);
			$f3->set('SESSION.user.email', $user->email);
			$f3->set('SESSION.user.picture', $user->picture);
			$f3->set('SESSION.user.language', $user->language);
			$f3->set('SESSION.user.created_at', $user->created_at);
			$f3->set('SESSION.user.updated_at', $user->updated_at);
			$f3->set('SESSION.user.logged_in', 1);
			$f3->reroute('/');
		} else {
			$f3->set('SESSION.message', $f3->get('user_not_recognised') );
			var_dump($f3->set('SESSION.message'));
			$f3->reroute('/login');
		}
	}


}