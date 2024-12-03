<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{

    // konyvtaros + admin
    public function index()
    {
        return Reservation::all();
    }

    // konyvtaros
    public function store(Request $request)
    {
        $record = new Reservation();
        $record->fill($request->all());
        $record->save();
    }

    // konyvtaros
    public function show(string $user_id, string $book_id, string $start)
    {
        $reservation = Reservation::where('user_id', $user_id)
        ->where('book_id', $book_id)
        ->where('start', $start)
        //listát ad vissza:
        ->get();
        return $reservation[0];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user_id, string $book_id, string $start)
    {
        $user = $this->show($user_id, $book_id, $start);
        $user->fill($request->all());
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id, string $book_id, string $start)
    {
        $this -> show($user_id, $book_id, $start) -> delete();
    }

    public function reservedBooks() {
        $user = Auth::user();
        return Reservation::with('books')
        ->where('user_id', $user -> id)
        ->get();
    }

    public function reservedCount() {
        $user = Auth::user();
        $pieces = DB::table('reservations')
        ->where('user_id', $user->id)
        ->count();

        return $pieces;
    }
}
