<?php

namespace App\Auth;

class TokenCache {
    public function storeTokens($accessToken) {
        $filePath = storage_path('app/token.json');
        $json = json_decode(file_get_contents($filePath), true);

        // Memperbarui data dengan token yang baru
        $json['accessToken'] = $accessToken->getToken();
        $json['refreshToken'] = $accessToken->getRefreshToken();
        $json['tokenExpires'] = $accessToken->getExpires();

        // Menulis kembali data ke dalam file JSON
        file_put_contents($filePath, json_encode($json));

        // Opsional: Simpan token dalam sesi
        session([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires(),
        ]);

    }

    public function clearTokens() {
      session()->forget('accessToken');
      session()->forget('refreshToken');
      session()->forget('tokenExpires');
    }

    // <GetAccessTokenSnippet>
    public function getAccessToken() {
        // Check if tokens exist
        $filePath = storage_path('app/token.json');
        $json = json_decode(file_get_contents($filePath), true);
        // if (empty(session('accessToken')) ||
        //     empty(session('refreshToken')) ||
        //     empty(session('tokenExpires'))) {
        //     return '';
        // }
        if (empty($json['accessToken']) || empty($json['refreshToken'] || empty($json['tokenExpires']))) {
            return '';
        }
        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now = time() + 300;
        if ($json['tokenExpires'] <= $now) {
            // Token is expired (or very close to it)
            // so let's refresh

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

            try {
            $newToken = $oauthClient->getAccessToken('refresh_token', [
                'refresh_token' => $json['refreshToken']
            ]);

            // Store the new values
            $this->updateTokens($newToken);

            return $newToken->getToken();
            }
            catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            return '';
            }
        }

        // Token is still valid, just return it
        return $json['accessToken'];
    }
    // </GetAccessTokenSnippet>

    // <UpdateTokensSnippet>
    public function updateTokens($accessToken) {
        $filePath = storage_path('app/token.json');
        $json = json_decode(file_get_contents($filePath), true);

        // Memperbarui data dengan token yang baru
        $json['accessToken'] = $accessToken->getToken();
        $json['refreshToken'] = $accessToken->getRefreshToken();
        $json['tokenExpires'] = $accessToken->getExpires();

        // Menulis kembali data ke dalam file JSON
        file_put_contents($filePath, json_encode($json));

        session([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires()
        ]);
    }
    // </UpdateTokensSnippet>
}
