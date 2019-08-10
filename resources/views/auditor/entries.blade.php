
@extends('layouts.auditor')

@section('title', 'Brand Excellence Judge Dashboard')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>
@endsection


@section('breadcrumbs_title', 'Entries')

@section('breadcrumbs')
    <li class="active">Entries</li>
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
                        <h3 class="text-center">Entries</h3>
                        <h6>Panels: {{ $panelNames }}</h6>
                    </div>
                    <div class="card-body">
                        <table id="auditor-entries-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry ID</th>
                                    <th>Brand Name</th>
                                    <th>Category</th>
                                    <th>Industry Category</th>
                                    <th>Company</th>
                                    <th>Average</th>
                                    <th>Summary</th>
                                    <th>
                                        Audited
                                        <input class="d-block mx-auto" type="checkbox" name="" id="select-all-checkbox">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $d)
                                @php
                                $b = $d['brand'];
                                @endphp
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->category->name }}</td>
                                    <td>{{ $b->industryCategory->name }}</td>
                                    <td>{{ $b->company->name }}</td>
                                    <td>{{ $d['average'] }}</td>
                                    <td>
                                        <button brand_id="{{ $b->id }}" judges='{!! $d['judgeIds'] !!}' class="btn btn-primary view-summary">View</button>
                                    </td>
                                    <td>
                                        @if( $b->auditor_id == null)
                                            <input brand_id="{{ $b->id }}" class="select-audited d-block mx-auto" type="checkbox" name="" id="">
                                        @else
                                            <span class="text-success">Audited</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button id="approve-selected-btn" class="btn btn-primary">Approve Selected</button>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

    <!-- Modal -->
    <div class="modal fade" id="entry-score-modal" tabindex="-1" role="dialog" aria-labelledby="entryScoreModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Entry Score History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="score-history-container" class="container-fluid"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.js"></script>

    <script>
        $('#dashboard-li').addClass('active')

        $('#select-all-checkbox').change(function () {
            if($(this).is(':checked')) {
                $('.select-audited').each(function (index) {
                    $(this).prop('checked', true)
                })
            }
        })

        $('.select-audited').change(function () {
            $(this).each(function (index, el) {
                if(!$(el).is(':checked')) {
                    $('#select-all-checkbox').prop('checked', false)
                }
            })
        })

        $('#approve-selected-btn').click(function () {
            let brandIds = []

            $('.select-audited:checked').each(function (index) {
                brandIds.push($(this).attr('brand_id'))
            })

            if(brandIds.length === 0) {
                return false
            }

            const data = {
                brandIds,
                _token: '{{ csrf_token() }}'
            }

            const url = '{{ route('auditor.finalize_selected_entries') }}'

            $.post(url, data, function (response) {
                if(response === 'success') {
                    alert('Successfully audited selected entries')
                    location.reload()
                } else {
                    alert('Failed to finalize selected entries')
                }
            })
        })

        let contentBox = $('#entry-score-modal #score-history-container')

        $('.view-summary').click(function () {
            const judgeIds = JSON.parse($(this).attr('judges'))
            const brandId = $(this).attr('brand_id')
            const url = '{{ route('auditor.get_summary') }}'
            const data = {
                judgeIds,
                brandId
            }

            contentBox.children().remove()

            $.get(url, data, function (response) {

                for(let i = 0; i < response.length; i++) {
                    let temp = response[i]
                    let newRow = `
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Judge Name: ${temp.name}</h4>
                                        <ul>
                                            <li>Brand Intent: ${temp.intent}</li>
                                            <li>Brand Content: ${temp.content}</li>
                                            <li>Brand Process: ${temp.process}</li>
                                            <li>Brand Health KPI'S: ${temp.health}</li>
                                            <li>Financial Performance: ${temp.performance}</li>
                                            <li>Total: ${temp.total}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `
                    contentBox.append(newRow)
                }

                $('#entry-score-modal').modal()
            })
        })

        $('#finalize').click(function () {
            if(!confirm('Are you sure you want to finalize scoring?')) {
                return false
            }

            const numberOfEntriesFinalized = $(this).attr('num-entries')
            const url = '{{ route('judge.finalize') }}'
            const data = {
                _token: '{{ csrf_token() }}',
                numberOfEntriesFinalized
            }

            $.post(url, data, function (result) {
                // console.log(result)
                if(result === 'success') {
                    location.reload()
                } else {
                    alert('Failed to finalize')
                }
            })
        })

        $('#auditor-entries-table').DataTable( {
            "columnDefs": [
                { "orderable": false, "targets": 5 }
            ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    if(column[0][0] == 2 || column[0][0] == 3) {

                        var select = $('<select style="max-width: 150px;" class="form-control"><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );

                    }

                } );
            }
        } );

    </script>

@endsection
