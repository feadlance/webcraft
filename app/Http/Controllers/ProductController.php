<?php

namespace Webcraft\Http\Controllers;

use Webcraft\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function postNewAjax(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'title' => 'required|min:3|max:100|regex:/^[\pL\s\-]+$/u',
			'code' => 'required',
			'balance' => 'required|regex:/^\d*(\.\d{2})?$/'
		]);

		if ( $validator->fails() ) {
			return \Response::json(['errors' => $validator->errors()]);
		}

		$product = Product::create([
			'title' => $request->input('title'),
			'code' => $request->input('code'),
			'balance' => $request->input('balance')
		]);

		return \Response::json([
			'title' => $product->title,
			'balance' => $product->getBalance(),
			'code' => $product->getCode('-')
		]);
	}
}