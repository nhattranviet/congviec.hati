<?php

return [
    "idnhomquyen_canbo" => 1,
    "idnhomquyen_doipho" => 2,
    "idnhomquyen_doitruong" => 3,
    "idnhomquyen_capphodonvi" => 4,
    "idnhomquyen_captruongdonvi" => 5,
    "idnhomquyen_khach" => 6,
    "idnhomquyen_administrator" => 7,

    "id_doi_lanhdaodonvi" => 2,

    "id_module_congviec" => 1,
    'idnhomquyen_level_default' => ['1' => 1, '2' => 1, '3' => 2, '4' => 2, '5' => 2, '7' => 3],    //key: 1:can bo; 2: doi pho; 3: doitruong; 4:capphodonvi: 5:captruongdonvi: 7: Admin--------value:
    'level_info' => ['1' => 'Cán bộ', '2' => 'Cấp đội thuộc quyền', '3' => 'Tất cả'],   //1:canbo;  2:doiphutrach; 3: all
    'max_level_id' => 3,
    'congviec_idstatus_quahan' => 3,
    'thuongtru' => [
        'thutuc_capmoi' => 1,
        'thutuc_caplai' => 2,
        'thutuc_capdoi' => 3,
        'thutuc_tach' => 4,
        'thutuc_dangkynhankhau' =>  5,
        'thutuc_dieuchinhthaydoi' =>  6,
        'thutuc_dangkynoimoi' => 11,
    ],

    'default_route' => [
        '2' => 'nhat-ky-cong-tac-cb.index',  //PC44
        '19' => 'cong-viec.index',  //PC44
        '33' => 'cong-viec.index',  //TP
        '35' => 'nhan-ho-khau-home',    //H KA
    ],

    'idmoiquanhechuho' => 1,

    'default_hanhchinh' => [
        'country' => 1,
        'province' => 19,
        'district' => 202,
    ]
];