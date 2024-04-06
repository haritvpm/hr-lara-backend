<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySectionRequest;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\OfficeLocation;
use App\Models\Seat;
use App\Models\Section;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sections = Section::with(['seat_of_controling_officer', 'seat_of_reporting_officer', 'office_location'])->get();

        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        abort_if(Gate::denies('section_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seat_of_controling_officers = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seat_of_reporting_officers = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $office_locations = OfficeLocation::pluck('location', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sections.create', compact('office_locations', 'seat_of_controling_officers', 'seat_of_reporting_officers'));
    }

    public function store(StoreSectionRequest $request)
    {
        $section = Section::create($request->all());

        return redirect()->route('admin.sections.index');
    }

    public function edit(Section $section)
    {
        abort_if(Gate::denies('section_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seat_of_controling_officers = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seat_of_reporting_officers = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $office_locations = OfficeLocation::pluck('location', 'id')->prepend(trans('global.pleaseSelect'), '');

        $section->load('seat_of_controling_officer', 'seat_of_reporting_officer', 'office_location');

        return view('admin.sections.edit', compact('office_locations', 'seat_of_controling_officers', 'seat_of_reporting_officers', 'section'));
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section->update($request->all());

        return redirect()->route('admin.sections.index');
    }

    public function show(Section $section)
    {
        abort_if(Gate::denies('section_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $section->load('seat_of_controling_officer', 'seat_of_reporting_officer', 'office_location', 'sectionAttendanceBooks');

        return view('admin.sections.show', compact('section'));
    }

    public function destroy(Section $section)
    {
        abort_if(Gate::denies('section_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $section->delete();

        return back();
    }

    public function massDestroy(MassDestroySectionRequest $request)
    {
        $sections = Section::find(request('ids'));

        foreach ($sections as $section) {
            $section->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
