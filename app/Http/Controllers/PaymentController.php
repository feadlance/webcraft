<?php

namespace Webcraft\Http\Controllers;

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

	public function getListener()
	{
		
	}
}