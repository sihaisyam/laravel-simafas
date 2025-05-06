<table>
    <thead>
    <tr>
        <th><b>Name</b></th>
        <th><b>Email</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $val)
        <tr>
            <td>{{ $val->name }}</td>
            <td>{{ $val->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>