<?php
namespace App\Library\Suppliers;

use App\Supplier;
use App\fileHeader;
use App\fileBody;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ImportTasa
{


    public function import(Supplier $supplier, fileHeader $file)
    {
        $stream = Storage::disk('source')->readStream(strtolower($supplier->directory) . '/' . $file->fileName);
        $top = 0;
        while (!feof($stream) && $top < 500) {
            $data = fgetcsv($stream, null, ';');
            echo '<pre>';
            print_r($data);
            echo '</pre><br><br>';
            $top++;
        }

        fclose($stream);
        //$file->update(['status' => 'Imported']);
    }
}
