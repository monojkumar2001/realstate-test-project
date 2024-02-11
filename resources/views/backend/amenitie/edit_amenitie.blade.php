@extends('admin.layouts.master')
@section('content')
    <div class="page-content">
        <div class="row profile-body">
            <!-- left wrapper start -->

            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Edit Amenities Name</h6>
                                <form class="forms-sample" method="POST" action="{{ route('update.amenitie') }}">
                                    @csrf

                                    <input  type="hidden" name="id" value="{{$amenities->id}}">
                                    <div class="mb-3">
                                        <label for="amenities_name" class="form-label">Type Name</label>
                                        <input type="text" name="amenities_name"
                                            class="form-control @error('amenities_name') is-invalid @enderror" value="{{$amenities->amenities_name}}">
                                        @error('amenities_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                   

                                    <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                                </form>

                            </div>

                        </div>



                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
