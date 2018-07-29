@foreach($list_chucnang as $chucnang)
    <div class="col-xs-12 col-sm-2">
        <div class="checkbox checkbox-primary">
            <input class="chucnang_checkbox" name="idchucnang[]" id="{{ $chucnang->id }}" type="checkbox" value="{{ $chucnang->id }}" >
            <label for="checkbox">
                {{ $chucnang->name }}
            </label>
        </div>
        <input type="hidden" id="chucnang_level_{{ $chucnang->id }}" name="chucnang_level[]" value="" >
    </div>
@endforeach