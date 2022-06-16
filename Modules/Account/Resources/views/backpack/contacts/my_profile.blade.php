<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-content">
                <h4 class="navbar navbar-light mt-3 pl-0">{{ trans('account::account.contact_information') }}</h4>
                <div class="row pl-0">
                    <div class="col-md-6 pt-2">
                        <label>{{ trans('account::account.full_name') }} : <span>{{$entry->Fullname ?? ''}}</span></label>
                    </div>
                    <div class="col-md-6 pt-2">
                        <label> {{ trans('account::account.account') }} : {{ optional($entry->account)->name }}</label>
                    </div>
                    <div class="col-md-6 pt-2">
                        <label>{{ trans('account::account.mobile_phone') }} : <a href="tel:{{$entry->phone}}" class="text-primary">{{$entry->phone ?? ''}}</a></label>
                    </div>
                    <div class="col-md-6 pt-2">
                        <label> {{ trans('account::account.email') }} : <a href="mailto:{{$entry->email}}" class="text-primary">{{$entry->email ?? ''}}</a></label>
                    </div>
                    <div class="col-md-6 pt-2">
                        <label> {{ trans('account::account.status') }} : {!! $entry->statusHtml !!}</label>
                    </div>
                    <div class="col-md-6 pt-2">
                        <label> {{ trans('account::account.position') }} : {!! $entry->position !!}</label>
                    </div>
                    <div class="col-md-6 pt-2">
                        <label> {{ trans('account::account.address') }} : {!! $entry->address !!}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
