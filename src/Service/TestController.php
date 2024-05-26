<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Traits\HydraMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController
{
    use HydraMedia;

    public function store(Request $request)
    {

        // save test.txt in with storage facade

        Storage::disk('local')->put('test.txt', 'Hello World');

        $file = request()->file('file');

        $output = $this->storeMedia($file, 'test');

        return response()->json([
            'file' => $output,
        ]);
    }
}
