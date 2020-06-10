<table style="border: 1px">
    <thead>
    <tr>
        <th>Name</th>
        <th>Describe</th>
    </tr>
    </thead>
    <tbody>
    @foreach($group as $value)
        <tr>
            <td>{{ $value['name'] }}</td>
            <td>{!! $value['describe'] !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

