<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Product;
use Webcraft\Models\Group;

use Illuminate\Http\Request;

class MarketController extends Controller
{
	public function getIndex()
	{
		return view('market.index');
	}

	public function getProducts()
	{
		$products = Product::orderBy('title', 'asc')->get();

		return view('market.products')
			->with('products', $products);
	}

	public function postBuyProduct(Request $request, \Websend $ws)
	{
		$product = Product::find($request->input('id'));

		if ( $product === null ) {
			return \Response::json(['error' => 'Geçersiz ürün.']);
		}

		$piece = $request->input('piece');

		if ( empty($piece) === true || $piece <= 0 || $piece > 100 ) {
			return \Response::json(['error' => 'Adet, 1 den küçük ve 100 den büyük olamaz.']);
		}

		$user = \Auth::user();

		if ( $user->getBalance() < $product->balance * $piece ) {
			return \Response::json(['error' => 'Yeterli krediniz yok.']);
		}

		if ( !$user->game() || $user->game()->isOnline() !== true ) {
			return \Response::json(['error' => 'Ürün satın alabilmek için oyunda olmanız gerek.']);
		}

		if ( $user->giveItem($ws, $product->getCode(), $piece) ) {
			$user->takeBalance($ws, $product->balance * $piece);
		}

		return \Response::json(['success' => true]);
	}

	public function getGroups(\Websend $ws)
	{
		$groups = Group::orderBy('title', 'asc')->get();

		return view('market.groups')
			->with('groups', $groups);
	}

	public function postBuyGroup(Request $request, \Websend $ws)
	{
		$group = Group::find($request->input('id'));

		if ( $group === null ) {
			return \Response::json(['error' => 'Geçersiz grup.']);
		}

		$user = \Auth::user();

		if ( $user->money < $group->balance ) {
			return \Response::json(['error' => 'Yeterli paranız yok.']);
		}

		if ( $user->setGroup($ws, $group->group) ) {
			$user->takeMoney($group->balance);
			$ws->message($group->group . ' grubunu satin aldiniz.', $user->username);
		}

		return \Response::json(['success' => true]);
	}
}