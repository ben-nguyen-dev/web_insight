<?php $first = true; ?>

@foreach($departments as $department)
<div id="department-{{ $department['department']->id }}" role="tabpanel" class="department-item tab-pane fade <?php if (isset($current_department) && $current_department == $department['department']->id || $first) echo 'active show'; ?>">
    <div class="department-info">
        <h3 class="title">Deparment infomation</h3>
        <label>Department name: </label>
        <label>{{ $department['department']->name }} </label>
        <!-- <label>Default department: </label>
        <label>{{ $department['department']->default_department }} </label> -->
    </div>
    <div class="user-list">
        <h3 class="title">User List</h3>
        @if(isset($company['company_is_consultant']) && $company['company_is_consultant'])
        <div class="form-group">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAddConsultantUser">Add Consultant</button>
        </div>

        <div class="modal fade" id="modalAddConsultantUser" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Consultant</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="emailConsultant" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="emailConsultant" />
                            </div>
                            <div class="form-group">
                                <label for="userNameConsultant" class="col-form-label">User name:</label>
                                <input type="text" class="form-control" id="userNameConsultant" />
                            </div>
                            <div class="form-group">
                                <label for="passwordConsultant" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="passwordConsultant" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-add-consultant">Add Consultant</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(count($department['users']) == 0)
        <div class="form-group">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalInviteUser-{{ $department['department']->id }}">Invite Company Admin</button>
        </div>

        <div class="modal fade" id="modalInviteUser-{{ $department['department']->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Invite Company Admin</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="emailCompanyAdmin" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="emailCompanyAdmin" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-invite-company-admin">Invite user</button>
                    </div>
                </div>
            </div>
        </div>
        <p>The department has no users. </p>
        @endif
        @if(count($department['users']) > 0)
        <div class="select-action">
            <select class="select-department">
                <option value="">Move to other department</option>
                @foreach($departments as $item)
                @if($department['department']->id !== $item['department']->id)
                <option value="{{$item['department']->id}}">{{ $item['department']->name }}</option>
                @endif
                @endforeach
            </select>
            <button class="btn btn-success do-move-users">Apply</button>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Work email</th>
                    <th scope="col">Work phone</th>
                    <th scope="col">Job title</th>
                    <th scope="col">Is actived</th>
                    <th scope="col">Is verifed</th>
                    <th scope="col">Role</th>
                    <th scope="col"></th>
                    <th scope="col">
                        <input class="select-items" type="checkbox"></input>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach ($department['users'] as $user)
                <?php $i++; ?>
                <tr id="{{$user['id']}}" class="user-row">
                    <th scope="row"> {{ $i }}</th>
                    <td>{{ $user['full_name'] }}</td>
                    <td>{{ $user['work_email'] }}</td>
                    <td>{{ $user['work_phone'] }}</td>
                    <td>{{ $user['job_title'] }}</td>
                    <td>
                        <input type="checkbox" <?php if ($user['is_actived']) echo 'checked'; ?> disabled></input>
                    </td>
                    <td>
                        <input class="verify-user" type="checkbox" <?php if ($user['is_verified']) echo 'checked'; ?>></input>
                    </td>
                    <td>
                        <?php if ($user['roles']) {
                            foreach ($user['roles'] as $role) {
                                echo $role . '</br>';
                            }
                        } else echo 'User'; ?></input>
                    </td>
                    <td>
                        @if (in_array(\App\Enum\RoleEnum::ROLE_COMPANY_ADMIN, $user['roles']))
                        <a href="{{ route('company.user.removeRoleCompanyAdmin', $user['id']) }}" type="button" class="btn btn-danger btn-sm">Remove Company Admin</a>
                        @else
                        <a href="{{ route('company.user.addRoleCompanyAdmin', $user['id']) }}" type="button" class="btn btn-success btn-sm">Add Company Admin</a>
                        @endif
                        @if (in_array(\App\Enum\RoleEnum::ROLE_CONSULTANT, $user['roles']))
                        <a href="{{route('show.profile.page', $user['id'])}}" type="button" class="btn btn-primary btn-sm">Add profile page </a>
                        @endif
                    </td>
                    <td>
                        <input class="add-user" type="checkbox"></input>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>
</div>
<?php $first = false; ?>
@endforeach