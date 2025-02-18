<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class SettingController extends Controller
{
    public function create()
    {
        $info = Setting::find(1);
        return view('setting.create', ['info' => $info]);
    }

    public function store(Request $request)
    {
        $info = Setting::find(1);

        $request->validate([
            'home_about_pix' => 'nullable|image',
            'log_back' => 'nullable|image',
        ]);

        $table = $info;
        $table->name = $request->input('name');
        $table->email = $request->input('email');
        $table->tell = $request->input('tell');
        $table->address = $request->input('address');
        $table->currency = $request->input('currency');
        $table->slogan = $request->input('slogan');
        $table->home_about_title = $request->input('home_about_title');
        $table->home_about = $request->input('home_about');
        if ($request->hasFile('home_about_pix')) {
            unlink('public/images/' . $info->home_about_pix);
            $home_about_pix = $request->file('home_about_pix')->store('', 'images');
            $manager = new ImageManager(
                new Driver()
            );
            // open an image file
            $img = $manager->read(public_path('images/' . $home_about_pix));
            $img->resize(540, 507);
            $img->save();
            $table->home_about_pix = $home_about_pix;
        }
        if ($request->hasFile('log_back')) {
            unlink('public/images/' . $info->log_back);
            $log_back = $request->file('log_back')->store('', 'images');
            $manager = new ImageManager(
                new Driver()
            );
            // open an image file
            $img = $manager->read(public_path('images/' . $log_back));
            $img->resize(1000, 1050);
            $img->save();
            $table->log_back = $log_back;
        }
        $table->save();

        return redirect()->back()->with('status', 'Settings saved');
    }

    public function icon_create()
    {
        $info = Setting::find(1);
        return view('setting.icon_create', ['info' => $info]);
    }

    public function icon_store(Request $request)
    {
        $info = Setting::find(1);

        $request->validate([
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
        ]);

        $table = $info;
        if ($request->hasFile('logo')) {
            unlink('public/images/' . $info->logo);
            $logo = $request->file('logo')->store('', 'images');
            $manager = new ImageManager(
                new Driver()
            );
            // open an image file
            $img = $manager->read(public_path('images/' . $logo));
            $img->resize(199, 55);
            $img->save();
            $table->logo = $logo;
        }
        if ($request->hasFile('favicon')) {
            unlink('public/images/' . $info->favicon);
            $favicon = $request->file('favicon')->store('', 'images');
            $manager = new ImageManager(
                new Driver()
            );
            // open an image file
            $img = $manager->read(public_path('images/' . $favicon));
            $img->resize(32, 32);
            $img->save();
            $table->favicon = $favicon;
        }
        $table->save();

        return redirect()->back()->with('status', 'Settings saved');
    }

    public function smtp_create()
    {
        return view('setting.smtp_create');
    }

    public function smtp_store(Request $request)
    {
        if ($request->has('save')) {
            $host = $request->input('host');
            // 587
            $port = $request->input('port');
            // my-username
            $username = $request->input('username');
            // my-app-password
            $password = $request->input('password');
            // TLS (or SSL)
            $encryption = $request->input('encryption');
            $tls = ($encryption == $request->input('encryption')) ? true : false;
            $transport = new EsmtpTransport($host, $port, $tls);
            $transport->setUsername($username);
            $transport->setPassword($password);

            try {
                $transport->start();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()]);
            }

            setEnv('MAIL_MAILER', $request->input('mailer'));
            setEnv('MAIL_HOST', $request->input('host'));
            setEnv('MAIL_PORT', $request->input('port'));
            setEnv('MAIL_USERNAME', $request->input('username'));
            setEnv('MAIL_PASSWORD', $request->input('password'));
            setEnv('MAIL_ENCRYPTION', $request->input('encryption'));
            setEnv('MAIL_FROM_ADDRESS', $request->input('from_address'));

            return redirect()->back()->with('status', 'Settings saved');
        }
    }

    public function social_create()
    {
        return view('setting.social_create');
    }

    public function social_store(Request $request)
    {
        $table = Setting::find(1);

        $table->facebook = $request->input('facebook');
        $table->twitter = $request->input('twitter');
        $table->youtube = $request->input('youtube');
        $table->instagram = $request->input('instagram');

        $table->save();

        return redirect()->back()->with('status', 'Settings saved');
    }
}
