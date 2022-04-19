<?php

namespace App\Http\Controllers\V1;

use Auth;
use Validator;
use App\Models\Board;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'string|min:3'
        ]);
        if($validator->fails()) return response()->json($validator->messages());
        $created_board = Board::create([
            'name' => $request->name,
            'creator_id' => Auth::id()
        ]);
        if(!$created_board) return response()->json([
            'error' => 'board not created'
        ], 500);
        return response()->json($created_board, 200);
    }
}
