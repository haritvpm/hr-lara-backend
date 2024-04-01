<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOtCategoryRequest;
use App\Http\Requests\StoreOtCategoryRequest;
use App\Http\Requests\UpdateOtCategoryRequest;
use App\Models\OtCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ot_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otCategories = OtCategory::all();

        return view('admin.otCategories.index', compact('otCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('ot_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.otCategories.create');
    }

    public function store(StoreOtCategoryRequest $request)
    {
        $otCategory = OtCategory::create($request->all());

        return redirect()->route('admin.ot-categories.index');
    }

    public function edit(OtCategory $otCategory)
    {
        abort_if(Gate::denies('ot_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.otCategories.edit', compact('otCategory'));
    }

    public function update(UpdateOtCategoryRequest $request, OtCategory $otCategory)
    {
        $otCategory->update($request->all());

        return redirect()->route('admin.ot-categories.index');
    }

    public function show(OtCategory $otCategory)
    {
        abort_if(Gate::denies('ot_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.otCategories.show', compact('otCategory'));
    }

    public function destroy(OtCategory $otCategory)
    {
        abort_if(Gate::denies('ot_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtCategoryRequest $request)
    {
        $otCategories = OtCategory::find(request('ids'));

        foreach ($otCategories as $otCategory) {
            $otCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
