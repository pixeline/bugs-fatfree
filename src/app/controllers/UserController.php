<?php

class UserController extends Controller{

	function render(){
		if(!empty($this->f3->get('SESSION.message'))){
			$this->f3->set('message', $this->f3->get('SESSION.message') );
			$this->f3->set('SESSION.message', '');
		}
		$this->f3->set('content', 'form-login.htm');
	}


	function beforeroute(){
		// empty, to cancel the inherited Controller::beforeroute() method.
	}


	function authenticate() {

		$username = $this->f3->get('POST.username');
		$password = $this->f3->get('POST.password');

		$user = new User($this->db);
		$user->getByIdOrName($username);

		if($user->dry()) {
			$this->f3->set('SESSION.message', $this->f3->get('user_not_recognised') );
			$this->f3->reroute('/login');
		}

		if(password_verify($password, $user->password)) {

			$this->f3->set('SESSION.user', array(
					'id' => $user->id,
					'username' => $user->username,
					'display_name' => $user->display_name,
					'email' => $user->email,
					'picture' => $user->picture,
					'language' => $user->language,
					'created_at' => $user->created_at,
					'updated_at' => $user->updated_at,
					'projects' => $user->projects($user->id),
				));

			$this->f3->set('SESSION.logged_in', 'ok');
			$this->f3->reroute('/');
		} else {
			$this->f3->set('SESSION.message', $this->f3->get('password_not_recognised') );
			$this->f3->reroute('/login');
		}
	}

	function logout(){
		$this->f3->clear('SESSION');
		$this->f3->reroute('/');
	}


}