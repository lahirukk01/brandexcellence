@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Judges')

@section('breadcrumbs_title', 'Judges')

@section('breadcrumbs')
    <li class="active">Judges</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show floating-response" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{route('admin.judge.create')}}">Create Judge <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                                <th>Finalized</th>
                                <th>Allowed /<br>Blocked</th>
                                <th>Online<br>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($judges as $j)
                                <tr>
                                    <td>{{ $j->name }}</td>
                                    <td>{{ $j->email }}</td>
                                    <td>
                                        <a style="color: #0e6498;" href="{{route('admin.judge.show', $j->id)}}">View</a>
                                        <a class="mx-2" style="color: green;" href="{{route('admin.judge.edit', $j->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('admin.judge.destroy', $j->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-judge mx-2">Delete</a>
                                        </form>

                                    </td>
                                    <td><button id="{{ $j->id }}" class="btn btn-info unlock-btn" @if($j->finalized == false) disabled @endif>Unlock</button></td>
                                    <td>
                                        @if($j->allowed)
                                            <a href="{{ route('admin.judge.toggle_status', $j->id) }}" class="btn btn-danger">Block</a>
                                        @else
                                            <a href="{{ route('admin.judge.toggle_status', $j->id) }}" class="btn btn-primary">Allow</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($j->online_status == 'Online')
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-danger">Offline</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>

        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

    <script>
        $('#judges-li').addClass('active')

        $('.unlock-btn').click(function () {
            const judgeId = $(this).prop('id')

            const url = '{{ route('admin.judge.unlock') }}'

            const data = {
                judgeId,
                _token: '{{ csrf_token() }}'
            }

            $.post(url, data, function (result) {
                console.log(result)
                if(result === 'success') {
                    location.reload()
                } else {
                    alert('Failed to un-finalize judge scoring')
                }
            })
        })

        $('.delete-judge').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this judge?')) {
                return false
            }

            $(this).closest('form').submit()
        })

    </script>

@endsection