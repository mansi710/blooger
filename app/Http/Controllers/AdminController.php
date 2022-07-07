<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Blog;
use DB;
use DataTables;

class AdminController extends Controller
{
    //


    public function welcomeAdmin()
    {
        return view('admin.welcomeAdmin');
    }

    //select csv file
    public function selectFile()
    {
        return view('admin.blogCsvFile');
    }

    //upload csv file and add data in database
    public function storeCsvFile(Request $request,Blog $blogs)
    {
        $file = $request->file('csv');
        // dd($file);
        if ($file) 
        {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            
            $fileSize = $file->getSize();
            $location = 'csv_files'; //Created an "uploads" folder for that // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database 
            $filepath = public_path($location . "/" . $filename);
            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) 
            {    
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0)
                {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) 
                {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after readin
            $j = 0;
            foreach ($importData_arr as $importData) 
            {
                $title = $importData[1]; //Get user names
                $description = $importData[2]; //Get the user emails
                $status = $importData[3]; //Get the user emails
                $tag = $importData[4]; //Get the user emails
                $j++;
                    try 
                    {
                        // DB::beginTransaction();
                        Blog::create([
                        'title' => $importData[1],
                        'description' => $importData[2],
                        'status' => $importData[3],
                        'tag' => $importData[4]
                        ]);    
                            // DB::commit();
                     }  
                    catch (\Exception $e) 
                    {
                            //throw $th;
                            // DB::rollBack();
                    }
            }
                
            return response()->json(
                ['message' => "$j records successfully uploaded"]);
        } 
        else
        { //no file was uploaded
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

  
}



