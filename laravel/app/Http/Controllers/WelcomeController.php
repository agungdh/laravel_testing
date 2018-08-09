<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class WelcomeController extends Controller
{
	function index(Request $request) {
		$data = [];

		$UUID = new \stdClass();
		$UUID->name = 'UUID';
		$UUID->action = action('UUIDController@index');
		$data[] = $UUID;

		$PHPMailer = new \stdClass();
		$PHPMailer->name = 'PHP Mailer';
		$PHPMailer->action = action('PHPMailerController@index');
		$data[] = $PHPMailer;

		$passData['data'] = $data;

		return view('welcome.index', $passData);
	}
}
