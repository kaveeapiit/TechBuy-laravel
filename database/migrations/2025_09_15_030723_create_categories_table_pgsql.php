<?php<?php



use Illuminate\Database\Migrations\Migration;use     public function up(): void

use Illuminate\Database\Schema\Blueprint;    {

use Illuminate\Support\Facades\Schema;        Schema::create('categories', function (Blueprint $table) {

            $table->id();

return new class extends Migration            $table->string('name');

{            $table->string('slug')->unique();

    /**            $table->text('description')->nullable();

     * Run the migrations.            $table->string('image')->nullable();

     */            $table->boolean('is_active')->default(true);

    public function up(): void            $table->timestamps();

    {        });

        Schema::create('categories', function (Blueprint $table) {    }ate\Database\Migrations\Migration;

            $table->id();use Illuminate\Database\Schema\Blueprint;

            $table->string('name');use Illuminate\Support\Facades\Schema;

            $table->string('slug')->unique();

            $table->text('description')->nullable();return new class extends Migration

            $table->string('image')->nullable();{

            $table->boolean('is_active')->default(true);    /**

            $table->timestamps();     * Run the migrations.

        });     */

    }    public function up(): void

    {

    /**        Schema::create('categories_table_pgsql', function (Blueprint $table) {

     * Reverse the migrations.            $table->id();

     */            $table->timestamps();

    public function down(): void        });

    {    }

        Schema::dropIfExists('categories');

    }    /**

};     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_table_pgsql');
    }
};
