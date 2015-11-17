<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create("attendees", function(Blueprint $table) {
			$table->integer("event_id")->unsigned()->index();
			$table->integer("user_id")->unsigned()->index();
			$table->timestamps();
			$table->primary(["event_id", "user_id"]);
			$table->foreign("event_id")->references("id")->on("events");
			$table->foreign("user_id")->references("id")->on("users");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop("attendees");
	}
}
