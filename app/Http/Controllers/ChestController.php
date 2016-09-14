<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Response;
use Validator;

use Illuminate\Http\Request;

class ChestController extends Controller
{
	public function postSellItem(Request $request, $username)
	{
		$validator = Validator::make($request->all(), [
			'piece' => 'required|numeric',
			'price' => 'required|regex:/^\d*(\.\d{2})?$/'
		]);

		$validator->setAttributeNames([
			'piece' => 'Adet',
			'price' => 'Fiyat'
		]);

		if ( $validator->fails() ) {
			return Response::json(['validations' => $validator->errors()]);
		}

		$number = (int) $request->input('number');
		$order = (int) $request->input('order');
		$piece = (int) $request->input('piece');
		$price = (float) $request->input('price');

		$chest = Auth::user()->chests()->where('number', $number)->first();

		if ( $chest === null ) {
			return Response::json(['error' => 'Sandık bulunamadı.']);
		}

		if ( $chest->opened === true ) {
			return Response::json(['error' => 'Lütfen oyundan sandığı kapatıp tekrar deneyin.']);
		}

		$inventory = $chest->inventory[$order];

		if ( $piece > $inventory[4] ) {
			return Response::json(['error' => 'En fazla ' . $inventory[4] . ' adet satabilirsiniz.']);
		}

		$updateInventory = $chest->inventory;

		if ( $piece === (int) $inventory[4] ) {
			unset($updateInventory[$order]);
		} else {
			$updateInventory[$order][4] = $inventory[4] - $piece;
		}

		$chest->inventory = json_encode((object) $updateInventory);

		if ( empty(count($chest->inventory)) === true ) {
			$chest->delete();
		} else {
			$chest->save();
		}

		Auth::user()->market()->create([
			'price' => $price / $piece,
			'piece' => $piece,
			'type' => $inventory[1],
			'meta' => $inventory[2],
			'durability' => $inventory[5],
			'max_durability' => $inventory[6],
			'skills' => $inventory[7]
		]);

		return Response::json(['chest' => $chest]);
	}

	public function postSellItemModal(Request $request)
	{
		$chest = Auth::user()->chests()->where('number', $request->input('number'))->first();

		if ( $chest === null ) {
			return Response::json(['error' => 'Sandık bulunamadı.']);
		}

		return Response::json(['chest' => $chest]);
	}
}