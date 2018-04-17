<?php

namespace App\Exceptions;

use Exception;

class UnauthorisedUser extends Exception
{
	public function render(){
		if(request()->expectsJson())
			return ['error' => 'You are not authorised to access this page.'];
		return view('errors.unauthorised');
	}
}
