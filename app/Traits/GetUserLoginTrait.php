<?php

namespace App\Traits;

trait GetUserLoginTrait {
    /**
     * Do not change argument
     *
     * @param boolean $contact
     *
     * @return integer
     */
    public function getLoginContactOrUser($contact = true) {
        $auth = $this->getInstanceLoginContactOrUser($contact);
        if (!$auth) {
            return $auth;
        }

        return $auth->id;
    }

    /**
     * @param boolean $contact
     *
     * @return \Model
     */
    public function getInstanceLoginContactOrUser($contact = true) {
        $id = null;

        // Web auth or auth with middleware auth|auth:api
        $auth = optional(\Auth::user());

        if (!$auth->id) {
            // auth without inside middleware auth:api but has bearer token
            $auth = optional(\Auth::guard('api')->user());
        }

        if (!$auth->id) {
            // if default or guard api false get fallback to check backpack
            $auth = optional(backpack_user());
        }

        if ($auth->id) {
            // $auth fall to find contact fallback to $id = null
            if ($contact) {
                return optional($auth->contact);
            }

            return $auth;
        }
        return $id;
    }
}
