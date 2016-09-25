<?php

namespace Webcraft\Http\Controllers;

use Auth;
use Response;
use Webcraft\Models\Community_Market;
use Webcraft\Notifications\SelledCommunityItem;

use Illuminate\Http\Request;

class CommunityMarketController extends Controller
{
	public function getIndex()
	{
		$materials = Community_Market::groupBy('type', 'meta')->get();

		return view(app('template') . '.market.community.index')
			->with('materials', $materials);
	}

	public function postBuy(Request $request)
	{
		$product = Community_Market::find($request->input('id'));

		if ( $product === null ) {
			return Response::json(['error' => 'Ürün bulunamadı.']);
		}

		$balanceFormat = Auth::user()->game() && Auth::user()->game()->balance() ? Auth::user()->game()->balance()->balance : 0;

		if ( Auth::id() !== $product->user()->id && $product->price(true, false) > $balanceFormat ) {
			return Response::json(['error' => 'Bu ürünü almak için yeterli oyun paranız yok.']);
		}

		$available_chest = Auth::user()->chests()->available();

		if ( isset($available_chest->id) !== true ) {
			$last_chest = Auth::user()->chests()->orderBy('number', 'desc')->first();
			$last_chest_number = 1;

			if ( $last_chest !== null ) {
				$last_chest_number = $last_chest->number + 1;
			}

			$available_chest = Auth::user()->chests()->create(['number' => $last_chest_number]);
		}

		if ( $available_chest->opened === true ) {
			return Response::json(['error' => 'Sandık açıkken ürün alamazsınız.']);
		}

		$available_chest->addItem($product->type, $product->meta, $product->name, $product->piece, $product->durability, $product->max_durability, $product->skills);

		$success_message = 'Ürün tekrar sandığında. ' . config('minecraft.sqlchest.command');

		if ( Auth::id() !== $product->user()->id ) {
			Auth::user()->game()->balance()->take($product->price(true));

			$product->user()->game()->balance()->give($product->price(true));
			$product->user()->notify(new SelledCommunityItem(Auth::user(), $product->icon()));

			$success_message = 'Ürün başarıyla alındı! ' . config('minecraft.sqlchest.command') . ' yazarak görüntüleyebilirsin.';
		}

		$product->delete();

		return Response::json(['success' => true, 'message' => $success_message]);
	}
}