<?php

namespace Webcraft\Http\Controllers;

use Log;
use Auth;
use Validator;
use Webcraft\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function getIndex()
	{
		switch ( config('payment.type') ) {
			case 'batihost':
				return $this->getBatihost();
				break;
			case 'paywant':
				return $this->getPaywant();
				break;
			default:
				return redirect()->route('home')->with('flash.info', 'Siteye henüz bir ödeme yöntemi eklenmemiş.');
				break;
		}
	}

	public function postListener(Request $request)
	{
		switch ( config('payment.type') ) {
			case 'batihost':
				return $this->postBatihost($request);	
				break;
			case 'paywant':
				return $this->postPaywant($request);
				break;
			default:
				return redirect()->route('home');
				break;
		}
	}

	public function postSend(Request $request)
	{
		switch ( config('payment.type') ) {
			case 'paywant':
				return $this->sendPaywant($request);
				break;
			default:
				return redirect()->route('home');
				break;
		}
	}

	public function getSuccess()
	{
		return view(app('template') . '.payment.success');
	}

	public function getError()
	{
		return view(app('template') . '.payment.error');
	}

	/*
	* Helper Functions...
	*/

	private function lastPayment(User $user, $method, $code)
	{
		$last_payment = $user->getLastPayments()->where('method', $method)->first();

		if ( $last_payment !== null && $last_payment->code == $code ) {
			return true;
		}

		$insert_array = [
			'code' => $code,
			'method' => $method
		];

		if ( $last_payment === null ) {
			$user->getLastPayments()->create($insert_array);
		} else {
			$last_payment->update($insert_array);
		}

		return false;
	}

	private function giveCredit(User $user, Request $request, $credit) {
		$user->giveMoney($credit);
		Log::info($credit . ' kredi, ' . $user->username . ' hesabına eklendi. Detaylar => ' . json_encode($request->all()));
	}

	/*
	* Payment Methods
	*/

	/* Batıhost */

	private function getBatihost()
	{
		if ( !config('payment.methods.batihost.id') || !config('payment.methods.batihost.token') ) {
			return redirect()->route('home')->with('flash.info', 'Batıhost ödeme yöntemi için config ayarları yapılandırılmamış.');
		}

		return view(app('template') . '.payment.methods.batihost');
	}

	private function postBatihost(Request $request)
	{
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

		if ( $this->lastPayment($user, 'batihost', $request->input('transid')) ) {
			return 'Bu kod daha önce kullanıldı.';
		}

		$this->giveCredit($user, $request, $request->input('credit'));

		return 'OK';
	}

	/* Paywant */

	private function getPaywant()
	{
		if ( !config('payment.methods.paywant.key') || !config('payment.methods.paywant.secret') ) {
			return redirect()->route('home')->with('flash.info', 'PayWant ödeme yöntemi için config ayarları yapılandırılmamış.');
		}

		return view(app('template') . '.payment.methods.paywant');
	}

	private function postPaywant(Request $request)
	{
		if ( $request->has('SiparisID', 'ExtraData', 'UserID', 'ReturnData', 'Status', 'OdemeKanali', 'OdemeTutari', 'NetKazanc', 'Hash') !== true ) {
			return 'Gönderilen POST eksik.';
		}

		$checkHash = base64_encode(hash_hmac('sha256', implode('|', $request->only(['SiparisID', 'ExtraData', 'UserID', 'ReturnData', 'Status', 'OdemeKanali', 'OdemeTutari', 'NetKazanc'])) . config('payment.methods.paywant.key'), config('payment.methods.paywant.secret'), true));

		if ( $checkHash !== $request->input('Hash') ) {
			return 'Güvenlik kodu hatalı.';
		}

		$user = User::find($request->input('UserID'));

		if ( $user === null ) {
			return 'Bu kullanıcı, sistemimizde kayıtlı değil.';
		}

		if ( $this->lastPayment($user, 'paywant', $request->input('SiparisID')) ) {
			return 'OK'; // Bu kod daha önce kullanıldı.
		}

		if ( (int) $request->input('Status') !== 100 ) {
			return 'OK'; // İşlem iptal edildi.
		}

		$this->giveCredit($user, $request, $request->input('ExtraData'));

		return 'OK';
	}

	private function sendPaywant(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'amount' => 'required|numeric|regex:/^\d*(\.\d{2})?$/|min:1|max:90'
		]);

		$validator->setAttributeNames([
			'amount' => 'Kredi Miktarı'
		]);

		if ( $validator->fails() ) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$generateHash = base64_encode(hash_hmac('sha256', Auth::user()->username . '|' . Auth::user()->email . '|' . Auth::id() . config('payment.methods.paywant.key'), config('payment.methods.paywant.secret'), true));
		
		$productData = [
			'name' =>  'Kredi',
			'amount' => $request->input('amount') * 100,
			'extraData' => $request->input('amount'),
			'paymentChannel' => '1,2,3',
			'commissionType' => 1
		];

		$postData = [
			'apiKey' => config('payment.methods.paywant.key'),
			'hash' => $generateHash,
			'returnData'=> Auth::user()->username,
			'userEmail' => Auth::user()->email,
			'userIPAddress' => $request->ip(),
			'userID' => Auth::id(),
			'proApi' => true,
			'productData' => $productData
		];
		
		$curl = curl_init();

		curl_setopt_array($curl, [
		  CURLOPT_URL => 'http://api.paywant.com/gateway.php',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>  http_build_query($postData),
		]);
		
		$response = curl_exec($curl);
		$error = curl_error($curl);

		if ( $error ) {
			Log::error('Paywant Curl Error: ' . $error);
			return redirect()->back()->with('flash.error', 'Bir hata oluştu, lütfen admine işlem saatiyle birlikte haber verin.');
		}

		$responseJson = json_decode($response, false);
		$status = isset($responseJson->Status) ? (int) $responseJson->Status : null;

		if ( $status !== 100 ) {
			return $response;
		}

		curl_close($curl);

		return redirect()->to($responseJson->Message);
	}

	/*
	* Custom Payment Methods...
	*/

	//
}