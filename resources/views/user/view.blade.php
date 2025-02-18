<x-back-template>
    <x-slot:title>View User</x-slot:title>

    <div class="card">
        <div class='card-body'>
            <div class='table-responsive'>
                <table class='table table-striped'>
                    <tr>
                        <th>#</th>
                        <td>{{ $info->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $info->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $info->email }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ $info->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


</x-back-template>
