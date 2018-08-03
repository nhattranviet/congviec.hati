<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Faker\Factory as Faker;

class SeedNhanHoKhau extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nhanhokhau:import_thuongtru';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import dữ liệu về nhân hộ khẩu';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        require_once base_path().'/vendor/fzaninotto/faker/src/autoload.php';
        $faker = Faker::create('vi_VN');
        $ho_pho_bien = collect(['Trần', 'Trần', 'Trần', 'Nguyễn', 'Phạm', 'Lê', 'Trần', 'Hoàng', 'Huỳnh', 'Phan', 'Trần','Vũ', 'Võ', 'Đặng', 'Trần', 'Bùi', 'Trần', 'Đỗ', 'Hồ', 'Ngô', 'Trần', 'Dương', 'Trần', 'Lý', 'Tống', 'Trần' ]);
        $dantoc = collect(['Kinh', 'Thái', 'Tày', 'Nùng', 'Dao', 'Ê-đê', 'Khơ-mú']);
        $ngoaingu = collect(['A1', 'B1', 'C1', 'IELSE', 'TOEIC']);
        $trinhdochuyenmon = collect(['Tiến sĩ khoa học', 'Tiến sĩ', 'Thạc sĩ', 'Cử nhân', 'Kỹ sư', 'Cao đẳng', 'Trung cấp', 'Sơ cấp']);

        $limit_hoso = 108;
        $bar = $this->output->createProgressBar($limit_hoso);
        for ($i = 0; $i < $limit_hoso; $i++)
        {
            $this->info("====> Ghi ho so thu ".$i."/".$limit_hoso);
            $arrHoso = array(
            'hosohokhau_so' => 'HS_'. $faker->unique()->ean13,
            'hokhau_so' => 'HK_'.$faker->unique()->ean13,
            'so_dktt_so' => 'DKTT_'.$faker->unique()->ean13,
            'so_dktt_toso' => rand(10,1000),
            'ngaynopluu' => $faker->date,
            );
            $idhosohokhau = DB::table('tbl_hoso')->insertGetId($arrHoso);

            //-----------------------Chủ hộ-------------------------
            $arrnhankhau = array(
            'hoten' => $ho_pho_bien->random() . ' ' . $faker->middleName() . ' ' . $faker->firstName,
            'tenkhac' => $faker->middleName() . ' ' . $faker->firstName,
            'ngaysinh' => $faker->dateTimeThisCentury->format('Y-m-d'),
            'idquoctich' => 1,
            'idquocgia_nguyenquan' => 1,
            'idtinh_nguyenquan' => 19,
            'idhuyen_nguyenquan' => 202,
            'idxa_nguyenquan' => rand(3044,3064),

            'idquocgia_thuongtru' => 1,
            'idtinh_thuongtru' => 19,
            'idhuyen_thuongtru' => 202,
            'idxa_thuongtru' => rand(3044,3064),

            'idquocgia_noiohiennay' => 1,
            'idtinh_noiohiennay' => 19,
            'idhuyen_noiohiennay' => 202,
            'idxa_noiohiennay' => rand(3044,3064),

            'idquocgia_noisinh' => 1,
            'idtinh_noisinh' => 19,
            'idhuyen_noisinh' => 202,
            'idxa_noisinh' => rand(3044,3064),

            'idquocgia_noilamviec' => 1,
            'idtinh_noilamviec' => 19,
            'idhuyen_noilamviec' => 202,
            'idxa_noilamviec' => rand(3044,3064),
            'hochieu_so' => $faker->unique()->ean13,
            'cmnd_so' => $faker->unique()->ean13,
            'idtongiao' => rand(1,6),
            'iddantoc' => rand(1,20),
            'idtrinhdohocvan' => rand(1,6),
            'idnghenghiep' => rand(1,6),
            'trinhdochuyenmon' => $trinhdochuyenmon->random(),
            'trinhdongoaingu' => $ngoaingu->random(),
            'biettiengdantoc' => $dantoc->random(),
            'tomtatbanthan' => $faker->realText,
            'tomtatgiadinh' => $faker->realText,
            'gioitinh' => rand(0,1),
            );

            $check_ttt = rand(1,5);
            if($check_ttt == 1)
            {
                $arrnhankhau['idquocgia_thuongtrutruoc'] = 1;
                $arrnhankhau['idtinh_thuongtrutruoc'] = 35;
                $arrnhankhau['idhuyen_thuongtrutruoc'] = 407;
                $arrnhankhau['idxa_thuongtrutruoc'] = rand(6362,6386);
            }

            $check = rand(1,5);

            if($check == 1)
            {
                $arrnhankhau['tienan_tiensu'] = $faker->realText;
            }

            $idnhankhau = DB::table('tbl_nhankhau')->insertGetId($arrnhankhau);

            $arrHoKhau = array(
            'idhoso' => $idhosohokhau,
            'idnhankhau' => $idnhankhau,
            'idquanhechuho' =>  1,
            'ngaydangky' => $faker->dateTimeThisCentury->format('Y-m-d'),
            );
            $idsohokhau = DB::table('tbl_sohokhau')->insertGetId($arrHoKhau);

            $xa_tt_save = $arrnhankhau['idxa_thuongtru'];
            //-----------------End Chủ hộ----------------

            $num_thanhviengiadinh = rand(3,6);
            //--------------Thành viên trong gia đình--------------
            for($j = 0; $j < $num_thanhviengiadinh; $j++)
            {
                $arrnhankhau = array(
                'hoten' => $ho_pho_bien->random() . ' ' . $faker->middleName() . ' ' . $faker->firstName,
                'tenkhac' => $faker->middleName() . ' ' . $faker->firstName,
                'ngaysinh' => $faker->dateTimeThisCentury->format('Y-m-d'),
                'idquoctich' => 1,
                'idquocgia_nguyenquan' => 1,
                'idtinh_nguyenquan' => 19,
                'idhuyen_nguyenquan' => 202,
                'idxa_nguyenquan' => rand(3044,3064),

                'idquocgia_thuongtru' => 1,
                'idtinh_thuongtru' => 19,
                'idhuyen_thuongtru' => 202,
                'idxa_thuongtru' => $xa_tt_save,

                'idquocgia_noiohiennay' => 1,
                'idtinh_noiohiennay' => 19,
                'idhuyen_noiohiennay' => 202,
                'idxa_noiohiennay' => rand(3044,3064),

                'idquocgia_noisinh' => 1,
                'idtinh_noisinh' => 19,
                'idhuyen_noisinh' => 202,
                'idxa_noisinh' => rand(3044,3064),

                'idquocgia_noilamviec' => 1,
                'idtinh_noilamviec' => 19,
                'idhuyen_noilamviec' => 202,
                'idxa_noilamviec' => rand(3044,3064),
                'hochieu_so' => $faker->unique()->ean13,
                'cmnd_so' => $faker->unique()->ean13,
                'idtongiao' => rand(1,6),
                'iddantoc' => rand(1,20),
                'idtrinhdohocvan' => rand(1,6),
                'idnghenghiep' => rand(1,6),
                'trinhdochuyenmon' => $trinhdochuyenmon->random(),
                'trinhdongoaingu' => $ngoaingu->random(),
                'biettiengdantoc' => $dantoc->random(),
                'tomtatbanthan' => $faker->realText,
                'tomtatgiadinh' => $faker->realText,
                'gioitinh' => rand(0,1),
                );

                $check_ttt = rand(1,5);
                if($check_ttt == 1)
                {
                    $arrnhankhau['idquocgia_thuongtrutruoc'] = 1;
                    $arrnhankhau['idtinh_thuongtrutruoc'] = 35;
                    $arrnhankhau['idhuyen_thuongtrutruoc'] = 407;
                    $arrnhankhau['idxa_thuongtrutruoc'] = rand(6362,6386);
                }

                $check = rand(1,5);

                if($check == 1)
                {
                    $arrnhankhau['tienan_tiensu'] = $faker->realText;
                }

                $idnhankhau = DB::table('tbl_nhankhau')->insertGetId($arrnhankhau);

                $arrHoKhau = array(
                'idhoso' => $idhosohokhau,
                'idnhankhau' => $idnhankhau,
                'idquanhechuho' =>  rand(2,8),
                'ngaydangky' => $faker->dateTimeThisCentury->format('Y-m-d'),
                );

                $idhokhau = DB::table('tbl_sohokhau')->insertGetId($arrHoKhau);
            }
            //--------End Thành viên trong gia đình--------------

            $bar->advance();

        }

        $bar->finish();
        $this->info("\n Done!");
    }
}
