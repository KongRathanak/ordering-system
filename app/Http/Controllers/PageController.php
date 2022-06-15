<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index($slug, $subs = null)
    {
        $page = Page::findBySlug($slug);

        if (!$page || ($slug == 'article' && !$subs)) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = $page->title;
        $this->data['page'] = $page->withFakes();
        $this->data['page'] = $subs;

        return view('pages.'.$page->template, $this->data);
    }
}
