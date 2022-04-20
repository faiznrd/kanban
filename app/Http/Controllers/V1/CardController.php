<?php

namespace App\Http\Controllers\V1;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller
{
    public function create(Request $request, $board_id, $list_id){
        try {
            $validator = Validator::make($request->all(), [
                'task' => 'required|min:3'
            ]);
    
            if($validator->fails()) return response()->json([
                'status' => false,
                'error' => $validator->messages()
            ], 400);
            $last_card_order = 1;
            $last_card = Card::orderBy('order', 'DESC')->first();
            if($last_card) $last_card_order = $last_card->order + 1;
            $card = new Card([
                'list_id' => $list_id,
                'task' => $request->task,
                'order' => $last_card_order
            ]);
            $card->save();
            return response()->json([
                'status' => true,
                'data' => $card
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'card not created'
            ], 500);
        }
    }
}
