<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Str;

class DosenController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (request()->ajax()) {
			$data = Dosen::query()
				->with('prodi')
				->with('user')
				->select('dosens.*');
			return DataTables::of($data)
				->addColumn('action', function ($row) {

					$btn = '<div class="table-actions">';

					$btn .= ' <a href="#" data-url="' . route('dosen.edit', ['dosen' => $row]) . '" class="open-modal text-primary m-1" title="Ubah"><i class="fas fa-edit"></i></a>';

					$btn .= ' <a href="#" data-url="' . route('dosen.delete', ['dosen' => $row]) . '" class="open-modal text-danger m-1" title="Hapus"><i class="fas fa-trash"></i></a>';

					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		$data = [
			'title' => 'Dosen'
		];
		return view('dosen.index', $data);
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
				'url' => route('dosen.store'),
				'prodi' => Prodi::all(),
			];
			return response()->json([
				'title' => 'Tambah Dosen Baru',
				'form' => view('dosen.form', $data)->render()
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
				'name' => 'required',
				'prodi_id' => 'required',
				'nidn' => 'required|unique:users,username',
			], [
				'name.required' => 'Nama dosen harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'nidn.required' => 'NIDN harus diisi',
				'nidn.unique' => 'NIDN telah digunakan'
			]);

			$user = new User();
			$user->uuid = Str::uuid();
			$user->name = $request->name;
			$user->username = $request->nidn;
			$user->password = $request->password ? bcrypt($request->password) : bcrypt($request->nidn);
			$user->role = 1;

			if ($user->save()) {
				$insert = new Dosen();
				$insert->user_id = $user->id;
				$insert->nidn = $request->nidn;
				$insert->nip = $request->nip;
				$insert->tempat_lahir = $request->tempat_lahir;
				$insert->tgl_lahir = $request->tgl_lahir;
				$insert->jenis_kelamin = $request->jenis_kelamin;
				$insert->prodi_id = $request->prodi_id;
				$insert->status = $request->status;
				if ($insert->save()) {
					$insert->mata_kuliah()->sync($request->mata_kuliah);
					return response()->json(['message' => 'Data berhasil disimpan']);
				}
				return response()->json(['message' => 'Data gagal disimpan'], 500);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Dosen  $dosen
	 * @return \Illuminate\Http\Response
	 */
	public function show(Dosen $dosen)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Dosen  $dosen
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Dosen $dosen)
	{
		if (request()->ajax()) {
			$data = [
				'url' => route('dosen.update', ['dosen' => $dosen]),
				'data' => $dosen,
				'prodi' => Prodi::all()
			];
			return response()->json([
				'title' => 'Ubah Data Dosen',
				'form' => view('dosen.form', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Dosen  $dosen
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Dosen $dosen)
	{
		if (request()->ajax()) {
			$request->validate([
				'name' => 'required',
				'prodi_id' => 'required',
				'nidn' => 'required|unique:users,username,' . $dosen->user_id,
			], [
				'name.required' => 'Nama dosen harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'nidn.required' => 'NIDN harus diisi',
				'nidn.unique' => 'NIDN telah digunakan'
			]);

			$user = $dosen->user;
			$user->name = $request->name;
			$user->username = $request->nidn;
			if ($request->password) {
				$user->password = bcrypt($request->password);
			}
			$user->role = 1;

			if ($user->save()) {
				$insert = $dosen;
				$insert->user_id = $user->id;
				$insert->nidn = $request->nidn;
				$insert->nip = $request->nip;
				$insert->tempat_lahir = $request->tempat_lahir;
				$insert->tgl_lahir = $request->tgl_lahir;
				$insert->jenis_kelamin = $request->jenis_kelamin;
				$insert->prodi_id = $request->prodi_id;
				$insert->status = $request->status;
				if ($insert->save()) {
					$insert->mata_kuliah()->sync($request->mata_kuliah);
					return response()->json(['message' => 'Data berhasil disimpan']);
				}
				return response()->json(['message' => 'Data gagal disimpan'], 500);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Dosen  $dosen
	 * @return \Illuminate\Http\Response
	 */
	public function delete(Dosen $dosen)
	{
		if (request()->ajax()) {
			$data = [
				'url' => route('dosen.destroy', ['dosen' => $dosen]),
				'data' => $dosen->nidn . ' - ' . $dosen->user->name
			];
			return response()->json([
				'title' => 'Konfirmasi Hapus',
				'form' => view('delete', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function destroy(Dosen $dosen)
	{
		if (request()->ajax()) {
			if ($dosen->delete()) {
				return response()->json(['message' => 'Data berhasil dihapus']);
			}
			return response()->json(['message' => 'Data gagal dihapus'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
}
