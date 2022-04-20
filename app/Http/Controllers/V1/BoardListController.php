<?php

namespace App\Http\Controllers\V1;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardList;

class BoardListController extends Controller
{
    public function create(Request $request, $board_id){
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3'
            ]);
    
            if($validator->fails()) return response()->json([
                'status' => false,
                'error' => $validator->messages()
            ], 400);
            $order = 1;
            $last_board_list = BoardList::where('board_id', $board_id)->orderBy('order', 'DESC')->first();
            if($last_board_list){
                $order = $last_board_list->order + 1;
            }
            $board_list = new BoardList([
                'board_id' => $board_id,
                'name' => $request->name,
                'order' => $order
            ]);
            
            $created_board_list = $board_list->save();

            return response()->json([
                'status' => true,
                'data' => $created_board_list
            ], 200);
        } catch (Excecption $e) {
            return response()->json([
                'status' => false,
                'error' => 'list not created'
            ], 500);
        }

    }
    public function changeOrder(Request $request, $list_id){
        try {
            $validator = Validator::make($request->all(), [
                'order' => 'required'
            ]);
            if($validator->fails()) return response()->json([
                'status' => false,
                'error' => $validator->messages()
            ], 400);
            $board_list = Board::find($list_id);
            $board_list->order = $request->order;
            $board_list->save();

            return response()->json([
                'status' => true,
                'data' => $board_list
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'list not updated'
            ], 500);
        }

    }
    public function update(Request $request, $list_id){
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3'
            ]);
    
            if($validator->fails()) return response()->json([
                'status' => false,
                'error' => $validator->messages()
            ], 400);
    
            $board_list = new BoardList([
                'id' => $request->list_id,
                'name' => $request->name
            ]);
    
            $updated_board_list = $board_list->save();

            return response()->json([
                'status' => true,
                'data' => $updated_board_list
            ], 200);
        } catch (Excecption $e) {
            return response()->json([
                'status' => false,
                'error' => 'list not updated'
            ], 500);
        }
    }
}
