<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

use DB;
use App\Quotation;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }
	public function messages()
	{
		return view('messages');
	}
	public function createmessage()
	{
		return view('createmessage');
	}	
	public function account()
	{
		return view('account');
	}
	public function billing()
	{
		return view('billing');
	}
	public function subscribers()
	{
		return view('subscribers');
	}
	
	public function testtext()
	{
		return view('testtext');
	}
	
	public function localmessages()
	{
		return view('localmessages');
	}
	
	public function massMessage(Request $req)
	{
		foreach(DB::table('temp')->get() as $user)
		{
			// Your Account SID and Auth Token from twilio.com/console
		$sid = 'ACe2aa32694f78f94511d7f1d49c48c890';
		$token = '1009f83f977ee48ffa7aa654269637d3';
		$client = new Client($sid, $token);

		// Use the client to do fun stuff like send text messages!
		$client->messages->create(
			// the number you'd like to send the message to
			$user->Cell,
			array(
				// A Twilio phone number you purchased at twilio.com/console
				'from' => '+19312029267',
				// the body of the text message you'd like to send
				'body' => str_replace("NAME", $user->F_Name, $req['body'])
			)
		);
		}
	}
	
	public function addPerson(Request $req)
	{
		if(isset($req['F_Name']) && isset($req['Cell']))
		{
			if(isset($req['id'])){
				if(isset($req['L_Name']))
					DB::table('temp')->where('id', $req['id'])->update(['F_Name' => $req['F_Name'],'L_Name' => $req['L_Name'],'Cell' => $req['Cell'] ]);
				else
					DB::table('temp')->where('id', $req['id'])->update(['F_Name' => $req['F_Name'],'Cell' => $req['Cell'] ]);
			}else
				DB::insert('insert into temp (id, F_Name, L_Name, Cell) values (?, ?, ?, ?)', [1, $req['F_Name'],$req['L_Name'], $req['Cell']]);
		}
		return back();
	}
	
	public function deleteData(Request $req)
	{
		if(isset($req['cell'])) 
			DB::table('temp')->where('Cell', '=', $req['cell'])->delete();
		return back();
	}
	
	public function sendMessage(Request $req)
	{
		// Your Account SID and Auth Token from twilio.com/console
		$sid = 'ACe2aa32694f78f94511d7f1d49c48c890';
		$token = '1009f83f977ee48ffa7aa654269637d3';
		$client = new Client($sid, $token);

		// Use the client to do fun stuff like send text messages!
		$client->messages->create(
			// the number you'd like to send the message to
			$req['number'],
			array(
				// A Twilio phone number you purchased at twilio.com/console
				'from' => '+19312029267',
				// the body of the text message you'd like to send
				'body' => str_replace("LNAME", $user->L_Name, str_replace("FNAME", $user->F_Name, $req['body']))
			)
		);
	}
}
