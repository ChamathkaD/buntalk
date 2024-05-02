<?php

namespace Cyntrek\Outlet\Http\Controllers\Admin;

use Cyntrek\Outlet\Datagrids\OutletDataGrid;
use Cyntrek\Outlet\Repositories\OutletRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Prettus\Validator\Exceptions\ValidatorException;

class OutletController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected OutletRepository $outletRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(OutletDataGrid::class)->toJson();
        }

        return view('outlet::admin.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(): JsonResponse
    {
        $this->validate(request(), [
            'name'        => 'required|min:2|unique:outlets,name|max:25',
            'address'     => 'string|nullable',
            'description' => 'string|nullable',
        ]);

        $this->outletRepository->create(request()->only([
            'name',
            'address',
            'description',
        ]));

        return new JsonResponse([
            'message' => 'Outlet Created Successfully!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $outlet = $this->outletRepository->findOrFail($id);

        return view('outlet::admin.edit', compact('outlet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws ValidatorException
     */
    public function update(int $id)
    {
        $this->validate(request(), [
            'name' => ['required', 'unique:outlets,name,'.$id, 'max:25'],
        ]);

        $this->outletRepository->update(request()->only([
            'name',
            'address',
            'description',
        ]), $id);

        session()->flash('success', 'Outlet Updated Successflly!');

        return redirect()->route('admin.outlet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->outletRepository->findOrFail($id);

        if ($this->outletRepository->count() == 1) {
            return new JsonResponse([
                'message' => 'At least one outlet is required!',
            ], 400);
        }

        try {
            $this->outletRepository->delete($id);

            return new JsonResponse([
                'message' => 'Outlet Deleted Successfully!',
            ], 200);
        } catch (\Exception $e) {
            report($e);
        }

        return new JsonResponse([
            'message' => 'Outlet Deleted Failed!',
        ], 500);
    }
}
