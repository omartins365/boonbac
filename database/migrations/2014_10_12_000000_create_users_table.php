<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('brand_name',20)->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('wa_phone')->nullable();
            $table->tinyInteger('rank')->default(0);
            $table->json('permission')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement("
        INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `rank`, `permission`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
        (1, 'System', 'Default', 'system@shelter-electronics.com.ng', 2, NULL, '2022-04-14 15:11:42', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'RkFTDdvLtwiXlnVKaBQpZo6NrcZ0aMUAMthCT1EPTWWu60PvmaxPhqYQ5wtK', '2022-04-14 15:11:42', '2022-04-14 15:12:56');
        ");

        // dump("dumped dummy users");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
