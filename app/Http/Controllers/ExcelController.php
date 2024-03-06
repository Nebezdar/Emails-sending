<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class ExcelController extends Controller
{
    public function reading(Request $request)
    {
//        $emailsArr[] = new FollowerController();
        $file = $request ->file('file');
        $reader = new Csv();
        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet -> getActiveSheet();
        $highestRow = $sheet -> getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {
            $emails[] = $sheet->getCell('A' . $row)->getValue();
        }

        foreach ($emails as $email) {
            $emailsArr[] = [
                "email" => $email,
                "source" => 75542,
                "not_doi" => 1
            ];
//            var_dump($emailsArr);
        }
//var_dump($emailsArr);
        $url = 'https://mailganer.com/api/v2/emails/';

        $headers = [
            'Content-Type: application/json',
            'Authorization:CodeRequest 4e255e71d5efaf49ccd65f8d55b709a9'
        ];

        $data_json = json_encode($emailsArr, JSON_UNESCAPED_UNICODE);
//        var_dump($data_json);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        $response = curl_exec($curl);

        var_dump($response);
    }
}
