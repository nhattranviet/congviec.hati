<option value="">Chọn đội công tác</option>
@foreach ($list_canbo as $canbo)
    <option value="{{ $canbo->id }}">{{ $canbo->hoten .' - '.$canbo->tenchucvu }} </option>
@endforeach