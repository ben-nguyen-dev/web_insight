@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/systemAdmin.css') }}">
@endsection
@section('content')
<div class="row">
    @include('systemAdmin.menu')
    <div class="row col-10 justify-content-center update-profile-page">
        <form method="POST" action="">
            @csrf
            <h3 class="title">Profile page</h3>
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Profile title:<span class="star-required">*</span></label>
                <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="user_id" value="{{ $user_id }}">
                    <input type="text" class="form-control" name="profile_title" value="{{$profile_page ? $profile_page->profile_title : '' }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Profile description:</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="profile_description" rows="5"><?php echo $profile_page ? $profile_page->profile_description : ''; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Location:</label>
                <div class="col-sm-9">
                    <input id="locationInput" type="text" tabindex="3" class="form-control" name="profile_location" value="{{$profile_page ? $profile_page->location : '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Status:</label>
                <div class="col-sm-9">
                    <select type="select" class="form-control profile-status" name="profile_status" >
                        <option value="">Choose status</option>
                        <option value="publish" <?php if($profile_page && 'publish' == $profile_page->status) echo 'selected' ;?>>Publish</option>
                        <option value="draft" <?php if($profile_page && 'draft' == $profile_page->status) echo 'selected' ;?>>Draft</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-3 col-9">
                    <button name="submit" type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script src='{{ asset('js/systemAdmin.js') }}'></script>
@endsection