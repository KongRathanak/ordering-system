<div class="box box-box bg-white p-3 border-top border-primary mb-3">
    <div class="box-header with-border">
        <h3 class="box-title">
            User Information
        </h3>
    </div>
    <div class="box-body box-profile p-0">
        <div class="border-box text-center pb-2">
        <img src="{{optional($entry->user)->AvatarOriginal ?? asset('assets/default.png')}}" alt="..."
             class="profile-user-img img-responsive img-fluid d-block mx-auto rounded-circle img-thumbnail"
             style="width: 150px; height: 150px;"
             >
        </div>
        <div class="text-center">
            <h3 class="profile-username text-center text-capitalize text-break">{{ $entry->fullName }}</h3>
            <a href="#" class="text-decoration-none" target="_blank" rel="noopener">
            <span class="text-muted"><em class="la la-bank "></em> {{ optional($entry->account)->name }}</span><br>
            </a>
        </div>
        <ul class="list-group pb-2">
            <li class="list-group-item border-left-0 border-right-0">
                <em class="nav-icon la la-phone mr-1"></em>
                <a href="tel:{{$entry->phone}}">{{$entry->phone}}</a>
            </li>
        <li class="list-group-item border-left-0 border-right-0">
            <em class="nav-icon la la-envelope mr-1"></em>
            <a href="mailto:{{$entry->email}}" class="text-break">{{$entry->email}}</a>
        </li>
        </ul>
            <a href="{{backpack_url('contact/'.$entry->id.'/edit')}}" class="btn btn-primary btn-block"><strong>Edit Profile</strong></a>
    </div>
</div>
