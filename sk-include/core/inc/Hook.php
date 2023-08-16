<?php
//
//class Hook extends FrameWork
//{
//    public static $Action;
//
//    public function __construct()
//    {
//        self::$Action = [
//
//                'admin_header_code', 'admin_add_menu', 'admin_footer_code'
//
//        ];
//
//        var_dump(
//            [
//                'name' => 'test',
//                'type' => 0,
//                'link' => ''
//            ],
//            [
//                'name' => 'demo',
//                'type' => 1,
//                'item' => [
//                    'name' => 'demo_1',
//                    'link' => ''
//                ]
//            ]
//        );
//    }
//
//    public static function SetHook($action)
//    {
//
//    }
//
//    public function AddMenu(array $arr)
//    {
//        if (FrameWork::getAction() == 'admin') {
//            if (isset($arr)) {
//                if ($arr['type'] == 0) {
//                    foreach ($arr['name'] as $a) {
//                        print <<<EOT
//
//EOT;
//
//
//                    }
//
//                } else if ($arr['type'] == 1) {
//
//                } else {
//
//                }
//            }
//        }
//
//    }
//
//
//}