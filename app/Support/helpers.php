<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('uploadPublicFiles')) {
    function uploadPublicFiles($request)
    {
        $data = null;
        if (array_key_exists('files', $request)) {
            foreach ($request['files'] as $file) {
                $data[] = uploadPublicFilesHelper($file);
            }
        } else {
            $data = uploadPublicFilesHelper($request['file']);
        }

        return $data;
    }
}

if (!function_exists('uploadPublicFilesHelper')) {
    function uploadPublicFilesHelper($file)
    {
        $path = null;
        $name = Str::random(15).md5(Carbon::now()->format('YmdHis')).$file->getClientOriginalName();
        $path = public_path().'/files';

        if (!file_exists($path.$name)) {
            $file->move($path, $name);
            $path = 'files/'.$name;
        }

        return $path;
    }
}

if (!function_exists('storePrivateFile')) {
    /**
     * Store a private file.
     */
    function storePrivateFile($directory = 'uploads', $fileObject, $filename = false, $mimeType = false)
    {
        if ($filename) {
            $file = Storage::putFileAs($directory, $fileObject, $filename, [
                'visibility' => 'private',
                'mimetype' => $mimeType ? $mimeType : $fileObject->getMimeType(),
            ]);
        } else {
            $file = Storage::putFile($directory, $fileObject, [
                'visibility' => 'private',
                'mimetype' => $mimeType ? $mimeType : $fileObject->getMimeType(),
            ]);
        }

        return response()->json(
            count($directory) >= 1 ? $directory.'/'.basename($file) : basename($file)
        );
    }
}

if (!function_exists('downloadPrivateFile')) {
    /**
     * Download private files.
     *
     * @param string $filepath
     *
     * @return mixed
     */
    function downloadPrivateFile($filepath, $isDownload = false, $urlOnly = false)
    {
        $disk = Storage::disk(env('FILESYSTEM_DRIVER', 'public'));

        if (
            env('APP_ENV') !== 'testing'
            && env('FILESYSTEM_DRIVER') === 's3'
            && $disk->exists($filepath)
        ) {
            $command = $disk->getDriver()->getAdapter()->getClient()->getCommand(
                'GetObject',
                [
                    'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
                    'Key' => $filepath,
                    'ResponseContentDisposition' => 'inline;',
                ]
            );
            $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+5 minutes');

            if ($urlOnly) {
                return $request->getUri();
            }

            return redirect((string) $request->getUri());
        } else {
            $filepath = Storage::url($filepath);
        }

        if ($urlOnly) {
            return $filepath;
        }

        return response()->download($filepath);
    }
}
