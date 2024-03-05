<div class="container">
    <h3>View all image</h3>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Image id</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($imageData as $data)
            <tr>
                <td>{{$data->ImageID}}</td>
                <td>
                    <img src="{{ url('../images/logo.png') }}" style="height: 100px; width: 150px;">
                    <img src="{{ asset('/images/0LVK6oqzcbu5ecpbECR4x8pan3vzjUaRaVfWq9PB.jpg') }}" style="height: 100px; width: 150px;">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>