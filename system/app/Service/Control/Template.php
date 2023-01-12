<?php

namespace App\Service\Control;

trait Template
{
    public function getTemplateMigration()
    {
        return [
            /*0*/
            [
                "type" => "unsignedBigInteger",
                "param" => "unsigned,index",
            ],
            /*1*/
            [
                "type" => "string",
                "size" => "100"
            ],
            /*2*/
            [
                "type" => "string",
                "size" => "20",
                "param" => "nullable"
            ],
            /*3*/
            [
                "type" => "string",
                "size" => "200",
                "param" => "nullable"
            ],
            /*4*/
            [
                "type" => "time",
                "param" => "nullable"
            ],
            /*5*/
            [
                "type" => "string",
                "size" => "100",
                "param" => "unique",
            ],
            /*6*/
            [
                "type" => "date",
                "param" => "nullable"
            ],
            /*7*/
            [
                "type" => "unsignedBigInteger",
            ],
            /*8*/
            [
                "type" => "unsignedBigInteger",
                "param" => "nullable"
            ],
            /*9*/
            [
                "type" => "boolean",
                "param" => "default"
            ],
            /*10*/
            [
                "type" => "text",
            ],
            /*11*/
            [
                "type" => "string",
                "size" => "100",
                "param" => "nullable,default|0",
            ],
            /*12*/
            [
                "type" => "string",
                "size" => "10",
                "param" => "nullable,default|0",
            ],
            /*13*/
            [
                "type" => "bigInteger",
            ],
            /*14*/
            [
                "type" => "integer",
                "param" => "default|0",
            ],
        ];
    }
    public function getTemplateValidation()
    {
        return [
            /*0*/
            "string|nullable",
            /*1*/
            "nullable|mimes:jpg,png,jpeg,ico,JPG,PNG,JPEG",
            /*2*/
            "required",
            /*3*/
            "required|unique:users",
            /*4*/
            "required|string|min:6",
            /*5*/
            "required|email|unique:users",
            /*6*/
            "nullable",
            /*7*/
            "integer|nullable",
            /*8*/
            "required|integer",
            /*9*/
            "string|unique:transaksi",
            /*10*/
            "nullable|string",
            /*11*/
            "required|string",
        ];
    }
    public function getTemplateMiddelware()
    {
        return [
            /*0*/
            [
                "api",
                "role:admin"
            ],
            /*1*/
            [
                "api",
                "role:instansi"
            ],
            /*2*/
            [
                "api",
                "role:kantin"
            ],
            /*3*/
            [
                "api",
                "role:orangtua"
            ],
            /*4*/
            [
                "api",
                "role:super-admin"
            ]
        ];
    }
    public function getTemplateView()
    {
        return  [
            "text" => [
                "type" => "text",
                "modeInput" => "text",
                "attr" => [
                    "required" => true
                ],
                "class" => "",
                "id" => ""
            ],
            "time" => [
                "type" => "time",
                "modeInput" => "text",
                "attr" => [
                    "required" => true
                ],
                "class" => "",
                "id" => ""
            ],
            "select_static" => [
                "type" => "select",
                "modeInput" => "select",
                "attr" => [
                    "required" => true
                ],
                "option" => [
                    "mode" => "static",
                    "value" => [
                        "-" => "",
                        "A" => "A",
                        "B" => "B",
                        "C" => "C"
                    ]
                ],
                "class" => "",
                "id" => ""
            ]
        ];
    }
}
