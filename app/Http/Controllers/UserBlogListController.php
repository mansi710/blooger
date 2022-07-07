<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Favourite;
use DB;
use Auth;

class UserBlogListController extends Controller
{
    //

    public function litOfBlog(Request $request)
    {
        $blogs=DB::table('blogs')->where('status','!=','archive')->orderBy('order','ASC');
        if($request->has('title') && $request->title != ''){
            $blogs= $blogs->where('title','like','%'.$request->title.'%');
        }
        if($request->has('description') && $request->description != ''){
            $blogs= $blogs->where('description','like','%'.$request->description.'%');
        }
        if($request->has('tag') && $request->tag != ''){
            $blogs= $blogs->where('tag','like','%'.$request->tag.'%');
        }
        if($request->has('status') && $request->status != ''){
            $blogs= $blogs->where('status','like','%'.$request->status.'%');
        }
        if($request->created_at && $request->created_at != ''){
                $blogs = $blogs->whereDate('created_at',$request->created_at);
        }
        $blogdata = $blogs->get();
        return view('user.userSideBlogListing',compact('blogdata'));
    }

    public function blogDetailPage($id)
    {
        $blog=Blog::find($id);
        return view('user.blogDetailPage',compact('blog'));
    }

    public function postRating(Request $request)
    {
        
        $blog=Blog::where('id',$request->id)->first();

            $rating=new Favourite();
            $rating->user_id=\Auth::user()->id;
            $rating->blog_id=$blog->id;
            $rating->favourite_data="1";
            $rating->save();
     
        // $rating=Rating::create();


        // $rating->user_id=auth()->user()->id;
        // $rating->blog_id=$request->get('blog_id');
        // $rating->rating_data="1";
        // $rating->save();

       
    }

   
 

  
}

// $product = Product::select('*')->sortable();
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