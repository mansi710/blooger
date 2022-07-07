<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Blog;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Mail\Message;

class AuthController extends Controller
{
    //Use For Registration
    public function register(Request $request)
    {
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

    //Use For Login
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:200',
            'password' => 'required|string|min:8'
        ]);

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
    public function index(Request $request)
    {

        // $blogs = Blog::all();
        $commonSearch = $request->get('search');

        // $sort = $request->get('sort', 'asc');
        $sortBy = $request->get('sortBy') ?? 'id';
        $sortKey = $request->get('sortKey') ?? 'asc';
        // $sortKey=in_array($request->sortOrder,['asc','desc']);
        // $sortBy=in_array($request->sortBy,['id','title','description','status','tag','order']);
        if (!empty($commonSearch)) {

            $Blog = Blog::where('title', 'like', '%' . $commonSearch . '%')
                ->orwhere('description', 'like', '%' . $commonSearch . '%')
                ->orwhere('status', 'like', '%' . $commonSearch . '%')
                ->orwhere('tag', 'like', '%' . $commonSearch . '%')
                ->orwhere('order', '=',  $commonSearch);
        } else {
            $Blog = Blog::select('*');
            if ($request->title && $request->title != '') {
                $Blog = $Blog->where('title', 'like', '%' . $request->title . '%');
            }
            if ($request->description && $request->description != '') {
                $Blog = $Blog->where('description', 'like', '%' . $request->description . '%');
            }
            if ($request->status && $request->status != '') {
                $Blog = $Blog->where('status', 'like', '%' . $request->status . '%');
            }
            if ($request->tag && $request->tag != '') {
                $Blog = $Blog->where('tag', 'like', '%' . $request->tag . '%');
            }
            if ($request->order && $request->order != '') {
                $Blog = $Blog->where('order', '=', $request->order);
            }
        }
        $blogs = $Blog->orderBy($sortBy, $sortKey)->paginate(4);
        // $blogs = $Blog->orderBy(array('id' => 'asc', 'title' => 'asc', 'tag' => 'asc'))->paginate(4);
        if (count($blogs)) {
            // $sort = $sort == 'asc' ? 'desc' : 'asc'; 
            return response()->json(["blog" => $blogs]);
        } else {
            return response()->json(['message' => 'No Data not found'], 404);
        }
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
        } else {
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

    //For update log
    /**
     * $id is use for check if id exists then provide to update record otherwise not
     */
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

    public function forgotPassword(Request $request)
    {
        $email = $request->get('email');
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $token = Str::random(10);

        try {
            DB::table('password_resets')->insert([
                "email" => $email,
                "token" => $token,
            ]);

            // send email
            Mail::send("Mail.passwordLink", ['token' => $token], function (Message $message) use ($email) {
                $message->to($email);
                $message->subject("Reset your Password");
            });
            return response([
                "message" => "Check your email",

            ]);
        } catch (\Exception $exception) {
            return response([
                "message" => $exception->getMessage(),
                "status" => 400,
            ]);
        }
    }


    public function resetPassword(Request $request)
    {
        $token = $request->get('token');


        if (!$passwordReset = DB::table('password_resets')->where('token', $token)->first()) {
            return response([
                'message' => "Invalid token!",
                'status' => 400
            ]);
        }
        if (!$user = User::where('email', $passwordReset->email)->first()) {
            return response([
                'message' => 'User not exist',
                'status' => 404
            ]);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response([
            'message' => 'success',
            'status' => 200,
        ]);
    }
}
