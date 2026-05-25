@foreach ($users as $user)
    <form action="/users/{{ $user->id }}/role" method="POST">
        @csrf

        <p>{{ $user->name }}</p>

        <select name="role" onchange="this.form.submit()">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="courier" {{ $user->role == 'courier' ? 'selected' : '' }}>Courier</option>
        </select>
    </form>
@endforeach