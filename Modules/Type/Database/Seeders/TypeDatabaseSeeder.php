<?php

namespace Modules\Type\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Type\Entities\Type;

class TypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan module:seed Type
     *
     * @return void
     */
    public function run()
    {
        DB::statement("ALTER SEQUENCE roles_id_seq RESTART WITH 1000;");

        $arrParents = [
            1 => [
                "name" => "Wallet Types",
                "code" => 'wallet_types',
                "auto_code" => true,
            ],
            2 => [
                "name" => "Status",
                "code" => 'status_boolean',
                "auto_code" => true,
            ],
            3 => [
                "name" => "Default",
                "code" => 'default_boolean',
                "auto_code" => true,
            ],
            4 => [
                "name" => "Positions",
                "code" => 'positions',
                "auto_code" => true,
            ],
            5 => [
                "name" => "Approval Status",
                "code" => 'approval_status',
                "auto_code" => true,
            ],
            6 => [
                "name" => "Payroll Status",
                "code" => 'payroll_status',
                "auto_code" => true,
            ],
            7 => [
                "name" => "Sending Status",
                "code" => 'sending_status',
                "auto_code" => true,
            ],
            8 => [
                "name" => "User Status",
                "code" => 'user_status',
                "auto_code" => true,
            ],
            9 => [
                "name" => "BIC",
                "code" => 'bic',
                "auto_code" => true,
            ],
            10 => [
                "name" => "Template Type",
                "code" => 'template_type',
                "auto_code" => true,
            ]
        ];

        $this->checkIfHaveParentAndCreate($arrParents);

        if (env('DB_CONNECTION') === 'pgsql') {
            DB::statement("ALTER SEQUENCE types_id_seq RESTART WITH 1000;");
        } else {
            DB::statement("ALTER TABLE types AUTO_INCREMENT = 1000;");
        }

        $arrAccountType = [
            [
                'name' => 'Bank',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Main',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Salary',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Loyalty',
                'code' => 'Coupon',
                'auto_code' => true,
            ],
            [
                'name' => 'Staking',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Suspend',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Company Balance',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Perfund Balance',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Profit & Loss Balance',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Payroll',
                'code' => '',
                'auto_code' => true,
            ],
        ];

        $this->runLooping(1, $arrAccountType, 'option');

        $arrAccountType = [
            [
                'name' => 'Active',
                'code' => '1',
                'auto_code' => true,
            ],
            [
                'name' => 'Inactive',
                'code' => '0',
                'auto_code' => true,
            ],
        ];

        $this->runLooping(2, $arrAccountType, 'option');

        $arrDefaultType = [
            [
                'name' => 'Yes',
                'code' => '1',
                'auto_code' => true,
            ],
            [
                'name' => 'No',
                'code' => '0',
                'auto_code' => true,
            ],
        ];

        $this->runLooping(3, $arrDefaultType, 'option');

        $arrPosition = [
            [
                'name' => 'CEO',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Sale',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Trainer',
                'code' => '',
                'auto_code' => true,
            ],
            [
                'name' => 'Director',
                'code' => '',
                'auto_code' => true,
            ]
        ];

        $this->runLooping(4, $arrPosition, 'option');

        $arrApprovalStatus = [
            [
                'name' => 'Pending',
                'code' => 'pending',
                'auto_code' => true,
            ],
            [
                'name' => 'Approved',
                'code' => 'approved',
                'auto_code' => true,
            ],
            [
                'name' => 'Rejected',
                'code' => 'rejected',
                'auto_code' => true,
            ]
        ];
        $this->runLooping(5, $arrApprovalStatus, 'option');

        $arrPayrollStatus = [
            [
                'name' => 'Active',
                'code' => '1',
                'auto_code' => true,
            ],
            [
                'name' => 'Inactive',
                'code' => '0',
                'auto_code' => true,
            ]
        ];
        $this->runLooping(6, $arrPayrollStatus, 'option');

        $arrPayrollStatus = [
            [
                'name' => 'Send',
                'code' => '1',
                'auto_code' => true,
            ],
            [
                'name' => 'Unsend',
                'code' => '0',
                'auto_code' => true,
            ]
        ];

        $this->runLooping(7, $arrPayrollStatus, 'option');

        $arrPayrollStatus = [
            [
                'name' => 'valid',
                'code' => '1',
                'auto_code' => true,
            ],
            [
                'name' => 'invalid',
                'code' => '0',
                'auto_code' => true,
            ]
        ];

        $this->runLooping(8, $arrPayrollStatus, 'option');
        $arrBicType = [
            [
                'name' => 'ACLEDA mobile',
                'code' => 'ACLBKHPP',
                'auto_code' => true,
            ],
            [
                'name' => 'Visa/Master Card',
                'code' => 'VISA_MASTER',
                'auto_code' => true,
            ],
            [
                'name' => 'Sathapana Mobile',
                'code' => 'SBPLKHPP',
                'auto_code' => true,
            ],
            [
                'name' => 'WeChat Pay',
                'code' => 'WECHAT',
                'auto_code' => true,
            ],
            [
                'name' => 'ABA Mobile',
                'code' => 'ABAAKHPP',
                'auto_code' => true,
            ],
            [
                'name' => 'Alipay',
                'code' => 'ALIPAY',
                'auto_code' => true,
            ]
        ];
        $this->runLooping(9, $arrBicType, 'option');


        $arrTemplateType = [
            [
                'name' => 'Contact',
                'code' => 'contact',
                'auto_code' => true,
            ]
        ];
        $this->runLooping(10, $arrTemplateType, 'option');

        $arrParents = [
            36 => [
                "name" => "Operation",
                "code" => 'Operation',
                "auto_code" => true,
            ]
        ];
        $this->checkIfHaveParentAndCreate($arrParents);
        $arrTemplateType = [

            [
                'name' => 'Transfer',
                'code' => 'transfer',
                'auto_code' => true,
            ],
            [
                'name' => 'Cashout',
                'code' => 'cashout',
                'auto_code' => true,
            ],
            [
                'name' => 'Receive',
                'code' => 'receive',
                'auto_code' => true,
            ],
            [
                'name' => 'Loyalty to salary',
                'code' => 'loyalty_to_salary',
                'auto_code' => true,
            ],
            [
                'name' => 'Salary to loyalty',
                'code' => 'salary_to_loyalty',
                'auto_code' => true,
            ]
        ];
        $this->runLooping(36, $arrTemplateType, 'option');
    }

    protected function checkIfHaveParentAndCreate($arr)
    {
        foreach ($arr as $k => $val) {
            $checkParent = Type::where('id', $k)->first();
            if (!$checkParent) {
                Type::firstOrCreate([
                    'id' => $k,
                    'name' => $val['name'],
                    'code' => $val['code'] ? $val['code'] : $val['name'],
                    'parent_id' => null,
                    'option' => true,
                    'category' => true
                ]);
            }
        }
    }

    protected function runLooping($parentValue, $children = [], $option = '')
    {
        if (!$parentValue) {
            return false;
        }

        $optionCheck = 0;
        $categoryCheck = 0;

        if ($option == 'option') {
            $optionCheck = 1;
        } else {
            $categoryCheck = 1;
        }

        if (is_array($children) && count($children)) {
            foreach ($children as $value) {
                $this->checkChild($value, $parentValue, $optionCheck, $categoryCheck);
            }
        }
    }

    protected function checkChild($value, $parentValue, $optionCheck, $categoryCheck)
    {
        if (array_key_exists('child', $value) && is_array($value['child']) && count($value['child'])) {
            $pparent = $this->firstOrCreateType($value, $parentValue, $optionCheck, $categoryCheck);

            foreach ($value['child'] as $vv) {
                $this->checkChild($vv, $pparent->id, $optionCheck, $categoryCheck);
            }
        } else {
            $this->firstOrCreateType($value, $parentValue, $optionCheck, $categoryCheck);
        }
    }

    protected function firstOrCreateType($value, $parentValue, $optionCheck, $categoryCheck)
    {
        return Type::firstOrCreate([
            'name' => $value['name'],
            'code' => $value['code'] || $value['code'] == 0 ? $value['code'] : $value['name'],
            'parent_id' => $parentValue,
            'option' => $optionCheck,
            'category' => $categoryCheck
        ]);
    }
}
