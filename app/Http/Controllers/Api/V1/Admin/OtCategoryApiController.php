<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOtCategoryRequest;
use App\Http\Requests\UpdateOtCategoryRequest;
use App\Http\Resources\Admin\OtCategoryResource;
use App\Models\OtCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ot_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtCategoryResource(OtCategory::all());
    }

    public function store(StoreOtCategoryRequest $request)
    {
        $otCategory = OtCategory::create($request->all());

        return (new OtCategoryResource($otCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OtCategory $otCategory)
    {
        abort_if(Gate::denies('ot_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtCategoryResource($otCategory);
    }

    public function update(UpdateOtCategoryRequest $request, OtCategory $otCategory)
    {
        $otCategory->update($request->all());

        return (new OtCategoryResource($otCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OtCategory $otCategory)
    {
        abort_if(Gate::denies('ot_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
