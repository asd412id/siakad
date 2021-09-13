<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Config;
use Illuminate\Support\Facades\Hash;

class CommonController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function login()
	{
		$data = [
			'title' => 'Halaman Login'
		];
		return view('login', $data);
	}

	public function loginProcess(Request $r)
	{
		$rules = [
			'username' => 'required',
			'password' => 'required',
		];

		$msgs = [
			'username.required' => 'Username tidak boleh kosong!',
			'password.required' => 'Password tidak boleh kosong!',
		];

		validator($r->all(), $rules, $msgs)->validate();

		if (!Auth::attempt(['username' => $r->username, 'password' => $r->password], (bool) $r->remember)) {
			return redirect()->back()->withErrors('Username dan password tidak benar!');
		}

		return redirect()->route('home');
	}

	public function logout()
	{
		if (request()->ajax()) {
			return response()->json([
				'title' => 'Konfirmasi',
				'form' => view('logout')->render()
			]);
		}
		return redirect()->route('home')->withErrors('Anda tidak memiliki akses!');
	}

	public function logoutProcess()
	{
		if (request()->ajax()) {
			auth()->logout();
			return response()->json(['message' => 'Anda berhasil keluar!<br>Mengarahkan ke halaman login ...', 'redirect' => route('login'), 'timeout' => 500]);
		}
		return redirect()->route('home')->withErrors('Anda tidak memiliki akses!');
	}

	public function home()
	{
		$data = [
			'title' => 'Beranda'
		];
		return view('home', $data);
	}
	public function account()
	{
		if (request()->ajax()) {
			$data = [
				'title' => auth()->user()->role == 0 ? 'Pengaturan Akun' : 'Ubah Password',
				'user' => auth()->user(),
				'configs' => Config::configs(),
			];
			return response()->json([
				'title' => $data['title'],
				'form' => view('account', $data)->render(),
			]);
		}
		return redirect()->route('home')->withErrors('Anda tidak memiliki akses!');
	}

	public function accountUpdate(Request $r)
	{
		if ($r->ajax()) {
			$rules = [
				'name' => 'required',
				'username' => 'required',
				'password' => 'required',
				'newpassword' => 'confirmed',
			];

			$msgs = [
				'name.required' => 'Nama tidak boleh kosong!',
				'username.required' => 'Username tidak boleh kosong!',
				'password.required' => 'Password tidak boleh kosong!',
				'newpassword.confirmed' => 'Perulangan password tidak benar!',
			];

			if (auth()->user()->role != 0) {
				unset($rules['name']);
				unset($rules['username']);
				unset($msgs['name.required']);
				unset($msgs['username.required']);
			}

			$r->validate($rules, $msgs);

			$user = auth()->user();

			if (!Hash::check($r->password, $user->password)) {
				return response()->json(['message' => 'Password tidak benar!'], 406);
			}

			if (auth()->user()->role == 0) {
				$user->name = $r->name;
				$user->username = $r->username;
			}
			if ($r->newpassword) {
				$user->password = bcrypt($r->newpassword);
			}

			if ($user->save()) {
				return response()->json(['message' => 'Data akun berhasil diubah'], 202);
			}
			return response()->json(['message' => 'Tidak dapat mengubah data akun!'], 500);
		}
		return redirect()->route('home')->withErrors('Anda tidak memiliki akses!');
	}
	public function configsUpdate(Request $r)
	{
		if ($r->ajax()) {
			$data = [];
			foreach ($r->all() as $key => $v) {
				if ($key == '_token') {
					continue;
				}
				array_push($data, [
					'config' => $key,
					'value' => $v
				]);
			}

			Config::truncate();
			$insert = Config::insert($data);

			if ($insert) {
				return response()->json(['message' => 'Pengaturan berhasil diubah'], 202);
			}
			return response()->json(['message' => 'Pengaturan gagal disimpan!'], 500);
		}
		return redirect()->route('home')->withErrors('Anda tidak memiliki akses!');
	}
}
