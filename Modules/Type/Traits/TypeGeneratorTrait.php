<?php

namespace Modules\Type\Traits;

use Modules\Type\Entities\Type;

trait TypeGeneratorTrait {

    public function checkIfHaveParentAndCreate($arr)
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

    public function runLooping($parentValue, $children = [], $option = '')
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

    public function checkChild($value, $parentValue, $optionCheck, $categoryCheck)
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

    public function firstOrCreateType($value, $parentValue, $optionCheck, $categoryCheck)
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
