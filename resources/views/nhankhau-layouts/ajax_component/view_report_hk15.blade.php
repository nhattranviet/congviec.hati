@include('commons.word_css')
<table class="head">
    <tr>
        <td class="center" style="width: 250px" valign="top" >
            CÔNG AN TỈNH HÀ TĨNH<br>
            <span class="daumuc">CÔNG AN HUYỆN KỲ ANH</span>
        </td>
        <td  class="center">
            <span class="daumuc">THỐNG KÊ TÌNH HÌNH, KẾT QUẢ ĐĂNG KÝ, QUẢN LÝ CƯ TRÚ</span><br>
            <span class="italic">(từ ngày {{ $tungay }} đến ngày {{ $denngay }} )</span>
        </td>
        <td class="center" style="width: 170px" valign="top" >
            Mẫu HK15 ban hành theo TT số 36/2014/TT-BCA ngày 09/9/2014
        </td>
    </tr>
</table>
<br>
<span class="daumuc">I. HỘ, NHÂN KHẨU ĐĂNG KÝ THƯỜNG TRÚ:</span> <br>
Tổng số: {{ $thuongtru_tongsoho + $tamtru_tongso_ho - $khongcutru_ho }}  hộ; {{ $thuongtru_tongnhankhau + $tamtru_tongso_nhankhau - $khongcutru_nhankhau }} nhân khẩu <br>
Trong đó: {{ $thuongtru_count_thanhthi + $tamtru_count_thanhthi - $khongcutru_nhankhauthanhthi }}  nhân khẩu thành thị; {{ $thuongtru_gioitinh_nu + $tamtru_gioitinh_nu - $khongcutru_nhankhaunu }} nhân khẩu nữ; {{ $thuongtru_nk_better_14 + $tamtru_nk_better_14_total - $khongcutru_nhankhautu14 }} nhân khẩu từ 14 tuổi trở lên.
<br>
    <span class="daumuc">II. CÁC LOẠI HỘ, NHÂN KHẨU</span><br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="10" class="daumuc">HỘ, NHÂN KHẨU ĐĂNG KÝ THƯỜNG TRÚ</td>
            </tr>
            <tr>
                <td colspan="5" rowspan="2" class="daumuc">TỔNG SỐ</td>
                <td colspan="5" class="daumuc">KHÔNG CƯ TRÚ TẠI NƠI ĐÃ ĐĂNG KÝ THƯỜNG TRÚ</td>
            </tr>
            <tr>
                <td colspan="2">Tổng số</td>
                <td rowspan="2">NK Thành thị</td>
                <td rowspan="2">NK Nữ</td>
                <td rowspan="2">NK từ 14 tuổi trở lên</td>
            </tr>
            <tr>
                <td>Hộ</td>
                <td>NK</td>
                <td>NK Thành thị</td>
                <td>NK Nữ</td>
                <td>NK từ 14 tuổi trở lên</td>
                <td>Hộ</td>
                <td>NK</td>
            </tr>

            <tr>
                <td>{{ $thuongtru_tongsoho }}</td>
                <td>{{ $thuongtru_tongnhankhau }}</td>
                <td>{{ $thuongtru_count_thanhthi }}</td>
                <td>{{ $thuongtru_gioitinh_nu }}</td>
                <td>{{ $thuongtru_nk_better_14 }}</td>
                <td>{{ $khongcutru_ho }}</td>
                <td>{{ $khongcutru_nhankhau }}</td>
                <td>{{ $khongcutru_nhankhauthanhthi }}</td>
                <td>{{ $khongcutru_nhankhaunu }}</td>
                <td>{{ $khongcutru_nhankhautu14 }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td colspan="15" class="daumuc">HỘ, NHÂN KHẨU ĐĂNG KÝ THƯỜNG TRÚ</td>
        </tr>
        <tr>
            <td colspan="15" class="daumuc">KHÔNG CƯ TRÚ TẠI NƠI ĐÃ ĐĂNG KÝ THƯỜNG TRÚ</td>
        </tr>
        <tr>
            <td colspan="5">Đi ngoài tỉnh</td>
            <td colspan="5">Đi ngoài huyện trong tỉnh</td>
            <td colspan="5">Đi ngoài xã trong huyện</td>
        </tr>
        <tr>
            <td colspan="2">Tổng số</td>
            <td rowspan="2">NK Thành thị</td>
            <td rowspan="2">NK Nữ</td>
            <td rowspan="2">NK từ 14 tuổi trở lên</td>
            <td colspan="2">Tổng số</td>
            <td rowspan="2">NK Thành thị</td>
            <td rowspan="2">NK Nữ</td>
            <td rowspan="2">NK từ 14 tuổi trở lên</td>
            <td colspan="2">Tổng số</td>
            <td rowspan="2">NK Thành thị</td>
            <td rowspan="2">NK Nữ</td>
            <td rowspan="2">NK từ 14 tuổi trở lên</td>
        </tr>
        <tr>
            <td>Hộ</td>
            <td>NK</td>
            <td>Hộ</td>
            <td>NK</td>
            <td>Hộ</td>
            <td>NK</td>
        </tr>
        <tr>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
            <td valign="top"></td>
        </tr>
    </tbody>
</table>
    <br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="15" class="daumuc"> HỘ, NHÂN KHẨU ĐĂNG KÝ TẠM TRÚ</td>
            </tr>
            <tr>
                <td colspan="2">Tổng số</td>
                <td rowspan="3">NK Thành thị</td>
                <td rowspan="3">NK Nữ</td>
                <td rowspan="3"> NK từ 14 tuổi trởlên</td>
                <td colspan="5">Ngoài tỉnh đến</td>
                <td colspan="5"> Ngoài huyện trong tỉnh đến</td>
            </tr>
            <tr>
                <td rowspan="2">Hộ</td>
                <td rowspan="2">NK</td>
                <td colspan="2">Tổng số</td>
                <td rowspan="2">NK Thành thị</td>
                <td rowspan="2">NK Nữ</td>
                <td rowspan="2"> NK từ 14 tuổi trởlên</td>
                <td colspan="2">Tổng số</td>
                <td rowspan="2">NK Thành thị</td>
                <td rowspan="2">NK Nữ</td>
                <td rowspan="2"> NK từ 14 tuổi trởlên</td>
            </tr>
            <tr>
                <td>Hộ</td>
                <td>NK</td>
                <td>Hộ</td>
                <td>NK</td>
            </tr>
            <tr>
                <td>{{ $tamtru_tongso_ho }}</td>
                <td>{{ $tamtru_tongso_nhankhau }}</td>
                <td>{{ $tamtru_count_thanhthi }}</td>
                <td>{{ $tamtru_gioitinh_nu }}</td>
                <td>{{ $tamtru_nk_better_14_total }}</td>
                <td>{{ $tamtru_ngoaitinhden_ho }}</td>
                <td>{{ $tamtru_ngoaitinhden_nk }}</td>
                <td>{{ $tamtru_ngoaitinhden_nk_thanhthi }}</td>
                <td>{{ $tamtru_ngoaitinhden_nk_nu }}</td>
                <td>{{ $tamtru_ngoaitinhden_nk_tren_14 }}</td>
                <td>{{ $tamtru_ngoaitinh_tronghuyen_den_ho }}</td>
                <td>{{ $tamtru_ngoaitinh_tronghuyen_den_nk }}</td>
                <td>{{ $tamtru_ngoaitinh_tronghuyenden_nk_thanhthi }}</td>
                <td>{{ $tamtru_ngoaitinh_tronghuyen_nk_nu }}</td>
                <td>{{ $tamtru_ngoaitinh_tronghuyen_nk_tren_14 }}</td>
            </tr>
        </tbody>
    </table>
    <br>

    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="5" class="daumuc">HỘ, NHÂN KHẨU ĐĂNG KÝ TẠM TRÚ</td>
                <td colspan="4" class="daumuc">NHÂN KHẨU LƯU TRÚ</td>
                <td colspan="2" class="daumuc">NHÂN KHẨU TẠM VẮNG</td>
                <td rowspan="4" class="daumuc">ĐỐI TƯỢNG QUẢN LÝ</td>
            </tr>
            <tr>
                <td colspan="5">Ngoài xã trong tỉnhđến</td>
                <td rowspan="3">Tổng số</td>
                <td colspan="3">Trong đó</td>
                <td rowspan="3">Tổng số</td>
                <td rowspan="3">Nữ</td>
            </tr>
            <tr>
                <td colspan="2">Tổng số</td>
                <td rowspan="2">NK Thành thị</td>
                <td rowspan="2">NK Nữ</td>
                <td rowspan="2">NK từ 14 tuổi trởlên</td>
                <td rowspan="2">Hộ gia đình</td>
                <td rowspan="2">Cơ sở cho thuê lưutrú</td>
                <td rowspan="2">Nữ</td>
            </tr>
            <tr>
                <td>Hộ</td>
                <td>NK</td>
            </tr>
            <tr>
                <td>{{ $tamtru_ngoaixa_trongtinh_den_ho }}</td>
                <td>{{ $tamtru_ngoaixa_trongtinh_den_nk }}</td>
                <td>{{ $tamtru_ngoaixa_trongtinh_den_nk_thanhthi }}</td>
                <td>{{ $tamtru_ngoaixa_trongtinh_den_nk_nu }}</td>
                <td>{{ $tamtru_ngoaixa_trongtinh_den_nk_tren_14 }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <br>
    <span class="daumuc">III. KẾT QUẢ ĐĂNG KÝ, QUẢN LÝ CƯ TRÚ</span><br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="6" class="daumuc">ĐĂNG KÝ THƯỜNG TRÚ</td>
                <td colspan="7" class="daumuc">XÓA ĐĂNG KÝ THƯỜNGTRÚ</td>
            </tr>
            <tr>
                <td colspan="2">Tổng số</td>
                <td rowspan="2">NK mới sinh</td>
                <td colspan="2">Ngoài tỉnh đến</td>
                <td rowspan="2">Định cư ở nước ngoài về (NK)</td>
                <td colspan="2">Tổng số</td>
                <td colspan="5">Trong đó</td>
            </tr>
            <tr>
                <td>Hộ</td>
                <td>NK</td>
                <td>Hộ</td>
                <td>NK</td>
                <td>Hộ</td>
                <td>NK</td>
                <td>Chết, mất tích</td>
                <td>Tuyển dụng vào CA, QĐ</td>
                <td>Hủy kết quả đăng ký</td>
                <td>Định cư ở nước ngoài về</td>
                <td>Đăng ký thường trú nơi cư trú mới</td>
            </tr>
            <tr>
                <td>{{ $thuongtru_ho_capmoi + $thuongtru_ho_tach }}</td>
                <td>{{ $thuongtru_nk_dangky }}</td>
                <td>{{ $thuongtru_nk_moisinh }}</td>
                <td>{{ $thuongtru_ho_ngoaitinh }}</td>
                <td>{{ $thuongtru_nk_ngoaitinh }}</td>
                <td>{{ $thuongtru_nk_ngoainuoc }}</td>
                <td>{{ $thuongtru_ho_xoa }}</td>
                <td>{{ $thuongtru_nk_xoa }}</td>
                <td>{{ $thuongtru_nk_chet }}</td>
                <td>{{ $thuongtru_nk_caqd }}</td>
                <td>{{ $thuongtru_nk_huy }}</td>
                <td></td>
                <td>{{ $thuongtru_nk_dangkynoimoi }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="info"  border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="4" class="daumuc">CẤP GIẤY CHUYỂN HỘ KHẨU</td>
                <td colspan="5" class="daumuc">CẤP MỚI, CẤP LẠI, CẤP ĐỔI, TÁCH SỔ HỘ KHẨU</td>
                <td rowspan="3" class="daumuc">ĐIỀU CHỈNH THAY ĐỔI (trường hợp)</td>
            </tr>
            <tr>
                <td colspan="2">Tổng số</td>
                <td colspan="2">Đi ngoài tỉnh</td>
                <td rowspan="2">Tổng số</td>
                <td colspan="4">Trong đó</td>
            </tr>
            <tr>
                <td>Hộ</td>
                <td>NK</td>
                <td>Hộ</td>
                <td>NK</td>
                <td>Cấp mới</td>
                <td>Cấp lại</td>
                <td>Cấp đổi</td>
                <td>Tách Sổ</td>
            </tr>
            <tr>
                <td>{{ $thuongtru_ho_dangkynoimoi }}</td>
                <td>{{ $thuongtru_nk_dangkynoimoi }}</td>
                <td>{{ $thuongtru_ho_chuyenkhau_ngoaitinh }}</td>
                <td>{{ $thuongtru_nk_chuyenkhau_ngoaitinh }}</td>
                <td>{{ $thuongtru_ho_capmoi + $thuongtru_ho_caplai + $thuongtru_ho_capdoi + $thuongtru_ho_tach }}</td>
                <td>{{ $thuongtru_ho_capmoi }}</td>
                <td>{{ $thuongtru_ho_caplai }}</td>
                <td>{{ $thuongtru_ho_capdoi }}</td>
                <td>{{ $thuongtru_ho_tach }}</td>
                <td>{{ $thuongtru_nk_dieuchinhthaydoi }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="6" class="daumuc">ĐĂNG KÝ TẠM TRÚ</td>
                <td colspan="4" class="daumuc">TIẾP NHẬN THÔNG BÁO LƯU TRÚ</td>
                <td colspan="2" class="daumuc">KHAI BÁO TẠM VẮNG</td>
            </tr>
            <tr>
                <td colspan="2">Tổng số</td>
                <td colspan="2">Ngoài tỉnh đến</td>
                <td rowspan="2">Cấp Sổ tạm trú</td>
                <td rowspan="2">Gia hạn tạm trú</td>
                <td rowspan="2">Tổng số (NK)</td>
                <td colspan="3">Hình thức thông báo</td>
                <td rowspan="2">Tổng số</td>
                <td rowspan="2">Nữ</td>
            </tr>
            <tr>
                <td>Hộ</td>
                <td>NK</td>
                <td>Hộ</td>
                <td>NK</td>
                <td>Trực tiếp</td>
                <td>Điện thoại</td>
                <td>Qua mạng</td>
            </tr>
            <tr>
                <td>{{ $tamtru_dangky_ho }}</td>
                <td>{{ $tamtru_dangky_nk }}</td>
                <td>{{ $tamtru_ngoaitinhden_dangky_ho }}</td>
                <td>{{ $tamtru_ngoaitinhden_dangky_nk }}</td>
                <td>{{ ($tamtru_dangky_ho + $tamtru_dangky_canhan_so) }}</td>
                <td>{{ $tamtru_giahantamtru_nk }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <br>
    <span class="daumuc">IV. KIỂM TRA, XỬ LÝ VI PHẠM VÀ GIẢI QUYẾT KHIẾU NẠI, TỐ CÁO</span><br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="4" class="daumuc">KIỂM TRA CƯ TRÚ</td>
                <td colspan="5" class="daumuc">XỬ LÝ VI PHẠM</td>
                <td colspan="4" class="daumuc">GIẢI QUYẾT KHIẾU NẠI, TỐ CÁO (trường hợp)</td>
            </tr>
            <tr>
                <td rowspan="3">Tổng số (lượt)</td>
                <td colspan="3">Trong đó</td>
                <td rowspan="3">Tổng số</td>
                <td colspan="4">Trong đó</td>
                <td width="145" colspan="2">Khiếu nại</td>
                <td width="145" colspan="2">Tố cáo</td>
            </tr>
            <tr>
                <td rowspan="2">Hộ gia đình</td>
                <td rowspan="2">Cơ sở cho thuê lưu trú</td>
                <td rowspan="2">Cơ sở khác</td>
                <td rowspan="2">Cảnh cáo</td>
                <td colspan="2">Phạt tiền</td>
                <td rowspan="2">Hủy kết quả đăng ký</td>
                <td rowspan="2">Nhận</td>
                <td rowspan="2">Giải quyết</td>
                <td rowspan="2">Nhận</td>
                <td rowspan="2">Giải quyết</td>
            </tr>
            <tr>
                <td>Trường hợp</td>
                <td>Số tiền</td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <span class="daumuc">V. CÔNG TÁC TÀNG THƯ HỒ SƠ HỘ KHẨU:</span><br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="11" class="daumuc" >KẾT QUẢ CÔNG TÁC TÀNG THƯ HỒ SƠ HỘ KHẨU</td>
                <td colspan="6" class="daumuc">PHƯƠNG TIỆN, NƠI LƯU TRỮ</td>
            </tr>
            <tr>
                <td colspan="2">Hồ sơ hộ khẩu đã lập</td>
                <td rowspan="3">Số Phiếu HK06 đã lập</td>
                <td colspan="3">Cập nhật thông tin HKNK</td>
                <td rowspan="3">Nhận HSHK đến</td>
                <td rowspan="3">Chuyển HSHK đi</td>
                <td colspan="3">Tra cứu, khai thác thông tin</td>
                <td colspan="2">Tủ, giá hồ sơ</td>
                <td colspan="2">Máy vi tính</td>
                <td colspan="2">Diện tích nơi lưu trữ</td>
            </tr>
            <tr>
                <td rowspan="2">Hộ</td>
                <td rowspan="2">Nhân khẩu</td>
                <td rowspan="2">Tổng số</td>
                <td colspan="2">Trong đó</td>
                <td rowspan="2">Tổng số</td>
                <td colspan="2">Trong đó</td>
                <td rowspan="2">Hiện có</td>
                <td rowspan="2">Thiếu</td>
                <td rowspan="2">Hiện có</td>
                <td rowspan="2">Thiếu</td>
                <td rowspan="2">Diện tích (m<sup>2</sup>)</td>
                <td rowspan="2">Thiếu (m<sup>2</sup>)</td>
            </tr>
            <tr>
                <td>Bản khai NK</td>
                <td>Thông tin về đối tượng</td>
                <td>ĐKQL cư trú</td>
                <td>Yêu cầu nghiệp vụ</td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="head" width="100%">
        <tr>
            <td class="center" style="width: 50%" valign="top"></td>
            <td> <span class="italic">Hà Tĩnh, ngày.....tháng.....năm.....</span> </td>
        </tr>
    <tr>
        <td valign="top" style="width: 50%">
            <span class="daumuc">CÁN BỘ LẬP THỐNG KÊ</span><br>
            <span class="italic">(ký, ghi rõ họ tên)</span>
        </td>
        <td valign="top" class="center">
            <span class="daumuc">TRƯỞNG CÔNG AN HUYỆN</span>
        </td>
    </tr>
</table>