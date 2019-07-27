
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Categories')

@section('breadcrumbs_title', 'Benchmarks')

@section('breadcrumbs')
    <li class="active">Benchmarks</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3"><label class="font-weight-bold" for="">Select Category</label></div>
                                <div class="col-sm-6">
                                    <select name="category" id="category-select">
                                        <option value=""></option>
                                        @foreach($categories as $c)
                                            @if($c->r1_finalized == false)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <button id="submit-category" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="passed-entries-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Brand Name</th>
                                    <th>Average Score</th>
                                    <th>Details</th>
                                    <th>
                                        Select All <input class="ml-3" type="checkbox" name="" id="select-all-checkbox">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button id="pass-entries-btn" class="btn btn-primary">Pass Entries</button>
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

    <script>
        $('#benchmarks-li').addClass('active')

        let tableData;
        let tbody = $('table tbody')
        $('#pass-entries-btn').prop('disabled', true)
        $('#select-all-checkbox').prop('disabled', true)

        $('#pass-entries-btn').click(function () {
            if(!confirm('Are you sure you want pass selected entries to the second round?' +
                ' (Once you submit you will not be able to make changes)')) {
                return false
            }

            let inputs = $('tbody input[type=checkbox]:checked')

            let selectedBrandIds = []

            inputs.each(function (integer) {
                selectedBrandIds.push($(this).attr('entry_id'))
            })

            let categoryId = $('#category-select').val()

            const data = {
                _token: '{{ csrf_token() }}',
                categoryId,
                selectedBrandIds
            }

            const url = '{{ route('admin.benchmark.pass_brands_category') }}'

            $.post(url, data, function ({response}) {
                // console.log(response)
                if(response === 'success') {
                    alert('Successfully updated the system')
                } else {
                    alert('Failed to update the system')
                }
                location.reload()
            })

        })

        $('#category-select').change(function () {
            $('table tbody').children().remove()
            if($(this).val() === '') {
                $('#pass-entries-btn').prop('disabled', true)
                $('#select-all-checkbox').prop('disabled', true)
            } else {
                $('#pass-entries-btn').prop('disabled', false)
                $('#select-all-checkbox').prop('disabled', false)
            }
        })

        $('#select-all-checkbox').click(function () {
            $('.pass-entry-to-r2').prop('checked', true)
        })

        tbody.on('click', 'input', function () {
            if($(this).prop('checked') == false) {
                $('#select-all-checkbox').prop('checked', false)
            }
        })

        $('#submit-category').click(function () {
            let categoryId = $('#category-select').val()

            if(categoryId === '') {
                return false
            }

            const data = {
                categoryId
            }

            const url = '{{ route('admin.benchmark.get_brands') }}'

            $.get(url, data, function (response) {
                if(response == null) {
                    alert('No data found')
                } else {
                    tableData = response

                    let allRows = $('table tbody tr')
                    if(allRows) {
                        allRows.remove()
                    }

                    for( let i = 0; i < response.length; i++) {
                        let newRow = `<tr>
                            <td>${response[i].brand.name}</td>
                            <td>${response[i].average}</td>
                            <td><button table_data_index="${i}" class="btn btn-info view-score-btn">View Detail</button></td>
                            <td><input entry_id="${response[i].brand.id}" type="checkbox" class="d-block mx-auto pass-entry-to-r2"></td>
                        </tr>`
                        tbody.append(newRow)
                    }
                }
            })
        })

        tbody.on('click', 'button', function () {
            let tableDataIndex = $(this).attr('table_data_index')

            const scoreData = tableData[tableDataIndex].scoreData;

            $('#entry-score-modal .modal-body .container-fluid').children().remove()

            for( let i = 0; i < scoreData.length; i++) {
                let temp = scoreData[i]
                console.log(scoreData[i])
                let newRow = `
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Judge Name: ${temp.judge.name}</h4>
                                    <ul>
                                        <li>Brand Intent: ${temp.score.intent}</li>
                                        <li>Brand Content: ${temp.score.content}</li>
                                        <li>Brand Process: ${temp.score.process}</li>
                                        <li>Brand Health KPI'S: ${temp.score.health}</li>
                                        <li>Financial Performance: ${temp.score.performance}</li>
                                        <li>Total: ${temp.score.total}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    What is good?
                                </div>
                                <div class="col-sm-9">
                                    <p>${temp.score.good}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    What is bad?
                                </div>
                                <div class="col-sm-9">
                                    <p>${temp.score.bad}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    What needs to be improved?
                                </div>
                                <div class="col-sm-9">
                                    <p>${temp.score.improvement}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `

                $('#entry-score-modal .container-fluid').append(newRow)
            }

            $('#entry-score-modal').modal()
        })

    </script>

@endsection
