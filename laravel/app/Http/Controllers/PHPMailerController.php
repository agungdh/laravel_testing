<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PHPMailerController extends Controller
{
	function index(Request $request) {
		$data = [];

		return view('PHPMailer.index', $data);
	}
}
