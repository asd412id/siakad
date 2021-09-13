<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\DB;
use Str;

class ProdiController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (request()->ajax()) {
			$data = Prodi::query()->with(['dosen', 'mahasiswa', 'matakuliah']);
			return DataTables::of($data)
				->addColumn('action', function ($row) {

					$btn = '<div class="table-actions">';

					$btn .= ' <a href="#" data-url="' . route('prodi.edit', ['prodi' => $row]) . '" class="open-modal text-primary m-1" title="Ubah"><i class="fas fa-edit"></i></a>';

					$btn .= ' <a href="#" data-url="' . route('prodi.delete', ['prodi' => $row]) . '" class="open-modal text-danger m-1" title="Hapus"><i class="fas fa-trash"></i></a>';

					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		$data = [
			'title' => 'Program Studi'
		];
		return view('prodi.index', $data);
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
				'url' => route('prodi.store')
			];
			return response()->json([
				'title' => 'Tambah Prodi Baru',
				'form' => view('prodi.form', $data)->render()
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
			$request->validate([
				'name' => 'required'
			], [
				'name.required' => 'Nama prodi harus diisi'
			]);

			$insert = new Prodi();
			$insert->uuid = (string) Str::uuid();
			$insert->name = $request->name;
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
	 * @param  \App\Models\Prodi  $prodi
	 * @return \Illuminate\Http\Response
	 */
	public function show(Prodi $prodi)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Prodi  $prodi
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Prodi $prodi)
	{
		if (request()->ajax()) {
			$data = [
				'url' => route('prodi.update', ['prodi' => $prodi]),
				'data' => $prodi
			];
			return response()->json([
				'title' => 'Ubah Data Prodi',
				'form' => view('prodi.form', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Prodi  $prodi
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Prodi $prodi)
	{
		if (request()->ajax()) {
			$request->validate([
				'name' => 'required'
			], [
				'name.required' => 'Nama prodi harus diisi'
			]);

			$insert = $prodi;
			$insert->name = $request->name;
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
	 * @param  \App\Models\Prodi  $prodi
	 * @return \Illuminate\Http\Response
	 */
	public function delete(Prodi $prodi)
	{
		if (request()->ajax()) {
			$data = [
				'url' => route('prodi.destroy', ['prodi' => $prodi]),
				'data' => 'Prodi ' . $prodi->name
			];
			return response()->json([
				'title' => 'Konfirmasi Hapus',
				'form' => view('delete', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function destroy(Prodi $prodi)
	{
		if (request()->ajax()) {
			if ($prodi->delete()) {
				return response()->json(['message' => 'Data berhasil dihapus']);
			}
			return response()->json(['message' => 'Data gagal dihapus'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
}
