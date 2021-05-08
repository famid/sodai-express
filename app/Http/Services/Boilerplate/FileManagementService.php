<?php


namespace App\Http\Services\Boilerplate;


use Illuminate\Support\Facades\Storage;
use Exception;

class FileManagementService extends BaseService
{
    /**
     * @param $file
     * @param $destinationPath
     * @param null $oldFile
     * @return array
     */
    public function uploadFile ($file, $destinationPath, $oldFile = null): array {
        if ($oldFile != null) {
            $this->deleteFile($destinationPath, $oldFile);
        }
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $uploaded = Storage::put('public/'.$destinationPath . $fileName, file_get_contents($file->getRealPath()));
        $fileName = env('SERVER_URL').'storage/'.$destinationPath.$fileName;

        return !$uploaded ?
            $this->response()->error():
            $this->response($fileName)->success();
    }

    /**
     * @param $destinationPath
     * @param $file
     * @return bool
     */
    public function deleteFile($destinationPath, $file): bool {
        if ($file != null) {
            try {
                $exists = Storage::exists($destinationPath.'/'.$file);

                if (!$exists) {
                    return false;
                }
                Storage::delete($destinationPath . $file);

                return true;
            } catch (Exception $e) {

                return false;
            }
        }
    }

    /**
     * @return string
     */
    public function productImagePath () : string {
        return 'upload/product/attachment/';
    }
}
