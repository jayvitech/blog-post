<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Blog_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller
{
    public function index() {
        $blogData = Blog::select('blogs.blog_category_id', 'blogs.title', 'blogs.description', 'users.name')->join('users', 'users.id', 'blogs.user_id')->get();
        return view('blog.list', ['blogData' => $blogData]);
    }

    public function add() {
        $categoryData = Blog_category::where('status', 1)->get();
        return view('blog.add', ['categoryData' => $categoryData]);
    }

    public function addBlog(Request $request) {
        request()->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();

        $categoryId = '';
        foreach($data['category'] as $key => $value) {
            $categoryId .= $value . ',';
        }

        $blog = Blog::create([
            'user_id' => auth()->user()->id,
            'blog_category_id' => rtrim($categoryId, ','),
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        return Redirect::to("blog")->with('success', 'Blog added successfully.');
    }

    public function filterDate($date) {
        $blogData = Blog::select('blogs.blog_category_id', 'blogs.title', 'blogs.description', 'users.name')->join('users', 'users.id', 'blogs.user_id')->whereDate('blogs.created_at', '=', $date)->get();

        $data = '';
        foreach($blogData as $key => $blog) {
            $data .= '<tr>
                <td>'. ($key+1) .'</td>
                <td>'. $blog->name .'</td>
                <td>'. $blog->title .'</td>';

            $category = '';
            $idsArr = explode(',',$blog['blog_category_id']);
            $categoryData = Blog_category::whereIn('id',$idsArr)->get();
            if(count($categoryData) > 0) {
                foreach ($categoryData as $value) {
                    $category .= $value->name .', ';
                }
                $category = rtrim($category, ', ');
            }
            $data .= '<td>'. $category .'</td>';
            $data .= '</tr>';
        }
        return $data;
    }
}
