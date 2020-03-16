<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Session;
use App\Models\Staticpage;

class StaticController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function staticpages() {
        return view('staticcontent');
    }

    public function viewstaticpages($id) {
        $getContent = Staticpage::where(['page_id'=>$id])->first();
        $pageContent = ['id'=>$getContent->id, 'content'=>$getContent->content, 'title'=>$getContent->title];
        return view('editpagestatic',compact('pageContent','id'));
    }

    public function updatestaticpages(Request $request, $id) {
        $getContent = Staticpage::where(['page_id'=>$id])->first();
        
        if($getContent) {
            $editor_content = $request->content;
            $dom = new \DomDocument('1.0', 'UTF-8');
            libxml_use_internal_errors(true);
            $dom->loadHtml($editor_content);

            $getContent->content = $dom->saveHTML();
            $getContent->update();
        }
        return redirect()->route('static-pages');
    }

    public function term() {
        $getContent = Staticpage::where(['id'=>2])->first();
        return view('Terms', compact('getContent'));
    }
    public function about() {
        $getContent = Staticpage::where(['id'=>1])->first();
        return view('about', compact('getContent'));
    }

    public function privacy() {
        $getContent = Staticpage::where(['id'=>3])->first();
        return view('Privacy', compact('getContent'));
    }
}
