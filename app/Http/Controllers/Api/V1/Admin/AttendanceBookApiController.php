<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendanceBookRequest;
use App\Http\Requests\UpdateAttendanceBookRequest;
use App\Http\Resources\Admin\AttendanceBookResource;
use App\Models\AttendanceBook;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceBookApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendance_book_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendanceBookResource(AttendanceBook::with(['section'])->get());
    }

    public function store(StoreAttendanceBookRequest $request)
    {
        $attendanceBook = AttendanceBook::create($request->all());

        return (new AttendanceBookResource($attendanceBook))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AttendanceBook $attendanceBook)
    {
        abort_if(Gate::denies('attendance_book_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendanceBookResource($attendanceBook->load(['section']));
    }

    public function update(UpdateAttendanceBookRequest $request, AttendanceBook $attendanceBook)
    {
        $attendanceBook->update($request->all());

        return (new AttendanceBookResource($attendanceBook))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AttendanceBook $attendanceBook)
    {
        abort_if(Gate::denies('attendance_book_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceBook->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
