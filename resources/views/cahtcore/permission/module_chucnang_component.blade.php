@foreach($list_chucnang as $chucnang)
    @if (in_array( $chucnang->id, $arr_list_chucnang ))
        <div class="col-xs-12 col-sm-2">
            <div class="checkbox checkbox-primary">
                <input class="chucnang_checkbox" id="{{ $chucnang->id }}" checked type="checkbox" value="{{ $chucnang->id }}" >
                <label for="checkbox">
                    {{ $chucnang->name }}
                </label>
            </div>
            <fieldset class="form-group">
                <input readonly type="text" name="so_dktt_toso" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_toso" value="{{ config('user_config.level_info')[$list_chucnang_db[$chucnang->id]] }}">
            </fieldset>
            <input type="hidden" id="chucnang_{{ $chucnang->id }}" name="chucnang[]" value="{{ $chucnang->id }}" >
            <input type="hidden" id="chucnang_level_{{ $chucnang->id }}" name="chucnang_level[]" value="{{ $list_chucnang_db[$chucnang->id] }}" >
        </div>
        
    @else
        <div class="col-xs-12 col-sm-2">
            <div class="checkbox checkbox-primary">
                <input class="chucnang_checkbox" id="{{ $chucnang->id }}" type="checkbox" value="{{ $chucnang->id }}" >
                <label for="checkbox">
                    {{ $chucnang->name }}
                </label>
            </div>
            <fieldset class="form-group">
                <input type="text" name="so_dktt_toso" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_toso" value="">
            </fieldset>
            <input type="hidden" id="chucnang_{{ $chucnang->id }}" name="chucnang[]" value="" >
            <input type="hidden" id="chucnang_level_{{ $chucnang->id }}" name="chucnang_level[]" value="" >
        </div>
    @endif



    
@endforeach