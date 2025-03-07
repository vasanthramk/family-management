<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->date('birthdate');
            $table->string('mobile_no');
            $table->text('address');
            $table->string('state');
            $table->string('city');
            $table->string('pincode');
            $table->string('marital_status');
            $table->date('wedding_date')->nullable();
            $table->text('hobbies')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('families');
    }
}

class CreateFamilyMembersTable extends Migration
{
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->date('birthdate');
            $table->string('marital_status');
            $table->date('wedding_date')->nullable();
            $table->string('education');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_members');
    }
}