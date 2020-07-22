<table>
    <thead>
    <tr>
        <th>Question</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>D</th>
        <th>Right Answer</th>
        <th>Explain</th>
    </tr>
    </thead>
    <tbody>
    @foreach($array as $value)
        <tr>
            <td>{{ $value['question'] }}</td>
            <td>{{ isset($value['A']) ? ($value['A']) : '' }}</td>
            <td>{{ isset($value['B']) ? ($value['B']) : '' }}</td>
            <td>{{ isset($value['C']) ? ($value['C']) : '' }}</td>
            <td>{{ isset($value['D']) ? ($value['D']) : '' }}</td>
            <td>{{ $value['right'] }}</td>
            <td>{{ $value['explain'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

