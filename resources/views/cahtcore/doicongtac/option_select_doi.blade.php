<option value="">Chọn đội công tác</option>
@foreach ($list_doi as $doi)
    <option value="{{ $doi->id }}">{{ $doi->name }}</option>
@endforeach