<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    //alap fg-ek
    public function index()
    {
        return Lending::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Lending();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id, $copy_id, $start)
    {
        $lending = Lending::where('user_id', $user_id)
        ->where('copy_id', $copy_id)
        ->where('start', $start)
        //listát ad vissza:
        ->get();
        return $lending[0];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id, $copy_id, $start)
    {
        $record = $this->show($user_id, $copy_id, $start);
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id, $copy_id, $start)
    {
        $this->show($user_id, $copy_id, $start)->delete();
    }

    //egyéb lekérdezések
    public function lendingsWithCopies(){
        $user = Auth::user();	//bejelentkezett felhasználó
        //copies: fg neve!!!
        return Lending::with('copies')
        ->where('user_id','=', $user->id)
        ->get();
    }
    public function dateSpecific(){
        return Lending::with('specificDate')
        ->where('start','=',"2016-07-11" )
        ->get();
    }
    public function copySpecific($copy_id){
        return Lending::with('copies')
        ->where('copy_id','=', $copy_id)
        ->get();
    }
    
    public function lendingCount() {
        $user = Auth::user();
        $lendings = DB::table('lendings as l')
        ->where('user_id', $user->id)
        ->count();
        return $lendings;
    }

    public function activeLendingCount() {
        $user = Auth::user();
        $lendings = DB::table('lendings as l')
        ->where('user_id', $user->id)
        ->whereNull('end')
        ->count();
        return $lendings;
    }

    public function lendingBooksCount() {
        $user = Auth::user();
        $books = DB::table('lendings as l')
        ->join('copies as c', 'l.copy_id', 'c.copy_id')
        ->where('user_id', $user->id)
        ->distinct('c.book_id')
        ->count();
        return $books;
    }

    public function lendingBooksData() {
        $user = Auth::user();
        $books = DB::table('lendings as l')
        ->join('copies as c', 'l.copy_id', 'c.copy_id')
        ->join('books as b', 'c.book_id', 'b.book_id')
        ->select('b.book_id', 'author', 'title')
        ->where('user_id', $user->id)
        ->groupBy('b.book_id')
        ->count();
        return $books;
    }

    public function lendingsBooksYear() {
        $user = Auth::user();
        $books = DB::table('lendings as l')
        ->join('copies as c', 'l.copy_id', 'c.copy_id')
        ->join('books as b', 'c.book_id', 'b.book_id')
        ->selectRaw('count(*) as ennyiszer, b.book_id, author, title')
        ->where('user_id', $user->id)
        ->groupBy('b.book_id')
        ->havingRaw('ennyiszer < 2')
        ->get();

        return $books;
        
    }

    public function lendingsHardCovered() {
        $user = Auth::user();
        $books = DB::table('lendings as l')
        ->join('copies as c', 'l.copy_id', 'c.copy_id')
        ->join('books as b', 'c.book_id', 'b.book_id')
        ->selectRaw('count(*) as ennyiszer, b.book_id, author, title')
        ->where('user_id', $user->id)
        ->groupBy('b.book_id')
        ->having('count(b.book_id)', '<', 2)
        ->get();

        return $books;
    }
}
