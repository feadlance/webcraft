<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function getIndex()
	{
		if ( config('payment.type') === 'batihost' && config('payment.methods.batihost.id') ) {
			return view('credit.batihost');
		}

		return redirect()->back()->with('flash.info', 'Siteye henüz bir ödeme yöntemi eklenmemiş.');
	}

	public function getSuccess() {

	}

	public function getError() {

	}

	public function getListener(Request $request)
	{
		if ( config('payment.type') === 'batihost' && config('payment.methods.batihost.id') ) {

			Auth::user()->money = Auth::user()->money + $request->input('credit');
			Auth::user()->save();

		}
	}

	public function postListener(Request $request)
	{
		if ( config('payment.type') === 'batihost' && config('payment.methods.batihost.id') ) {

			Auth::user()->money = Auth::user()->money + $request->input('credit');
			Auth::user()->save();

		}
	}
}