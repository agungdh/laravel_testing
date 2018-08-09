<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
	function __construct() {
	    $this->middleware('CustomAuth:a');
	}

	function index() {
		if (session('login') == true) {
			return 'login';
		} else {
			return 'not login';
		}
	}

	function hash($hash) {
		echo hash::make($hash);
	}
}
