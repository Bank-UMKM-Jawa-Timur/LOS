<?php

namespace App\Http\Controllers\Dagulir\master;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonfirgurasiApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('api_configuration')->first();
        return view('dagulir.master.konfirgurasiApi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = DB::table('api_configuration')->where('id',$request->id)->first();
            if (!$data) {
                DB::table('api_configuration')->insert([
                    'hcs_host' => $request->hcs_host ? $request->hcs_host : null,
                    'dwh_host' => $request->dwh_host ? $request->dwh_host : null,
                    'dwh_store_kredit_api_url' => $request->dwh_store_kredit_api_url ? $request->dwh_store_kredit_api_url : null,
                    'dwh_token' => $request->dwh_token ? $request->dwh_token : null,
                    'sipde_host' => $request->sipde_host ? $request->sipde_host : null,
                    'sipde_username' => $request->sipde_username ? $request->sipde_username : null,
                    'sipde_password' => $request->sipde_password ? $request->sipde_password : null,
                    'url_callback' => $request->url_callback ? $request->url_callback : null,
                    'oauth_app_id' => $request->oauth_app_id ? $request->oauth_app_id : null,
                    'oauth_app_secret' => $request->oauth_app_secret ? $request->oauth_app_secret : null,
                    'oauth_authority' => $request->oauth_authority ? $request->oauth_authority : null,
                    'oauth_authorize_endpoint' => $request->oauth_authorize_endpoint ? $request->oauth_authorize_endpoint : null,
                    'oauth_token_endpoint' => $request->oauth_token_endpoint ? $request->oauth_token_endpoint : null,
                ]);
            } else {
                DB::table('api_configuration')->where('id', $request->id)->update([
                    'hcs_host' => $request->hcs_host ? $request->hcs_host : null,
                    'dwh_host' => $request->dwh_host ? $request->dwh_host : null,
                    'dwh_store_kredit_api_url' => $request->dwh_store_kredit_api_url ? $request->dwh_store_kredit_api_url : null,
                    'dwh_token' => $request->dwh_token ? $request->dwh_token : null,
                    'sipde_host' => $request->sipde_host ? $request->sipde_host : null,
                    'sipde_username' => $request->sipde_username ? $request->sipde_username : null,
                    'sipde_password' => $request->sipde_password ? $request->sipde_password : null,
                    'url_callback' => $request->url_callback ? $request->url_callback : null,
                    'oauth_app_id' => $request->oauth_app_id ? $request->oauth_app_id : null,
                    'oauth_app_secret' => $request->oauth_app_secret ? $request->oauth_app_secret : null,
                    'oauth_authority' => $request->oauth_authority ? $request->oauth_authority : null,
                    'oauth_authorize_endpoint' => $request->oauth_authorize_endpoint ? $request->oauth_authorize_endpoint : null,
                    'oauth_token_endpoint' => $request->oauth_token_endpoint ? $request->oauth_token_endpoint : null,
                ]);
            }
            alert()->success('Success', 'Berhasil menyimpan perubahan.');
            return back();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function signin() {
        // Initialize the OAuth client
        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => config('azure.appId'),
            'clientSecret'            => config('azure.appSecret'),
            'redirectUri'             => config('azure.redirectUri'),
            'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
            'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => config('azure.scopes')
        ]);

        $authUrl = $oauthClient->getAuthorizationUrl();

        // Save client state so we can validate in callback
        session(['oauthState' => $oauthClient->getState()]);

        // Redirect to AAD signin page
        return redirect()->away($authUrl);
    }
}
