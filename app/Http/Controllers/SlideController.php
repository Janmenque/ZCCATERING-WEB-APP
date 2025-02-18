<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SlideController extends Controller
{
    public function index($xfilter = '--')
    {
        $list = Slide::all();
        return view('slide.index', ['list' => $list]);
    }

    public function create()
    {
        return view('slide.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pix' => 'image|required'
        ]);

            $table = new Slide();
            $pix = $request->file('pix')->store('', 'slides');

            $manager = new ImageManager(
                new Driver()
            );
            // open an image file
            $img = $manager->read(public_path('uploads/slides/' . $pix));
            $img->resize(1500, 800);
            $img->save();

        $table->pix = $pix;
        $table->save();

        return redirect()->route('slide')->with('status', 'Slide saved');
    }

    public function delete($id)
    {
        $table = Slide::find($id);
        unlink('public/uploads/slides/'.$table->pix);
        $table->delete();

        return redirect()->route('slide')->with('status', 'Product deleted');
    }
}
