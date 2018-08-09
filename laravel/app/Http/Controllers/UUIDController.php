<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UUIDController extends Controller
{
	function index(Request $request) {
		$data = [];

		$data['uuid'] = $this->generateUUID();

		return view('UUID.index', $data);
	}

	private function generateUUID() {
		$data = new \stdClass();
		try {
		    $uuid1 = Uuid::uuid1();
		    $data->uuid1 = Uuid::uuid1()->toString(); 
		    
		    $uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, 'php.net');
		    $data->uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, 'php.net')->toString(); 
		    
		    $uuid4 = Uuid::uuid4();
		    $data->uuid4 = Uuid::uuid4()->toString(); 
		    
		    $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'php.net');
		    $data->uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'php.net')->toString(); 

		    $data->success = true;
		} catch (UnsatisfiedDependencyException $e) {
		    $data->message = 'Caught exception: ' . $e->getMessage();
		    
		    $data->success = true;
		}

		return $data;
	}
}
