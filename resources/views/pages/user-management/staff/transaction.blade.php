<div class="card rounded-1">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table border table-striped align-middle table-hover table-row-bordered gy-4 gs-4">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-150px">Reference</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end">Request Date</th>
                        <th class="text-end">Processed Date</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @foreach($response['query'] as $data)
                    <tr>
                        <td>{{$data->reference}}</td>
                        <td>₱{{$data->amount}}</td>
                        <td>
                            @if($data->status == 0)
                            <div class="badge badge-light-danger">UNPAID</div>
                            @elseif($data->status == 1)
                            <div class="badge badge-light-primary">PARTIALLY PAID</div>
                            @else
                            <div class="badge badge-light-success">FULLY PAID</div>
                            @endif
                        </td>
                        <td class="text-end">{{$data->disbursement_date}}</td>
                        <td class="text-end">{{$data->updated_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            @if($response['filters']['rows'] != "All")
            {{ $response['query']->onEachSide(1)->links() }}
            @endif
        </div>
    </div>
</div>
