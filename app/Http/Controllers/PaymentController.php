<?php

namespace Webcraft\Http\Controllers;

use Log;
use Webcraft\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function getIndex()
	{
		if ( config('payment.type') === 'batihost' ) {
			return $this->getBatihost();
		}

		return redirect()->back()->with('flash.info', 'Siteye henüz bir ödeme yöntemi eklenmemiş.');
	}

	public function getSuccess()
	{
		return view(app('template') . '.payment.success');
	}

	public function getError()
	{
		return view(app('template') . '.payment.error');
	}

	public function postListener(Request $request)
	{
		if ( config('payment.type') === 'batihost' ) {
			return $this->postBatihost($request);			
		}
	}

	/*
	* Payment Methods
	*/

	private function getBatihost()
	{
		if ( !config('payment.methods.batihost.id') || !config('payment.methods.batihost.token') ) {
			return redirect()->back()->with('flash.info', 'Batıhost ödeme yöntemi için config ayarları yapılandırılmamış.');
		}

		return view(app('template') . '.payment.methods.batihost');
	}

	private function postBatihost(Request $request)
	{
		Log::info($request->all());

		if ( !config('payment.methods.batihost.id') || !config('payment.methods.batihost.token') ) {
			return 'Batıhost ödeme yöntemi için config ayarları yapılandırılmamış.';
		}

		if ( $request->has('transid', 'user', 'credit', 'guvenlik') !== true ) {
			return 'Gönderilen POST eksik.';
		}

		if ( $request->input('guvenlik') !== config('payment.methods.batihost.token') ) {
			return 'Kardeş hacking mi yapıyon nedir?';
		}

		$user = User::where('username', $request->input('user'))->first();

		if ( $user === null ) {
			return 'Sunucuda bu isimde oynayan bir oyuncumuz yok.';
		}

		$last_payment = $user->getLastPayments()->where('method', 'batihost')->first();

		if ( $last_payment !== null && $last_payment->code === $request->input('transid') ) {
			return 'Bu kod daha önce kullanıldı.';
		}

		$insert_array = [
			'code' => $request->input('transid'),
			'method' => 'batihost'
		];

		if ( $last_payment === null ) {
			$user->getLastPayments()->create($insert_array);
		} else {
			$last_payment->update($insert_array);
		}

		$user->giveMoney($request->input('credit'));

		Log::info($request->input('credit') . ' kredi, ' . $user->username . ' hesabına eklendi. Detaylar =>' . $request->all());

		return 'OK';
	}
}