<?php
class RegisterController extends BasicIndexController {
	private $_users = null;
	private $_roles = null;
	protected function initAll() {
		$this->_users = new Table ( "users" );
		$this->_roles = new Table ( "roles" );
	}
	function indexAction() {
		$this->_view->title = "Lpunkt.pl - Rejestracja";
	}
	function registerAction() {
		$this->_view->title = "Lpunkt.pl - Rejestracja";
		$tab = $this->getParametersMap ();
		if (isset ( $tab ['submit'] )) {
			unset ( $tab ['submit'] );
			$user = $this->_users->find ( "email = '" . $tab ["email"] . "'" );
			if ($user->isNull ()) {
				if ($tab ["role"] == "kursant") {
					unset ( $tab ['nr'] );
				}
				$role = $this->_roles->find ( "role_name = '" . $tab ["role"] . "'" );
				unset ( $tab ['role'] );
				$tmp = $role->current ();
				$tab ["role_id"] = $tmp ["id_role"];
				$index = $this->_users->insert ( $tab );
				
				$this->setMessage ( "Rejestracja powiodła się! Zaloguj się!" );
				$link = "Location: /login";
			} else {
				$this->setMessage ( "Podany e-mail już jest w bazie! Rejestracja nie powiodła się!" );
				$link = "Location: /register";
			}
		} else {
			$this->setMessage ( "Błąd! Rejestracja nie powiodła się!" );
			$link = "Location: /register";
		}
		header ( $link );
	}
}