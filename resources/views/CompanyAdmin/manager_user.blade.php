@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('css/companyAdmin.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="title-user">Manager users</h3>
                <div class="user-table">
                    <div class="list-action float-right">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="show-delete" id="show-delete">
                            <label class="form-check-label" for="exampleCheck1">Show deleted users</label>
                        </div>
                        <button type="button" class="btn btn-success" id="open-modal-invite" style="margin-bottom: 20px;">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Invite
                          </button>
                          <div class="dropdown">
                            <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="" id="active-user">
                                    <img src="{{ asset('images/btn-active.png') }}" style="margin-right: 12px;" />     Active
                                </a>
                                <a class="dropdown-item" href="" id="inactive-user"><img src="{{ asset('images/btn-block.png') }}" style="margin-right: 14px;" />Inactive</a>
                            </div>
                          </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="clear:both;">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="clear:both;">
                            {{ session('warning') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                      <div id="message-success" style="clear:both;"></div>
                      <div class="show-table">
                          <div id="table-show-user">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-top">
                                    <tr>
                                        <th></th>
                                        <th scope="col">STT</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Handle</th>
                                    </tr>
                                </thead>
                                <tbody class="thead-body">
                                    @if(isset($users) && count($users) > 0)
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <th class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input check-box" name="user_check" type="checkbox" id="inlineCheckbox1" value="{{ $user->id }}">
                                                    </div>
                                                </th>
                                                <th scope="row">{{ ++$key }}</th>
                                                <td>{{ $user->user_name }}</td>
                                                <td>{{ $user->full_name }}</td>
                                                <td class="text-center user_actve">
                                                    @if ($user->user_active)
                                                        <p style="color:#0070ff;"> Active</p>
                                                    @else
                                                        <p style="color:#ff2a00;"> InActive</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach ($user->roles as $role)
                                                        <p>{{ $role['name'] }}</p>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    @if ($user->isAdministrator(\App\Enum\RoleEnum::ROLE_COMPANY_ADMIN))
                                                        <a href="{{ route('companyAdmin.removeRoleCompanyAdmin',$user->id) }}" type="button" class="btn btn-danger btn-sm btn-remove">Remove Company Admin</a>
                                                    @else
                                                        <a href="{{ route('companyAdmin.addRoleCompanyAdmin',$user->id) }}" type="button" class="btn btn-success btn-sm btn-make">Make Company Admin</a>
                                                    @endif
                                                <span data-id="{{ $user->id }}" data-html="{{ $user->user_name }}" id="btn-delete">
                                                    <img src="{{ asset('images/btn-delete.png') }}"/>
                                                </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7"> No result found</td>
                                    </tr> 
                                    @endif
                                </tbody>
                            </table>
                            @if (isset($users))
                            {{ $users->links('pagination.default') }}
                            @endif
                        </div>
                         <div id="table-show-delete-user">
                         </div>
                      </div>
                    <div class="modal fade" id="modal-invite" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Invite User</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div id="message-error"></div>
                                <form>
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Email address <span class="star-required">*</span></label>
                                      <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Role <span class="star-required">*</span></label>
                                        <select class="form-control" id="invite-role">
                                            <option value="">Select user role</option>
                                            <option value="{{ \App\Enum\RoleEnum::ROLE_COMPANY_ADMIN }}">{{ \App\Enum\RoleEnum::ROLE_COMPANY_ADMIN }}</option>
                                            <option value="{{ \App\Enum\RoleEnum::ROLE_USER }}">{{ \App\Enum\RoleEnum::ROLE_USER }}</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="submit-send-mail">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="modal fade" id="confirm-delete-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Confirm Delete</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body text-center modal-delete">
                            <h3>Are You Sure?</h3>
                            <p style="margin: 30px 0px;">
                                Do you really want to delete user "<span id="user-name"></span>" ? This <br>
                                process cannot be undo.
                            </p>
                            <button type="button" class="btn btn-secondary" style="padding:7px 25px; font-size: 16px;" data-dismiss="modal">Cancel</button>
                          <button type="button" class="btn btn-danger" id="submit-delete">Delete</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <form action="{{ route('companyAdmin.deleteSoftUser') }}" method="POST" id="submit-form-deleteUser">
                      @csrf
                      <input type="hidden" name="user_id" value="" id="user_id">
                  </form>
            </div> 
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/company.js') }}"></script>
@endsection