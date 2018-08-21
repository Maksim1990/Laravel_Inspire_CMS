<?php
/**
 * Created by PhpStorm.
 * User: Maxim.Narushevich
 * Date: 06.08.2018
 * Time: 11:50
 */

namespace App\Config;


class DefaultMenuLangs
{

    const DEFAULT_LANGS = [
        1 => [
            'languages' => [
                "EN" => "Modules",
                "FR" => "Modules",
                "RU" => "Modules",
                "TH" => "Modules"
            ],
            'parent' => 0,
            'sortorder' => 0

        ],
        2 => [
            'languages' => [
                "EN" => "Settings",
                "FR" => "Settings",
                "RU" => "Settings",
                "TH" => "Settings"
            ],
            'parent' => 0,
            'sortorder' => 0
        ],
        3 => [
            'languages' => [
                "EN" => "Labels management",
                "FR" => "Labels management",
                "RU" => "Labels management",
                "TH" => "Labels management"
            ],
            'parent' => 1,
            'sortorder' => 5
        ],
        4 => [
            'languages' => [
                "EN" => "Pagebuilder",
                "FR" => "Pagebuilder",
                "RU" => "Pagebuilder",
                "TH" => "Pagebuilder"
            ],
            'parent' => 1,
            'sortorder' => 10
        ],
        5 => [
            'languages' => [
                "EN" => "Custom CSS",
                "FR" => "Custom CSS",
                "RU" => "Custom CSS",
                "TH" => "Custom CSS"
            ],
            'parent' => 1,
            'sortorder' => 15
        ],
        6 => [
            'languages' => [
                "EN" => "Menu settings",
                "FR" => "Menu settings",
                "RU" => "Menu settings",
                "TH" => "Menu settings"
            ],
            'parent' => 2,
            'sortorder' => 5
        ],
        7 => [
            'languages' => [
                "EN" => "Code editor settings",
                "FR" => "Code editor settings",
                "RU" => "Code editor settings",
                "TH" => "Code editor settings"
            ],
            'parent' => 2,
            'sortorder' => 10
        ],
        8 => [
            'languages' => [
                "EN" => "Language settings",
                "FR" => "Language settings",
                "RU" => "Language settings",
                "TH" => "Language settings"
            ],
            'parent' => 2,
            'sortorder' => 15
        ],
        9 => [
            'languages' => [
                "EN" => "Posts module",
                "FR" => "Posts module",
                "RU" => "Posts module",
                "TH" => "Posts module"
            ],
            'parent' => 1,
            'sortorder' => 20
        ],
        10 => [
            'languages' => [
                "EN" => "Images module",
                "FR" => "Images module",
                "RU" => "Images module",
                "TH" => "Images module"
            ],
            'parent' => 1,
            'sortorder' => 25
        ],
        11 => [
            'languages' => [
                "EN" => "Website settings",
                "FR" => "Website settings",
                "RU" => "Website settings",
                "TH" => "Website settings"
            ],
            'parent' => 2,
            'sortorder' => 20
        ],
        12 => [
            'languages' => [
                "EN" => "Profile settings",
                "FR" => "Profile settings",
                "RU" => "Profile settings",
                "TH" => "Profile settings"
            ],
            'parent' => 2,
            'sortorder' => 25
        ],
        13 => [
            'languages' => [
                "EN" => "Export module",
                "FR" => "Export module",
                "RU" => "Export module",
                "TH" => "Export module"
            ],
            'parent' => 1,
            'sortorder' => 30
        ],
        14 => [
            'languages' => [
                "EN" => "Mail module",
                "FR" => "Mail module",
                "RU" => "Mail module",
                "TH" => "Mail module"
            ],
            'parent' => 1,
            'sortorder' => 35
        ],
        15 => [
            'languages' => [
                "EN" => "Office module",
                "FR" => "Office module",
                "RU" => "Office module",
                "TH" => "Office module"
            ],
            'parent' => 1,
            'sortorder' => 40
        ],
        16 => [
            'languages' => [
                "EN" => "About",
                "FR" => "About",
                "RU" => "About",
                "TH" => "About"
            ],
            'parent' => 2,
            'sortorder' => 30
        ],
        17 => [
            'languages' => [
                "EN" => "Contact Us",
                "FR" => "Contact Us",
                "RU" => "Contact Us",
                "TH" => "Contact Us"
            ],
            'parent' => 2,
            'sortorder' => 35
        ],
        18 => [
            'languages' => [
                "EN" => "Import module",
                "FR" => "Import module",
                "RU" => "Import module",
                "TH" => "Import module"
            ],
            'parent' => 1,
            'sortorder' => 50
        ],
        19 => [
            'languages' => [
                "EN" => "Tasks module",
                "FR" => "Tasks module",
                "RU" => "Tasks module",
                "TH" => "Tasks module"
            ],
            'parent' => 1,
            'sortorder' => 45
        ],
    ];


}