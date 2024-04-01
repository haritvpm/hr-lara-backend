<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAttendanceBookRequest;
use App\Http\Requests\StoreAttendanceBookRequest;
use App\Http\Requests\UpdateAttendanceBookRequest;
use App\Models\AttendanceBook;
use App\Models\Section;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceBookController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendance_book_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceBooks = AttendanceBook::with(['section'])->get();

        return view('admin.attendanceBooks.index', compact('attendanceBooks'));
    }

    public function create()
    {
        abort_if(Gate::denies('attendance_book_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.attendanceBooks.create', compact('sections'));
    }

    public function store(StoreAttendanceBookRequest $request)
    {
        $attendanceBook = AttendanceBook::create($request->all());

        return redirect()->route('admin.attendance-books.index');
    }

    public function edit(AttendanceBook $attendanceBook)
    {
        abort_if(Gate::denies('attendance_book_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendanceBook->load('section');

        return view('admin.attendanceBooks.edit', compact('attendanceBook', 'sections'));
    }

    public function update(UpdateAttendanceBookRequest $request, AttendanceBook $attendanceBook)
    {
        $attendanceBook->update($request->all());

        return redirect()->route('admin.attendance-books.index');
    }

    public function show(AttendanceBook $attendanceBook)
    {
        abort_if(Gate::denies('attendance_book_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceBook->load('section');

        return view('admin.attendanceBooks.show', compact('attendanceBook'));
    }

    public function destroy(AttendanceBook $attendanceBook)
    {
        abort_if(Gate::denies('attendance_book_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendanceBook->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttendanceBookRequest $request)
    {
        $attendanceBooks = AttendanceBook::find(request('ids'));

        foreach ($attendanceBooks as $attendanceBook) {
            $attendanceBook->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
