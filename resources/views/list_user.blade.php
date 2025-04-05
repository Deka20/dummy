<div>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIM</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dataku)
                <tr>
                    <td>{{ $dataku['id'] }}</td>
                    <td>{{ $dataku['nama'] }}</td>
                    <td>{{ $dataku['nim'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
