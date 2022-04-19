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
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3'
            ]);
            if($validator->fails()) return response()->json($validator->messages());
            $created_board = Board::create([
                'name' => $request->name,
                'creator_id' => Auth::id()
            ]);
            $board = Board::find($created_board->id);
            $board->members()->attach(Auth::id());
            return response()->json([
                'success' => true,
                'data' => $created_board
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'board not created'
            ], 500);
        }

    }
    public function delete($id){
        try {
            $board = Board::find($id);
            $board->delete();
            return response()->json([
                'success' => true,
                'message' => 'board sucessfully created'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'board not deleted'
            ], 500);
        }

    }
    public function getAllBoards(){
        try {
            $boards = Board::where('creator_id', Auth::id())->get();
            return response()->json([
                'success' => true,
                'data' => $boards
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'cant get boards'
            ], 500);
        }
    }
    public function getBoardDetail($id){
        $board = Board::with('lists.cards')->find($id);
        $data = $board;
        $data['members'] = $board->members;
        foreach($data['members'] as $member){
            unset($member->pivot);
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
