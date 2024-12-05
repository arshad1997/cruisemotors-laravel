<div class="details">
    <ul>
        <li>Tracking Code: {{ $data->code }}</li>
        <li>Car Brand: {{ $data->car_make->name }}</li>
        <li>Car Model: {{ $data->car_model->name }}</li>
        <li>VIN: {{ $data->vin }}</li>
        <li>Comments: {{ $data->comments }}</li>
    </ul>

    <div>
        <h4>Services Requested</h4>
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Cost</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->serviceItems as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->documentService->name }}</td>
                    <td>{{ $item->cost }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
