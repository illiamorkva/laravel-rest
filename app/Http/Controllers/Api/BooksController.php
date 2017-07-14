<?php

namespace App\Http\Controllers\Api;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all()->toArray();

        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());

        try{
            $user->books()->create([
                'name' => $request->input('name'),
                'price' => $request->input('price')
            ]);
            return response()->json(['status'=>true,'Great thanks'],200);

        }catch (\Exception $e){
            Log::critical("Could not store book: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response('Something bad', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $book = Book::find($id);

            if(!$book){
                return response()->json(['This id does not exist'], 404);
            }

            return response()->json($book,200);

        }catch (\Exception $e){
            Log::critical("Could not show book: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response('Something bad', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $book = Book::find($id);

            if(!$book){
                return response()->json(['This id does not exist'], 404);
            }

            $user = JWTAuth::toUser(JWTAuth::getToken());

            if($user->id != $book->user_id){
                return response()->json(['Unauthenticated'], 401);
            }

            $book->name = $request->input('name');
            $book->price = $request->input('price');
            $book->save();

            return response()->json(['status'=>true,'Great thanks'],200);

        }catch (\Exception $e){
            Log::critical("Could not update book: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response('Something bad', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $book = Book::find($id);

            if(!$book){
                return response()->json(['This id does not exist'], 404);
            }

            $user = JWTAuth::toUser(JWTAuth::getToken());

            if($user->id != $book->user_id){
                return response()->json(['Unauthenticated'], 401);
            }

            $book->delete();

            return response()->json('Book deleted', 200);

        } catch(\Exception $e) {
            Log::critical("Could not delete book: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response('Something bad', 500);
        }
    }
}
