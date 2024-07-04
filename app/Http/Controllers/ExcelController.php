<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class ExcelController extends Controller
{
    public function reading(Request $request): void
    {

        $file = $request ->file('file');
        $reader = new Csv();
        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet -> getActiveSheet();
        $highestRow = $sheet -> getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {
            $emails[] = $sheet->getCell('A' . $row)->getValue();
        }

        $emailsArr = [];
        foreach ($emails as $emailString) {
            $emailList = preg_split('/\s+/', trim($emailString));
            foreach ($emailList as $email) {
                if (!empty($email)) {
                    $emailsArr[] = [
                        "email" => $email,
                        "source" => 75542,
                        "not_doi" => 1
                    ];
                }
            }
        }

        $url = 'https://mailganer.com/api/v2/emails/';

        $headers = [
            'Content-Type: application/json',
            'Authorization: CodeRequest 4e255e71d5efaf49ccd65f8d55b709a9'
        ];

        $data_json = json_encode($emailsArr, JSON_UNESCAPED_UNICODE);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        $response = curl_exec($curl);



        curl_close($curl);


    }
}
