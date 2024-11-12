<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            //átnevezzük, Modelben def-ni!
            $table->id('book_id');
            $table->string('author');
            $table->string('title');
            /* $table->integer('pieces'); */
            $table->timestamps();
        });

        Book::create(['author'=>'Shakespear',
         'title'=> 'Spear',
          /* 'pieces'=> 40 */
        ]);

        Book::create(['author'=>'James bond',
         'title'=> 'Mission',
          /* 'pieces'=> 25 */
        ]);

        Book::create(['author'=>'John Flaggan',
         'title'=> 'Umbra',
          /* 'pieces'=> 10 */
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
