<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StudyController extends Controller
{
	public function index()
	{
		$data = [
			'title' => 'Data Studi Mahasiswa'
		];
		return view('study.index', $data);
	}
	public function query(Request $request)
	{
		if ($request->ajax()) {
			if (auth()->user()->role == 0 && !$request->prodi_id && !$request->dosen_id) {
				return response()->json([
					'message' => 'Program studi dan/atau dosen pembimbing harus dipilih'
				], 406);
			}
			$mahasiswa = Mahasiswa::when(auth()->user()->role == 0, function ($q) use ($request) {
				$q->when($request->prodi_id, function ($q, $role) {
					$q->where('prodi_id', $role);
				})->when($request->dosen_id, function ($q, $role) {
					$q->where('dosen_id', $role);
				});
			})
				->when(auth()->user()->role == 1, function ($q) {
					$q->where('dosen_id', auth()->user()->dosen->id);
				})
				->when(auth()->user()->role == 2, function ($q) {
					$q->where('id', auth()->user()->mahasiswa->id);
				})
				->with('prodi')
				->with('krs')
				->with('nilai')
				->get();

			if (!count($mahasiswa)) {
				return response()->json([
					'message' => 'Data studi mahasiswa tidak ditemukan'
				], 404);
			}
			if (!Krs::whereIn('mahasiswa_id', $mahasiswa->pluck('id')->toArray())->count() || !Nilai::whereIn('mahasiswa_id', $mahasiswa->pluck('id')->toArray())->count()) {
				return response()->json([
					'message' => 'Data studi mahasiswa tidak ditemukan'
				], 404);
			}

			$semester = Krs::whereIn('mahasiswa_id', $mahasiswa->pluck('id')->toArray())
				->select('semester')
				->distinct('semester')
				->orderBy('semester', 'asc')
				->get();
			$data = [
				'semester' => $semester,
				'mahasiswa' => $mahasiswa,
			];
			return response()->json([
				'view' => view('study.table', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
}
