<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Config;
use Session;
use Response;
use Validator;
use MinecraftServer;
use Webcraft\Models\User;
use Webcraft\Models\Iconomy;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function getIndex()
	{
		return view('auth.index');
	}

	public function postSignup(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'register_username' => 'required|unique:users,username|min:3|max:16|minecraft_username',
			'register_email' => 'required|unique:users,email|max:30|email',
			'register_password' => 'required|min:6'
		]);

		$validator->setAttributeNames([
			'register_username' => 'Kullanıcı adı',
			'register_email' => 'e-Posta',
			'register_password' => 'Şifre'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$encryption = Config::get('minecraft.auth.encryption');
		
		$username = $request->input('register_username');
		$password = $request->input('register_password');

		$user = User::create([
			'username' => $username,
			'email' => $request->input('register_email'),
			'password' => $encryption === 'bcrypt' ? bcrypt($password) : md5($password),
			'action_token' => md5(uniqid($username, true))
		]);

		/*\Mail::send('templates.mail.verify', ['user' => $user], function ($m) use ($user) {
		    $m->to($user->email, $user->username)->subject(MinecraftServer::name());
		});*/

		Auth::login($user);

		return Response::json(['success' => true]);
	}

	public function postSignin(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'username' => 'required|minecraft_username',
			'password' => 'required'
		]);

		$validator->setAttributeNames([
			'username' => 'Kullanıcı adı',
			'password' => 'Şifre'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$user = User::where('username', $request->input('username'))->first();

		if ( $user === null ) {
			return Response::json(['error' => 'Kullanıcı adı geçersiz.']);
		}

		$encryption = Config::get('minecraft.auth.encryption');

		if ( $encryption === 'bcrypt' ) {
			if ( !Auth::attempt($request->only(['username', 'password'])) ) {
				$password_wrong = true;
			}
		} else {
			if ( $user->password !== md5($request->input('password')) ) {
				$password_wrong = true;
			}
		}

		if ( isset($password_wrong) === true ) {
			return Response::json(['error' => 'Bu kullanıcıya ait şifre yanlış.']); 
		}

		Auth::login($user);

		return Response::json(['success' => true]);
	}

	public function getVerify(Request $request, $email)
	{
		if ( $user = User::where('email', $email)->where('action_token', $request->input('token'))->first() ) {
			$user->isVerified = 1;
			$user->action_token = null;
			$user->save();

			Auth::login($user);
		}

		return redirect()
			->route('auth.welcome')
			->with('verify_email_ok', true);
	}

	public function getWelcome()
	{
		if ( Session::get('verify_email_ok') === null ) {
			return redirect()->route('auth.index');
		}

		return view('auth.welcome');
	}

	public function getEmail()
	{
		return view('auth.email');
	}

	public function postEmail(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|unique:users'
		]);

		$validator->setAttributeNames([
			'email' => 'e-Posta'
		]);

		if ( $validator->fails() ) {
			return redirect()->route('auth.email')->withErrors($validator)->withInput();
		}

		Auth::user()->email = $request->input('email');
		Auth::user()->save();

		return redirect()->route('home');
	}

	public function getSignout()
	{
		Auth::logout();
		return redirect()->route('auth.index');
	}
}
