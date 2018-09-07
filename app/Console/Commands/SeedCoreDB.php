<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class SeedCoreDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "import {module}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import default Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $data_config_nhomquyen = array(
			["key" => "idnhomquyen_canbo", 'value' => 1],
			["key" => "idnhomquyen_doipho", 'value' => 2],
			["key" => "idnhomquyen_doitruong", 'value' => 3],
			["key" => "idnhomquyen_capphodonvi", 'value' => 4],
			["key" => "idnhomquyen_captruongdonvi", 'value' => 5],
			["key" => "idnhomquyen_khach", 'value' => 6],
			["key" => "idnhomquyen_administrator", 'value' => 7],
        );
    
    public $data_level_role = array(
			["name" => "Cấp cán bộ", "keyword" => "idcanbo"],
			["name" => "Cấp đội thuộc quyền", "keyword" => "id_iddonvi_iddoi"],
			["name" => "Tất cả", "keyword" => ""],
        );
    
    public $data_modules = array(
			["name" => "Công việc"],
			["name" => "Nhật ký công tác"],
			["name" => "Lịch công tác"],
			["name" => "Báo cáo"],
			["name" => "Đối tượng"],
			["name" => "Vụ việc"],
			["name" => "Cán bộ"],
			["name" => "Người dùng"],
        );
    
    
    public $data_chucnang = array(
		["idmodule" => 1, 'name' => 'Quản lý', 'method' => 'index'],
		["idmodule" => 1, 'name' => 'Thêm mới', 'method' => 'create'],
		["idmodule" => 1, 'name' => 'Thêm mới (post)', 'method' => 'store'],
		["idmodule" => 1, 'name' => 'Sửa việc', 'method' => 'edit'],
		["idmodule" => 1, 'name' => 'Sửa việc (post)', 'method' => 'update'],
		["idmodule" => 1, 'name' => 'Xem việc', 'method' => 'show'],
		["idmodule" => 1, 'name' => 'Chuyển tiếp', 'method' => 'chuyentiep'],
		["idmodule" => 1, 'name' => 'Chuyển tiếp (post)', 'method' => 'postChuyentiep'],
		["idmodule" => 1, 'name' => 'Xóa việc', 'method' => 'delete'],
		["idmodule" => 1, 'name' => 'Xóa việc (post)', 'method' => 'destroy'],
		["idmodule" => 1, 'name' => 'Xóa node việc', 'method' => 'deleteNodeChuyentiep'],
		["idmodule" => 1, 'name' => 'Thay đổi trạng thái', 'method' => 'toggle_congviec_status'],
	);
    
    public $data_moiquanhe = array(
			["name" => "Chủ hộ", 'loaiquanhe' => 'nhanthan'],
			["name" => "Chồng", 'loaiquanhe' => 'nhanthan'],
			["name" => "Vợ", 'loaiquanhe' => 'nhanthan'],
			["name" => "Con đẻ", 'loaiquanhe' => 'nhanthan'],
			["name" => "Con nuôi", 'loaiquanhe' => 'nhanthan'],
			["name" => "Con dâu", 'loaiquanhe' => 'nhanthan'],
			["name" => "Con rể", 'loaiquanhe' => 'nhanthan'],
			["name" => "Cháu", 'loaiquanhe' => 'nhanthan'],
			["name" => "Anh ruột", 'loaiquanhe' => 'nhanthan'],
			["name" => "Chị ruột", 'loaiquanhe' => 'nhanthan'],
			["name" => "Em ruột", 'loaiquanhe' => 'nhanthan'],
			["name" => "Ông nội", 'loaiquanhe' => 'nhanthan'],
			["name" => "Bà nội", 'loaiquanhe' => 'nhanthan'],
			["name" => "Ông ngoại", 'loaiquanhe' => 'nhanthan'],
			["name" => "Bà ngoại", 'loaiquanhe' => 'nhanthan'],
			["name" => "Cô", 'loaiquanhe' => 'nhanthan'],
			["name" => "Dì", 'loaiquanhe' => 'nhanthan'],
			["name" => "Dượng", 'loaiquanhe' => 'nhanthan'],
			["name" => "Chú", 'loaiquanhe' => 'nhanthan'],
			["name" => "Bác", 'loaiquanhe' => 'nhanthan'],
			["name" => "Cậu", 'loaiquanhe' => 'nhanthan'],
			["name" => "Mự", 'loaiquanhe' => 'nhanthan'],
			["name" => "Chắt", 'loaiquanhe' => 'nhanthan'],
			["name" => "Quan hệ khác", 'loaiquanhe' => 'nhanthan'],
        );
        
    
        public $data_loaicutru = array(
			["name" => "Thường trú"],
			["name" => "Tạm trú"],
			["name" => "Lưu trú"],
			["name" => "Tạm vắng"]
        );
        
        public $data_thutuccutru = [
		    ['name' => 'Cấp mới hộ khẩu', 'idloaicutru' => 1, 'type' => 'dangkythuongtru'],
		    ['name' => 'Cấp lại hộ khẩu', 'idloaicutru' => 1, 'type' => 'dangkythuongtru'],
		    ['name' => 'Cấp đổi hộ khẩu', 'idloaicutru' => 1, 'type' => 'dangkythuongtru'],
		    ['name' => 'Tách hộ khẩu', 'idloaicutru' => 1, 'type' => 'dangkythuongtru'],
		    ['name' => 'Đăng ký nhân khẩu', 'idloaicutru' => 1, 'type' => 'dangkythuongtru'],
		    ['name' => 'Điều chỉnh thay đổi', 'idloaicutru' => 1, 'type' => 'dangkythuongtru'],
		    ['name' => 'Chết, mất tích', 'idloaicutru' => 1, 'type' => 'xoathuongtru'],
		    ['name' => 'Tuyển dụng vào CA, QĐ', 'idloaicutru' => 1, 'type' => 'xoathuongtru'],
		    ['name' => 'Hủy kết quả đăng ký', 'idloaicutru' => 1, 'type' => 'xoathuongtru'],
		    ['name' => 'Định cư nước ngoài về', 'idloaicutru' => 1, 'type' => 'xoathuongtru'],
		    ['name' => 'Đăng ký nơi thường trú mới', 'idloaicutru' => 1, 'type' => 'xoathuongtru'],
		    ['name' => 'Đăng ký tạm trú', 'idloaicutru' => 2, 'type' => 'dangkytamtru'],
		    ['name' => 'Điều chỉnh thay đổi', 'idloaicutru' => 2, 'type' => 'dangkytamtru'],
		    ['name' => 'Gia hạn tạm trú', 'idloaicutru' => 2, 'type' => 'dangkytamtru'],
		    ['name' => 'Xóa tạm trú', 'idloaicutru' => 2, 'type' => 'dangkytamtru'],
		    ['name' => 'Cấp sổ tạm trú', 'idloaicutru' => 2, 'type' => 'dangkytamtru'],
        ];
        
        public $data_chucvu = [
		    ["name" => "Đội phó"],
			["name" => "Đội trưởng"],
			["name" => "Phó trưởng phòng"],
			["name" => "Trưởng phòng"],
			["name" => "Phó Trưởng công an huyện"],
			["name" => "Trưởng Công an huyện"],
			["name" => "Phó Trưởng Công an thị xã"],
			["name" => "Trưởng Công an thị xã"],
			["name" => "Phó trưởng Công an Thành phố"],
			["name" => "Trưởng Công an Thành phố"],
			["name" => "Phó Giám đốc"],
			["name" => "Giám đốc"],
			["name" => "Cán bộ"],
			["name" => "Lao động có thời hạn"],
        ];
        
        public $data_capbac = [
		    ["name" => "Hạ sỹ"],
			["name" => "Trung sỹ"],
			["name" => "Thượng sỹ"],
			["name" => "Thiếu úy"],
			["name" => "Trung úy"],
			["name" => "Thượng úy"],
			["name" => "Đại úy"],
			["name" => "Thiếu tá"],
			["name" => "Trung tá"],
			["name" => "Thượng tá"],
			["name" => "Đại tá"],
			["name" => "Thiếu tướng"],
			["name" => "Trung tướng"],
			["name" => "Thượng tướng"],
			["name" => "Đại tướng"],
			["name" => "Khác"],
        ];
        
        public $data_trinhdohocvan = [
		    ["name" => "Tiểu học"],
			["name" => "Trung học cơ sở"],
			["name" => "Trung học phổ thông"],
			["name" => "Trung cấp"],
			["name" => "Cao đẳng"],
			["name" => "Đại học"],
			["name" => "Thạc sỹ"],
			["name" => "Tiến sỹ"],
			["name" => "Đại học"],
			["name" => "Thạc Sỹ"],
			["name" => "Mù chữ"],
			["name" => "1/12"],
			["name" => "2/12"],
			["name" => "3/12"],
			["name" => "4/12"],
			["name" => "5/12"],
			["name" => "6/12"],
			["name" => "7/12"],
			["name" => "8/12"],
			["name" => "9/12"],
			["name" => "10/12"],
			["name" => "11/12"],
			["name" => "12/12"],
			["name" => "1/10"],
			["name" => "2/10"],
			["name" => "3/10"],
			["name" => "4/10"],
			["name" => "5/10"],
			["name" => "6/10"],
			["name" => "7/10"],
			["name" => "8/10"],
			["name" => "9/10"],
			["name" => "10/10"],
			["name" => "Khác"],
        ];
        
        public $data_tongiao = [
		    ["name" => "Không"],
		    ["name" => "Thiên chúa giáo"],
			["name" => "Phật giáo"],
			["name" => "Tin Lành"],
			["name" => "Hồi giáo"],
			["name" => "Cao Đài"],
			["name" => "Hoà Hảo"],
			["name" => "Tôn giáo khác"],
        ];
        
        public $data_nghenghiep = [
		    ["name" => "Học sinh"],
			["name" => "Sinh viên"],
			["name" => "Công an"],
			["name" => "Bộ đội"],
			["name" => "Cán bộ, công nhân, viên chức"],
			["name" => "Hợp đồng sỹ quan"],
			["name" => "Nông nghiệp"],
			["name" => "Lâm nghiệp"],
			["name" => "Ngư nghiệp"],
			["name" => "Lao động tự do"],
			["name" => "Nghề nghiệp khác"],
        ];
        
        public $data_dantoc = [
		    ["name" => "Kinh (Việt)"],
			["name" => "Thái"],
			["name" => "Tày"],
			["name" => "Hoa (Hán)"],
			["name" => "Khơ-me"],
			["name" => "Mường"],
			["name" => "Nùng"],
			["name" => "Hmông (Mèo)"],
			["name" => "Dao"],
			["name" => "Gia-rai"],
			["name" => "Ngái"],
			["name" => "Ê-đê"],
			["name" => "Ba-na"],
			["name" => "Xơ-đăng"],
			["name" => "Sán Chay (Cao Lan – Sán Chỉ)"],
			["name" => "Cơ-ho"],
			["name" => "Chăm (Chàm)"],
			["name" => "Sán Dìu"],
			["name" => "Hrê"],
			["name" => "Mnông"],
			["name" => "Ra-giai"],
			["name" => "Xtiêng"],
			["name" => "Bru - Vân Kiều"],
			["name" => "Thổ"],
			["name" => "Giáy"],
			["name" => "Cơ-tu"],
			["name" => "Gié - Triêng"],
			["name" => "Mạ"],
			["name" => "Khơ-mú"],
			["name" => "Co"],
			["name" => "Ta-ôi"],
			["name" => "Cho-ro"],
			["name" => "Kháng"],
			["name" => "Xinh-mun"],
			["name" => "Hà Nhì"],
			["name" => "Chu-ru"],
			["name" => "Lào"],
			["name" => "La Chí"],
			["name" => "La Ha"],
			["name" => "Phù Lá"],
			["name" => "La Hủ"],
			["name" => "Lự"],
			["name" => "Lô Lô"],
			["name" => "Chứt"],
			["name" => "Mảng"],
			["name" => "Pà Thẻn"],
			["name" => "Cơ Lao"],
			["name" => "Cống"],
			["name" => " Bố Y"],
			["name" => "Si La"],
			["name" => "Pu Péo"],
			["name" => "Brâu"],
			["name" => "Ơ-đu"],
			["name" => "Rơ-măm"],
			["name" => "Dân tộc khác"],
        ];
        
        public $data_nhomquyen = [
		    ["name" => "Cán bộ"],
			["name" => "Phó Đội trưởng"],
			["name" => "Đội trưởng"],
			["name" => "Cấp phó đơn vị"],
			["name" => "Cấp trưởng đơn vị"],
			["name" => "Khách"],
			["name" => "Administrator"],
        ];
        
        public $data_donvi = [
			["kyhieu" => "Ban Giám đốc", "name" => "Ban Giám đốc", "loaidonvi" => "bgd"],
		    ["kyhieu" => "PV01", "name" => "Phòng tham mưu", "loaidonvi" => "phongban"],
			["kyhieu" => "PX01", "name" => "Phòng tổ chức cán bộ", "loaidonvi" => "phongban"],
			["kyhieu" => "PX03", "name" => "Phòng công tác Đảng và công tác chính trị", "loaidonvi" => "phongban"],
			["kyhieu" => "PX05", "name" => "Phòng thanh tra", "loaidonvi" => "phongban"],
			["kyhieu" => "PV06", "name" => "Phòng hồ sơ nghiệp vụ", "loaidonvi" => "phongban"],
			["kyhieu" => "PV05", "name" => "Phòng XDPTTDBVANTQ", "loaidonvi" => "phongban"],
			["kyhieu" => "PH10", "name" => "Phòng hậu cần", "loaidonvi" => "phongban"],
			["kyhieu" => "PB01", "name" => "Phòng tình báo", "loaidonvi" => "phongban"],
			["kyhieu" => "PA07", "name" => "Phòng bảo vệ an ninh chính trị nội bộ", "loaidonvi" => "phongban"],
			["kyhieu" => "PA06", "name" => "Phòng kỹ thuật nghiệp vụ", "loaidonvi" => "phongban"],
			["kyhieu" => "PA08", "name" => "Phòng quản lý xuất nhập cảnh", "loaidonvi" => "phongban"],
			["kyhieu" => "PA04", "name" => "Phòng an ninh kinh tế", "loaidonvi" => "phongban"],
			["kyhieu" => "PA03", "name" => "Phòng an ninh văn hóa", "loaidonvi" => "phongban"],
			["kyhieu" => "PA02", "name" => "Phòng an ninh nông thôn và phòng chống khủng bố", "loaidonvi" => "phongban"],
			["kyhieu" => "PA09", "name" => "Phòng an ninh điều tra", "loaidonvi" => "phongban"],
			["kyhieu" => "PC01", "name" => "Văn phòng cảnh sát điều tra", "loaidonvi" => "phongban"],
			["kyhieu" => "PC02", "name" => "Phòng cảnh sát hình sự", "loaidonvi" => "phongban"],
			["kyhieu" => "PC03", "name" => "Phòng cảnh sát kinh tế", "loaidonvi" => "phongban"],
			["kyhieu" => "PC04", "name" => "Phòng cảnh sát ma túy", "loaidonvi" => "phongban"],
			["kyhieu" => "PC05", "name" => "Phòng cảnh sát môi trường", "loaidonvi" => "phongban"],
			["kyhieu" => "PC52", "name" => "Phòng cảnh sát truy nã", "loaidonvi" => "phongban"],
			["kyhieu" => "PC06", "name" => "Phòng CS Quản lý hành chính", "loaidonvi" => "phongban"],
			["kyhieu" => "PC07", "name" => "Phòng cảnh sát phòng cháy chữa cháy", "loaidonvi" => "phongban"],
			["kyhieu" => "PC08", "name" => "Phòng cảnh sát giao thông đường bộ - đường sắt", "loaidonvi" => "phongban"],
			["kyhieu" => "PC08B", "name" => "Phòng cảnh sát giao thông đường thủy", "loaidonvi" => "phongban"],
			["kyhieu" => "PC09", "name" => "Phòng kỹ thuật hình sự", "loaidonvi" => "phongban"],
			["kyhieu" => "PC10", "name" => "Phòng cảnh sát thi hành án và hỗ trợ tư pháp", "loaidonvi" => "phongban"],
			["kyhieu" => "PC11", "name" => "Trại tạm giam", "loaidonvi" => "phongban"],
			["kyhieu" => "PK02", "name" => "Phòng cảnh sát cơ động", "loaidonvi" => "phongban"],
			["kyhieu" => "CATP Hà Tĩnh", "name" => "Công an TP Hà Tĩnh", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Thị xã Kỳ Anh", "name" => "CA Thị xã Kỳ Anh", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Kỳ Anh", "name" => "CA Huyện Kỳ Anh", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Cẩm Xuyên", "name" => "CA Huyện Cẩm Xuyên", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Thạch Hà", "name" => "CA Huyện Thạch Hà", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Can Lộc", "name" => "CA Huyện Can Lộc", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Lộc Hà", "name" => "CA Huyện Lộc Hà", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Thị xã Hồng Lĩnh", "name" => "CA Thị xã Hồng Lĩnh", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Đức Thọ", "name" => "CA Huyện Đức Thọ", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Hương Sơn", "name" => "CA Huyện Hương Sơn", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Hương Khê", "name" => "CA Huyện Hương Khê", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Vũ Quang", "name" => "CA Huyện Vũ Quang", "loaidonvi" => "huyentptx"],
			["kyhieu" => "CA Huyện Nghi Xuân", "name" => "CA Huyện Nghi Xuân", "loaidonvi" => "huyentptx"],
        ];
        
        public $data_doicongtac = [
			["name" => "Lãnh đạo Công an tỉnh", "loaidoi" => "doi_phongban"],
		    ["name" => "Lãnh đạo đơn vị", "loaidoi" => "doi_phongban"],
			["name" => "Đội Tổng hợp", "loaidoi" => "doi_phongban"],
			["name" => "Đội An ninh", "loaidoi" => "doi_phongban"],
			["name" => "Đội CSQLHC về TTXH", "loaidoi" => "doi_phongban"],
			["name" => "Điều tra Tổng hợp", "loaidoi" => "doi_phongban"],
			["name" => "Đội CSĐTTP về TTXH", "loaidoi" => "doi_phongban"],
			["name" => "Đội CSĐTTP về QLKT và CV", "loaidoi" => "doi_phongban"],
			["name" => "Đội CAXDPT và QLBVDP", "loaidoi" => "doi_phongban"],
			["name" => "Đội CSĐTTP về MT", "loaidoi" => "doi_phongban"],
			["name" => "Đội CSGT - TT", "loaidoi" => "doi_phongban"],
			["name" => "Đội CSTT - CĐ", "loaidoi" => "doi_phongban"],
			["name" => "Đội THAHS và HTTP", "loaidoi" => "doi_phongban"],
			["name" => "Đội Văn thư", "loaidoi" => "doi_phongban"],
			["name" => "Trung tâm thông tin Chỉ huy", "loaidoi" => "doi_phongban"],
			["name" => "Đội nghiên cứu Chuyên đề AN", "loaidoi" => "doi_phongban"],
			["name" => "Đội nghiên cứu Chuyên đề CS", "loaidoi" => "doi_phongban"],
			["name" => "Đội Pháp chế", "loaidoi" => "doi_phongban"],
			["name" => "Đội TKLS & QLKH", "loaidoi" => "doi_phongban"],
			["name" => "Đội Cơ yếu", "loaidoi" => "doi_phongban"],
			["name" => "Đội Viễn thông", "loaidoi" => "doi_phongban"],
			["name" => "Văn thư - Tổng hợp", "loaidoi" => "doi_phongban"],
			["name" => "Công an xã Thạch Trung", "loaidoi" => "conganxaphuong"],
			["name" => "Công an phường Trần Phú", "loaidoi" => "doi_phongban"],
			["name" => "Đội Thanh Tra", "loaidoi" => "doi_phongban"],
			["name" => "Đội điều tra và Thẩm định tố tụng", "loaidoi" => "doi_phongban"],
        ];
        
    public $data_donvi_doi = [
			['iddonvi' => 2, 'iddoi' => 2],
			['iddonvi' => 2, 'iddoi' => 3],
			['iddonvi' => 2, 'iddoi' => 14],
			['iddonvi' => 2, 'iddoi' => 15],
			['iddonvi' => 2, 'iddoi' => 16],
			['iddonvi' => 2, 'iddoi' => 17],
			['iddonvi' => 2, 'iddoi' => 18],
			['iddonvi' => 2, 'iddoi' => 19],
			['iddonvi' => 2, 'iddoi' => 20],
			['iddonvi' => 2, 'iddoi' => 21],
			['iddonvi' => 19, 'iddoi' => 2],
			['iddonvi' => 19, 'iddoi' => 22],
			['iddonvi' => 19, 'iddoi' => 25],
			['iddonvi' => 19, 'iddoi' => 26],
			['iddonvi' => 33, 'iddoi' => 2],
			['iddonvi' => 33, 'iddoi' => 3],
			['iddonvi' => 33, 'iddoi' => 4],
			['iddonvi' => 33, 'iddoi' => 5],
			['iddonvi' => 33, 'iddoi' => 6],
			['iddonvi' => 33, 'iddoi' => 7],
			['iddonvi' => 33, 'iddoi' => 8],
			['iddonvi' => 33, 'iddoi' => 9],
			['iddonvi' => 33, 'iddoi' => 10],
			['iddonvi' => 33, 'iddoi' => 11],
			['iddonvi' => 33, 'iddoi' => 12],
			['iddonvi' => 33, 'iddoi' => 13],
			['iddonvi' => 1, 'iddoi' => 2],
		];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$module = $this->argument('module');
		if($module == 'coredb')
		{
			DB::table('tbl_chucvu')->insert( $this->data_chucvu );
			DB::table('tbl_capbac')->insert( $this->data_capbac );
			DB::table('tbl_trinhdohocvan')->insert( $this->data_trinhdohocvan );
			DB::table('tbl_tongiao')->insert( $this->data_tongiao );
			DB::table('tbl_nghenghiep')->insert( $this->data_nghenghiep );
			DB::table('tbl_dantoc')->insert( $this->data_dantoc );
			DB::table('tbl_moiquanhe')->insert($this->data_moiquanhe);
			DB::table('tbl_nhomquyen')->insert( $this->data_nhomquyen );
			DB::table('tbl_donvi')->insert( $this->data_donvi );
			DB::table('tbl_doicongtac')->insert( $this->data_doicongtac );
			DB::table('tbl_donvi_doi')->insert( $this->data_donvi_doi );
			DB::table('configs')->insert($this->data_config_nhomquyen);
			DB::table('tbl_modules')->insert($this->data_modules);
			DB::table('tbl_chucnang')->insert($this->data_chucnang);
			DB::table('tbl_level')->insert($this->data_level_role);
		}
		elseif( $module == 'nhanhokhau' )
		{
			DB::connection('nhanhokhau')->table('tbl_loaicutru')->insert($this->data_loaicutru);
			DB::connection('nhanhokhau')->table('tbl_thutuccutru')->insert( $this->data_thutuccutru );
		}
		
    }
}
