<table>
    <thead>
    <tr>
        <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $item)
        <tr>
            <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>