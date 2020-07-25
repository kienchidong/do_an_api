<table style="border: 1px">
    <thead>
    <tr>
        <th>Title</th>
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
    @foreach($group as $value)
        <tr>
            <td>Name </td>
            <td colspan="7">{{ $value->name }}</td>
        </tr>
        <tr>
            <td>Describe </td>
            <td colspan="7">{!! $value->describe !!}</td>
        </tr>
        @foreach($value->listExcel() as $question)
            <tr>
                <td> </td>
                <td>{{ $question['question'] }}</td>
                <td>{{ isset($question['A']) ? ($question['A']) : '' }}</td>
                <td>{{ isset($question['B']) ? ($question['B']) : '' }}</td>
                <td>{{ isset($question['C']) ? ($question['C']) : '' }}</td>
                <td>{{ isset($question['D']) ? ($question['D']) : '' }}</td>
                <td>{{ $question['right'] }}</td>
                <td>{{ $question['explain'] }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

