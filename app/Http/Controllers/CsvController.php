<?php

namespace App\Http\Controllers;

use App\Models\CsvQuestion;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $objects =  explode(',', preg_replace('/[\{\}\[\]\" "]+/', '', $request->input('headers')));

        $file = $request->file('questions');
        if ($file) {
            $path = $request->file('questions')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 0, count($data));
            unset($csv_data[0]);

            $csv_data = $this->toUtf8($csv_data);
            return MenuController::build($this->toCsvQuestion($csv_data));
        }
    }

    public function toUtf8($csv_data): array
    {
        $utfEncoded = array();

        foreach ($csv_data as $data) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i] = utf8_encode($data[$i]);
                // $paper = Paper::inputPaper($base, $data, $headers, $review);
            }
            array_push($utfEncoded, $data);
        }

        return $utfEncoded;
    }
    public function toCsvQuestion($csv_data): array
    {
        $csvDescriptions = array();

        foreach ($csv_data as $data) {
            $newCsvQuestion = new CsvQuestion($data);
            array_push($csvDescriptions, $newCsvQuestion->build());
        }

        return $csvDescriptions;
    }
}
