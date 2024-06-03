
<form method="POST" action="{{route('staff.profile.update',['tab'=>'summary','id'=>Crypt::encrypt($response['staff']->id)])}}">
    @csrf
    <span class="d-flex mb-5 position-relative">
        <span class="d-inline-block mb-2 fs-5 text-uppercase fw-bold text-gray-900">
            Staff Details
        </span>
        <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-success translate rounded"></span>
    </span>
    <input type="hidden" name="users_id" value="">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Name</label>
                <input type="text" name="name" value="{{$response['staff']->name}}" class="form-control">
                @error("name")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Email</label>
                <input type="email" name="email" value="{{$response['staff']->email}}" class="form-control">
                @error("email")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Pincode</label>
                <input type="text" name="pincode" value="{{$response['staff']->pincode}}" class="form-control">
                @error("pincode")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase">Status</label>
                <select name="status" class="form-control">
                    <option value="ACTIVE" {{$response['staff']->status=="ACTIVE"?"Selected":""}}>ACTIVE</option>
                    <option value="INACTIVE" {{$response['staff']->status=="INACTIVE"?"Selected":""}}>INACTIVE</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Password</label>
                <div class="input-group">
                    <span class="input-group-text border-right-0" >
                        <a style="cursor:pointer" >
                            <i id="password-lock" class="far fa-eye"></i>
                        </a>
                    </span>
                    <input type="password" id="password" name="password" autocomplete="new-password" class="form-control" />
                </div>
                @error("password")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text border-right-0" >
                        <a style="cursor:pointer" >
                            <i id="password-lock-confirmation" class="far fa-eye"></i>
                        </a>
                    </span>
                    <input type="password" id="password-confirmation" name="password_confirmation" class="form-control" />
                </div>
                @error("password_confirmation")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="separator separator-dashed my-3"></div>
    <div class="mb-5 fv-row">
        <button type="submit" class="btn btn-light-success ls-1 text-uppercase blocker fs-8 fw-bolder w-100">Save Changes</button>
    </div>
</form>
