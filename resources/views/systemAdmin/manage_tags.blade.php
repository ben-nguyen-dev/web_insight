@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/systemAdmin.css') }}">
@endsection
@section('content')
    <div class="row">
        @include('systemAdmin.menu')
        <div class="row col-10 justify-content-center right-content">
            <div class="col-md-10">
                <h3 class="text-center">Manage Tags</h3>
                <div class="alert" role="alert" style="display:none;"></div>
                <div class="add-new">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCreateTag">Create tag</button>
                </div>
                <div class="modal fade create-tag" id="modalCreateTag" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title">Create Tag</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="tagName" class="col-form-label">Name:<span class="star-required">*</span></label>
                                    <input type="text" class="form-control" id="tagName" value=""/>
                                </div>
                            </form>
                            <div class="message" style="display:none">
                                <div class="alert" role="alert">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-create-tag">Create tag</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="user-table tag-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Name</th>
                                <th scope="col">Is actived</th>
                                <th scope="col">Deleted at</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>
                            @if(isset($tags) && count($tags) > 0)
                                @foreach ($tags as $tag)
                                    <?php $i++; ?>
                                    <tr>
                                        <th scope="row"> {{ $i }}</th>
                                        <td><a href="{{ route('update.tag', $tag->id) }}" data-toggle="modal" data-target="#modalUpdateTag-{{$tag->id}}">{{ $tag->name }}</a></td>
                                        <td><?php if($tag->is_active) echo 'True'; else echo 'False'; ?></td>
                                        <td><?php if($tag->removed_date) echo $tag->removed_date; else echo ''; ?></td>
                                        <td>
                                            <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUpdateTag-{{$tag->id}}">Edit</a>
                                            <a type="button" class="btn btn-danger btn-delete-tag">Delete</a>
                                            <input type="hidden" class="object-id" value="{{$tag->id}}"/>
                                        </td>
                                    </tr>
                                    <div class="modal fade create-tag" id="modalUpdateTag-{{$tag->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h4 class="modal-title">Update Tag</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="tagName" class="col-form-label">Name:<span class="star-required">*</span></label>
                                                        <input type="text" class="form-control" id="tagName" value="{{$tag->name}}"/>
                                                    </div>
                                                </form>
                                                <form>
                                                    <div class="form-group">    
                                                        <label for="isActive" class="col-form-label">Is actived:</label>
                                                        <input type="checkbox" class="" id="isActive" <?php if($tag->is_active) echo 'checked'; ?>/>
                                                    </div>
                                                </form>
                                                <div class="message" style="display:none">
                                                    <div class="alert" role="alert">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button id="{{$tag->id}}" type="button" class="btn btn-primary btn-update-tag">Update tag</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    @include('modal', ['title' => 'Delete tag', 'checkDelete' => true, 'object' => 'tag', 'name' => $tag->name, 'id' => $tag->id, 'class' => 'create-tag'])
                                @endforeach
                            @endif
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