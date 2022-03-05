<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz\Answer;
use App\Models\Quiz\Question;
use Illuminate\Http\Request;

class ImportController extends Controller{
    public function import (){
        $inputFileName = public_path('import/questions.xlsx');

        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        /**  Convert Spreadsheet Object to an Array for ease of use  **/
        $data = $spreadsheet->getActiveSheet()->toArray();

        dump($data[0]);
        for($i=1; $i<count($data); $i++){
            try{
                $question = Question::create([
                    'set_id' => $data[$i][2],
                    'question' => $data[$i][0],
                    'category' => $data[$i][1]
                ]);

                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $data[$i][5],
                    'correct' => (int)($data[$i][6])
                ]);
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $data[$i][7],
                    'correct' => (int)($data[$i][8])
                ]);
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $data[$i][9],
                    'correct' => (int)($data[$i][10])
                ]);
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $data[$i][11],
                    'correct' => (int)($data[$i][12])
                ]);
            }catch (\Exception $e){
                dump($e);
            }
        }

        dd("Finished mate !");
        dd($data);
    }
}
