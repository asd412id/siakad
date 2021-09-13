<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SearchController extends Controller
{
	public function mataKuliah(Request $request)
	{
		if ($request->ajax()) {
			$result = MataKuliah::where('name', 'like', "%$request->q%")
				->orWhere('semester', 'like', "%$request->q%")
				->orWhereHas('prodi', function ($q) use ($request) {
					$q->where('name', 'like', "%$request->q%");
				})
				->select('id', 'name as text')
				->get();

			return response()->json([
				'results' => $result
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function prodi(Request $request)
	{
		if ($request->ajax()) {
			$result = Prodi::where('name', 'like', "%$request->q%")
				->select('id', 'name as text')
				->get();

			return response()->json([
				'results' => $result
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function dosen(Request $request)
	{
		if ($request->ajax()) {
			$query = Dosen::with('user')
				->whereHas('user', function ($q) use ($request) {
					$q->where('name', 'like', "%$request->q%");
				})
				->orWhere('nidn', 'like', "%$request->q%")
				->orWhere('nip', 'like', "%$request->q%")
				->get();

			$result = [];
			foreach ($query as $key => $v) {
				array_push($result, [
					'id' => $v->id,
					'text' => $v->user->name,
				]);
			}

			return response()->json([
				'results' => $result
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
}
