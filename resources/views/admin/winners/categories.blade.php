
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Winner Categories')

@section('breadcrumbs_title', 'Winners')

@section('breadcrumbs')
    <li class="active">Winner Categories</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Winner Categories</h4>
                    </div>
                    <div class="card-body">
                        <table id="passed-entries-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Visit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $c)
                                <tr>
                                    <td>{{ $c->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.winner.show_category_results', $c->id) }}"
                                           class="btn btn-primary">Visit</a>
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

        $('#winners-li').addClass('active')

    </script>

@endsection
