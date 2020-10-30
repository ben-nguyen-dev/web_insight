@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/systemAdmin.css') }}">
@endsection
@section('content')
    <div class="row">
        @include('systemAdmin.menu')
        <div class="row col-10 justify-content-center right-content">
            <div class="col-md-10">
                <h3 class="text-center">Manage Companies</h3>
                <div class="create-company-consultant">
                    <a href="{{route('create.company')}}" class="btn btn-success btn-create-company">Create company</a>
                </div>
                <div class="user-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Company name</th>
                                <th scope="col">Company number</th>
                                <th scope="col">Company address</th>
                                <th scope="col">Is verifed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>
                            @foreach ($companies as $company)
                                <?php $i++; ?>
                                <tr>
                                    <th scope="row"> {{ $i }}</th>
                                    <td><a href="{{ route('manage.company.departments', $company['id']) }}" >{{ $company['name'] }}</a></td>
                                    <td>{{ $company['registration_number'] }}</td>
                                    <td>{{ $company['address'] }}</td>
                                    <td><?php if($company['is_verified']) echo '<p class="text-success">True</p>'; else echo '<p class="text-danger">False</p>'; ?></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
@endsection

@section('script')
<script src='{{ asset('js/systemAdmin.js') }}'></script>    
@endsection