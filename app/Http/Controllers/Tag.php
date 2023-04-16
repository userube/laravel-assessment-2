<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTags(Request $request)
    {
        $tags = Tag::orderBy('id', 'desc');

        return response()->json([
            'success' => true,
            'message' => 'Tag retrieved succesffully',
            'tags' => $tags
        ]);
    }
}