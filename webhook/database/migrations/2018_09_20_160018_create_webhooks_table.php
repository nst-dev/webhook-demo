<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_id');
            $table->string('payload_url')->comment('URL nhận request payload');
            $table->string('secret')->comment('Mã bảo mật');
            $table->string('content_type')->comment('Kiểu dữ liệu nhận payload (JSON, FORM)');
            $table->string('status')->comment('Trạng thái (INACTIVE, ACTIVE)');
            $table->text('events')->comment('Danh sách trạng thái webhook listen');
            $table->timestamps();

            $table->index(['app_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhooks');
    }
}
