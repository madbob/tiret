<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupEmail extends Migration
{
    public function up()
    {
        Schema::table('groups', function(Blueprint $table)
        {
            $table->text('email')->default('');
        });
    }

    public function down()
    {
        Schema::table('groups', function(Blueprint $table)
        {
            $table->dropColumn(['email']);
        });
    }
}
