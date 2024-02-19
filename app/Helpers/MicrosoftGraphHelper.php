<?php

namespace App\Helpers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use League\OAuth2\Client\Provider\GenericProvider;
use stdClass;

class MicrosoftGraphHelper
{
    public function upload($request, $filePath, $fileName) {
        $fileName = urlencode($fileName);
        try {
            // Configure your OAuth settings
            $client_id = config('microsoft-graph.microsoft_graph_client_id');
            $client_secret = config('microsoft-graph.microsoft_graph_client_secret');
            $tenant_id = config('microsoft-graph.microsoft_graph_tenant_id');
            $url_authorization = config('microsoft-graph.microsoft_graph_url_authorization');
            $url_access_token = "https://login.microsoftonline.com/consumers/oauth2/v2.0/token";
            $scopes = 'https://graph.microsoft.com/.default';

            $body = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'scope' => $scopes,
                'grant_type' => 'client_credentials'
            ];
            $accessToken = "eyJ0eXAiOiJKV1QiLCJub25jZSI6Imk1VUluUFJuRGdMYkxTRlRGQnlVT2FtNXBfY2dOTjJEbmNIaUhWbXVJbFUiLCJhbGciOiJSUzI1NiIsIng1dCI6ImtXYmthYTZxczh3c1RuQndpaU5ZT2hIYm5BdyIsImtpZCI6ImtXYmthYTZxczh3c1RuQndpaU5ZT2hIYm5BdyJ9.eyJhdWQiOiJodHRwczovL2dyYXBoLm1pY3Jvc29mdC5jb20iLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC85MTg4MDQwZC02YzY3LTRjNWItYjExMi0zNmEzMDRiNjZkYWQvIiwiaWF0IjoxNzA2OTUxOTI4LCJuYmYiOjE3MDY5NTE5MjgsImV4cCI6MTcwNjk1NTgyOCwiYWlvIjoiRTJWZ1lGajE0RTNCdnZUay9oY3VQTmVYUGplU0JBQT0iLCJhcHBfZGlzcGxheW5hbWUiOiJsYXJhdmVsLWJhY2t1cCIsImFwcGlkIjoiMTIzMzFlZTItOTNmYy00OWFhLTk5MTQtY2IwN2FjYzM2NjNiIiwiYXBwaWRhY3IiOiIxIiwiaWRwIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvOTE4ODA0MGQtNmM2Ny00YzViLWIxMTItMzZhMzA0YjY2ZGFkLyIsImlkdHlwIjoiYXBwIiwib2lkIjoiMDAwMDAwMDAtMDAwMC0wMDAwLTAwMDAtMDAwMDQ1MzI2Y2E3IiwicmgiOiIwLkFTY0NEUVNJa1dkc1cweXhFamFqQkxadHJRTUFBQUFBQUFBQXdBQUFBQUFBQUFBekFBQS4iLCJzdWIiOiIwMDAwMDAwMC0wMDAwLTAwMDAtMDAwMC0wMDAwNDUzMjZjYTciLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiU0EiLCJ0aWQiOiI5MTg4MDQwZC02YzY3LTRjNWItYjExMi0zNmEzMDRiNjZkYWQiLCJ1dGkiOiJZcHJDYVBpX09VcXhvQS16TkhPLUFBIiwidmVyIjoiMS4wIiwid2lkcyI6WyIwOTk3YTFkMC0wZDFkLTRhY2ItYjQwOC1kNWNhNzMxMjFlOTAiXSwieG1zX3RjZHQiOjE0MzE2NDE0OTh9.dJqKLEsN08xsJD-uNPZjb3ymNs_CTAC5r4vaOuy93yjPhfMHCseiPgSGwWyMUi3vTuT3zIgaJhYGPbaw0BTQVj1YdWOdsOzRGlU3fvTvfTNKZFYDKvgyyiofnSAoKRIieTRP4YbxZJLWShGQKX2kkElVJl26GaIZx9NsJN_em3nKhraUEtrayT_gfRiTLQY4M6fRPnFpAfOFB4Dfpjw0ahV2CSQAOaBoX4sCQc5p4cSOoSnq7cBaQchENzZMpUPwY4mnvZST1Fk8h_9pzFCJqvbSRibMwYiLbUUL0RJk8ROHPho3O3yePOVEds0N2hXNp6TGJsjh7SQzXGPBLBKvxA";

            // Prepare the file for upload
            $fileContent = file_get_contents($filePath);
            $accessTokenFile = 'EwCIA8l6BAAUs5+HQn0N+h2FxWzLS31ZgQVuHsYAAURNPuB5rQHTmoGsy3c9fsgJxwlaS76X36M3gwSDJOqOFY8bFK0OrQi5ynNvacpjLZ1m1JlY49ecVXHrKvqaNgKZOPS3tP3zMgDHqgnLvy98ejfwDoc2pLLsY0hadTxAzt1Tgu7R/iMOSAcCmS1U2C1rpv4hg2u1odg/3lNZaGciVGgIdvRA5nZfC7UIWaSaPg5YccSpklvoiaUxAJwJfxkXWyqBHF3LLIe7ltL/tSZg6qedl0uhgQWxpyZwvsiA4vALWkEjsDbbhC8K9Y5wu9QY9+RpO0SDoPirVM/t0H0e8G5F8VDTcrzzZE+EUg661yF3yUOdHhiuVSZvnUkC3ckDZgAACIlqyDaP3kkWWALLCc96EXAlLjRMHHkSKLyxv6zBsDIFzl5N3/sgC3xeLHBgKepNbOQom1EYxM78rk+7CPZsa8Pk3nwVQCaqyF8F+kWwNzUCvmMD4vEZAtDs1EPpkqyXxQJZPGWuO56B3KkTTrgSHrjQMKqb6yRp12H8mbjJftE+swmmAgORUpc/lN9SvpcJyx+IlWTF62Joi3pY0VSulCCB/PaE4tGJaoOyDak8nZ8pw9Kck/mpW+xEu/0njflVbndRVnT1LeYpuD8bjATiJtSriierGEy3Fy+D1yiBOrzP+jIFLM48cpcrmVHqY4Fh6kyC6Ii/HmB7zv9j0DmwKOCHECE6qs8HkVklnOghJKYjQrc8u4iFG0bpxeNxko+0JgEDv2fKm35SA693h16Q4xu9FRnqpy/7J5qLjwrmnYsjL1hfJnQwVblrdPuHGwMgQk0gyg8dC0awd1Ec32S08MkfapNZMrJgB1++SCtGBgSho8Kb6VRRSCD68uM60z8ElgWpUTpkBbxllx5HaT2HJK8M5Zieg6LEeuXTXjvsbcS7i3Vg6Ib16luAmDvXI4SqVPK0hFMstqLUHEksx5uyMBX9ZndYKl6hDCLQGieTqYHeexRLI33tEKAdLa2+46G5ITxuaZM6V46+Y8uMeLONKs6PhEXhRSeB118S0PUIKKrQmT6a1WY3bqi7UIdzK/PDILE+ZZ1/rJLDL8mhs7Bpj5YgF0q4nj9rW8bmRoA93+Mii4ztZmAlEtBER9Mx5h6DVol6ABwhWdKmjOLIdFSTYZh0M/dT7pJp7DAFaWtiAxuycsCbAg==';

            // Set up the API request
            $client = new Client();
            // $upload_url = "https://graph.microsoft.com/v1.0/me/drive/root:/{$fileName}:/content";
            $upload_session_token = 'EwCIA8l6BAAUs5+HQn0N+h2FxWzLS31ZgQVuHsYAAURNPuB5rQHTmoGsy3c9fsgJxwlaS76X36M3gwSDJOqOFY8bFK0OrQi5ynNvacpjLZ1m1JlY49ecVXHrKvqaNgKZOPS3tP3zMgDHqgnLvy98ejfwDoc2pLLsY0hadTxAzt1Tgu7R/iMOSAcCmS1U2C1rpv4hg2u1odg/3lNZaGciVGgIdvRA5nZfC7UIWaSaPg5YccSpklvoiaUxAJwJfxkXWyqBHF3LLIe7ltL/tSZg6qedl0uhgQWxpyZwvsiA4vALWkEjsDbbhC8K9Y5wu9QY9+RpO0SDoPirVM/t0H0e8G5F8VDTcrzzZE+EUg661yF3yUOdHhiuVSZvnUkC3ckDZgAACIlqyDaP3kkWWALLCc96EXAlLjRMHHkSKLyxv6zBsDIFzl5N3/sgC3xeLHBgKepNbOQom1EYxM78rk+7CPZsa8Pk3nwVQCaqyF8F+kWwNzUCvmMD4vEZAtDs1EPpkqyXxQJZPGWuO56B3KkTTrgSHrjQMKqb6yRp12H8mbjJftE+swmmAgORUpc/lN9SvpcJyx+IlWTF62Joi3pY0VSulCCB/PaE4tGJaoOyDak8nZ8pw9Kck/mpW+xEu/0njflVbndRVnT1LeYpuD8bjATiJtSriierGEy3Fy+D1yiBOrzP+jIFLM48cpcrmVHqY4Fh6kyC6Ii/HmB7zv9j0DmwKOCHECE6qs8HkVklnOghJKYjQrc8u4iFG0bpxeNxko+0JgEDv2fKm35SA693h16Q4xu9FRnqpy/7J5qLjwrmnYsjL1hfJnQwVblrdPuHGwMgQk0gyg8dC0awd1Ec32S08MkfapNZMrJgB1++SCtGBgSho8Kb6VRRSCD68uM60z8ElgWpUTpkBbxllx5HaT2HJK8M5Zieg6LEeuXTXjvsbcS7i3Vg6Ib16luAmDvXI4SqVPK0hFMstqLUHEksx5uyMBX9ZndYKl6hDCLQGieTqYHeexRLI33tEKAdLa2+46G5ITxuaZM6V46+Y8uMeLONKs6PhEXhRSeB118S0PUIKKrQmT6a1WY3bqi7UIdzK/PDILE+ZZ1/rJLDL8mhs7Bpj5YgF0q4nj9rW8bmRoA93+Mii4ztZmAlEtBER9Mx5h6DVol6ABwhWdKmjOLIdFSTYZh0M/dT7pJp7DAFaWtiAxuycsCbAg==';
            $upload_url_session = "https://graph.microsoft.com/v1.0/me/drive/root:/{$fileName}:/createUploadSession";
            $headers = [
                'Authorization' => "Bearer $upload_session_token",
                'Content-Type' => 'application/json'
            ];
            $response = Http::withHeaders($headers)
                            ->post($upload_url_session);
            $responseBody = null;
            if ($response->getStatusCode() == 200) {
                $responseBody = json_decode($response->getBody(), true);
            }
            $upload_file_url = null;

            if ($responseBody) {
                $upload_file_url = $responseBody['uploadUrl'];
            }

            if ($upload_file_url) {
                $headers2 = [
                    'Authorization' => 'Bearer ' . $accessTokenFile,
                    'Content-Type'  => 'text/plain',
                    'Content-Length' => '26',
                    'Content-Range' => 'bytes 0-25/128',
                ];
                $response = Http::withHeaders($headers2)
                                ->put($upload_file_url);
                $responseBody = null;
                dd($response, $upload_file_url);
                return $response->getStatusCode();
            }
            // $upload_url = "https://graph.microsoft.com/v1.0/me/drive/root:/doraemon.jpg:/createUploadSession";

            // $response = $client->request('PUT', $upload_url, [
            //     'headers' => [
            //         'Authorization' => 'Bearer ' . $accessTokenFile,
            //         'Content-Type'  => 'text/plain',
            //     ],
            //     'body' => $fileContent,
            // ]);

            // Check if the upload was successful
            if ($response->getStatusCode() == 200) {
                return "File uploaded successfully!";
            } else {
                return "Error uploading file.";
            }
        }
        catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Handle authorization errors
            return 'Authorization failed: ' . $e->getMessage();
        }
        catch (Exception $e) {
            return 'error : '.$e->getMessage();
        }
    }
}