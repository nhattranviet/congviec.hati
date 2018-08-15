var inputs = [];
var el = null;
var isBusy = false;
var modal = $('#address-modal');
$(document).on('focus', '#addressPicker', function (event) {
  event.preventDefault();
  el = $(this).parent();
  modal.find('.modal-title').text($(this).attr('placeholder'));
  modal.modal('show');
});

$('#saveChange').click(function (event) {
  /* Act on the event */

  loadAddress(el);

});

modal.find('#country').change(function (event) {
  /* Act on the event */
  getProvinces($(this).val());
  clearSelect('#district', 'Chọn Huyện');
  clearSelect('#ward', 'Chọn Xã');
  isBusy = false;
});

modal.find('#province').change(function (event) {
  /* Act on the event */

  getDistricts($(this).val());
  clearSelect('#ward', 'Chọn Xã');
  isBusy = false;
});

modal.find('#district').change(function (event) {
  /* Act on the event */
  getWards($(this).val());
  isBusy = false;
});





var loadAddress = function (el, data = null) {
  inputs = el.find('input[type=hidden]').toArray();

  if (data != null) {

    // put address name
    el.find('#' + inputs[0].id).attr('data-addr', data.country);
    el.find('#' + inputs[1].id).attr('data-addr', data.province);
    el.find('#' + inputs[2].id).attr('data-addr', data.district);
    el.find('#' + inputs[3].id).attr('data-addr', data.ward);
    el.find('#' + inputs[4].id).attr('data-addr', data.addressDetail);
  } else {
    // put address
    el.find('#' + inputs[0].id).val(modal.find('#country').val());
    el.find('#' + inputs[1].id).val(modal.find('#province').val());
    el.find('#' + inputs[2].id).val(modal.find('#district').val());
    el.find('#' + inputs[3].id).val(modal.find('#ward').val());
    el.find('#' + inputs[4].id).val(modal.find('#addressDetail').val());

    // put address name
    el.find('#' + inputs[0].id).attr('data-addr', modal.find('#country').find('option:selected').text());
    el.find('#' + inputs[1].id).attr('data-addr', modal.find('#province').find('option:selected').text());
    el.find('#' + inputs[2].id).attr('data-addr', modal.find('#district').find('option:selected').text());
    el.find('#' + inputs[3].id).attr('data-addr', modal.find('#ward').find('option:selected').text());
    el.find('#' + inputs[4].id).attr('data-addr', modal.find('#addressDetail').val());
  }


  var subAddr = "";

  // show address detail
  for (var i = 0; i < inputs.length; i++) {

    subAddr += el.find('#' + inputs[i].id).attr('data-addr');

    if (i < inputs.length - 1) {
      var noneNull = el.find('#' + inputs[i + 1].id).attr('data-addr') || "";
      if ($.trim(noneNull) != "") {
        subAddr += ' - ';
      }
    }
  }

  el.find('#addressPicker').val(subAddr);
}


$(document).on('click', '#clearAddress', function (event) {
  event.preventDefault();
  /* Act on the event */

  $(this).parent().find('#addressPicker').val('');

  inputs = $(this).parent().find('input[type=hidden]').toArray();

  for (var i = 0; i < inputs.length; i++) {
    $(this).parent().find('#' + inputs[i].id).val('');
    $(this).parent().find('#' + inputs[i].id).attr('data-addr', '');
  }

});

var getDistricts = function (id, val, func) {
  if (isBusy) { return; }
  clearSelect('#district', 'Chọn Huyện');
  $.ajax({
    url: '/nhan-khau/districts/' + id,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      if (func == undefined) {
        for (var i = 0; i < data.length; i++) {
          $('#district').append($('<option>', {
            value: data[i].id,
            text: data[i].name
          })).select2();
        }
        if (val != null) {
          isBusy = true;
          $('#district').val(val).change();
        }
      } else {
        func(data);
      }
    }
  })
}

var getWards = function (id, val, func) {
  if (isBusy) { return; }
  clearSelect('#ward', 'Chọn Xã');
  $.ajax({
    url: '/nhan-khau/wards/' + id,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      if (func == undefined) {
        for (var i = 0; i < data.length; i++) {
          $('#ward').append($('<option>', {
            value: data[i].id,
            text: data[i].name
          })).select2();
        }
        if (val != null) { $('#ward').val(val).change(); }
      } else {
        func(data);
      }
    }
  })
}

var getProvinces = function (id, val, func) {
  if (isBusy) { return; }
  clearSelect('#province', 'Chọn Tỉnh hoặc Thành Phố');
  $.ajax({
    url: '/nhan-khau/provinces/' + id,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      if (func == undefined) {
        for (var i = 0; i < data.length; i++) {
          $('#province').append($('<option>', {
            value: data[i].id,
            text: data[i].name
          })).select2();
        }
        if (val != null) {
          isBusy = true;
          $('#province').val(val).change();
        }
      } else {
        func(data);
      }
    }
  })
}

var clearSelect = function (el, text) {
  $(el).empty();
  $(el).append('<option value="">' + text + '</option>');
  $(el).select2();
}