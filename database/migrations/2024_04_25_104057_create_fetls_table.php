<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFetlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fetls', function (Blueprint $table) {
            $table->id();
            $table->string('control_no')->nullable();
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('equipment_model_id');
            $table->string('trouble')->nullable();
            $table->string('date')->nullable();
            $table->string('parts_needed')->nullable();
            $table->string('action_done')->nullable();
            $table->string('fetls_status')->nullable();
            $table->string('date_parts_replaced')->nullable();
            $table->string('location_of_equipment')->nullable();
            $table->string('date_of_trouble')->nullable();
            $table->string('remark')->nullable();
            $table->string('created_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->string('noted_by_time_remark')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('checked_by_time_remark')->nullable();
            $table->string('done_by')->nullable();
            $table->unsignedTinyInteger('approval_status')->default(1)->comment = '1-Noted by Approval, 2-Checked by Approval, 3-Approved, 4-Noted by Disapproved,5-Checked by Disapproved, 6-Approved/Done';
            $table->unsignedTinyInteger('status')->default(1)->comment = '1-active,2-inactive';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
            $table->timestamps();

            // Foreign Key
            $table->foreign('equipment_id')->references('id')->on('equipments');
            $table->foreign('equipment_model_id')->references('id')->on('equipment_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fetls');
    }
}
