<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{

    public function index()
    {
        $shortLinks = ShortLink::latest()->get();
        return view('shortenLink', compact('shortLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url'
        ]);
        $input['link'] = $request->link;
        $input['code'] = Str::uuid();
        ShortLink::create($input);

        return redirect('/')
            ->with('success', 'Сокращенная ссылка сгенерирована успешно!');
    }

    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();
        return redirect($find->link);
    }
}
