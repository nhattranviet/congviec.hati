/**
 * Theme: Uplon Admin Template
 * Author: Coderthemes
 * Email: coderthemes@gmail.com
 * File Uploads
 */

$(document).ready(function () {

    'use-strict';

    var modal = $('#nhatkycanbo-modal');
    $(document).on("click", "#checkAll", function () {
        $('.nhatky').prop('checked', this.checked);
    });

    $(document).on("click", ".editNhatkyCB", function (event) {
        event.preventDefault();
        $("#wait").css("display", "block");
        var idnhatky = $(this).attr('nhatky_id');
        var ngay = $("tr[tr_id=" + idnhatky + "] td.ngay").text();
        CKEDITOR.instances.noidungdukien.setData($("tr[tr_id=" + idnhatky + "] td.noidung").html());
        CKEDITOR.instances.ketquathuchien.setData($("tr[tr_id=" + idnhatky + "] td.ketqua").html());
        $("#ngay").val(ngay);
        $('h4.modal-title').text('Sửa nhật ký cán bộ');
        $("#idnhatky_hidden").val(idnhatky);
        $("#wait").css("display", "none");
        modal.modal('show');

    });

    $("#submitBtnUpdateCB").on("click", function (event) {
        event.preventDefault();
        $("#wait").css("display", "block");
        var current_form = $(this).parents("form");
        var idnhatky = $("#idnhatky_hidden").val()
        var data_send = {
            idnhatky: idnhatky,
            noidungdukien: CKEDITOR.instances.noidungdukien.getData(),
            ketquathuchien: CKEDITOR.instances.ketquathuchien.getData()
        };
        $.ajax({
            url: current_form.attr("action"),
            type: "GET",
            data: data_send,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "json",
            success: function (data) {
                $("#wait").css("display", "none");
                $("#error-msg").css("display", "none");

                if ($.isEmptyObject(data.error)) {
                    $("tr[tr_id=" + idnhatky + "] td.noidung").html(data_send.noidungdukien);
                    $("tr[tr_id=" + idnhatky + "] td.ketqua").html(data_send.ketquathuchien);
                    modal.modal('hide');
                    Command: toastr["success"](data.success);
                } else {
                    printMsg("#error-msg", data.error[0]);
                }

            },
            error: function (data) {
                $("#wait").css("display", "none");
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(data.responseText);
                });
            }
        });
    });
});