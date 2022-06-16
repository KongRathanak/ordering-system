<?php

namespace Modules\Type\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Modules\Type\Repositories\TypeRepository;
use Modules\Type\Http\Resources\Types\TypeAPIResource;

class TypeAPIController extends AppBaseController{

    public function getWalletTypes() {
        $walletTypes = collect(resolve(TypeRepository::class)->getTypesByParentIDs([1], false))
            ->groupBy('parent_id');

        if(!count($walletTypes)){
            return $this->errorResponse('Wallet Transaction not found', 404);
        }

        return $this->successResponse(
            TypeAPIResource::collection($walletTypes[1]),
            'Successfully',
            200
        );
    }

}
