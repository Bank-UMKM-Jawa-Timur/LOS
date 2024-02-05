<?php

namespace App\Http\Controllers;

use App\Helpers\MicrosoftGraphHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use File;

class UploadOnedriveController extends Controller
{
    public function index() {
        return $this->fileUploadWithChunk();
        $latestBackup = BackupDestination::create('local', 'Laravel')
            ->newestBackup();

        $filepath = storage_path('app/'.$latestBackup->path());
        $filename = explode('/',$latestBackup->path())[1];

        $accessTokenFile = 'EwCAA8l6BAAUs5+HQn0N+h2FxWzLS31ZgQVuHsYAAdGgbIVgIdbp4yNo+ba8KeEmBWZXij3seGwSsgCC0tHPCcgVwxiq5dLbFgHLwcW3Lv0Z/l3WT0OIlPTJ7Xr92R1JMisQLA/LUThvQ8EVKn7TzY/m7NFmuEntvUvyw9OrHlvqK21S6BZZnp0ihhl4iE2hIEEU6t5ldgDKmtHqh2C4pPvu/rRIUPSpZAnEiyda6gYMvAz1uuljTLM73GmHcUTrNM9m5xbfKT9Lo4j2R8VGz9Wbf0wVjkrms4esA1wBBjHoHdMKyvPGVKFtHvuoepkV/4+uIrlr66ySlL/UBu/Oya0SjSKe0RbrhlQyFAsjgLnuviBPCTtLMSh0bE+CpSIDZgAACFNJJ7QOh+bCUAILjA+bI9cEJ7a6sguvV+4qdwcVgNaitjfj9Ih3wajs7uut1E9Av+mnbxicLz1TQX48aO1MBFYXSNLrkNyvKWWPSLcRm21bSZYCuvq6bwW4Gq45aSmyLZg6EaeW08sUxN5Rid2GsgK+suwZDD3aRQXelRbAIzpWYuShaay64WZm7mTBr2UtMb4WRb7yidg0LutDyeIfjXK5X95485M43mKNMfNLnEbSVVPL03MiSdZTTt6qVIeWBk+Q/y3zC8E1Nct8yh3bWdR17ngJKqxOwKFp2Um3Pwi8kiUFc0D23hnejxLYZPb4b/vUN8Ktz/RbnIvURdDKT9fGSSC7p+VuIcJ6qYfTS2+Ef+8JCcHFHVMAwSq2LVryLa6QMNO+vV5VfXFDSGSKTc+Or24fERbVNCjLdJXusEHttL3lx39x/rJ6B3qgUAnfZ7olCljlOKNZLccoI9tzA79IAM7v9vbzJ5wJ593hUKhWwbDpqUYi0ryum7LM8G18hIHC76S2LBskuCcqsoey0cLnoYWNPz7pS7bGe7APZnLn29ZFjeu4yDKR+H8yvgITtdq2aPU79hvi+Wi0Fn1XRqOl8aSDkIu1Kaajd/vIrpDrhVcg3KjvJItJnJ1JWehaW0t6BXS31yN+TgqTBgGjfGzxxH8xEvrxyUdZUMHN7++IzHSHuEPOqrNfKnDIN/xFcBsyKH/5viWplc9Xkf5rJlHKVeMjc9Q/4usGAsjQqujn4obKc461vdoHK2Xhos+LCChjlDeBmYzHs31+4gmR9zRfi7CKdKS0iCH6jwI=';

        $url = "https://graph.microsoft.com/v1.0/me/drive/root:/backup/$filename:/createUploadSession";

        $data = [
            "item" => [
                "@microsoft.graph.conflictBehavior" => "rename",
                "description" => "description",
                "fileSystemInfo" => ["@odata.type" => "microsoft.graph.fileSystemInfo"],
                "name" => $filename
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessTokenFile",
        ];

        $response = Http::withHeaders($headers)->post($url, $data);

        $result = $response->json();
        $graphUrl = $result['uploadUrl'];

        $fragSize = 320 * 1024;
        $file = file_get_contents($filepath);
        $fileSize = strlen($file);
        $numFragments = ceil($fileSize / $fragSize);
        $bytesRemaining = $fileSize;
        $i = 0;

        while ($i < $numFragments) {
            $chunkSize = $numBytes = $fragSize;
            $start = $i * $fragSize;
            $end = $i * $fragSize + $chunkSize - 1;
            $offset = $i * $fragSize;

            if ($bytesRemaining < $chunkSize) {
                $chunkSize = $numBytes = $bytesRemaining;
                $end = $fileSize - 1;
            }

            $dataChunk = substr($file, $offset, $chunkSize);

            $contentRange = "bytes $start-$end/$fileSize";
            $headersChunk = [
                "Content-Length" => $numBytes,
                "Content-Range" => $contentRange
            ];

            $responseChunk = Http::withHeaders($headersChunk)
                ->withBody($dataChunk, 'application/octet-stream')
                ->put($graphUrl);

            $info = $responseChunk->json(); // Adjust this part based on your needs

            $bytesRemaining = $bytesRemaining - $chunkSize;
            $i++;
        }
        dd($info);
        // File upload completed successfully
        dd('File uploaded successfully!');

        return view('upload-onedrive.index');
    }

    function fileUploadWithChunk() {
        // Mendapatkan informasi backup terbaru
        $oldestBackup = BackupDestination::create('local', 'Laravel')->oldestBackup();
        $latestBackup = BackupDestination::create('local', 'Laravel')
            ->newestBackup();
        // mendapatkan filepath dan filename
        $filepath = storage_path('app/'.$latestBackup->path());
        $filename = explode('/',$latestBackup->path())[1];

        $filepathOldest = storage_path('app/'.$oldestBackup->path());
        $filenameOldest = explode('/',$oldestBackup->path())[1];

        // Token akses
        $accessTokenFile = 'EwCAA8l6BAAUs5+HQn0N+h2FxWzLS31ZgQVuHsYAAdGgbIVgIdbp4yNo+ba8KeEmBWZXij3seGwSsgCC0tHPCcgVwxiq5dLbFgHLwcW3Lv0Z/l3WT0OIlPTJ7Xr92R1JMisQLA/LUThvQ8EVKn7TzY/m7NFmuEntvUvyw9OrHlvqK21S6BZZnp0ihhl4iE2hIEEU6t5ldgDKmtHqh2C4pPvu/rRIUPSpZAnEiyda6gYMvAz1uuljTLM73GmHcUTrNM9m5xbfKT9Lo4j2R8VGz9Wbf0wVjkrms4esA1wBBjHoHdMKyvPGVKFtHvuoepkV/4+uIrlr66ySlL/UBu/Oya0SjSKe0RbrhlQyFAsjgLnuviBPCTtLMSh0bE+CpSIDZgAACFNJJ7QOh+bCUAILjA+bI9cEJ7a6sguvV+4qdwcVgNaitjfj9Ih3wajs7uut1E9Av+mnbxicLz1TQX48aO1MBFYXSNLrkNyvKWWPSLcRm21bSZYCuvq6bwW4Gq45aSmyLZg6EaeW08sUxN5Rid2GsgK+suwZDD3aRQXelRbAIzpWYuShaay64WZm7mTBr2UtMb4WRb7yidg0LutDyeIfjXK5X95485M43mKNMfNLnEbSVVPL03MiSdZTTt6qVIeWBk+Q/y3zC8E1Nct8yh3bWdR17ngJKqxOwKFp2Um3Pwi8kiUFc0D23hnejxLYZPb4b/vUN8Ktz/RbnIvURdDKT9fGSSC7p+VuIcJ6qYfTS2+Ef+8JCcHFHVMAwSq2LVryLa6QMNO+vV5VfXFDSGSKTc+Or24fERbVNCjLdJXusEHttL3lx39x/rJ6B3qgUAnfZ7olCljlOKNZLccoI9tzA79IAM7v9vbzJ5wJ593hUKhWwbDpqUYi0ryum7LM8G18hIHC76S2LBskuCcqsoey0cLnoYWNPz7pS7bGe7APZnLn29ZFjeu4yDKR+H8yvgITtdq2aPU79hvi+Wi0Fn1XRqOl8aSDkIu1Kaajd/vIrpDrhVcg3KjvJItJnJ1JWehaW0t6BXS31yN+TgqTBgGjfGzxxH8xEvrxyUdZUMHN7++IzHSHuEPOqrNfKnDIN/xFcBsyKH/5viWplc9Xkf5rJlHKVeMjc9Q/4usGAsjQqujn4obKc461vdoHK2Xhos+LCChjlDeBmYzHs31+4gmR9zRfi7CKdKS0iCH6jwI=';

        // URL untuk membuat upload session di OneDrive
        $url = "https://graph.microsoft.com/v1.0/me/drive/root:/backup/$filename:/createUploadSession";

        // set data if used createUploadsession used rename
        //  "@microsoft.graph.conflictBehavior": "rename",
        $data = [
            "item" => [
                "@microsoft.graph.conflictBehavior" => "rename",
                "description" => "description",
                "fileSystemInfo" => ["@odata.type" => "microsoft.graph.fileSystemInfo"],
                "name" => $filename
            ]
        ];
        // Header untuk request
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessTokenFile",
        ];

        // url create session
        // Membuat upload session di OneDrive
        $response = Http::withHeaders($headers)->post($url, $data);
        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 200) {
            return "File uploaded successfully! ";
        } else {
            return "Error uploading file.".$response->json()['error']['message'];
        }
        $result = $response->json();
        $graphUrl = $result['uploadUrl'];

        // Ukuran fragment
        $fragSize = 320 * 1024;
        $file = file_get_contents($filepath);
        $fileSize = strlen($file);
        $numFragments = ceil($fileSize / $fragSize);
        $bytesRemaining = $fileSize;
        $i = 0;

        while ($i < $numFragments) {
            $chunkSize = $numBytes = $fragSize;
            $start = $i * $fragSize;
            $end = $i * $fragSize + $chunkSize - 1;
            $offset = $i * $fragSize;

            if ($bytesRemaining < $chunkSize) {
                $chunkSize = $numBytes = $bytesRemaining;
                $end = $fileSize - 1;
            }

            $dataChunk = substr($file, $offset, $chunkSize);

            $contentRange = "bytes $start-$end/$fileSize";
            $headersChunk = [
                "Content-Length" => $numBytes,
                "Content-Range" => $contentRange
            ];

            // Mengirim chunk data ke OneDrive
            $responseChunk = Http::withHeaders($headersChunk)
                ->withBody($dataChunk, 'application/octet-stream')
                ->put($graphUrl);

            $info = $responseChunk->json(); // Adjust this part based on your needs

            $bytesRemaining = $bytesRemaining - $chunkSize;
            $i++;
            if (!$responseChunk->successful()) {
                // Handle upload failure
                return  'Upload failed:'.$responseChunk->status().''.$responseChunk->body().'.';
            }
        }
        // Hapus file sebelumnya di OneDrive
        $previousFileName = $filenameOldest;
        $previousFileUrl = "https://graph.microsoft.com/v1.0/me/drive/root:/backup/$previousFileName";
        Http::withHeaders($headers)->delete($previousFileUrl);

        // Hapus file lokal setelah berhasil diupload
        File::delete($filepathOldest);

        return 'File uploaded successfully!';
    }

    function fileUploadContent() {
        $latestBackup = BackupDestination::create('local', 'Laravel')
        ->newestBackup();

        $filepath = storage_path('app/'.$latestBackup->path());
        $filename = explode('/',$latestBackup->path())[1];

        $accessTokenFile = 'EwCAA8l6BAAUs5+HQn0N+h2FxWzLS31ZgQVuHsYAAaanm+x+zOfTxuPH5aCVAO9KjD7NXiMlst0VWCWa1Y1Hi0gKAUXTASma91X0y2kX0j1DJzCljvfPIwTOBdI/7lEaE9p9fn0+X2ds3lCRqwylZNWumBgq6oyVUAn0glFGGZyqdYAz5PXNZ769DiRWvwyMEMJrASGg1D2AjcR5vYMfKKFCI/OD6PAFwCttMKZMHqySK+nvBKFcaNrfVPsQ5v/T3KgCBjAxq6bOqg64RbAP9TrIRR3LOr9+pVqJXeGI9S3zzlVH67p188mp5jaAIfA3nJrC3dhEcuPxYwNMWuwc6QxTRB7KAwrH9wAVVL8BmLtQtcWEvaYEvRsjRilqHpsDZgAACH8pDfEueN+MUAIp6daSV40T91pJTxFq6SVUa0MHz/yAFW5f4umlyisHb1gJQA4OONDBlilLfuQs+bDFJX8/2IBL2q+mJCwO3RMjrtOs9/5qBS13F9YMxQ2b81BqYe3zotm0JfYmME53fyzjwwf2BpDBcZH/ss3XJ6OXbdkgWUJS4OSLPAWyo/07iJjm14wAYaJdC3hKquaDL5LIexyyG8ydKP8uqsoUkXCh+iefRZU3pEvRoqsjqkdMfnXVefZ7jDhqlFdfddzZUqTa7ZKJe2dUGuMe4V/ghQ1hSLcMARCQjJh2dlZYR4QLVO6cQ/vMWR3AXZYVlOWfWCsUVgG1+pvr1ZnmbsVfvkkdODnDPVpb1s1mWlNShQyGm+S7IeY3LKyZjQ2UfHYNXZa/mh5DF0PosDmDLovSxsuHSxCr9G1cw1bu9q/vc+QVz3bhZw2u+Q7tAsqCuEVJiCLD3q6VBXvLwK4ceqv9Jw55xlZDHYJUVVuR+4k1XmcHFSdWPIsDlZmkKGYlwNj69jRZTIJZTnswb+3nccoQGsn0OnkXlsZke+WGYCnyAj+u+4egPGk9Asl+ODoofbGNg0UwQFRYYRuuxC2RN3CDM6tQSELgPseyYeGIzuHjfKSU76pJFJgH5mHDEuAwxWHjzh9eG5cR8AMnE+YwxGIeSDEMt0JSzKkl8fQgdlvdoy+Bsi9P87xcy/LoII7vxanX8ELKX7H5yuEtQSpwujv052Xz43pqF8Y2RSoeo1vD0+RYwRHkG8ii/o/GT1q0vNioF7PeCq072j6iqp2gPwmdldfDjwI=';

        $client = new Client();
        $response = $client->request('PUT', "https://graph.microsoft.com/v1.0/me/drive/root:/Backups/{$filename}:/content", [
            'headers' => [
                'Authorization' => 'Bearer '.$accessTokenFile,
                'Content-Type'  => 'text/plain',
            ],
            'body' => file_get_contents($filepath),
        ]);
        // Check if the upload was successful
        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 200) {
            echo "File uploaded successfully!";
        } else {
            echo "Error uploading file.";
        }
    }

    public function store(Request $request) {
        $helper = new MicrosoftGraphHelper;
        $file = $request->file('file');
        // dd($file);
        $filename = $file->getClientOriginalName();
        $filepath = $file->path();
        // return file_get_contents($filepath);
        return $helper->upload($request, $filepath, $filename);
    }

    function monitorLog()  {
        $filepath = storage_path('logs/laravel.log');
        $fileContent = File::get($filepath); // Use File facade for simplicity
        $logLines = explode(PHP_EOL, $fileContent);

        return view('logs.index',compact('logLines'));
    }
}
