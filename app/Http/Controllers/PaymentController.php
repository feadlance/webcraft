<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function getIndex()
	{
		if ( config('payment.type') === 'batihost' && config('payment.methods.batihost.id') ) {
			return view(app('template') . '.credit.batihost');
		}

		return redirect()->back()->with('flash.info', 'Siteye henüz bir ödeme yöntemi eklenmemiş.');
	}

	public function getSuccess()
	{

	}

	public function getError()
	{

	}

	public function getListener(Request $request)
	{

	}

	public function postListener(Request $request)
	{
		if ( config('payment.type') === 'batihost' ) {

			if ( config('payment.methods.batihost.id') && config('payment.methods.batihost.token') ) {
				return redirect()->back()->with('flash.info', 'Batıhost ödeme yöntemi için config ayarları yapılandırılmamış.');
			}

			if ( $request->input('guvenlik') !== config('payment.methods.batihost.token') ) {
				return redirect()->back()->with('flash.info', 'Kardeş hacking mi yapıyon nedir?');
			}

			$user = User::where('username', $request->input('username'))->first();

			if ( $user === null ) {
				return redirect()->back()->with('flash.info', 'Sunucuda bu isimde oynayan bir oyuncumuz yok.');
			}

			$user->money = $user->money + $request->input('credit');
			$user->save();
			
		}
	}
}