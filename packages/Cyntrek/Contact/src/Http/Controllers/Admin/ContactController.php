<?php

namespace Cyntrek\Contact\Http\Controllers\Admin;

use Cyntrek\Contact\Datagrids\ContactUsDataGrid;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(ContactUsDataGrid::class)->toJson();
        }

        return view('contact::admin.index');
    }
}
