<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerController extends Controller
{
	function index(Request $request) {
		
		$gmail = DB::table('phpmailer_server')->where('id', 'f799871b-8a56-48ca-8e1a-636dec2fa576')->first();
		$outlook = DB::table('phpmailer_server')->where('id', 'a287b2e6-b9a1-4f6d-a3fc-005f18815b31')->first();

		// dd($this->sendMail($gmail->server, $gmail->encryption, 'username', 'password', $gmail->port, 'agunggantengdh@gmail.com', 'ini test aja yakkk', '<br><br><br><h1>Hai brooo...</h1><br><br><br>'));
		// dd($this->sendMail($outlook->server, $outlook->encryption, 'username', 'password', $outlook->port, 'agunggantengdh@gmail.com', 'ini test aja yakkk', '<br><br><br><h1>Hai brooo...</h1><br><br><br>'));

		// $data = [];

		// return view('PHPMailer.index', $data);

		dd([$gmail, $outlook]);
	}

	private function sendMail($server, $encryption, $email, $password, $port, $toEmail, $subject, $body) {
		$data = new \stdClass();

		$mail = new PHPMailer(true);                              
		try {
		    $mail->isSMTP();                                      
		    $mail->Host = $server;  
		    $mail->SMTPOptions = [ 'ssl' => [
								     'verify_peer' => false,
								     'verify_peer_name' => false,
								     'allow_self_signed' => true
								 	]
		    					];
		    $mail->SMTPAuth = true;                               
		    $mail->Username = $email;                 
		    $mail->Password = $password;                           
		    $mail->SMTPSecure = $encryption;                            
		    $mail->Port = $port;                                    

		    $mail->setFrom($email);
		    $mail->addAddress($toEmail);               
		    
		    $mail->isHTML(true);                                  
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    $mail->send();
		    
		    $data->success = true;
		} catch (Exception $e) {
		    $data->message = $mail->ErrorInfo;

		    $data->success = false;
		}

		return $data;
	}
}
