<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\UserRequest;
use \App\Models\User;
use \App\Models\Cabang;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $param;

    public function __construct()
    {
        $this->param['pageIcon'] = 'fa fa-database';
        $this->param['parentMenu'] = '/user';
        $this->param['current'] = 'User';
    }

    public function index(Request $request)
    {
        $this->param['pageTitle'] = 'List User';
        $this->param['btnText'] = 'Tambah User';
        $this->param['btnLink'] = route('user.create');

        try {
            $keyword = $request->get('keyword');
            $getUser = User::with('cabang')->orderBy('id', 'ASC');

            if ($keyword) {
                $getUser->where('id', 'LIKE', "%{$keyword}%")->orWhere('name', 'LIKE', "%{$keyword}%")->orWhere('nip', 'LIKE', "%{$keyword}%");
            }

            $this->param['user'] = $getUser->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return \view('user.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['pageTitle'] = 'Tambah User';
        $this->param['btnText'] = 'List User';
        $this->param['btnLink'] = route('user.index');
        $this->param['allCab'] = Cabang::get();


        return \view('user.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        /* TODO
        1. validasi form
        2. simpan ke db
        3. redirect ke index
        */

        $validated = $request->validated();
        try {
            $user = new User;
            $user->nip = ($request->get('nip') == null) ? null : $validated['nip'];
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->password = \Hash::make('12345678');
            $user->id_cabang = $validated['id_cabang'];
            $user->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('user.index')->withStatus('Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->param['pageTitle'] = 'Edit User';
        $this->param['user'] = User::find($id);
        $this->param['btnText'] = 'List User';
        $this->param['btnLink'] = route('user.index');
        $this->param['allCab'] = Cabang::get();

        return view('user.edit', $this->param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate(
            [
                'nip' => 'sometimes|nullable|unique:users,nip,'.$user->id,
                'name' => 'required',
                'email' => 'required',
                'role' => 'required',
                'id_cabang' => 'required',
            ],
        );

        try {
            $user->nip = $request->get('nip');
            $user->name = $request->get('name');
            $user->email = $request['email'];
            $user->role = $request['role'];
            $user->id_cabang = $request['id_cabang'];
            $user->save();

            
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('user.index')->withStatus('Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan.');
        }

        return redirect()->route('user.index')->withStatus('Data berhasil dihapus.');
    }

    public function changePassword()
    {
        $this->param['pageTitle'] = 'Edit Password';
        $this->param['user'] = User::find(auth()->user()->id);
        if(Auth::user()->password_change_at == null){
            $this->param['force'] = true;
        } else {
            $this->param['force'] = false;
        }
        return view('user.change-password', $this->param);
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);;
        $old = $request->old_pass;
        $new = $request->password;

        if(!\Hash::check($old, $user->password))
            return back()->withError('Password lama tidak cocok.');

        if(\Hash::check($new, $user->password))
            return back()->withError('Password baru tidak boleh sama dengan password lama.');

        $validatedData = $request->validate(
            [
                'old_pass' => 'required',
                'password' => 'required',
                'confirmation' => 'required|same:password'
            ],
            [
                'required' => ':attribute harus diisi.',
                'password.unique' => 'Password baru tidak boleh sama dengan password lama.',
                'same' => 'Konfirmasi password harus sesuai.'
            ],
            [
                'old_pass' => 'Password lama',
                'password' => 'Password baru',
                'confirmation' => 'Konfirmasi password baru',
            ]
        );

        try {
            $user->password = \Hash::make($request->get('password'));
            $user->password_change_at = now();
            $user->save();


        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }

        return back()->withStatus('Password berhasil diperbarui.');
    }

    function resetPassword($id) {
        $user = User::findOrFail($id);
        try{
            $user->password = \Hash::make('12345678');
            $user->password_change_at = null;
            $user->save();
        } catch(Exception $e){
            return redirect()->back()->withError('Terjadi Kesalahan.'.$e);
        } catch(Exception $e){
            return redirect()->back()->withError('Terjadi Kesalahan.'.$e);
        }

        return back()->withStatus('Password berhasil di-reset.');
    }
}
