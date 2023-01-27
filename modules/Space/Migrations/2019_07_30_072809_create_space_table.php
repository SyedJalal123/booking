<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    use Modules\Space\Models\BusCompanies;
    use Modules\Space\Models\BusStops;
    use Modules\Space\Models\BusBookingPassengers;
    use Modules\Space\Models\Bus;
    use Modules\Space\Models\BusSeat;
    use Modules\Space\Models\BusTerm;
    use Modules\Space\Models\BusSeatType;

    class CreateSpaceTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            $this->down();
            Schema::create('bravo_bus_terms', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('term_id')->nullable();
                $table->integer('target_id')->nullable();
                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();

                $table->softDeletes();
                $table->timestamps();
            });
            Schema::create('bravo_bus_stops', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->string('code')->unique();
                $table->string('address')->nullable();
                $table->integer('location_id')->nullable();
                $table->text('description')->nullable();
                $table->string('map_lat', 20)->nullable();
                $table->string('map_lng', 20)->nullable();
                $table->integer('map_zoom')->nullable();
                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
            Schema::create('bravo_bus_companies', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->integer('image_id')->nullable();
                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
            Schema::create('bravo_bus_seat_types', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code')->unique();
                $table->string('name')->nullable();
                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('bravo_buses', function (Blueprint $blueprint) {
                $blueprint->engine = 'InnoDB';
                $blueprint->bigIncrements('id');
                $blueprint->string('title')->nullable();
                $blueprint->string('code')->nullable();
                $blueprint->decimal('review_score',2,1)->nullable();
                $blueprint->dateTime('departure_time')->nullable();
                $blueprint->dateTime('arrival_time')->nullable();
                $blueprint->float('duration')->nullable();
                $blueprint->decimal('min_price', 12, 2)->nullable();
                $blueprint->integer('airport_to')->nullable();
                $blueprint->integer('airport_from')->nullable();
                $blueprint->integer('airline_id')->nullable();
                $blueprint->string('status', 50)->nullable();

                $blueprint->bigInteger('create_user')->nullable();
                $blueprint->bigInteger('update_user')->nullable();
                $blueprint->timestamps();
                $blueprint->softDeletes();
            });
            Schema::create('bravo_bus_seats', function (Blueprint $blueprint) {
                $blueprint->engine = 'InnoDB';
                $blueprint->bigIncrements('id');
                $blueprint->decimal('price', 12, 2)->nullable();
                $blueprint->integer('max_passengers')->nullable();
                $blueprint->integer('flight_id')->nullable();
                $blueprint->string('seat_type')->nullable();
                $blueprint->string('person')->nullable();
                $blueprint->integer('baggage_check_in')->nullable();
                $blueprint->integer('baggage_cabin')->nullable();


                $blueprint->bigInteger('create_user')->nullable();
                $blueprint->bigInteger('update_user')->nullable();
                $blueprint->timestamps();
                $blueprint->softDeletes();
            });
            Schema::create('bus_booking_passengers', function (Blueprint $blueprint) {
                $blueprint->engine = 'InnoDB';

                $blueprint->bigIncrements('id');
                $blueprint->integer('flight_id')->nullable();
                $blueprint->integer('flight_seat_id')->nullable();
                $blueprint->integer('booking_id')->nullable();
                $blueprint->string('seat_type')->nullable();
                $blueprint->string('email')->nullable();
                $blueprint->string('first_name')->nullable();
                $blueprint->string('last_name')->nullable();
                $blueprint->string('phone')->nullable();
                $blueprint->dateTime('dob')->nullable();
                $blueprint->decimal('price', 12, 2)->nullable();
                $blueprint->string('id_card')->nullable();


                $blueprint->bigInteger('create_user')->nullable();
                $blueprint->bigInteger('update_user')->nullable();
                $blueprint->timestamps();
                $blueprint->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('bravo_bus_terms');
            Schema::dropIfExists('bravo_bus_stops');
            Schema::dropIfExists('bravo_bus_companies');
            Schema::dropIfExists('bravo_bus_seat_types');
            Schema::dropIfExists('bravo_buses');
            Schema::dropIfExists('bravo_bus_seats');
            Schema::dropIfExists('bus_booking_passengers');
        }
    }

?>












<!-- For Space -->
<?php

    // use Illuminate\Support\Facades\Schema;
    // use Illuminate\Database\Schema\Blueprint;
    // use Illuminate\Database\Migrations\Migration;

    // class CreateSpaceTable extends Migration
    // {
    //     /**
    //      * Run the migrations.
    //      *
    //      * @return void
    //      */
    //     public function up()
    //     {
    //         Schema::create('bravo_spaces', function (Blueprint $table) {
    //             $table->bigIncrements('id');

    //             //Info
    //             $table->string('title', 255)->nullable();
    //             $table->string('slug',255)->charset('utf8')->index();
    //             $table->text('content')->nullable();
    //             $table->integer('image_id')->nullable();
    //             $table->integer('banner_image_id')->nullable();
    //             $table->integer('location_id')->nullable();
    //             $table->string('address', 255)->nullable();
    //             $table->string('map_lat',20)->nullable();
    //             $table->string('map_lng',20)->nullable();
    //             $table->integer('map_zoom')->nullable();
    //             $table->tinyInteger('is_featured')->nullable();
    //             $table->string('gallery', 255)->nullable();
    //             $table->string('video', 255)->nullable();
    //             $table->text('faqs')->nullable();

    //             //Price
    //             $table->decimal('price', 12,2)->nullable();
    //             $table->decimal('sale_price', 12,2)->nullable();
    //             $table->tinyInteger('is_instant')->default(0)->nullable();
    //             $table->tinyInteger('allow_children')->default(0)->nullable();
    //             $table->tinyInteger('allow_infant')->default(0)->nullable();
    //             $table->integer('max_guests')->default(0)->nullable();

    //             $table->tinyInteger('bed')->default(0)->nullable();
    //             $table->tinyInteger('bathroom')->default(0)->nullable();
    //             $table->integer('square')->default(0)->nullable();

    //             $table->tinyInteger('enable_extra_price')->nullable();
    //             $table->text('extra_price')->nullable();
    //             $table->text('discount_by_days')->nullable();

    //             //Extra Info
    //             $table->string('status',50)->nullable();
    //             $table->tinyInteger('default_state')->default(1)->nullable();

    //             $table->bigInteger('create_user')->nullable();
    //             $table->bigInteger('update_user')->nullable();
    //             $table->softDeletes();

    //             $table->timestamps();
    //         });

    //         Schema::create('bravo_space_translations', function (Blueprint $table) {
    //             $table->bigIncrements('id');
    //             $table->integer('origin_id')->unsigned();
    //             $table->string('locale')->index();

    //             //Info
    //             $table->string('title', 255)->nullable();
    //             $table->text('content')->nullable();
    //             $table->text('faqs')->nullable();
    //             $table->string('address', 255)->nullable();

    //             $table->bigInteger('create_user')->nullable();
    //             $table->bigInteger('update_user')->nullable();
    //             $table->softDeletes();

    //             $table->timestamps();
    //         });

    //         Schema::create('bravo_space_term', function (Blueprint $table) {
    //             $table->bigIncrements('id');

    //             $table->integer('term_id')->nullable();
    //             $table->integer('target_id')->nullable();

    //             $table->bigInteger('create_user')->nullable();
    //             $table->bigInteger('update_user')->nullable();
    //             $table->timestamps();

    //         });

    //         Schema::create('bravo_space_dates', function (Blueprint $table) {

    //             $table->bigIncrements('id');
    //             $table->bigInteger('target_id')->nullable();

    //             $table->timestamp('start_date')->nullable();
    //             $table->timestamp('end_date')->nullable();
    //             $table->decimal('price',12,2)->nullable();
    //             $table->tinyInteger('max_guests')->nullable();
    //             $table->tinyInteger('active')->default(0)->nullable();
    //             $table->text('note_to_customer')->nullable();
    //             $table->text('note_to_admin')->nullable();
    //             $table->tinyInteger('is_instant')->default(0)->nullable();

    //             $table->bigInteger('create_user')->nullable();
    //             $table->bigInteger('update_user')->nullable();
    //             $table->timestamps();

    //         });
    //     }

    //     /**
    //      * Reverse the migrations.
    //      *
    //      * @return void
    //      */
    //     public function down()
    //     {
    //         Schema::dropIfExists('bravo_spaces');
    //         Schema::dropIfExists('bravo_space_translations');
    //         Schema::dropIfExists('bravo_space_term');
    //         Schema::dropIfExists('bravo_space_dates');
    //     }
    // }
?>