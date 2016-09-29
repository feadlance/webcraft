<?php

namespace Webcraft\Http\Controllers;

use Mail;
use Auth;
use MinecraftServer;
use Illuminate\Http\Request;

class BugController extends Controller
{
	public function post(Request $request)
	{
		$cause = $request->input('bug.cause');

		if ( mb_strlen($cause, 'UTF-8') > 350 ) {
			return redirect()->back()->with('flash.error', 'Hata mesajı 350 karakterden fazla olamaz.');
		}

		Mail::send(app('template') . '.partials.mail.bug', ['bug' => $request->input('bug.cause'), 'user' => Auth::user(), 'server_name' => MinecraftServer::name()], function ($m) {
		    $m->to('davutkmbr@gmail.com', 'Davut Kember')->subject(MinecraftServer::name() . ' sunucusundan gelen bug bildirimi.');
		});

		return redirect()->back()->with('flash.success', 'Hata bildiriminiz başarıyla gönderildi!');
	}
}