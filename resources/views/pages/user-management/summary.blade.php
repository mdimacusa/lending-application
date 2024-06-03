<form method="POST" action="{{route('client.profile.update',['tab'=>'summary','id'=>Crypt::encrypt($response['client']->id)])}}">
    @csrf
    <span class="d-flex mb-5 position-relative">
        <span class="d-inline-block mb-2 fs-5 text-uppercase fw-bold text-gray-900">
            Client Details
        </span>
        <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-success translate rounded"></span>
    </span>
    <input type="hidden" name="users_id" value="">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">First Name</label>
                <input type="text" name="first_name" value="{{$response['client']->first_name}}" class="form-control">
                @error("first_name")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase">Middle Name</label>
                <input type="text" name="middle_name" value="{{$response['client']->middle_name}}" class="form-control">
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Surname</label>
                <input type="text" name="surname" value="{{$response['client']->surname}}" class="form-control">
                @error("surname")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Email</label>
                <input type="email" name="email" value="{{$response['client']->email}}" class="form-control">
                @error("email")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase required">Contact Number</label>
                <input type="text" name="contact_number" value="{{$response['client']->contact_number}}" class="form-control">
                @error("contact_number")
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase">Status</label>
                <select name="status" class="form-control">
                    <option value="ACTIVE" {{$response['client']->status=="ACTIVE"?"Selected":""}}>ACTIVE</option>
                    <option value="INACTIVE" {{$response['client']->status=="INACTIVE"?"Selected":""}}>INACTIVE</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="mb-4">
                <label class="form-label mb-3 fs-9 fw-bold text-uppercase">Address</label>
                <textarea name="address" class="form-control" rows="4" cols="50">{{$response['client']->address}}</textarea>
            </div>
        </div>
    </div>
    <div class="separator separator-dashed my-3"></div>
    <div class="mb-5 fv-row">
        <button type="submit" class="btn btn-light-success ls-1 text-uppercase blocker fs-8 fw-bolder w-100">Save Changes</button>
    </div>
</form>
