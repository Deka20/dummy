    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['studio_id']);  // Hapus foreign key yang ada
            $table->foreign('studio_id')->references('id')->on('studios')->onDelete('cascade');  // Tambahkan onDelete('cascade')
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['studio_id']);
            $table->foreign('studio_id')->references('id')->on('studios');
        });
    }

    };
