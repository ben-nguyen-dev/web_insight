<div id="createDepartment" role="tabpanel" class="department-item form-create-department tab-pane fade"> 
  <form method="POST" action="{{ route('create.department') }}">
    @csrf
    <h3 class="title">Deparment infomation</h3>
    <div class="form-group row">
      <label for="departmentName" class="col-sm-3 col-form-label">Department name: <span class="star-required">*</span></label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="departmentName" name="department_name" placeholder="Enter department name">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Company name:</label>
      <div class="col-sm-9">
        <input type="hidden" class="form-control" name="company_id" value="{{$company['id']}}">
        <input type="text" class="form-control" placeholder="{{$company['company_name']}}" disabled>
      </div>
    </div>
    <div class="form-group row">
      <div class="offset-3 col-9">
        <button name="submit" type="submit" class="btn btn-primary btn-submit-department">Create Department</button>
      </div>
    </div>

  </form>
</div>
