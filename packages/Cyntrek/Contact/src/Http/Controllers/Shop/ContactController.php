<?php

namespace Cyntrek\Contact\Http\Controllers\Shop;

use Cyntrek\Contact\Http\Requests\StoreContactRequest;
use Cyntrek\Contact\Repositories\ContactRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct(
        protected ContactRepository $contactRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('contact::shop.index');
    }

    public function store(StoreContactRequest $request)
    {
        $this->contactRepository->create($request->all());

        session()->flash('success', 'Thank you for your message');

        return back();
    }
}
