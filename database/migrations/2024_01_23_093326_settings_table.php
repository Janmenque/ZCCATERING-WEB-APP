<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function(Blueprint $table){
$table->id();
$table->string('name');
$table->string('email');
$table->string('tell')->nullable();
$table->text('address')->nullable();
$table->string('currency', 30);
$table->string('logo');
$table->string('favicon');
$table->string('slogan')->nullable();
$table->string('home_about_title')->nullable();
$table->longText('home_about')->nullable();
$table->string('home_about_pix');
$table->string('captcha_site_key')->nullable();
$table->string('captcha_secret_key')->nullable();
$table->string('facebook')->nullable();
$table->string('twitter')->nullable();
$table->string('instagram')->nullable();
$table->string('youtube')->nullable();
$table->string('log_back')->nullable();
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
        });

        $home_about = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ullamcorper dignissim cras tincidunt lobortis feugiat vivamus at augue. Maecenas sed enim ut sem viverra aliquet eget. Diam in arcu cursus euismod quis viverra nibh cras pulvinar. Nunc aliquet bibendum enim facilisis gravida neque convallis. Et magnis dis parturient montes nascetur ridiculus mus mauris. Pellentesque habitant morbi tristique senectus. Pharetra massa massa ultricies mi quis hendrerit.<br /><br />
        Nascetur ridiculus mus mauris vitae ultricies leo. In hac habitasse platea dictumst vestibulum rhoncus est pellentesque. Integer feugiat scelerisque varius morbi enim nunc faucibus a. Convallis convallis tellus id interdum velit laoreet id donec. Egestas quis ipsum suspendisse ultrices gravida dictum fusce ut. Gravida in fermentum et sollicitudin ac orci. Augue ut lectus arcu bibendum at varius vel.";

        Setting::insert([
            ['name' => 'Meg Restaurant', 'email' => 'info@onecrib.com', 'tell' => '080', 'address' => '#1 OneCrib Avenue, on mountain top', 'currency' => '$', 'logo' => 'logo.png', 'favicon' => 'favicon.png', 'slogan' => 'Wonderful Experience', 'home_about_title' => 'We will give you a greate memory', 'home_about' => $home_about, 'home_about_pix' => 'home_about_pix.jpg', 'facebook' => '#', 'twitter' => '#', 'instagram' => '#', 'youtube' => '#', 'log_back' => 'log_back.jpg']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
