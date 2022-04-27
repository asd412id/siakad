<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Str;

class OperatorController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (request()->ajax()) {
			$data = User::query()
				->where('role', 3)
				->with('prodi')
				->select('users.*');
			return DataTables::of($data)
				->addColumn('action', function ($row) {

					$btn = '<div class="table-actions">';

					$btn .= ' <a href="#" data-url="' . route('operator.edit', ['operator' => $row]) . '" class="open-modal text-primary m-1" title="Ubah"><i class="fas fa-edit"></i></a>';

					$btn .= ' <a href="#" data-url="' . route('operator.delete', ['operator' => $row]) . '" class="open-modal text-danger m-1" title="Hapus"><i class="fas fa-trash"></i></a>';

					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		$data = [
			'title' => 'Operator'
		];
		return view('operator.index', $data);
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
				'url' => route('operator.store'),
				'prodi' => Prodi::all(),
			];
			return response()->json([
				'title' => 'Tambah Operator Baru',
				'form' => view('operator.form', $data)->render()
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
				'username' => 'required|unique:users,username',
			], [
				'name.required' => 'Nama operator harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'username.required' => 'Username harus diisi',
				'username.unique' => 'Username telah digunakan'
			]);

			$operator = new User();
			$operator->uuid = Str::uuid();
			$operator->name = $request->name;
			$operator->username = $request->username;
			$operator->password = $request->password ? bcrypt($request->password) : bcrypt($request->username);
			$operator->role = 3;
			$operator->prodi_id = $request->prodi_id;
			$operator->jenis_kelamin = $request->jenis_kelamin;

			if ($operator->save()) {
				return response()->json(['message' => 'Data berhasil disimpan']);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Operator  $operator
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $operator)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Operator  $operator
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $operator)
	{
		if (request()->ajax()) {
			$data = [
				'url' => route('operator.update', ['operator' => $operator]),
				'data' => $operator,
				'prodi' => Prodi::all()
			];
			return response()->json([
				'title' => 'Ubah Data Operator',
				'form' => view('operator.form', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Operator  $operator
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $operator)
	{
		if (request()->ajax()) {
			$request->validate([
				'name' => 'required',
				'prodi_id' => 'required',
				'username' => 'required|unique:users,username,' . $operator->id,
			], [
				'name.required' => 'Nama operator harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'username.required' => 'Username harus diisi',
				'username.unique' => 'Username telah digunakan'
			]);

			$operator->name = $request->name;
			$operator->username = $request->username;
			if ($request->password) {
				$operator->password = bcrypt($request->password);
			}
			$operator->role = 3;
			$operator->prodi_id = $request->prodi_id;
			$operator->jenis_kelamin = $request->jenis_kelamin;

			if ($operator->save()) {
				return response()->json(['message' => 'Data berhasil disimpan']);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Operator  $operator
	 * @return \Illuminate\Http\Response
	 */
	public function delete(User $operator)
	{
		if (request()->ajax()) {
			$data = [
				'url' => route('operator.destroy', ['operator' => $operator]),
				'data' => $operator->name
			];
			return response()->json([
				'title' => 'Konfirmasi Hapus',
				'form' => view('delete', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function destroy(User $operator)
	{
		if (request()->ajax()) {
			if ($operator->delete()) {
				return response()->json(['message' => 'Data berhasil dihapus']);
			}
			return response()->json(['message' => 'Data gagal dihapus'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
}
