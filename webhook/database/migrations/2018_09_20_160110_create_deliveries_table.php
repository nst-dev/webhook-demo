<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('app_id');
            $table->unsignedInteger('webhook_id');
            $table->unsignedBigInteger('event_id');
            $table->string('status')->comment('Trạng thái gửi');
            $table->tinyInteger('attempts')->comment('Số lần gửi');
            $table->string('request_url')->comment('URL đã gửi request payload');
            $table->string('request_token')->comment('Token bảo mật');
            $table->dateTime('request_time')->nullable()->comment('Thời gian gửi');
            $table->integer('response_status')->comment('Response status code nhận được');
            $table->longText('response_body')->comment('Response content nhận được');
            $table->timestamps();

            $table->index(['app_id']);
            $table->index(['webhook_id', 'status']);
            $table->index(['event_id', 'status']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
