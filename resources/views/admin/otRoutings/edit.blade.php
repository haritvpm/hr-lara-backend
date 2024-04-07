@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.otRouting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ot-routings.update", [$otRouting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="from_seat_id">{{ trans('cruds.otRouting.fields.from_seat') }}</label>
                <select class="form-control select2 {{ $errors->has('from_seat') ? 'is-invalid' : '' }}" name="from_seat_id" id="from_seat_id">
                    @foreach($from_seats as $id => $entry)
                        <option value="{{ $id }}" {{ (old('from_seat_id') ? old('from_seat_id') : $otRouting->from_seat->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('from_seat'))
                    <span class="text-danger">{{ $errors->first('from_seat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.from_seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="to_seats">{{ trans('cruds.otRouting.fields.to_seats') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('to_seats') ? 'is-invalid' : '' }}" name="to_seats[]" id="to_seats" multiple>
                    @foreach($to_seats as $id => $to_seat)
                        <option value="{{ $id }}" {{ (in_array($id, old('to_seats', [])) || $otRouting->to_seats->contains($id)) ? 'selected' : '' }}>{{ $to_seat }}</option>
                    @endforeach
                </select>
                @if($errors->has('to_seats'))
                    <span class="text-danger">{{ $errors->first('to_seats') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.to_seats_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_forwarded_to">{{ trans('cruds.otRouting.fields.last_forwarded_to') }}</label>
                <input class="form-control {{ $errors->has('last_forwarded_to') ? 'is-invalid' : '' }}" type="text" name="last_forwarded_to" id="last_forwarded_to" value="{{ old('last_forwarded_to', $otRouting->last_forwarded_to) }}">
                @if($errors->has('last_forwarded_to'))
                    <span class="text-danger">{{ $errors->first('last_forwarded_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.last_forwarded_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="js_as_ss_id">{{ trans('cruds.otRouting.fields.js_as_ss') }}</label>
                <select class="form-control select2 {{ $errors->has('js_as_ss') ? 'is-invalid' : '' }}" name="js_as_ss_id" id="js_as_ss_id">
                    @foreach($js_as_sses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('js_as_ss_id') ? old('js_as_ss_id') : $otRouting->js_as_ss->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('js_as_ss'))
                    <span class="text-danger">{{ $errors->first('js_as_ss') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.js_as_ss_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection