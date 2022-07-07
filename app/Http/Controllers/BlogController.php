<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
  // list records of csv file
  public function lisDataOfCsvFile(Request $request)
  {
    $blogs = Blog::orderBy('order', 'ASC')->get();

    return view('admin.listOfData', compact('blogs'));
  }


  //load this method when datatable load
  public function getData(Request $request)
  {
    $columns = array(
      0 => 'id',
      1 => 'title',
      2 => 'description',
      3 => 'status',
      4 => 'tag',
      5 => 'created_at',
    );

    $totalData = Blog::count();

    //   $totalFiltered = $totalData; 
    $draw = $request->get('draw');
    $start = $request->get('start');
    $limit = $request->get('length');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->input('columns');
    $columnIndex = $order_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc

    $blogs = Blog::orderBy($columnName, $columnSortOrder)
      ->skip($start)
      ->take($limit)
      ->get();

    //   foreach ($blogs as $blog) {
    //       $blog->actions = ['id' => $blog->id];
    //   }

    $dataArr = [
      'aaData' => $blogs,
      "draw" => intval($draw),
      "iTotalRecords" => $totalData,
      "iTotalDisplayRecords" => $totalData,
    ];
    return response()->json($dataArr);
  }

  //For Delete Record
  public function deleteData($id)
  {

    $blogs = Blog::where('id', $id)->delete();
    return redirect()->route('lisDataOfCsvFile')->with('message-deleted', 'data deleted successfully.');
  }


  // For Edit Record
  public function editData($id)
  {
    $blogs = Blog::find($id);
    return view('admin.editData', compact('blogs'));
  }

  //Update Record
  public function updateData(Request $request, $id)
  {

    $request->validate([
      'title' => 'required',
      'description' => 'required|string|max:50',
      'status' => 'required|string|max:20',
      'tag' => 'required|string|max:10'
    ]);

    $blogs = Blog::find($id);
    $blogs->title = $request->title;
    $blogs->description = $request->description;
    $blogs->status = $request->status;
    $blogs->tag = $request->tag;
    $blogs->save();

    return redirect()->route('lisDataOfCsvFile')->with('success', 'data updated succefully');
  }


  //create a new Data
  public function create()
  {
    return view('admin.createData');
  }


  public function storeData(Request $request, Blog $blogs)
  {

    $request->validate([
      'title' => 'required',
      'description' => 'required|string|max:50',
      'status' => 'required|string|max:20',
      'tag' => 'required|string|max:10'
    ]);


    $Blogs = Blog::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'status' => $request->input('status'),
      'tag' => $request->input('tag')
    ]);


    return redirect()->route('lisDataOfCsvFile')->with('success', 'category added succefully');
  }


  public function sortableDataUpdate(Request $request, Blog $blogs)
  {
    $blogs = Blog::all();
    foreach ($blogs as $blog) {
      $blog->timestamps = false; // To disable update_at field updation
      $id = $blog->id;
      foreach ($request->order as $order) {
        if ($order['id'] == $blog->id) {
          $blog->update(['order' => $order['position']]);
          $blog->save();
        }
      }
    }
  }

  //  return response()->json($blog);

  // $order = $request->order;

  // $records = Blog::all();

  // foreach($records as $row) {
  //     $row->order = $order;
  //     $row->update();
  //     $order++;
  // }

  // $blog = Blog::all(); 
  // foreach($blog as $blogs)
  // {

  //     foreach($request->order as $order)
  //     {

  //         // $currentitem =$blogs->find($blogs['id']);


  //         dump($currentitem->order = $order['position']);

  //         $currentitem->save();
  //     }
  // }



  // $order = $request->order;

  // $records = Blog::all();

  // foreach($records as $row) {
  //     $row->order = $order;

  //     $row->update();

  //     $order++;
  // }





  public function archiveBlog(Request $request)
  {
    //   dd($request);
    $blog = Blog::where('id', $request->id)->get()->first();

    $blog->status = "archive";


    $blog->save();

    // return response()->json($blog);

    //  return response($blog);

    // // dd($blog);
    // return response()->json($blog);

    // // return redirect()->back();
    return redirect()->route('lisDataOfCsvFile')->with('success', 'category updated succefully');
  }
  public function myDivSortable()
  {
    return  view('admin.divSortable');
  }
}
