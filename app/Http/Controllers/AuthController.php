<?php

namespace Webcraft\Http\Controllers;

use Mail;
use Hash;
use Auth;
use Config;
use Session;
use Response;
use Validator;
use MinecraftServer;
use Webcraft\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function getIndex()
	{
		return view(app('template') . '.auth.index');
	}

	public function postSignup(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'register_username' => 'required|unique:users,username|min:3|max:16|minecraft_username',
			'register_email' => 'required|unique:users,email|max:30|email',
			'register_password' => 'required|min:6',
			'register_password_confirm' => 'required|same:register_password',
			'register_captcha' => 'required|captcha'
		]);

		$validator->setAttributeNames([
			'register_username' => 'Kullanıcı adı',
			'register_email' => 'e-Posta',
			'register_password' => 'Şifre',
			'register_password_confirm' => 'Şifre Tekrarı',
			'register_captcha' => 'İnsan olmak'
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
			'action_token' => str_random(64)
		]);

		Mail::send(app('template') . '.partials.mail.verify', ['user' => $user], function ($m) use ($user) {
		    $m->to($user->email, $user->username)->subject(MinecraftServer::name());
		});

		$request->session()->flash('verify_email', $user->email);

		return Response::json([
			'success' => true,
			'data' => [
				'redirect' => route('auth.verify')
			]
		]);
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
			if ( !Hash::check($request->input('password'), $user->password) ) {
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

		if ( empty($user->email) ) {
			if ( !$request->input('email') ) {
				return Response::json([
					'email_field' => true
				]);
			}

			$validator = Validator::make($request->all(), [
				'email' => 'required|unique:users|max:30|email'
			]);

			$validator->setAttributeNames([
				'email' => 'e-Posta'
			]);

			if ( $validator->fails() ) {
				return Response::json(['validations' => $validator->errors()]);
			}

			$user->email = $request->input('email');
			$user->save();
		}

		if ( $user->isVerified() ) {
			Auth::login($user);
			return Response::json(['success' => true]);
		}

		Mail::send(app('template') . '.partials.mail.verify', ['user' => $user], function ($m) use ($user) {
		    $m->to($user->email, $user->username)->subject(MinecraftServer::name());
		});

		$request->session()->flash('verify_email', $user->email);

		return Response::json([
			'success' => true,
			'data' => [
				'redirect' => route('auth.verify')
			]
		]);
	}

	public function getForgotPassword()
	{
		return view(app('template') . '.auth.forgot_password');
	}

	public function postForgotPassword(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|max:30|email'
		]);

		$validator->setAttributeNames([
			'email' => 'e-Posta'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$user = User::where('email', $request->input('email'))->first();

		if ( $user === null ) {
			sleep(2);
			return;
		}

		$user->action_token = str_random(64);
		$user->save();

		Mail::send(app('template') . '.partials.mail.forgot_password', ['user' => $user], function ($m) use ($user) {
		    $m->to($user->email, $user->username)->subject(MinecraftServer::name());
		});

		return Response::json(['success' => true]);
	}

	public function getForgotNewPassword(Request $request, $email)
	{
		$user = User::where('email', $email)->first();

		if ( $user === null || $user->action_token !== $request->input('token') ) {
			return redirect()->route('auth.index');
		}

		return view(app('template') . '.auth.new_password')->with('email', $email);
	}

	public function postForgotNewPassword(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'password' => 'required|min:6',
			'password_confirm' => 'required|same:password'
		]);

		$validator->setAttributeNames([
			'password' => 'Şifre',
			'password_confirm' => 'Şifre tekrarı'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$user = User::where('email', $request->input('email'))->first();

		if ( $user === null ) {
			return Response::json(['error' => 'Bu kullanıcı sistemimizde kayıtlı değil.']);
		}

		if ( $request->input('token') !== $user->action_token ) {
			return Response::json(['error' => 'Hatalı istek.']);
		}

		$password = $request->input('password');
		$encryption = config('minecraft.auth.encryption');

		$user->action_token = null;
		$user->password = $encryption === 'bcrypt' ? bcrypt($password) : md5($password);
		$user->save();

		return Response::json(['success' => true]);
	}

	public function getInformation()
	{
		if ( !Session::has('verify_email') ) {
			return redirect()->route('auth.index');
		}

		return view(app('template') . '.auth.information');
	}

	public function getVerify(Request $request, $email = null)
	{
		if ( empty($email) ) {
			return $this->getInformation();
		}

		$user = User::where('email', $email)->where('action_token', $request->input('token'))->first();

		if ( $user === null ) {
			return redirect()->route('auth.index');
		}

		$user->isVerified = 1;
		$user->action_token = null;
		$user->save();

		Auth::login($user);

		return redirect()->route('auth.welcome')->with('verify_email_ok', true);
	}

	public function getWelcome()
	{
		if ( !Session::has('verify_email_ok') ) {
			return redirect()->route('auth.index');
		}

		return view(app('template') . '.auth.welcome');
	}	

	public function getNewEmail()
	{
		return view(app('template') . '.auth.email');
	}

	public function postNewEmail(Request $request)
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
