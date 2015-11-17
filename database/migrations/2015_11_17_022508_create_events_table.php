<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create("events", function(Blueprint $table) {
			$table->increments("id");
			$table->integer("user_id")->unsigned()->index();
			$table->string("event_name", 64);
			$table->string("event_description");
			$table->timestamps();
			$table->foreign("user_id")->references("id")->on("users");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop("events");
	}
}
