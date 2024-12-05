<div class="details">
    <ul>
        <li>Tracking Code: {{$data->code}}</li>
        <li>Contact Person: {{ $data->user->name }}</li>
        <li>Contact Person Email: {{ $data->user->email }}</li>
        <li>Contact Person Phone: {{ $data->user->phone }}</li>

        <li>
            <div>
                <h4>Point of Loading</h4>
                <ul>
                    <li>Country: {{ optional($data->depature_country)->name }}</li>
                    <li>State: {{ optional($data->depature_state)->name }}</li>
                    <li>City: {{ optional($data->depature_city)->name }}</li>
                    <li>Port: {{ optional($data->depature_port)->name }}</li>
                </ul>
            </div>
        </li>

        <li>
            <div>
                <h4>Point of Discharge</h4>
                <ul>
                    <li>Country: {{ optional($data->pickup_country)->name }}</li>
                    <li>State: {{ optional($data->pickup_state)->name }}</li>
                    <li>City: {{ optional($data->pickup_city)->name }}</li>
                    <li>Port: {{ optional($data->pickup_port)->name }}</li>
                </ul>
            </div>
        </li>

        <li>Transportation Type: {{ $data->transportation_type }}</li>
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
