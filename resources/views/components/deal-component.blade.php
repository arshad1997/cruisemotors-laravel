<div class="details">
    <ul>
        <li>Tracking Code: {{ $data->code }}</li>
        <li>Agent Name: {{ $data->agent_name }}</li>
        <li>Agent Phone: {{ $data->agent_phone }}</li>
        <li>Client Name: {{ $data->client_name }}</li>
        <li>Client Phone: {{ $data->client_phone }}</li>
        <li>Client Address: {{ $data->client_address }}</li>
        <li>Car Brand: {{ optional($data->car_make)->name }}</li>
        <li>Car Model: {{ optional($data->car_model)->name }}</li>
        <li>Year: {{ $data->year }}</li>
        <li>Color: {{ $data->color }}</li>
        <li>Quantity: {{ $data->quantity }}</li>
        <li>Destination: {{ $data->destination }}</li>
        <li>Agent Target Amount: {{ $data->agent_target_amount }}</li>
        <li>Agent Commission Amount: {{ $data->agetn_commission_amount }}</li>
    </ul>
</div>
