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
                <label class="required" for="seat_id">{{ trans('cruds.otRouting.fields.seat') }}</label>
                <select class="form-control select2 {{ $errors->has('seat') ? 'is-invalid' : '' }}" name="seat_id" id="seat_id" required>
                    @foreach($seats as $id => $entry)
                        <option value="{{ $id }}" {{ (old('seat_id') ? old('seat_id') : $otRouting->seat->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat'))
                    <span class="text-danger">{{ $errors->first('seat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="routing_seats">{{ trans('cruds.otRouting.fields.routing_seats') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('routing_seats') ? 'is-invalid' : '' }}" name="routing_seats[]" id="routing_seats" multiple>
                    @foreach($routing_seats as $id => $routing_seat)
                        <option value="{{ $id }}" {{ (in_array($id, old('routing_seats', [])) || $otRouting->routing_seats->contains($id)) ? 'selected' : '' }}>{{ $routing_seat }}</option>
                    @endforeach
                </select>
                @if($errors->has('routing_seats'))
                    <span class="text-danger">{{ $errors->first('routing_seats') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.routing_seats_helper') }}</span>
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
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection