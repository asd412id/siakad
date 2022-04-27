<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Str;
use DataTables;

class MataKuliahController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (request()->ajax()) {
			$data = MataKuliah::query()
				->with('prodi')
				->select('mata_kuliahs.*');
			if (!auth()->user()->isAdmin) {
				$data->where('prodi_id', auth()->user()->prodi_id);
			}
			return DataTables::of($data)
				->addColumn('action', function ($row) {

					$btn = '<div class="table-actions">';

					$btn .= ' <a href="#" data-url="' . route('matakuliah.edit', ['matakuliah' => $row]) . '" class="open-modal text-primary m-1" title="Ubah"><i class="fas fa-edit"></i></a>';

					$btn .= ' <a href="#" data-url="' . route('matakuliah.delete', ['matakuliah' => $row]) . '" class="open-modal text-danger m-1" title="Hapus"><i class="fas fa-trash"></i></a>';

					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		$data = [
			'title' => 'Mata Kuliah'
		];
		return view('matakuliah.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (request()->ajax()) {
			$data = [
				'url' => route('matakuliah.store'),
				'prodi' => Prodi::all()
			];
			return response()->json([
				'title' => 'Tambah Mata Kuliah Baru',
				'form' => view('matakuliah.form', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (request()->ajax()) {
			$rules = [
				'name' => 'required',
				'prodi_id' => 'required',
				'semester' => 'required|numeric',
			];

			$msgs = [
				'name.required' => 'Nama matakuliah harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'semester.required' => 'Semester harus diisi',
				'semester.numeric' => 'Semester harus berupa angka'
			];

			if (!auth()->user()->isAdmin) {
				unset($rules['prodi_id']);
				unset($msgs['prodi_id.required']);
			}

			$request->validate($rules, $msgs);

			$insert = new MataKuliah();
			$insert->uuid = (string) Str::uuid();
			$insert->name = $request->name;
			$insert->semester = $request->semester;
			$insert->sks = $request->sks;
			$insert->prodi_id = auth()->user()->isAdmin ? $request->prodi_id : auth()->user()->prodi_id;
			if ($insert->save()) {
				return response()->json(['message' => 'Data berhasil disimpan']);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\MataKuliah  $matakuliah
	 * @return \Illuminate\Http\Response
	 */
	public function show(MataKuliah $matakuliah)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\MataKuliah  $matakuliah
	 * @return \Illuminate\Http\Response
	 */
	public function edit(MataKuliah $matakuliah)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($matakuliah->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$data = [
				'url' => route('matakuliah.update', ['matakuliah' => $matakuliah]),
				'data' => $matakuliah,
				'prodi' => Prodi::all(),
			];
			return response()->json([
				'title' => 'Ubah Data Mata Kuliah',
				'form' => view('matakuliah.form', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\MataKuliah  $matakuliah
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, MataKuliah $matakuliah)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($matakuliah->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$rules = [
				'name' => 'required',
				'prodi_id' => 'required',
				'semester' => 'required|numeric',
			];

			$msgs = [
				'name.required' => 'Nama matakuliah harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'semester.required' => 'Semester harus diisi',
				'semester.numeric' => 'Semester harus berupa angka'
			];

			if (!auth()->user()->isAdmin) {
				unset($rules['prodi_id']);
				unset($msgs['prodi_id.required']);
			}

			$request->validate($rules, $msgs);

			$insert = $matakuliah;
			$insert->name = $request->name;
			$insert->semester = $request->semester;
			$insert->sks = $request->sks;
			$insert->prodi_id = auth()->user()->isAdmin ? $request->prodi_id : auth()->user()->prodi_id;
			if ($insert->save()) {
				return response()->json(['message' => 'Data berhasil disimpan']);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\MataKuliah  $matakuliah
	 * @return \Illuminate\Http\Response
	 */
	public function delete(MataKuliah $matakuliah)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($matakuliah->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$data = [
				'url' => route('matakuliah.destroy', ['matakuliah' => $matakuliah]),
				'data' => ['Mata Kuliah ' . $matakuliah->name, $matakuliah->prodi ? 'Prodi ' . $matakuliah->prodi->name : null]
			];
			return response()->json([
				'title' => 'Konfirmasi Hapus',
				'form' => view('delete', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function destroy(MataKuliah $matakuliah)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($matakuliah->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			if ($matakuliah->delete()) {
				return response()->json(['message' => 'Data berhasil dihapus']);
			}
			return response()->json(['message' => 'Data gagal dihapus'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
}
