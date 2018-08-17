<table>
    <tr>
        <td>
            CÔNG AN TỈNH HÀ TĨNH<br>
            CÔNG AN HUYỆN KỲ ANH
        </td>
        <td>
            THỐNG KÊ TÌNH HÌNH, KẾT QUẢ ĐĂNG KÝ, QUẢN LÝ CƯ TRÚ<br>
            (từ ngày 15/07/2018 đến ngày 15/08/2018 )
        </td>
    </tr>
</table>

<h5>I) HỘ, NHÂN KHẨU ĐĂNG KÝ THƯỜNG TRÚ:</h5>
<p>Tổng số: {{ $thuongtru_tongsoho + $this->tamtru_tongso_ho - $request->khongcutru_ho }}  hộ; ($thuongtru_tongnhankhau + $this->tamtru_tongso_nhankhau - $request->khongcutru_nhankhau) nhân khẩu</p>
<p>Trong đó: ($thuongtru_count_thanhthi + $this->tamtru_count_thanhthi - $request->khongcutru_nhankhauthanhthi)  NK thành thị; ( $thuongtru_gioitinh_nu + $this->tamtru_gioitinh_nu - $request->khongcutru_nhankhaunu ) NK nữ; ( $thuongtru_nk_better_14 + $this->tamtru_nk_better_14_total - $request->khongcutru_nhankhautu14 ) NK từ 14 tuổi trở lên.</p>';

$html_table .= '<h5>II) CÁC LOẠI HỘ, NHÂN KHẨU</h5>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="10">HỘ, NHÂN KHẨU ĐĂNG KÝ THƯỜNG TRÚ</td>
            </tr>
            <tr>
                <td colspan="5" rowspan="2">TỔNG SỐ</td>
                <td colspan="5">KHÔNG CƯ TRÚ TẠI NƠI ĐÃ ĐĂNG KÝ THƯỜNG TRÚ</td>
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
                <td>$thuongtru_tongsoho</td>
                <td>$thuongtru_tongnhankhau</td>
                <td>$thuongtru_count_thanhthi</td>
                <td>$thuongtru_gioitinh_nu</td>
                <td>$thuongtru_nk_better_14</td>
                <td>$request->khongcutru_ho</td>
                <td>$request->khongcutru_nhankhau</td>
                <td>$request->khongcutru_nhankhauthanhthi</td>
                <td>$request->khongcutru_nhankhaunu</td>
                <td>$request->khongcutru_nhankhautu14</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="15"> HỘ, NHÂN KHẨU ĐĂNG KÝ TẠM TRÚ</td>
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
                <td>$this->tamtru_tongso_ho</td>
                <td>$this->tamtru_tongso_nhankhau</td>
                <td>$this->tamtru_count_thanhthi</td>
                <td>$this->tamtru_gioitinh_nu</td>
                <td>$this->tamtru_nk_better_14_total</td>
                <td>$this->tamtru_ngoaitinhden_ho</td>
                <td>$this->tamtru_ngoaitinhden_nk</td>
                <td>$this->tamtru_ngoaitinhden_nk_thanhthi</td>
                <td>$this->tamtru_ngoaitinhden_nk_nu</td>
                <td>$this->tamtru_ngoaitinhden_nk_tren_14</td>
                <td>$this->tamtru_ngoaitinh_tronghuyen_den_ho</td>
                <td>$this->tamtru_ngoaitinh_tronghuyen_den_nk</td>
                <td>$this->tamtru_ngoaitinh_tronghuyenden_nk_thanhthi</td>
                <td>$this->tamtru_ngoaitinh_tronghuyen_nk_nu</td>
                <td>$this->tamtru_ngoaitinh_tronghuyen_nk_tren_14</td>
            </tr>
        </tbody>
    </table>
    <br>

    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="5">HỘ, NHÂN KHẨU ĐĂNG KÝ TẠM TRÚ</td>
                <td colspan="4">NHÂN KHẨU LƯU TRÚ</td>
                <td colspan="2">NHÂN KHẨU TẠM VẮNG</td>
                <td rowspan="4">ĐỐI TƯỢNG QUẢN LÝ</td>
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
                <td>$this->tamtru_ngoaixa_trongtinh_den_ho</td>
                <td>$this->tamtru_ngoaixa_trongtinh_den_nk</td>
                <td>$this->tamtru_ngoaixa_trongtinh_den_nk_thanhthi</td>
                <td>$this->tamtru_ngoaixa_trongtinh_den_nk_nu</td>
                <td>$this->tamtru_ngoaixa_trongtinh_den_nk_tren_14</td>
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
    <h5>III) KẾT QUẢ ĐĂNG KÝ, QUẢN LÝ CƯ TRÚ</h5>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="6">ĐĂNG KÝ THƯỜNG TRÚ</td>
                <td colspan="7">XÓA ĐĂNG KÝ THƯỜNGTRÚ</td>
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
                <td>($this->thuongtru_ho_capmoi + $this->thuongtru_ho_tach)</td>
                <td>$this->thuongtru_nk_dangky</td>
                <td>$this->thuongtru_nk_moisinh</td>
                <td>$this->thuongtru_ho_ngoaitinh</td>
                <td>$this->thuongtru_nk_ngoaitinh</td>
                <td>$this->thuongtru_nk_ngoainuoc</td>
                <td>$this->thuongtru_ho_xoa</td>
                <td>$this->thuongtru_nk_xoa</td>
                <td>$this->thuongtru_nk_chet</td>
                <td>$this->thuongtru_nk_caqd</td>
                <td>$this->thuongtru_nk_huy</td>
                <td>0</td>
                <td>$this->thuongtru_nk_dangkynoimoi</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="info"  border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="4">CẤP GIẤY CHUYỂN HỘ KHẨU</td>
                <td colspan="5">CẤP MỚI, CẤP LẠI, CẤP ĐỔI, TÁCH SỔ HỘ KHẨU</td>
                <td rowspan="3">ĐIỀU CHỈNH THAY ĐỔI (trường hợp)</td>
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
                <td>$this->thuongtru_ho_dangkynoimoi</td>
                <td>$this->thuongtru_nk_dangkynoimoi</td>
                <td>$this->thuongtru_ho_chuyenkhau_ngoaitinh</td>
                <td>$this->thuongtru_nk_chuyenkhau_ngoaitinh</td>
                <td>( $this->thuongtru_ho_capmoi + $this->thuongtru_ho_caplai + $this->thuongtru_ho_capdoi + $this->thuongtru_ho_tach )</td>
                <td>$this->thuongtru_ho_capmoi</td>
                <td>$this->thuongtru_ho_caplai</td>
                <td>$this->thuongtru_ho_capdoi</td>
                <td>$this->thuongtru_ho_tach</td>
                <td>$this->thuongtru_nk_dieuchinhthaydoi</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="info" border="1" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td colspan="6">ĐĂNG KÝ TẠM TRÚ</td>
                <td colspan="4">
                    TIẾP NHẬN THÔNG BÁOLƯU TRÚ</td>
                <td colspan="2">KHAI BÁO TẠM VẮNG</td>
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
                <td>$this->tamtru_dangky_ho</td>
                <td>$this->tamtru_dangky_nk</td>
                <td>$this->tamtru_ngoaitinhden_dangky_ho</td>
                <td>$this->tamtru_ngoaitinhden_dangky_nk</td>
                <td>($this->tamtru_dangky_ho + $this->tamtru_dangky_canhan_so)</td>
                <td>$this->tamtru_giahantamtru_nk</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>