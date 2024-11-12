<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            //0: admin, 1: librarian, 2: warehouseman, 3: user
            $table->boolean('role')->default(3);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name'=>'admin', 
            'email'=> 'admin@akk.hu',
            'password' => Hash::make('admin12345'),
            'role' => 0
        ]);

        User::create([
            'name'=>'librarian', 
            'email'=> 'librarian@admin.hu',
            'password' => Hash::make('librarian12345'),
            'role' => 1
        ]);

        User::create([
            'name'=>'user', 
            'email'=> 'user@user.hu',
            'password' => Hash::make('user12345')
        ]);
        
        

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
