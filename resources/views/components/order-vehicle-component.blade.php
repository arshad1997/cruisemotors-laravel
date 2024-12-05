<div class="details">
    <ul>
        <li>Tracking Code: {{$data->code}}</li>
        <li>Client Name: {{ $data->client_name }}</li>
        <li>Client Phone: {{ $data->client_phone }}</li>
        <li>Designation: {{ $data->designation }}</li>
        <li>
            Location: {{ optional($data->port)->name.' '.optional($data->city)->name.' '.optional($data->state)->name.' '.optional($data->country)->name }}
        </li>
        <li>Company Name: {{ $data->company_name }}</li>
        <li>Interior Color: {{ $data->interior_color }}</li>
        <li>Exterior Color: {{ $data->exterior_color }}</li>
        <li>Production: {{ $data->production_date_time }}</li>
        <li>Delivery: {{ $data->delivery_date_time }}</li>
        <li>Engine Size: {{ $data->engine_size }}</li>
        <li>Fuel Type: {{ $data->fuel_type }}</li>
        <li>Steering Type: {{ $data->steering }}</li>
        <li>Asking Price: {{ $data->asking_price }}</li>
    </ul>

    <div>
        <h4>Vehicle Details</h4>
        <table>
            <thead>
            <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->items as $vehicle)
                <tr>
                    <td>{{ $vehicle->car_make->name }}</td>
                    <td>{{ $vehicle->car_model->name }}</td>
                    <td>{{ $vehicle->year }}</td>
                    <td>{{ $vehicle->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
