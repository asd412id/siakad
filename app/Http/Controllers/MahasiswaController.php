<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Str;

class MahasiswaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (request()->ajax()) {
			$data = Mahasiswa::query()
				->with('prodi')
				->with('dosen.user')
				->with('user')
				->select('mahasiswas.*');
			if (!auth()->user()->isAdmin) {
				$data->where('prodi_id', auth()->user()->prodi_id);
			}
			return DataTables::of($data)
				->addColumn('action', function ($row) {

					$btn = '<div class="table-actions">';

					$btn .= ' <a href="#" data-url="' . route('mahasiswa.krs', ['mahasiswa' => $row]) . '" class="open-modal text-primary m-1" title="KRS" data-type="modal-xl"><i class="fas fa-th-list"></i></a>';
					$btn .= ' <a href="#" data-url="' . route('mahasiswa.nilai', ['mahasiswa' => $row]) . '" class="open-modal text-success m-1" title="Nilai" data-type="modal-xl"><i class="fas fa-list-ol"></i></a>';
					$btn .= ' <a href="#" data-url="' . route('mahasiswa.edit', ['mahasiswa' => $row]) . '" class="open-modal text-warning m-1" title="Ubah"><i class="fas fa-edit"></i></a>';

					$btn .= ' <a href="#" data-url="' . route('mahasiswa.delete', ['mahasiswa' => $row]) . '" class="open-modal text-danger m-1" title="Hapus"><i class="fas fa-trash"></i></a>';

					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		$data = [
			'title' => 'Mahasiswa'
		];
		return view('mahasiswa.index', $data);
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
				'url' => route('mahasiswa.store'),
				'prodi' => Prodi::all(),
			];
			return response()->json([
				'title' => 'Tambah Mahasiswa Baru',
				'form' => view('mahasiswa.form', $data)->render()
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
				'nim' => 'required|unique:users,username',
			];
			$msgs = [
				'name.required' => 'Nama mahasiswa harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'nim.required' => 'NIM harus diisi',
				'nim.unique' => 'NIM telah digunakan'
			];

			if (!auth()->user()->isAdmin) {
				unset($rules['prodi_id']);
				unset($msgs['prodi_id.required']);
			}

			$request->validate($rules, $msgs);

			$user = new User();
			$user->uuid = Str::uuid();
			$user->name = $request->name;
			$user->username = $request->nim;
			$user->password = $request->password ? bcrypt($request->password) : bcrypt($request->nim);
			$user->role = 2;

			if ($user->save()) {
				$insert = new Mahasiswa();
				$insert->user_id = $user->id;
				$insert->nim = $request->nim;
				$insert->tempat_lahir = $request->tempat_lahir;
				$insert->tgl_lahir = $request->tgl_lahir;
				$insert->jenis_kelamin = $request->jenis_kelamin;
				$insert->prodi_id = auth()->user()->isAdmin ? $request->prodi_id : auth()->user()->prodi_id;
				$insert->dosen_id = $request->dosen_id;
				$insert->status = $request->status;
				if ($insert->save()) {
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
	 * @param  \App\Models\Mahasiswa  $mahasiswa
	 * @return \Illuminate\Http\Response
	 */
	public function show(Mahasiswa $mahasiswa)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Mahasiswa  $mahasiswa
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Mahasiswa $mahasiswa)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$data = [
				'url' => route('mahasiswa.update', ['mahasiswa' => $mahasiswa]),
				'data' => $mahasiswa,
				'prodi' => Prodi::all()
			];
			return response()->json([
				'title' => 'Ubah Data Mahasiswa',
				'form' => view('mahasiswa.form', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Mahasiswa  $mahasiswa
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Mahasiswa $mahasiswa)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$rules = [
				'name' => 'required',
				'prodi_id' => 'required',
				'nim' => 'required|unique:users,username,' . $mahasiswa->user_id,
			];
			$msgs = [
				'name.required' => 'Nama mahasiswa harus diisi',
				'prodi_id.required' => 'Program studi harus dipilih',
				'nim.required' => 'NIM harus diisi',
				'nim.unique' => 'NIM telah digunakan'
			];

			if (!auth()->user()->isAdmin) {
				unset($rules['prodi_id']);
				unset($msgs['prodi_id.required']);
			}

			$request->validate($rules, $msgs);

			$user = $mahasiswa->user;
			$user->name = $request->name;
			$user->username = $request->nim;
			if ($request->password) {
				$user->password = bcrypt($request->password);
			}
			$user->role = 2;

			if ($user->save()) {
				$insert = $mahasiswa;
				$insert->user_id = $user->id;
				$insert->nim = $request->nim;
				$insert->tempat_lahir = $request->tempat_lahir;
				$insert->tgl_lahir = $request->tgl_lahir;
				$insert->jenis_kelamin = $request->jenis_kelamin;
				$insert->prodi_id = auth()->user()->isAdmin ? $request->prodi_id : auth()->user()->prodi_id;
				$insert->dosen_id = $request->dosen_id;
				$insert->status = $request->status;
				if ($insert->save()) {
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
	 * @param  \App\Models\Mahasiswa  $mahasiswa
	 * @return \Illuminate\Http\Response
	 */
	public function delete(Mahasiswa $mahasiswa)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$data = [
				'url' => route('mahasiswa.destroy', ['mahasiswa' => $mahasiswa]),
				'data' => $mahasiswa->nim . ' - ' . $mahasiswa->user->name
			];
			return response()->json([
				'title' => 'Konfirmasi Hapus',
				'form' => view('delete', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function destroy(Mahasiswa $mahasiswa)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			if ($mahasiswa->delete()) {
				return response()->json(['message' => 'Data berhasil dihapus']);
			}
			return response()->json(['message' => 'Data gagal dihapus'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function krs(Mahasiswa $mahasiswa)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$semester = MataKuliah::where('prodi_id', $mahasiswa->prodi_id)
				->select('semester')
				->distinct('semester')
				->orderBy('semester', 'asc')
				->get();
			$data = [
				'url' => route('mahasiswa.krs.update', ['mahasiswa' => $mahasiswa]),
				'data' => $mahasiswa,
				'semester' => $semester,
				'mata_kuliah' => MataKuliah::where('prodi_id', $mahasiswa->prodi_id)
					->orderBy('semester', 'asc')
					->orderBy('name', 'asc')
					->get(),
				'krs' => $mahasiswa->krs()->with('mata_kuliah')
			];
			return response()->json([
				'title' => "Pengaturan KRS - ({$mahasiswa->nim}) {$mahasiswa->user->name}",
				'form' => view('mahasiswa.krs', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	public function krsUpdate(Mahasiswa $mahasiswa, Request $request)
	{
		if ($request->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$status = true;
			$mahasiswa->krs()->delete();
			if ($request->mk && count($request->mk)) {
				foreach ($request->mk as $smt => $mk) {
					foreach ($mk as $v) {
						$_mk = MataKuliah::find($v);
						$krs = new Krs();
						$krs->semester = $smt;
						$krs->mahasiswa_id = $mahasiswa->id;
						$krs->mata_kuliah_id = $v;
						$krs->sks = $_mk->sks;
						$status = $krs->save();
					}
				}
			}

			if ($status) {
				return response()->json(['message' => 'Data berhasil disimpan']);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function nilai(Mahasiswa $mahasiswa)
	{
		if (request()->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$semester = $mahasiswa->krs()
				->select('semester')
				->distinct('semester')
				->orderBy('semester', 'asc')
				->get();
			if (!count($semester)) {
				$mahasiswa->nilai()->delete();
			}
			$data = [
				'url' => route('mahasiswa.nilai.update', ['mahasiswa' => $mahasiswa]),
				'data' => $mahasiswa,
				'semester' => $semester,
				'mata_kuliah' => MataKuliah::where('prodi_id', $mahasiswa->prodi_id)
					->orderBy('semester', 'asc')
					->orderBy('name', 'asc')
					->get(),
				'krs' => $mahasiswa->krs()->with(['mata_kuliah' => function ($q) {
					$q->orderBy('semester', 'asc')
						->orderBy('name', 'asc');
				}])
			];
			return response()->json([
				'title' => "Input Nilai - ({$mahasiswa->nim}) {$mahasiswa->user->name}",
				'form' => view('mahasiswa.nilai', $data)->render()
			]);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}
	public function nilaiUpdate(Mahasiswa $mahasiswa, Request $request)
	{
		if ($request->ajax()) {
			if (!auth()->user()->isAdmin) {
				if ($mahasiswa->prodi_id != auth()->user()->prodi_id) {
					return response()->json(['message' => 'Akses ditolak!'], 403);
				}
			}
			$status = true;
			$mahasiswa->nilai()->delete();
			if ($request->bnilai && count($request->bnilai)) {
				foreach ($request->bnilai as $smt => $bnilai) {
					foreach ($bnilai as $mkid => $v) {
						$mk = MataKuliah::find($mkid);
						foreach ($v as $n) {
							if ($n && !is_null($n)) {

								if ($n > 100) {
									$n = 100;
								}

								$nilai = new Nilai();
								$nilai->semester = $smt;
								$nilai->mahasiswa_id = $mahasiswa->id;
								$nilai->mata_kuliah_id = $mkid;
								$nilai->sks = $mk->sks;
								$nilai->bnilai = $n;

								$nilai->poin_nilai = $this->convertNilai($n);
								$nilai->index_nilai = $this->indexNilai($nilai->poin_nilai);
								$nilai->total_nilai = $nilai->poin_nilai * $mk->sks;

								$status = $nilai->save();
							}
						}
					}
				}
			}

			if ($status) {
				return response()->json(['message' => 'Data berhasil disimpan']);
			}
			return response()->json(['message' => 'Data gagal disimpan'], 500);
		}
		return redirect()->route('home')->withErrors('Akses ditolak!');
	}

	public function indexNilai($nilai)
	{
		switch ($nilai) {
			case 4:
				$index = 'A+';
				break;
			case 3.75:
				$index = 'A';
				break;
			case 3.5:
				$index = 'A-';
				break;
			case 3.25:
				$index = 'B+';
				break;
			case 3:
				$index = 'B';
				break;
			case 2.75:
				$index = 'B-';
				break;
			case 2.5:
				$index = 'C+';
				break;
			case 2.25:
				$index = 'C';
				break;
			case 2:
				$index = 'C-';
				break;
			case 1:
				$index = 'D';
				break;

			default:
				$index = 'E';
				break;
		}

		return $index;
	}

	public function convertNilai($nilai)
	{
		$index = 0;
		switch ($nilai) {
			case $nilai >= 95:
				$index = 4;
				break;
			case $nilai >= 90 && $nilai <= 94:
				$index = 3.75;
				break;
			case $nilai >= 85 && $nilai <= 89:
				$index = 3.5;
				break;
			case $nilai >= 80 && $nilai <= 84:
				$index = 3.25;
				break;
			case $nilai >= 75 && $nilai <= 79:
				$index = 3;
				break;
			case $nilai >= 70 && $nilai <= 74:
				$index = 2.75;
				break;
			case $nilai >= 65 && $nilai <= 69:
				$index = 2.5;
				break;
			case $nilai >= 61 && $nilai <= 64:
				$index = 2.25;
				break;
			case $nilai >= 55 && $nilai <= 60:
				$index = 2;
				break;
			case $nilai >= 50 && $nilai <= 54:
				$index = 1;
				break;
			case $nilai <= 49:
				$index = 0;
				break;
		}

		return $index;
	}
}
