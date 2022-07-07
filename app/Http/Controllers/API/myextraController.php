<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Blog;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // $validator = $this->validate($request, [
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8',
            // 'confirm_password' => 'required|string|min:8'
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8'
        ]);
     
        if ($request->name == "" || $request->email == "" || $request->password == "" || $request->confirm_password == "") {
            if ($validator->fails()) {    
                return response()->json($validator->messages(), 422);
            }
        }
        if ($request->password != $request->confirm_password) {
            return response()->json(['confirmationError' => "Password doesn't match with confirm password"], 401);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'confirm_password' => Hash::make($request->confirm_password)
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',], 200);
        }
    }

    public function login(Request $request)
    {
        // $validator = $this->validate($request, [
        //     'email' => 'required|string|email|max:200',
        //     'password' => 'required|string|min:8',
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:200',
            'password' => 'required|string|min:8'
        ]);
        // if ($validator->fails()) {
        //         return response()->json($validator->errors());
        // }
        if ($request->email == "" || $request->password == "") {
            if ($validator->fails()) {
                return response()->json(['emptyData' => "please enter appropriate data"], 422);
            }
        } else if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()
                ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',], 200);
        } else {
            return response()->json(['wrongCredentials' => 'Unauthorised'], 401);
        }
    }

    // method for user logout and delete token
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()
            ->json(['message' => 'success fully logged out']);
    }

    //List Out All Blogs
    public function index()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    //add new blog and store it
    public function createNewBlog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|string|max:50',
            'status' => 'required|string|max:20',
            'tag' => 'required|string|max:10',
            'order' => 'required|numeric|min:2',
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 422);
        }
        else {
            $blog = Blog::create($request->post());
            return response()->json([
                'message' => 'blog Created Successfully!!',
                'blog' => $blog
            ]);
        }
    }

    //Delete Any specific Blog
    public function destroyBlog($id)
    {
        if (Blog::where('id', $id)->exists()) {
            $blog = Blog::find($id);
            $blog->delete();
            return response()->json([
                'message' => 'blog Deleted Successfully!!'
            ], 200);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }


    // For Edit Record
    public function editBlog($id)
    {
        if (Blog::where('id', $id)->exists()) {
            $blog = Blog::find($id);
            return response()->json([
                'blog' => $blog,
            ], 200);
        } else {
            return response()->json([
                "message" => "blog not found"
            ], 404);
        }
    }


    public function updateBlog(Request $request, $id)
    {
        $blogUpdate = $request->validate([
            'title' => 'required',
            'description' => 'required|string|max:50',
            'status' => 'required|string|max:20',
            'tag' => 'required|string|max:10'
        ]);


        if ($blogUpdate == "") {
            return response()->json(['data' => "please enter appropriate data"], 422);
        } else {
            if (Blog::where('id', $id)->exists()) {
                $blogs = Blog::find($id);
                $blogs->title = $request->title;
                $blogs->description = $request->description;
                $blogs->status = $request->status;
                $blogs->tag = $request->tag;
                $blogs->order = $request->order;
                $blogs->save();
                return response()->json([
                    'message' => "blog updated successfully",
                    'blog' => $blogs
                ], 200);
            } else {
                return response()->json([
                    "message" => "Blog not found"
                ], 404);
            }
        }
    }
}
public function index(Request $request)
{
    $error=0// api pass successfully

    // $blogs = Blog::all();
   $s = $request->get('search');
        $blogs = Blog::where('title', 'like', '%' . $s . '%')
            ->orwhere('description', 'like', '%' . $s . '%')
            ->orwhere('status', 'like', '%' . $s . '%')
            ->orwhere('tag', 'like', '%' . $s . '%')
            ->orwhere('order', '=',  $s)->paginate(4);

        if (count($blogs)) {
            return response()->json(["blog" => $blogs,"error"=>$error]);
        } else {
            $error=1;
            return response()->json(['message' => 'No Data not found',"error"=>$error], 404);
        }

        axios
        .post(`/getAllBlog?page=${pagination}&search=${this.searchTerm}`)
        .then((response) => {
          if(response.error)
          {
          this.blogs = response.data.blog;
          this.pagination = response.data.blog;  
          }else
          {
            console.log((this.message = error.response.data.message));
          }
          this.blogs = response.data.blog;
          this.pagination = response.data.blog;
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 404) {
            // console.log(error.response.data);
            console.log((this.message = error.response.data.message));
          }
          this.blogs = [];
        });
    // $response = [
    //     'pagination' => [
    //         'total' => $blogs->total(),
    //         'per_page' => $blogs->perPage(),
    //         'current_page' => $blogs->currentPage(),
    //         'last_page' => $blogs->lastPage(),
    //         'from' => $blogs->firstItem(),
    //         'to' => $blogs->lastItem()
    //     ],
    //     'data' => $blogs
    // ];
    // return response()->json($response);

    $product = Product::select('*')->sortable();
    // if($request->name && $request->name != ''){
    //     $product= $product->where('name','like','%'.$request->name.'%');
    // }
    // if($request->price && $request->price != ''){
    //     $product = $product->where('price','=',$request->price);
    // }
// if($request->category_name && $request->category_name != ' ')
// {
//     $product=$product->whereHas('category',function($query) use ($request){
//         $query->where('name','like','%'.$request->category_name.'%');
//     });
// }
// if($request->created_at && $request->created_at != ''){
//     $product = $product->whereDate('created_at',$request->created_at);
// }

// $productdata = $product->get();
// return view('admin.products',['productdata'=>$productdata]);
}